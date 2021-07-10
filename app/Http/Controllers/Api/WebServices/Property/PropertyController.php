<?php

namespace App\Http\Controllers\Api\WebServices\Property;

use App\Events\NotifyAdminOfEditedProperty;
use App\Events\NotifyAdminOfNewProperty;
use App\Events\UserErrorEvent;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CountTableController;
use App\Http\Controllers\Dashboard\LocationController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\PropertyBackendListingController;
use App\Jobs\SendNotificationOnPropertyUpdate;
use App\Models\Agency;
use App\Models\Dashboard\City;
use App\Models\Dashboard\Location;
use App\Models\Dashboard\User;
use App\Models\Image;
use App\Models\Property;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Property as PropertyResource;
use App\Http\Resources\PropertyListing as PropertyListingResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\PropertyController as SitePropertyController;
use Exception;


class PropertyController extends Controller
{
    const CITY = 000;
    const LOCATION = 000;
    const PRICE = 00;
    const LANDAREA = 00;
    const DEFAULT = NULL;


    // Display detailed page of property
    public function show(Request $request)
    {

        $property = Property::where('id', $request->property)->where('status', 'active')->first();
        if ($property) {

//            $views = $property->views;
//            $property->views = $views + 1;
//            $property->save();

            $is_favorite = false;

            if (Auth::guard('api')->check()) {
                $is_favorite = DB::table('favorites')->select('id')
                    ->where([
                        ['user_id', '=', Auth::guard('api')->user()->getAuthIdentifier()],
                        ['property_id', '=', $property->id],
                    ])->exists();
            }
            $property->city = $property->city->name;
            $property->location = $property->location->name;

            $similar_properties = (new PropertySearchController())->listingFrontend()
                ->where([
                    ['properties.id', '<>', $property->id],
                    ['properties.city_id', $property->city_id],
                    ['properties.type', $property->type],
                    ['properties.sub_type', $property->sub_type],
                    ['properties.purpose', $property->purpose],
                ]);

            $sort_area = 'higher_area';
            $sort = 'newest';

            $similar_properties = (new PropertySearchController())->sortPropertyListing($sort, $sort_area, $similar_properties);

            $similar_properties = $similar_properties->limit(10)->get();

            if ($similar_properties->count() > 0) {
                $similar_properties = (new PropertyListingResource)->myToArray($similar_properties);
            } else
                $similar_properties = [];


            $data = (object)[
                'property' => new PropertyResource($property),
                'similar_properties' => $similar_properties
            ];

            return (new \App\Http\JsonResponse)->success("Property Details", $data);
        } else
            return (new \App\Http\JsonResponse)->resourceNotFound();


    }

    public function getUserAreaUnit($id)
    {
        $user = DB::table('accounts')->select('default_area_unit')->where('user_id', $id)->first();
        if ($user)
            return $user->default_area_unit;
        else
            return 'none';

    }

    public function store(Request $request)
    {
        return $this->defaultStore($request, 'pending');
    }

    public function saveDraft(Request $request)
    {

        return $this->defaultStore($request, 'draft');


    }


