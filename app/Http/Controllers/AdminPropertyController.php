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
    public function LocationStore($loc, $city)
    {
        $user_id = Auth::user()->getAuthIdentifier();
        try {
            $location = (new Location)->updateOrInsert(['city_id' => $city->id, 'name' => $loc], [
                'user_id' => $user_id,
                'city_id' => $city->id,
                'name' => $loc,
                'is_active' => '1',
            ])->first();
            return $location;
        } catch (\Mockery\Exception $e) {
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
            $area_values = (new PropertyController)->calculateArea($request->input('unit'), $request->input('land_area'));

            $json_features = '';
            $city = (new City)->select('id', 'name')->where('name', '=', str_replace('_', ' ', $request->input('city')))->first();

            $location = '';
            if ($request->has('location'))
                $location = Location::select('id', 'name')->where('name', '=', $request->input('location'))->where('city_id', '=', $city->id)->first();
            else if ($request->has('add_location')) {
                $location = Location::select('id', 'name')->where('name', '=', $request->input('add_location'))->where('city_id', '=', $city->id)->first();
                if (!$location) {
                    $location = $this->LocationStore($request->input('add_location'), $city);
                }
            }

            $user_id = User::findUserByEmail($request->user_email);

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

            $address = $prepAddr = str_replace(' ', '+', $location->name . ',' . $city->name . ' Pakistan');
            $apiKey = config('app.google_map_api_key');
            $geo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address=' . $address . '&sensor=false&key=' . $apiKey);
            $geo = json_decode($geo, true); // Convert the JSON to an array
            $latitude = '';
            $longitude = '';

            if (isset($geo['status']) && ($geo['status'] == 'OK')) {
                $latitude = $geo['results'][0]['geometry']['location']['lat']; // Latitude
                $longitude = $geo['results'][0]['geometry']['location']['lng']; // Longitude
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
                'latitude' => $latitude,
                'longitude' => $longitude,
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

}
