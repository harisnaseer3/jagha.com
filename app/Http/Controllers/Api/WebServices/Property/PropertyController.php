<?php

namespace App\Http\Controllers\Api\WebServices\Property;

use App\Events\NotifyAdminOfEditedProperty;
use App\Events\NotifyAdminOfNewProperty;
use App\Events\UserErrorEvent;
use App\Http\Controllers\BaseController;
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


class PropertyController extends BaseController
{

    public function getProperties(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 10);

            $homes = Property::where('status', 'active')
                ->where('type', 'Home')
                ->with(['images', 'videos', 'floor_plans', 'agency', 'user'])
                ->paginate($perPage, ['*'], 'homes_page');

            $plots = Property::where('status', 'active')
                ->where('type', 'Plot')
                ->with(['images', 'videos', 'floor_plans', 'agency', 'user'])
                ->paginate($perPage, ['*'], 'plots_page');

            $commercials = Property::where('status', 'active')
                ->where('type', 'Commercial')
                ->with(['images', 'videos', 'floor_plans', 'agency', 'user'])
                ->paginate($perPage, ['*'], 'commercials_page');

            return $this->sendResponse([
                'homes' => $homes,
                'plots' => $plots,
                'commercials' => $commercials,
            ], 'Properties displayed successfully');

        } catch (\Exception $e) {
            return $this->sendError('Something went wrong while fetching properties.', $e->getMessage(), 500);
        }
    }

    public function propertyCountByCities()
    {
        try {
            $count = DB::table('property_count_by_cities')->all();

            return $this->sendResponse($count, 'Property count by cities fetched successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Failed to fetch property count by cities.', $e->getMessage(), 500);
        }
    }

    // Display detailed page of property
    public function show(Request $request)
    {
        try {
            $property = Property::where('id', $request->property)
                ->where('status', 'active')
                ->with(['images', 'videos', 'floor_plans', 'agency', 'user'])
                ->first();

            if (!$property) {
                return $this->sendError('Property not found or inactive.', [], 404);
            }

            $is_favorite = false;

            if (Auth::guard('api')->check()) {
                $user_id = Auth::guard('api')->user()->getAuthIdentifier();

                // Add to recently viewed
                (new RecentlyViewedController)->store($user_id, $property->id);

                // Check if property is in favorites
                $is_favorite = DB::table('favorites')->where([
                    ['user_id', '=', $user_id],
                    ['property_id', '=', $property->id],
                ])->exists();
            }

            // Attach custom attributes
            $property->is_favorite = $is_favorite;
            $property->city = optional($property->city)->name;
            $property->location = optional($property->location)->name;

            // Fetch similar properties
            $similar_properties_query = (new PropertySearchController())->listingFrontend()
                ->where('properties.id', '<>', $property->id)
                ->where('properties.city_id', $property->city_id)
                ->where('properties.type', $property->type)
                ->where('properties.sub_type', $property->sub_type)
                ->where('properties.purpose', $property->purpose);

            $sort_area = 'higher_area';
            $sort = 'newest';

            $similar_properties = (new PropertySearchController())->sortPropertyListing(
                $sort,
                $sort_area,
                $similar_properties_query
            )->limit(10)->get();

            if ($similar_properties->count() > 0) {
                $similar_properties = (new PropertyListingResource)->myToArray($similar_properties);
            } else {
                $similar_properties = [];
            }

            $data = (object)[
                'property' => new PropertyResource($property),
                'similar_properties' => $similar_properties,
            ];

            return $this->sendResponse($data, 'Property Details');
        } catch (\Exception $e) {
            return $this->sendError('Failed to fetch property details.', $e->getMessage(), 500);
        }
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
        if (!auth()->guard('api')->user()->hasVerifiedEmail()) {

            return (new \App\Http\JsonResponse)->unauthorized();
        }

        if ($request->has('is_draft') && $request->is('is_draft') == 1)
            return $this->defaultStore($request, 'draft');
        else
            return $this->defaultStore($request, 'pending');
    }