    public function defaultStore(Request $request, $status)
    {

        if (count($request->all()) > 0) {
            if ($request->hasFile('images')) {
                $result = $this->checksonImageData($request);
                if ($result != null && $result !== '')
                    return (new \App\Http\JsonResponse)->failed($result, 422);
            }


            $validator = Validator::make($request->all(), [
                'city' => 'required',
                'location' => 'required',
                'purpose' => 'required|in:sale,Sale,rent,Rent,wanted,Wanted',
                'type' => 'required|in:homes,Homes,plots,Plots,commercial,Commercial',
                'sub_type' => 'required',
                'title' => 'required|min:10|max:225',
                'description' => 'required|min:50|max:6144',
                'price' => 'nullable|numeric|max:99999999999|min:1000',
                'land_area' => 'required|numeric',
                'area_unit' => 'required|in:marla,Marla,square feet,Square Feet,Square Yards,square yards,kanal,Kanal,square meters,Square Meters',
                'unit' => 'string:',
                'image.*' => 'image|max:10000|mimes:jpeg,png,jpg',
                'phone' => 'nullable|string',
                'mobile' => 'string',

            ]);


            if ($validator->fails()) {

                return (new \App\Http\JsonResponse)->failed($validator->getMessageBag(), 422);
            }
            $user = Auth::guard('api')->user();


            try {

                $area_values = $this->calculateArea($request->input('area_unit'), $request->input('land_area'));


                if ($request->has('location')) {
                    $location = Location::select('id', 'name', 'latitude', 'longitude', 'is_active')->where('id', $request->input('location'))->first();
                }


                $max_id = DB::table('properties')->select('id')->pluck('id')->last();

                $max_id = $max_id + 1;

                $reference = date("Y") . '-' . str_pad($max_id, 8, 0, STR_PAD_LEFT);
                $agency = '';
                if ($request->has('agency')) {
                    if (DB::table('agencies')->where('id', '=', $request->input('agency'))->exists()) {
                        $agency = $request->input('agency');
                    }
                }
                $values = [
                    'reference' => $reference,
                    'user_id' => $user->id,
                    'city_id' => $city_id = $request->input('city'),
                    'location_id' => $location->id,
                    'agency_id' => $agency != '' ? $agency : null,
                    'purpose' => $request->input('purpose') ? $request->input('purpose') : 'Sale',
                    'sub_purpose' => $request->has('wanted_for') ? $request->input('wanted_for') : null,
                    'type' => $request->input('type') ? $request->input('type') : 'homes',
                    'sub_type' => $request->input('sub_type') ? $request->input('sub_type') : 'house',
                    'title' => $request->input('title') ? $request->input('title') : 'none',
                    'description' => $request->input('description') ? $request->input('description') : 'none',
                    'price' => $request->input('price'),
                    'call_for_inquiry' => 0,
                    'land_area' => $request->input('land_area'),
                    'area_unit' => $request->input('area_unit'),

                    'area_in_sqft' => $area_values['sqft'],
                    'area_in_sqyd' => $area_values['sqyd'],
                    'area_in_sqm' => $area_values['sqm'],
                    'area_in_marla' => $area_values['marla'],
                    'area_in_new_marla' => $area_values['new_marla'],
                    'area_in_kanal' => $area_values['kanal'],
                    'area_in_new_kanal' => 0,

                    'bedrooms' => $request->has('bedrooms') && $request->input('bedrooms') !== null ? $request->input('bedrooms') : 0,
                    'bathrooms' => $request->has('bathrooms') && $request->input('bathrooms') != null ? $request->input('bathrooms') : 0,
                    'latitude' => $location->latitude,
                    'longitude' => $location->longitude,

                    'status' => $status,
                    'basic_listing' => 1,
                    'contact_person' => $request->input('contact_person') ? $request->input('contact_person') : $user->name,
                    'phone' => $request->input('phone') ? $request->input('phone') : $user->phone,
                    'cell' => $request->input('mobile') ? $request->input('mobile') : $user->cell,
                    'email' => $request->input('contact_email') ? $request->input('contact_email') : $user->email,
                ];

                $property_id = DB::table('properties')->insertGetId($values);

                $property = DB::table('properties')->where('id', $property_id)->first();


                (new CountTableController)->_insert_in_status_purpose_table($property);

                if ($request->hasFile('images')) {

                    $this->storeImages($request, $property_id, $user->id);
                }

                if ($status == 'draft') {
                    return (new \App\Http\JsonResponse)->success("Property saved in Drafts successfully");
                } else if ($status == 'pending') {
                    event(new NotifyAdminOfNewProperty($property));
                    return (new \App\Http\JsonResponse)->success('Property added successfully.Your ad will be live in 24 hours after verification of provided information.');

                }


            } catch (Exception $e) {
//                return (new \App\Http\JsonResponse)->failed($e->getMessage());
                return (new \App\Http\JsonResponse)->failed(null);
            }
        }
        return (new \App\Http\JsonResponse)->unprocessable();

    }


