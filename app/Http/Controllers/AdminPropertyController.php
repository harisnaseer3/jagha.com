<?php

namespace App\Http\Controllers;

use App\Events\NewPropertyActivatedEvent;
use App\Events\NotifyAdminOfNewProperty;
use App\Http\Controllers\Dashboard\LocationController;
use App\Jobs\AddWaterMark;
use App\Jobs\InsertInCountTables;
use App\Jobs\InsertInStatusPurposeTable;
use App\Jobs\PropertyLog;
use App\Jobs\SendNotificationOnPropertyUpdate;
use App\Models\Account;
use App\Models\Agency;
use App\Models\Dashboard\City;
use App\Models\Dashboard\Location;
use App\Models\Dashboard\User;
use App\Models\Image;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\Visit;
use App\Notifications\PropertyRejectionMail;
use App\Notifications\PropertyStatusChange;
use App\Notifications\PropertyStatusChangeMail;
use App\Notifications\SendMailToJoinNotification;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Throwable;

class AdminPropertyController extends Controller

{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function LocationStore($loc, $city)
    {
        $user_id = Auth::user()->getAuthIdentifier();
        try {
            $address = $prepAddr = str_replace(' ', '+', $loc . ',' . $city->name . ' Pakistan');
            $apiKey = DB::table('google_key')->first()->key;

            $geo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address=' . $address . '&sensor=false&key=' . $apiKey);
            $geo = json_decode($geo, true); // Convert the JSON to an array

            DB::table('google_api_log')->where('id', 2)->increment('count', 1);

            $latitude = null;
            $longitude = null;

            if (isset($geo['status']) && ($geo['status'] == 'OK')) {
                $latitude = $geo['results'][0]['geometry']['location']['lat']; // Latitude
                $longitude = $geo['results'][0]['geometry']['location']['lng']; // Longitude
            }

            $location = (new Location)->updateOrInsert(['city_id' => $city->id, 'name' => $loc], [
                'user_id' => $user_id,
                'city_id' => $city->id,
                'name' => $loc,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'is_active' => '1',
            ])->first();

            return $location;
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Record not added, try again.');
        }
    }

