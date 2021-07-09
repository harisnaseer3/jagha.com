<?php

namespace App\Http\Controllers\Api\WebServices\Property;

use App\Events\NotifyAdminOfNewProperty;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CountTableController;
use App\Http\Controllers\Dashboard\LocationController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\PropertyBackendListingController;
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

        if (count($request->all()) > 0) {
            if ($request->hasFile('images')) {
                $this->checksonImageData($request);
            }

            $user = Auth::guard('api')->user();
            $validator = Validator::make($request->all(), [
                'city' => 'required',
                'location' => 'required_if:add_location,==,""|string',
                'purpose' => 'required|in:Sale,Rent,Wanted',
                'type' => 'required|in:Homes,Plots,Commercial',
                'subtype' => 'required',
                'title' => 'required|min:10|max:225',
                'description' => 'required|min:50|max:6144',
                'price' => 'nullable|numeric|max:99999999999|min:1000',
                'land_area' => 'required|numeric',
                'unit' => 'required',
                'image.*' => 'image|max:10000',
                'phone' => 'nullable|string',
                'mobile' => 'required',
                'video_host' => 'string|in:Youtube,Vimeo,Dailymotion,Dailymotion',
                'video_link' => 'nullable|url',
            ]);

            $status = 'pending';
            $errors = [];
            if ($validator->fails()) {
                $errors[] = ['Missing Fields' => $validator->getMessageBag()];
                $status = 'draft';
            }
            try {
                $area_values = array();


                $area_unit = $this->getUserAreaUnit($user->id);

                if ($area = $request->input('land_area') && $area_unit != NULL) {
                    $area_values = (new SitePropertyController)->calculateArea($area_unit, $area);
                }
                $city_id = 000;
                if ($request->has('city')) {
//                    $city = (new City)->select('id', 'name')->where('name', '=', str_replace('_', ' ', $request->input('city')))->first();
//                    $city = (new City)->select('id', 'name')->where('id', $request->input('city'))->first();
                    $city_id = $request->input('city');
                }
                $location_id = 000;

                if ($request->has('location')) {
////                    $location = Location::select('id', 'name', 'latitude', 'longitude', 'is_active')->where('name', '=', $request->input('location'))->where('city_id', '=', $city->id)->first();
                    $location = Location::select('id', 'name', 'latitude', 'longitude', 'is_active')->where('id', $request->input('location'))->first();
                    $location_id = $request->input('location');
//
                }

                $max_id = 0;

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
                    'city_id' => $city_id,
                    'location_id' => $location_id,
                    'agency_id' => $agency != '' ? $agency : null,
                    'purpose' => $request->input('purpose') ? $request->input('purpose') : 'Sale',
                    'sub_purpose' => $request->has('wanted_for') ? $request->input('wanted_for') : null,
                    'type' => $request->input('type') ? $request->input('type') : 'homes',
                    'sub_type' => $request->input('sub_type') ? $request->input('sub_type') : 'house',
                    'title' => $request->input('title') ? $request->input('title') : 'none',
                    'description' => $request->input('description') ? $request->input('description') : 'none',
                    'price' => $request->input('price') ? $request->input('price') : 000,
                    'call_for_inquiry' => 0,
                    'land_area' => $request->input('land_area') ? $request->input('land_area') : 000,
                    'area_unit' => $area_unit,

                    'area_in_sqft' => count($area_values) > 0 ? $area_values['sqft'] : 000,
                    'area_in_sqyd' => count($area_values) > 0 ? $area_values['sqyd'] : 000,
                    'area_in_sqm' => count($area_values) > 0 ? $area_values['sqm'] : 000,
                    'area_in_marla' => count($area_values) > 0 ? $area_values['marla'] : 000,
                    'area_in_new_marla' => count($area_values) > 0 ? $area_values['new_marla'] : 000,
                    'area_in_kanal' => count($area_values) > 0 ? $area_values['kanal'] : 000,
                    'area_in_new_kanal' => count($area_values) > 0 ? $area_values['new_kanal'] : 000,

                    'bedrooms' => $request->has('bedrooms') && $request->input('bedrooms') !== null ? $request->input('bedrooms') : 0,
                    'bathrooms' => $request->has('bathrooms') && $request->input('bathrooms') != null ? $request->input('bathrooms') : 0,
                    'latitude' => $location_id !== 000 ? $location->latitude : null,
                    'longitude' => $location_id !== 000 ? $location->longitude : null,

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
                    return (new \App\Http\JsonResponse)->success("Property saved in Drafts successfully", $errors);
                } else if ($status == 'pending') {
                    event(new NotifyAdminOfNewProperty($property));
                    return (new \App\Http\JsonResponse)->success('Property added successfully.Your ad will be live in 24 hours after verification of provided information.');
                }


            } catch (Exception $e) {
//                return (new \App\Http\JsonResponse)->failed($e->getMessage());
                return (new \App\Http\JsonResponse)->unprocessable();
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
//    public function update(Request $request, Property $property){
//        //check property has new images
//        // check property already has images
//        //check the total count <= 60
//
//       // store new images and maintain the order
//
//        print('hello');
//        exit();
//    }


    public function checksonImageData(Request $request)
    {
        if (count($request->file('images')) > 60)
            return (new \App\Http\JsonResponse)->failed('You can add 60 images only', 422);

        foreach ($request->file('images') as $file_name) {
            if ($file_name->getSize() > 10 * 1000000)  //> 10mb
            {
                return (new \App\Http\JsonResponse)->failed('File ' . $file_name->getClientOriginalName() . ' not accepted. Size is grater than 10 MB.', 422);
            }

        }
    }

    public function storeImages(Request $request, $property, $user)
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
//            $user_id = Auth::guard('api')->user()->getAuthIdentifier();

            DB::table('images')->insert([
                'user_id' => $user,
                'property_id' => $property,
                'name' => $filenametostore,
                'order' => $index + 1
            ]);
        }
    }

}