    public function edit(Property $property)
    {
        try {
            $city = $property->location->city->name;
            $property->city = $city;
            $users = [];
            $agencies_users = [];
            if ($property->agency_id !== null) {
                $agencies_users_ids = DB::table('agency_users')->select('user_id')
                    ->where('agency_id', $property->agency_id)
                    ->get()->pluck('user_id')->toArray();


                if (!empty($agencies_users_ids)) {
                    $agencies_users = (new User)->select('name', 'id')
                        ->whereIn('id', $agencies_users_ids)
                        ->get();
                    foreach ($agencies_users as $user) {
                        $users += array($user->id => $user->name);
                    }

                }
            }
            $agencies_ids = DB::table('agency_users')->select('agency_id')->where('user_id', '=', Auth::guard('api')->user()->getAuthIdentifier())->get()->pluck('agency_id')->toArray();

            $agencies_data = DB::table('agencies')->select('title', 'id')
                ->whereIn('id', $agencies_ids)
                ->where('status', '=', 'verified')->get();


            $agencies = [];
            foreach ($agencies_data as $agency) {
                $agencies += array($agency->id => $agency->title);
            }
            $data = [
                'agencies' => $agencies,
                'agency_staff' => $agencies_users,
                'property' => (new PropertyListingResource)->CleanEditPropertyData($property),

            ];
            return (new \App\Http\JsonResponse)->success("Property saved in Drafts successfully", $data);
        } catch (Exception $e) {
            return (new \App\Http\JsonResponse)->resourceNotFound();
        }

    }

//
    public function update(Request $request, Property $property)
    {


        if (count($request->all()) > 0) {


            $validator = Validator::make($request->all(), [
                'title' => 'required|min:10|max:225',
                'description' => 'required|min:50|max:6144',
                'price' => 'nullable|numeric|max:99999999999|min:1000',
                'land_area' => 'required|numeric',
                'area_unit' => 'required|in:marla,Marla,square feet,Square Feet,Square Yards,square yards,kanal,Kanal,square meters,Square Meters',
                'unit' => 'string:',
                'image.*' => 'image|max:10000|mimes:jpeg,png,jpg',
                'phone' => 'nullable|string',
                'mobile' => 'string',
            ]);


            if ($validator->fails()) {

                return (new \App\Http\JsonResponse)->failed($validator->getMessageBag(), 422);
            }
            $user = Auth::guard('api')->user();


            if ($request->hasFile('images')) {
                $order = 0;
                $saved_images = DB::table('images')->select('order')->where('property_id', $property->id)->orderBy('order', 'DESC')->get()->toArray();
                if (count($saved_images) > 0) {
                    if (count($saved_images) + count($request->file('images')) > 60)
                        return (new \App\Http\JsonResponse)->success('You can add 60 images only');
                    $order = $saved_images[0]->order;

                    if ($request->hasFile('images')) {
                        $result = $this->checksonImageData($request);
                        if ($result != null && $result !== '')
                            return (new \App\Http\JsonResponse)->failed($result, 422);
                    }

                }

                $this->storeImages($request, $property->id, $user->id, $order);


            }


            try {

                $area_values = $this->calculateArea($request->input('area_unit'), $request->input('land_area'));
                $status_before_update = $property->status;
                (new CountTableController)->_delete_in_status_purpose_table($property, $status_before_update);

                $agency = '';
                if ($request->has('agency')) {
                    if (DB::table('agencies')->where('id', '=', $request->input('agency'))->exists()) {
                        $agency = $request->input('agency');
                    }
                }
                $values = [

                    'agency_id' => $agency != '' ? $agency : null,

                    'title' => $request->input('title'),
                    'description' => $request->input('description'),
                    'price' => $request->input('price'),
                    'call_for_inquiry' => 0,
                    'land_area' => $request->input('land_area'),
                    'area_unit' => $request->input('area_unit'),

                    'area_in_sqft' => $area_values['sqft'],
                    'area_in_sqyd' => $area_values['sqyd'],
                    'area_in_sqm' => $area_values['sqm'],
                    'area_in_marla' => $area_values['marla'],
                    'area_in_new_marla' => $area_values['new_marla'],
                    'area_in_kanal' => $area_values['kanal'],
                    'area_in_new_kanal' => 0,

                    'bedrooms' => $request->has('bedrooms') && $request->input('bedrooms') !== null ? $request->input('bedrooms') : 0,
                    'bathrooms' => $request->has('bathrooms') && $request->input('bathrooms') != null ? $request->input('bathrooms') : 0,


                    'status' => 'pending',
                    'basic_listing' => 1,
                    'contact_person' => $request->input('contact_person') ? $request->input('contact_person') : $user->name,
                    'phone' => $request->input('phone') ? $request->input('phone') : $user->phone,
                    'cell' => $request->input('mobile') ? $request->input('mobile') : $user->cell,
                    'email' => $request->input('contact_email') ? $request->input('contact_email') : $user->email,
                ];


                DB::table('properties')->where('id', $property->id)->update($values);

                (new CountTableController)->_insert_in_status_purpose_table($property);

                $city = DB::table('cities')->select('id', 'name')->where('id', $property->city_id)->first();
                $location = DB::table('locations')->select('id', 'name')->where('id', $property->location->id)->first();


                $this->dispatch(new SendNotificationOnPropertyUpdate($property));

                if ($status_before_update === 'active') {
                    (new CountTableController())->_on_deletion_insertion_in_count_tables($city, $location, $property);
                }

                if ($property->status == 'pending')
                    event(new NotifyAdminOfEditedProperty($property));

                return (new \App\Http\JsonResponse)->success('Property with ID ' . $property->id . ' updated successfully.');


            } catch (Exception $e) {
//                return (new \App\Http\JsonResponse)->failed($e->getMessage());
                return (new \App\Http\JsonResponse)->failed(null);
            }
        }
        return (new \App\Http\JsonResponse)->unprocessable();


    }