    public function create()
    {
        $property_types = (new PropertyType)->all();
        $counts = (new PropertyBackendListingController)->getPropertyListingCount(Auth::user()->getAuthIdentifier());

        return view('website.admin-pages.portfolio',
            [
                'counts' => $counts,
                'property_types' => $property_types,
            ]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'city' => 'required',
//        'location' => 'required',
//            'add_location' => 'nullable|string',
            'location' => 'required_if:add_location,==,""|string',
            'purpose' => 'required|in:Sale,Rent,Wanted',
            'property_type' => 'required|in:Homes,Plots,Commercial',
            'property_subtype-*' => 'required',
            'property_title' => 'required|min:10|max:225',
            'description' => 'required|min:50|max:6144',
            'all_inclusive_price' => 'nullable|numeric|max:99999999999|min:1000',
            'land_area' => 'required|numeric',
            'unit' => 'required',
            'image.*' => 'image|max:10000',
            'phone' => 'nullable|string', // +92-511234567
            'mobile' => 'required', // +92-3001234567
            'contact_person' => 'required|max:225',
            'contact_email' => 'required|email',
            'user_email' => 'required|email',
            'video_host' => 'nullable|string|in:Youtube,Vimeo,Dailymotion,Dailymotion',
            'video_link' => 'nullable|url',
            'rejection_reason' => 'nullable|string'
        ]);
        if ($validator->fails()) {
//            dd($validator->errors());
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Error storing record, try again.');
        }
        try {

            $user_id = User::findUserByEmail($request->user_email);
            if (!$user_id) {
                return redirect()->back()->withInput()->with('error', 'User ' . $request->user_email . '.not found.');
            }

            if(!User::findUserByEmail($request->contact_email)){
                return redirect()->back()->withInput()->with('error', 'User ' . $request->contact_email . '. not found.');
            }

            $area_values = (new PropertyController)->calculateArea($request->input('unit'), $request->input('land_area'));

            $json_features = '';
            $city = (new City)->select('id', 'name')->where('name', '=', str_replace('_', ' ', $request->input('city')))->first();

            $location = '';
            if ($request->has('location'))
                $location = Location::select('id', 'name','latitude','longitude','is_active')->where('name', '=', $request->input('location'))->where('city_id', '=', $city->id)->first();
            else if ($request->has('add_location')) {
                $location = Location::select('id', 'name','latitude','longitude','is_active')->where('name', '=', $request->input('add_location'))->where('city_id', '=', $city->id)->first();
                if (!$location) {
                    $location = $this->LocationStore($request->input('add_location'), $city);
                }
            }

            if ($location->is_active && $location->longitude == null && $location->latitude == null) {
                (new LocationController)->getLngLat($location,$city);
            }

            if ($request->has('features')) {
                $icon_inputs = preg_grep('/^(.*?(-icon))$/', array_keys($request->all()));
                $icon_value = $request->only($icon_inputs);
                $features_input = $request->except(array_merge($icon_inputs, ['_token', '_method', 'data_index', 'purpose', 'wanted_for', 'property_type',
                    'property_subtype-Homes', 'property_subtype-Plots', 'property_subtype-Commercial', 'city', 'location', 'property_title', 'description',
                    'all_inclusive_price', 'land_area',
                    'unit', 'status', 'bedrooms', 'bathrooms', 'contact_person', 'phone', 'mobile', 'fax', 'contact_email', 'features', 'image', 'video_link',
                    'video_host', 'floor_plans', 'purpose-error', 'wanted_for-error', 'property_type-error', 'property_subtype-error', 'location-error', 'mobile_#',
                    'phone_check', 'agency', 'phone_#', 'data-index', 'phone_check', 'property_id', 'rejection_reason', 'property_reference', 'property_subtype_Homes',
                    'features-error', 'advertisement', 'add_location', 'property_agency', 'agencies-table_length', 'location_verified', 'property_user-error',
                    'property_agency-error', 'user_email'
                ]));
                $features = json_decode(json_encode($features_input), true);
                $json_features = [
                    'features' => $features,
                    'icons' => $icon_value
                ];
            }

            $subtype = '';

            if ($request->input('property_subtype-Homes')) $subtype = $request->input('property_subtype-Homes');
            else if ($request->input('property_subtype-Plots')) $subtype = $request->input('property_subtype-Plots');
            else if ($request->input('property_subtype-Commercial')) $subtype = $request->input('property_subtype-Commercial');
            $max_id = 0;
            $max_id = (new Property)->pluck('id')->last();
            $max_id = $max_id + 1;

            $reference = date("Y") . '-' . str_pad($max_id, 8, 0, STR_PAD_LEFT);
            $agency = '';
            if ($request->has('agency')) {
                if (DB::table('agencies')->where('id', '=', $request->input('agency'))->exists()) {
                    $agency = $request->input('agency');
                }
            }


            $property = (new Property)->Create([
                'reference' => $reference,
                'user_id' => $user_id->id,
                'city_id' => $city->id,
                'location_id' => $location->id,
                'agency_id' => $agency != '' ? $agency : null,
                'purpose' => $request->input('purpose'),
                'sub_purpose' => $request->has('wanted_for') ? $request->input('wanted_for') : null,
                'type' => $request->input('property_type'),
                'sub_type' => $subtype,
                'title' => $request->input('property_title'),
                'description' => $request->input('description'),
                'price' => $request->input('all_inclusive_price') ? $request->input('all_inclusive_price') : null,
                'call_for_inquiry' => $request->input('call_for_price_inquiry') ? 1 : 0,
                'land_area' => $request->input('land_area'),
                'area_unit' => ucwords(implode(' ', explode('_', $request->input('unit')))),
                'area_in_sqft' => $area_values['sqft'],
                'area_in_sqyd' => $area_values['sqyd'],
                'area_in_sqm' => $area_values['sqm'],
                'area_in_marla' => $area_values['marla'],
                'area_in_new_marla' => $area_values['new_marla'],
                'area_in_kanal' => $area_values['kanal'],
                'area_in_new_kanal' => $area_values['new_kanal'],
                'bedrooms' => $request->has('bedrooms') && $request->input('bedrooms') !== null ? $request->input('bedrooms') : 0,
                'bathrooms' => $request->has('bathrooms') && $request->input('bathrooms') != null ? $request->input('bathrooms') : 0,
                'latitude' => $location->latitude,
                'longitude' => $location->longitude,
                'features' => $request->has('features') ? json_encode($json_features) : null,
                'status' => $request->has('status') ? $request->input('status') : 'pending',
                'reviewed_by' => $request->has('status') && Auth::guard('admin')->user() ? Auth::guard('admin')->user()->name : null,
                'basic_listing' => 1,
                'contact_person' => $request->input('contact_person'),
                'phone' => $request->input('phone'),
                'cell' => $request->input('mobile'),
                'fax' => $request->input('fax'),
                'email' => $request->input('contact_email'),
            ]);

            if ($request->has('image') && $request->input('image') !== '' && $request->input('image') !== '[]' && $request->input('image') !== null) {
                (new ImageController)->storeImage($request->input('image'), $property);
            }
            if ($request->filled('video_link')) {
                (new VideoController)->store($request, $property);
            }
            $this->dispatch(new InsertInStatusPurposeTable($property));

            if ($request->has('status') && $request->input('status') === 'active') {
                $property->activated_at = Carbon::now();
                $dt = Carbon::now();

                $expiry = $dt->addMonths(3)->toDateTimeString();
                $property->expired_at = $expiry;
                $property->save();
                $this->dispatch(new InsertInCountTables($city, $location, $property));

            }
            event(new NotifyAdminOfNewProperty($property));
            $this->dispatch(new PropertyLog($property, Auth::guard('admin')->user()->name, Auth::guard('admin')->user()->id));


//            (new PropertyLogController())->store($property);
            return redirect()->route('admin.properties.listings', [$property->status, 'all', (string)Auth::user()->getAuthIdentifier(), 'id', 'asc', '50'])
                ->with('success', 'Property with ID ' . $property->id . ' updated successfully.');
        } catch (Exception $e) {
//            dd($e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Record not added, try again.');
        }
    }


    public function edit(Property $property)
    {


        $city = $property->location->city->name;
        $property->city = $city;
        $property->video = (new Property)->find($property->id)->videos()->where('name', '<>', 'null')->get(['name', 'id', 'host']);

        $property_types = (new PropertyType)->all();
        $counts = (new PropertyBackendListingController)->getPropertyListingCount(Auth::user()->getAuthIdentifier());
        $users = [];
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
        return view('website.admin-pages.portfolio',
            [
                'users' => $users,
                'property' => $property,
                'property_types' => $property_types,
                'counts' => $counts,
            ]);
    }

    public function update(Request $request, Property $property)
    {
        if ($request->has('contact_email')) {
            if (!(new User)->where('email', $request->input('contact_email'))->exists())
                return redirect()->back()->withInput()->with('error', 'User with the provided Contact Email not exist. Please Recheck your email.');
        }
        if ($request->has('status') && $request->input('status') == 'rejected') {
            if ($request->has('rejection_reason') && $request->input('rejection_reason') == '') {
                return redirect()->back()->withInput()->with('error', 'Please specify the reason of rejection.');
            } else {
                $reason = $request->input('rejection_reason');
                $property_user = User::where('id', '=', $property->user_id)->first();
                $property_user->notify(new PropertyRejectionMail($property, $reason));
            }
        } elseif ($request->has('location_verified') && $request->input('location_verified') == 'No' &&
            $request->has('status') && $request->input('status') != 'rejected') {
            return redirect()->back()->withInput()->with('error', 'Please verify the location or set status to Rejected and specify Rejection Reason as unverified location.');
        }
        $validator = Validator::make($request->all(), [
            'description' => 'required|min:50|max:6144',
            'all_inclusive_price' => 'nullable|numeric|max:99999999999|min:1000',
            'call_for_price_inquiry' => 'numeric',
            'land_area' => 'required|numeric',
            'unit' => 'required',
            'image.*' => 'image|max:10000',
            'floor_plans.*' => 'image|max:256',
            'phone' => 'nullable|string', // +92-511234567
            'mobile' => 'required', // +92-3001234567
            'contact_person' => 'required|max:225',
            'contact_email' => 'required|email',
            'video_host' => 'nullable|string|in:Youtube,Vimeo,Dailymotion',
            'video_link' => 'nullable|url',
            'rejection_reason' => 'nullable|string'
        ]);

        if ($validator->fails()) {
//            dd($validator->errors());
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Error storing record, try again.');
        }
        try {

            $json_features = '';
            if ($request->has('location_verified') && $request->input('location_verified') == 'Yes') {
                (new LocationController)->activate_location($property->location);
            }

            if ($request->has('features')) {
                $icon_inputs = preg_grep('/^(.*?(-icon))$/', array_keys($request->all()));
                $icon_value = $request->only($icon_inputs);
                $features_input = $request->except(array_merge($icon_inputs, ['_token', '_method', 'data_index', 'purpose', 'wanted_for', 'property_type',
                    'property_subtype-Homes', 'property_subtype-Plots', 'property_subtype-Commercial', 'city', 'location', 'property_title', 'description',
                    'all_inclusive_price', 'land_area',
                    'unit', 'status', 'bedrooms', 'bathrooms', 'contact_person', 'phone', 'mobile', 'fax', 'contact_email', 'features', 'image', 'video_link',
                    'video_host', 'floor_plans', 'purpose-error', 'wanted_for-error', 'property_type-error', 'property_subtype-error', 'location-error', 'mobile_#',
                    'phone_check', 'agency', 'phone_#', 'data-index', 'phone_check', 'property_id', 'rejection_reason', 'property_reference',
                    'property_subtype_Homes', 'features-error', 'advertisement', 'add_location', 'property_agency', 'agencies-table_length', 'location_verified', 'property_user-error',
                    'property_agency-error'
                ]));
                $features = json_decode(json_encode($features_input), true);
                $json_features = [
                    'features' => $features,
                    'icons' => $icon_value
                ];
            }
            $agency = '';

            if ($request->input('advertisement') == 'Agency' && $request->has('agency')) {
                if (DB::table('agencies')->where('id', '=', $request->input('agency'))->exists()) {
                    $agency = $request->input('agency');
                }
            }

            $area_values = (new PropertyController())->calculateArea($request->input('unit'), $request->input('land_area'));
            $status_before_update = $property->status;
            (new CountTableController)->_delete_in_status_purpose_table($property, $status_before_update);

            if ($request->has('status') && $request->input('status') == 'deleted') {
                if (Auth()->guard('admin')->check()) {
                    if (!Auth::guard('admin')->user()->can('Delete Properties')) {
                        return redirect()->back()->withErrors($validator)->withInput()->with('error', 'User does not have the right permissions.');
                    }
                }
            }


            $property = (new Property)->updateOrCreate(['id' => $property->id], [
                'agency_id' => $agency != '' ? $agency : null,
                'description' => $request->input('description'),
                'price' => $request->has('all_inclusive_price') ? $request->input('all_inclusive_price') : null,
                'call_for_inquiry' => $request->input('call_for_price_inquiry') ? 1 : 0,
                'land_area' => $request->input('land_area'),
                'area_unit' => ucwords(implode(' ', explode('_', $request->input('unit')))),
                'area_in_sqft' => $area_values['sqft'],
                'area_in_sqyd' => $area_values['sqyd'],
                'area_in_sqm' => $area_values['sqm'],
                'area_in_marla' => $area_values['marla'],
                'area_in_new_marla' => $area_values['new_marla'],
                'area_in_kanal' => $area_values['kanal'],
                'area_in_new_kanal' => $area_values['new_kanal'],
                'bedrooms' => $request->has('bedrooms') && $request->input('bedrooms') !== null ? $request->input('bedrooms') : 0,
                'bathrooms' => $request->has('bathrooms') && $request->input('bathrooms') !== null ? $request->input('bathrooms') : 0,
                'features' => $request->has('features') ? json_encode($json_features) : null,
                'status' => $request->has('status') ? $request->input('status') : 'pending',
                'reviewed_by' => $request->has('status') && Auth::guard('admin')->user() ? Auth::guard('admin')->user()->name : null,
                'basic_listing' => 1,
                'contact_person' => $request->input('contact_person'),
                'phone' => $request->input('phone'),
                'cell' => $request->input('mobile'),
                'fax' => $request->input('fax'),
                'email' => $request->input('contact_email'),
                'rejection_reason' => $request->has('rejection_reason') ? $request->input('rejection_reason') : null,
                'activated_at' => null,
                'expired_at' => $request->has('status') && $request->input('status') == 'expired' ? date('Y-m-d H:i:s') : null,
            ]);
            if ($request->has('image') && $request->input('image') !== '' && $request->input('image') !== '[]' && $request->input('image') !== null) {
                (new ImageController)->storeImage($request->input('image'), $property);
            }
            if ($request->filled('video_link')) {
                (new VideoController)->update($request, $property);
            }
            (new CountTableController)->_insert_in_status_purpose_table($property);

            $city = (new City)->select('id', 'name')->where('name', '=', str_replace('_', ' ', $request->input('city')))->first();
            $location = Location::select('id', 'name')->where('name', '=', $request->input('location'))->where('city_id', '=', $city->id)->first();

            if ($request->has('status') && $request->input('status') === 'active') {
                $dt = Carbon::now();
                $property->activated_at = date('Y-m-d H:i:s');
                $expiry = $dt->addMonths(3)->toDateTimeString();
                $property->expired_at = $expiry;
                $property->save();

                (new CountTableController())->_insertion_in_count_tables($city, $location, $property);
                //if property has images and status is going to live than add water mark on images
//                if (count($property->images) > 0) {
//                    foreach ($property->images as $property_image) {
//                        if ($property_image->watermarked == 0) {
//                            $this->dispatch(new AddWaterMark($property_image));
//                        }
//                    }
//
//                }

            }
            $this->dispatch(new SendNotificationOnPropertyUpdate($property));

            if ($status_before_update === 'active' && in_array($request->input('status'), ['edited', 'pending', 'expired', 'uploaded', 'hidden', 'deleted', 'rejected']))
                (new CountTableController())->_on_deletion_insertion_in_count_tables($city, $location, $property);
            if ($property->status == 'pending')
                event(new NotifyAdminOfNewProperty($property));

            (new PropertyLogController())->store($property);
            return redirect()->route('admin.properties.listings', [$property->status, 'all', (string)Auth::user()->getAuthIdentifier(), 'id', 'asc', '50'])
                ->with('success', 'Property with ID ' . $property->id . ' updated successfully.');

        } catch (Exception $e) {
//            dd($e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Record not updated, try again.');
        }
    }

}