//    public function saveDraft(Request $request)
//    {
//
//        return $this->defaultStore($request, 'draft');
//
//
//    }

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


                $max_id = DB::table('properties')->select('id')->orderBy('id', 'desc')->first()->id;

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
                return (new \App\Http\JsonResponse)->failed('Failed to insert data, Please try again.');
            }
        }
        return (new \App\Http\JsonResponse)->unprocessable();

    }


    public function edit(Property $property)
    {
        if (!auth()->guard('api')->user()->hasVerifiedEmail()) {
            return (new \App\Http\JsonResponse)->forbidden();
        }
        if (!$property->exists()) {
            return (new \App\Http\JsonResponse)->resourceNotFound();
        }
        try {
            $city = $property->location->city->name;
            $property->city = $city;
            $users = [];
//            $agencies_users = [];
//            if ($property->agency_id !== null) {
//                $agencies_users_ids = DB::table('agency_users')->select('user_id')
//                    ->where('agency_id', $property->agency_id)
//                    ->get()->pluck('user_id')->toArray();
//
//
//                if (!empty($agencies_users_ids)) {
//                    $agencies_users = (new User)->select('name', 'id')
//                        ->whereIn('id', $agencies_users_ids)
//                        ->get();
//                    foreach ($agencies_users as $user) {
//                        $users += array($user->id => $user->name);
//                    }
//
//                }
//            }
//            $agencies_ids = DB::table('agency_users')->select('agency_id')->where('user_id', '=', Auth::guard('api')->user()->getAuthIdentifier())->get()->pluck('agency_id')->toArray();
//
//            $agencies_data = DB::table('agencies')->select('title', 'id')
//                ->whereIn('id', $agencies_ids)
//                ->where('status', '=', 'verified')->get();

//
//            $agencies = [];
//            foreach ($agencies_data as $agency) {
//                $agencies += array($agency->id => $agency->title);
//            }
            $data = [
//                'agencies' => $agencies,
//                'agency_staff' => $agencies_users,
                'property' => (new PropertyListingResource)->CleanEditPropertyData($property),

            ];
            return (new \App\Http\JsonResponse)->success("Property fetched successfully", $data);
        } catch (Exception $e) {
            return (new \App\Http\JsonResponse)->resourceNotFound();
        }

    }

//
    public function update(Request $request, Property $property)
    {
        if (!auth()->guard('api')->user()->hasVerifiedEmail()) {
            return (new \App\Http\JsonResponse)->forbidden();
        }

        $status = 'pending';
        if ($request->has('is_draft') && $request->is_draft == 1)
            $status = 'draft';

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
//            $property = DB::table('properties')->where('id', $property->id)->first();

            if ($property->user_id != $user->getAuthIdentifier()) {
                return (new \App\Http\JsonResponse)->forbidden();
            }


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


                    'status' => $status,
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

                if ($status_before_update === 'active') {
                    (new CountTableController())->_on_deletion_insertion_in_count_tables($city, $location, $property);
                }

                if ($property->status == 'pending') {
                    $this->dispatch(new SendNotificationOnPropertyUpdate($property));
                    event(new NotifyAdminOfEditedProperty($property));
                }

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
        if (!auth()->guard('api')->user()->hasVerifiedEmail()) {
            return (new \App\Http\JsonResponse)->forbidden();
        }
        if ($property->status == 'deleted') {
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

    public function deleteImage(Request $request)
    {

        if (!auth()->guard('api')->user()->hasVerifiedEmail()) {
            return (new \App\Http\JsonResponse)->forbidden();
        }
        $property = (new Property)->where('id', $request->property)->first();
        if ($property->status == 'deleted') {
            return (new \App\Http\JsonResponse)->resourceNotFound();
        }

        foreach (explode(',', $request->image) as $imag) {
            $img = (new Image)->where('property_id', $property->id)->where('name', $imag)->first();
            if ($img) {
                $img->forceDelete();
            } else {
                return (new \App\Http\JsonResponse)->resourceNotFound();

            }
        }
        return (new \App\Http\JsonResponse)->success('Image deleted successfully.');

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