    public function destroy(Property $property)
    {
//        $property = (new Property)->where('id', $request->input('id'))->first();

        if($property->status == 'deleted' ){
            return (new \App\Http\JsonResponse)->resourceNotFound();
        }

        $status_before_update = $property->status;

        if ($property->exists) {
            try {
                $property->status = 'deleted';
                $property->activated_at = null;
                $property->save();

                $this->dispatch(new SendNotificationOnPropertyUpdate($property));

                $city = DB::table('cities')->select('id', 'name')->where('id', '=', $property->city_id)->first();
                $location = DB::table('locations')->select('id', 'name')->where('id', '=', $property->location_id)->where('city_id', '=', $city->id)->first();

                if ($status_before_update === 'active') {
                    (new CountTableController())->_on_deletion_insertion_in_count_tables($city, $location, $property);
                }

                (new CountTableController)->_delete_in_status_purpose_table($property, $status_before_update);
                (new CountTableController)->_insert_in_status_purpose_table($property);


                return (new \App\Http\JsonResponse)->success('Property of ID ' . $property->id . ' deleted successfully.');
            } catch (Exception $e) {
                return (new \App\Http\JsonResponse)->failed(null);
            }
        }
        return (new \App\Http\JsonResponse)->resourceNotFound();
    }

    public function checksonImageData(Request $request)
    {

        if (count($request->file('images')) > 60)
            return 'You can add 60 images only';

        foreach ($request->file('images') as $file_name) {
            if ($file_name->getSize() > 10 * 1000000)  //> 10mb
            {
                return 'File ' . $file_name->getClientOriginalName() . ' is not accepted. Size is grater than 10 MB.';
            }

        }
    }

    public function storeImages(Request $request, $property, $user, $order = 0)
    {
        foreach ($request->file('images') as $index => $file_name) {
            $filename = rand(0, 99);
            $extension = 'webp';

            $filenamewithoutext = $filename . time();
            $filenametostore = $filenamewithoutext . '.' . $extension;
            $files = [['width' => 750, 'height' => 600], ['width' => 450, 'height' => 350], ['width' => 200, 'height' => 200]];

            foreach ($files as $file) {
                $updated_path = $filenamewithoutext . '-' . $file['width'] . 'x' . $file['height'] . '.' . $extension;
                Storage::put('properties/' . $updated_path, fopen($file_name, 'r+'));

                //Resize image here
                $thumbnailpath = ('thumbnails/properties/' . $updated_path);

                $img = \Intervention\Image\Facades\Image::make($thumbnailpath)->fit($file['width'], $file['height'], function ($constraint) {
                    $constraint->aspectRatio();
                })->encode('webp', 1);

                $img->save($thumbnailpath);
            }
            DB::table('images')->insert([
                'user_id' => $user,
                'property_id' => $property,
                'name' => $filenametostore,
                'order' => $index + 1 + $order
            ]);
        }
    }

    //    calculate area value for different units
    public function calculateArea($area_unit, $land_area)
    {
        $area = number_format($land_area, 2, '.', '');

        $area_in_sqft = 0;
        $area_in_sqyd = 0;
        $area_in_sqm = 0;
        $area_in_marla = 0;
        $area_in_new_marla = 0;
        $area_in_kanal = 0;
        $area_in_new_kanal = 0;

        if (ucwords($area_unit) === 'Marla') {

            $area_in_sqft = $area * 272;
            $area_in_marla = $area;
            $area_in_new_marla = $area;
            $area_in_sqyd = $area_in_sqft / 9;
            $area_in_sqm = $area_in_sqft / 10.7639;
            $area_in_kanal = $area / 20;

        } else if (ucwords($area_unit) === 'Square Feet') {
            $area_in_sqft = $area;
            $area_in_marla = $area_in_sqft / 272;
            $area_in_new_marla = $area_in_sqft / 272;
            $area_in_sqyd = $area_in_sqft / 9;
            $area_in_sqm = $area_in_sqft / 10.7639;
            $area_in_kanal = $area_in_sqft / 5445;

        } else if (ucwords($area_unit) === 'Square Meters') {
            $area_in_sqft = $area * 10.7639;
            $area_in_marla = $area_in_sqft / 272;
            $area_in_new_marla = $area_in_sqft / 272;
            $area_in_sqyd = $area_in_sqft / 9;
            $area_in_sqm = $area;
            $area_in_kanal = $area_in_sqft / 5445;

        } else if (ucwords($area_unit) === 'Square Yards') {
            $area_in_sqft = $area * 9;
            $area_in_marla = $area_in_sqft / 272;
            $area_in_new_marla = $area_in_sqft / 272;
            $area_in_sqyd = $area;
            $area_in_sqm = $area_in_sqft / 10.7639;
            $area_in_kanal = $area_in_sqft / 5445;

        } else if (ucwords($area_unit) === 'Kanal') {
            $area_in_sqft = $area * 5445;
            $area_in_marla = $area_in_sqft / 272;
            $area_in_new_marla = $area_in_sqft / 272;
            $area_in_sqyd = $area_in_sqft / 9;
            $area_in_sqm = $area_in_sqft / 10.7639;
            $area_in_kanal = $area;

        }
        return [
            'new_marla' => $area_in_new_marla,  //working with this
            'sqft' => $area_in_sqft,
            'sqyd' => $area_in_sqyd,
            'sqm' => $area_in_sqm,
            'marla' => $area_in_marla,
            'kanal' => $area_in_kanal,
            'new_kanal' => $area_in_new_kanal
        ];

    }

}
