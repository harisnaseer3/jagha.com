<?php

namespace App\Http\Controllers;

use App\Events\NewPropertyActivatedEvent;
use App\Http\Controllers\Dashboard\LocationController;
use App\Models\Account;
use App\Models\Agency;
use App\Models\Dashboard\City;
use App\Models\Dashboard\Location;
use App\Models\Dashboard\User;
use App\Models\Property;
use App\Models\PropertyType;
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


class PropertyController extends Controller
{

//    list all featured properties
    public function featuredProperties()
    {
        $properties = (new PropertySearchController)->listingfrontend()
            ->where('properties.platinum_listing', '=', 1);

        $sort = '';
        $limit = '';
        $sort_area = '';

        if (request()->input('sort') !== null)
            $sort = request()->input('sort');
        else
            $sort = 'newest';

        if (request()->input('limit') !== null)
            $limit = request()->input('limit');
        else
            $limit = '15';

        if (request()->input('area_sort') !== null)
            $sort_area = request()->input('area_sort');

        $properties = (new PropertySearchController)->sortPropertyListing($sort, $sort_area, $properties);
        $property_count = $properties->count();
        if (request()->has('page') && request()->input('page') > ceil($property_count / $limit)) {
            $lastPage = ceil((int)$property_count / $limit);
            request()->merge(['page' => (int)$lastPage]);
        }
        $property_types = (new PropertyType)->all();
        (new MetaTagController())->addMetaTags();
        $footer_content = (new FooterController)->footerContent();

        $data = [
            'params' => request()->all(),
            'property_types' => $property_types,
            'properties' => $properties->paginate($limit),
            'recent_properties' => $footer_content[0],
            'footer_agencies' => $footer_content[1],
        ];
        return view('website.pages.property_listing', $data);
    }

    /* function call from top header (nav bar)*/
    public function getPropertyListing(Request $request, string $type)
    {
        $properties = (new PropertySearchController)->listingFrontend()
            ->where('properties.type', '=', $type);

        $sort = '';
        $limit = '';
        $sort_area = '';

        if (request()->input('sort') !== null)
            $sort = request()->input('sort');
        else
            $sort = 'newest';

        if (request()->input('limit') !== null) {
            $limit = request()->input('limit');
        } else
            $limit = '15';

        if (request()->input('area_sort') !== null)
            $sort_area = request()->input('area_sort');

        $properties = (new PropertySearchController)->sortPropertyListing($sort, $sort_area, $properties);
        $property_count = $properties->count();

        if ($request->has('page') && $request->input('page') > ceil($property_count / $limit)) {
            $lastPage = ceil((int)$property_count / $limit);
            $request->merge(['page' => (int)$lastPage]);
        }
        (new MetaTagController())->addMetaTags();

        $property_types = (new PropertyType)->all();
        $footer_content = (new FooterController)->footerContent();


        $data = [
            'params' => $request->all(),
            'property_types' => $property_types,
            'properties' => $properties->paginate($limit),
            'recent_properties' => $footer_content[0],
            'footer_agencies' => $footer_content[1],

        ];
        return view('website.pages.property_listing', $data);
    }

    //    display data on index page
    public function index()
    {
        (new MetaTagController())->addMetaTags();

        $property_types = (new PropertyType)->all();

        // property count table
        $total_count = DB::table('total_property_count')->select('property_count', 'sale_property_count', 'rent_property_count', 'agency_count', 'city_count')->first();
        $footer_content = (new FooterController)->footerContent();

        $data = [
            'total_count' => $total_count,
            'cities_count' => (new CountTableController())->getCitiesCount(),
            'property_types' => $property_types,
            'localBusiness' => (new MetaTagController())->addScriptJsonldTag(),
            'recent_properties' => $footer_content[0],
            'footer_agencies' => $footer_content[1],
        ];
        return view('website.index', $data);
    }

    public function create()
    {
        $unit = (new Account)->select('default_area_unit')->where('user_id', '=', Auth::user()->getAuthIdentifier())->first();

        $property_types = (new PropertyType)->all();
        $counts = (new PropertyBackendListingController)->getPropertyListingCount(Auth::user()->getAuthIdentifier());

        $agencies_ids = DB::table('agency_users')->select('agency_id')->where('user_id', '=', Auth::user()->getAuthIdentifier())->get()->pluck('agency_id')->toArray();

        $agencies_data = (new Agency)->select('title', 'id')
            ->whereIn('id', $agencies_ids)
            ->where('status', '=', 'verified')->get();

        $agencies = [];
        foreach ($agencies_data as $agency) {
            $agencies += array($agency->id => $agency->title);
        }


        $footer_content = (new FooterController)->footerContent();

        return view('website.pages.portfolio',
            ['default_area_unit' => $unit,
                'agencies' => $agencies,
                'property_types' => $property_types,
                'counts' => $counts,
                'recent_properties' => $footer_content[0],
                'footer_agencies' => $footer_content[1]]);
    }

    public function store(Request $request)
    {
        if (request()->hasFile('image')) {
            $error_msg = $this->_imageValidation('image');
            if ($error_msg !== null && count($error_msg)) {
                return redirect()->back()->withErrors($error_msg)->withInput()->with('error', 'Error storing record, try again.');
            }
        }
        if (request()->hasFile('floor_plans')) {
            $error_msg = $this->_imageValidation('floor_plans');
            if (count($error_msg)) {
                return redirect()->back()->withErrors($error_msg)->withInput()->with('error', 'Error storing record, try again.');
            }
        }
        $validator = Validator::make($request->all(), Property::$rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Error storing record, try again.');
        }
        try {
//            dd($request->all());
            $area_values = $this->calculateArea($request->input('unit'), $request->input('land_area'));

            $json_features = '';
            $city = (new City)->select('id', 'name')->where('name', '=', str_replace('_', ' ', $request->input('city')))->first();

            $location = (new LocationController)->store($request, $city);

            $user_id = Auth::user()->getAuthIdentifier();

            if ($request->has('features')) {
                $icon_inputs = preg_grep('/^(.*?(-icon))$/', array_keys($request->all()));
                $icon_value = $request->only($icon_inputs);
                $features_input = $request->except(array_merge($icon_inputs, ['_token', '_method', 'data_index', 'purpose', 'wanted_for', 'property_type', 'property_subtype-Homes', 'property_subtype-Plots', 'property_subtype-Commercial', 'city', 'location', 'property_title', 'description', 'all_inclusive_price', 'land_area',
                    'unit', 'status', 'bedrooms', 'bathrooms', 'contact_person', 'phone', 'mobile', 'fax', 'contact_email', 'features', 'image', 'video_link', 'video_host', 'floor_plans']));
                $features = json_decode(json_encode($features_input), true);
                $json_features = [
                    'features' => $features,
                    'icons' => $icon_value
                ];
            }

            $address = $prepAddr = str_replace(' ', '+', $location['location_name'] . ',' . $city->name . ' Pakistan');
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
            //$max_id = DB::select("SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'property_management' AND TABLE_NAME = 'properties'")[0]->AUTO_INCREMENT;
            //dd(DB::select("SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'property_management' AND TABLE_NAME = 'properties'")[0]->AUTO_INCREMENT);
            //  dd($max_id);
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
                'user_id' => $user_id,
                'city_id' => $city->id,
                'location_id' => $location['location_id'],
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
                'bedrooms' => $request->has('bedrooms') ? $request->input('bedrooms') : 0,
                'bathrooms' => $request->has('bathrooms') ? $request->input('bathrooms') : 0,
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

            if ($request->hasFile('image')) {
                (new ImageController)->store($request, $property);
            }
            if ($request->hasFile('floor_plans')) {
                (new FloorPlanController)->store($request, $property);
            }
            if ($request->filled('video_link')) {
                (new VideoController)->store($request, $property);
            }
            (new CountTableController)->_insert_in_status_purpose_table($property);
            // insertion in count tables when property status is active
            if ($request->has('status') && $request->input('status') === 'active') {
                $dt = Carbon::now();
                $property->activated_at = $dt;

                $expiry = $dt->addMonths(3)->toDateTimeString();
                $property->expired_at = $expiry;
                $property->save();
                (new CountTableController)->_insertion_in_count_tables($city, $location, $property);
            }

            return redirect()->route('properties.listings', ['pending', 'all', (string)$user_id, 'id', 'asc', '10'])->with('success', 'Record added successfully.');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Record not added, try again.');
        }
    }

    // Display detailed page of property
    public function show($slug, Property $property)
    {
        if ($slug !== Str::slug($property->location->name) . '-' . Str::slug($property->title) . '-' . $property->reference)
            return redirect($property->property_detail_path($property->location->name));

        $views = $property->views;
        $property->views = $views + 1;
        $property->save();
        $is_favorite = false;

        if (Auth::check()) {
            $is_favorite = DB::table('favorites')->select('id')
                ->where([
                    ['user_id', '=', Auth::user()->getAuthIdentifier()],
                    ['property_id', '=', $property->id],
                ])->exists();
        }
        $property_types = (new PropertyType)->all();
        $property->city = $property->city->name;
        $property->location = $property->location->name;

        (new MetaTagController())->addMetaTagsAccordingToPropertyDetail($property);
        $footer_content = (new FooterController)->footerContent();
        return view('website.pages.property_detail', [
            'property' => $property,
            'is_favorite' => $is_favorite,
            'property_types' => $property_types,
            'recent_properties' => $footer_content[0],
            'footer_agencies' => $footer_content[1],
        ]);
    }

    public function edit(Property $property)
    {
//        $agency_ids = [];
//        $agencies_ids = DB::table('agency_users')->select('agency_id')->where('user_id', '=', $property->user_id)->get()->toArray();
//
//        foreach ($agencies_ids as $ids) {
//            array_push($agency_ids, $ids->agency_id);
//        }
//        $agencies_data = (new Agency)->whereIn('id', $agency_ids)->where('status', '=', 'verified')->get();
//
//        $agencies = [];
//        foreach ($agencies_data as $agency) {
//            $agencies = array_merge($agencies, [$agency->title => $agency->title]);
//        }
//        dd($property->agency);
//        get name of assigned agency of property
//        $agency
        $city = $property->location->city->name;
        $property->location = $property->location->name;
        $property->city = $city;

        $property->image = (new Property)->find($property->id)->images()->where('name', '<>', 'null')->get(['name', 'id']);
        $property->video = (new Property)->find($property->id)->videos()->where('name', '<>', 'null')->get(['name', 'id', 'host']);
        $property->floor_plan = (new Property)->find($property->id)->floor_plans()->where('name', '<>', 'null')->get(['name', 'id', 'title']);
//        if ((new Agency())->select('title')->where('id', '=', $property->agency_id)->first()) {
//            $property->agency = (new Agency())->select('title')->where('id', '=', $property->agency_id)->first()->title;
//        }
        $property_types = (new PropertyType)->all();
        $counts = (new PropertyBackendListingController)->getPropertyListingCount(Auth::user()->getAuthIdentifier());

        if (Auth::guard('admin')->user()) {
            return view('website.admin-pages.portfolio',
                [
                    'property' => $property,
                    'property_types' => $property_types,
                    'counts' => $counts,
                ]);
        }
        $footer_content = (new FooterController)->footerContent();


        return view('website.pages.portfolio',
            [
                'property' => $property,
                'property_types' => $property_types,
                'counts' => $counts,
                'recent_properties' => $footer_content[0],
                'footer_agencies' => $footer_content[1]
            ]);
    }

    public function update(Request $request, Property $property)
    {
        if (request()->hasFile('image')) {
            $error_msg = $this->_imageValidation('images');

            if ($error_msg !== null && count($error_msg)) {
                return redirect()->back()->withErrors($error_msg)->withInput()->with('error', 'Error storing record, try again.');
            }
        }
        if (request()->hasFile('floor_plans')) {
            $error_msg = $this->_imageValidation('floor plans');
            if (count($error_msg)) {
                return redirect()->back()->withErrors($error_msg)->withInput()->with('error', 'Error storing record, try again.');
            }
        }
        if ($request->has('status') && $request->input('status') == 'rejected') {
            if ($request->has('rejection_reason') && $request->input('rejection_reason') == '') {
                return redirect()->back()->withInput()->with('error', 'Please specify the reason of rejection.');
            } else {
//                TODO: send an email to property user with reason of rejection
                $reason = $request->input('rejection_reason');
                $property_user = User::where('id', '=', $property->user_id)->first();
                $property_user->notify(new PropertyRejectionMail($property, $reason));
            }
        }
        $validator = Validator::make($request->all(), Property::$rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Error storing record, try again.');
        }
        try {
            $json_features = '';
            $city = (new City)->select('id', 'name')->where('name', '=', str_replace('_', ' ', $request->input('city')))->first();
            $location = (new LocationController)->update($request, $city);
            if ($request->has('features')) {
                $icon_inputs = preg_grep('/^(.*?(-icon))$/', array_keys($request->all()));
                $icon_value = $request->only($icon_inputs);
                $features_input = $request->except(array_merge($icon_inputs, ['_token', '_method', 'data_index', 'purpose', 'wanted_for', 'property_type', 'property_subtype-Homes', 'property_subtype-Plots', 'property_subtype-Commercial', 'city', 'location', 'property_title', 'description', 'all_inclusive_price', 'land_area',
                    'unit', 'status', 'bedrooms', 'bathrooms', 'contact_person', 'phone', 'mobile', 'fax', 'contact_email', 'features', 'image', 'video_link', 'video_host', 'floor_plans']));
                $features = json_decode(json_encode($features_input), true);
                $json_features = [
                    'features' => $features,
                    'icons' => $icon_value
                ];
            }

            $area_values = $this->calculateArea($request->input('unit'), $request->input('land_area'));

            $address = $prepAddr = str_replace(' ', '+', $location['location_name'] . ',' . $city->name . ' Pakistan');
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

            $status_before_update = $property->status;

//            $agency = '';
//            if ($request->input('agency')) {
//                $agency = DB::table('agencies')->select('id')->
//                where('title', '=', $request->input('agency'))->where('user_id', '=', $property->user_id)->first();
//            }
            $property = (new Property)->updateOrCreate(['id' => $property->id], [
//                    'reference' => $property->reference,
//                    'user_id' => $property->user_id,
//                    'city_id' => $city->id,
//                    'location_id' => $location['location_id'],
//                    'agency_id' => $agency != '' ? $agency->id : $property->agency_id,
//                    'purpose' => $request->input('purpose'),
//                    'sub_purpose' => $request->has('wanted_for') ? $request->has('wanted_for') : null,
//                    'type' => $request->input('property_type'),
//                    'sub_type' => $subtype,
//                    'title' => $request->input('property_title'),
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
                'bedrooms' => $request->has('bedrooms') ? $request->input('bedrooms') : 0,
                'bathrooms' => $request->has('bathrooms') ? $request->input('bathrooms') : 0,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'features' => $request->has('features') ? json_encode($json_features) : null,
                'status' => $request->has('status') ? $request->input('status') : 'edited',
                'reviewed_by' => $request->has('status') && Auth::guard('admin')->user() ? Auth::guard('admin')->user()->name : null,
                'basic_listing' => 1,
                'contact_person' => $request->input('contact_person'),
                'phone' => $request->input('phone'),
                'cell' => $request->input('mobile'),
                'fax' => $request->input('fax'),
                'email' => $request->input('contact_email'),
                'rejection_reason' => $request->has('rejection_reason') ? $request->input('rejection_reason') : null
            ]);
            if ($request->hasFile('image')) {
                (new ImageController)->update($request, $property);
            }
            if ($request->hasFile('floor_plans')) {
                (new FloorPlanController)->update($request, $property);
            }
            if ($request->filled('video_link')) {
                (new VideoController)->update($request, $property);
            }
            (new CountTableController)->_delete_in_status_purpose_table($property, $status_before_update);
            (new CountTableController)->_insert_in_status_purpose_table($property);
            if ($request->has('status') && $request->input('status') === 'active') {
                $dt = Carbon::now();
                $property->activated_at = $dt;

                $expiry = $dt->addMonths(3)->toDateTimeString();
                $property->expired_at = $expiry;
                $property->save();
//                comment out new property up event
//                event(new NewPropertyActivatedEvent($property));
                (new CountTableController())->_insertion_in_count_tables($city, $location, $property);
            }
            $user = User::where('id', '=', $property->user_id)->first();
            $user->notify(new PropertyStatusChange($property));
            Notification::send($user, new PropertyStatusChangeMail($property));

            if ($status_before_update === 'active' && in_array($request->input('status'), ['edited', 'pending', 'expired', 'uploaded', 'hidden', 'deleted', 'rejected']))
                (new CountTableController())->_on_deletion_insertion_in_count_tables($city, $location, $property);

            $footer_content = (new FooterController)->footerContent();

            if (Auth::guard('admin')->user()) {
                (new PropertyLogController())->store($property);
                return redirect()->route('admin.properties.listings', ['edited', 'all', (string)Auth::user()->getAuthIdentifier(), 'id', 'asc', '50'])->with('success', 'Property updated successfully');
            }

            return redirect()->route('properties.listings',
                ['edited', 'all', (string)Auth::user()->getAuthIdentifier(), 'id', 'asc', '10',
                    'recent_properties' => $footer_content[0],
                    'footer_agencies' => $footer_content[1]])->with('success', 'Property updated successfully');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Record not updated, try again.');
        }
    }

    public function destroy(Request $request)
    {
//        $user_id = Auth::user()->getAuthIdentifier();
        $property = (new Property)->where('id', '=', $request->input('record_id'))->first();
        $status_before_update = $property->status;
        if ($property->exists) {
            try {
                if (Auth::guard('admin')->user())
                    $property->reviewed_by = Auth::guard('admin')->user()->name;

                $property->status = 'deleted';
                $property->save();

                $user = User::where('id', '=', $property->user_id)->first();
                $user->notify(new PropertyStatusChange($property));

                Notification::send($user, new PropertyStatusChangeMail($property));

                $city = (new City)->select('id', 'name')->where('id', '=', $property->city_id)->first();
                $location_obj = (new Location)->select('id', 'name')->where('id', '=', $property->location_id)->first();
                $location = ['location_id' => $location_obj->id, 'location_name' => $location_obj->name];

                if ($status_before_update === 'active' && in_array($request->input('status'), ['edited', 'pending', 'expired', 'uploaded', 'hidden', 'deleted', 'rejected']))
                    (new CountTableController())->_on_deletion_insertion_in_count_tables($city, $location, $property);
                (new CountTableController)->_delete_in_status_purpose_table($property, $status_before_update);
                (new CountTableController)->_insert_in_status_purpose_table($property);

                return redirect()->back()->with('success', 'Record deleted successfully');
            } catch (Throwable $e) {
                return redirect()->back()->with('error', 'Error deleting record, please try again');
            }
        }
        return redirect()->back()->with('error', 'Record not found');
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

        if ($area_unit === 'Marla') {
            $area_in_sqft = $area * 225;
            $area_in_marla = $area_in_sqft / 272;
            $area_in_new_marla = $area_in_sqft / 225;
            $area_in_sqyd = $area_in_sqft / 9;
            $area_in_sqm = $area_in_sqft / 10.7639;
            $area_in_kanal = $area_in_sqft / 5440;
            $area_in_new_kanal = $area_in_sqft / 4500;
        }
//        if ($area_unit === 'Old Marla (272 sqft)') {
//            $area_in_sqft = $area * 272;
//            $area_in_marla = $area_in_sqft / 272;
//            $area_in_new_marla = $area_in_sqft / 225;
//            $area_in_sqyd = $area_in_sqft / 9;
//            $area_in_sqm = $area_in_sqft / 10.7639;
//            $area_in_kanal = $area_in_sqft / 5440;
//            $area_in_new_kanal = $area_in_sqft / 5440;
//            $area_in_new_kanal = $area_in_sqft / 4500;
//        }
        if ($area_unit === 'Square Feet') {
            $area_in_sqft = $area;
            $area_in_marla = $area_in_sqft / 272;
            $area_in_new_marla = $area_in_sqft / 225;
            $area_in_sqyd = $area_in_sqft / 9;
            $area_in_sqm = $area_in_sqft / 10.7639;
            $area_in_kanal = $area_in_sqft / 5440;
            $area_in_new_kanal = $area_in_sqft / 4500;
        }
        if ($area_unit === 'Square Meters') {
            $area_in_sqft = $area * 10.7639;
            $area_in_marla = $area_in_sqft / 272;
            $area_in_new_marla = $area_in_sqft / 225;
            $area_in_sqyd = $area_in_sqft / 9;
            $area_in_sqm = $area_in_sqft / 10.7639;
            $area_in_kanal = $area_in_sqft / 5440;
            $area_in_new_kanal = $area_in_sqft / 4500;
        }
        if ($area_unit === 'Square Yards') {
            $area_in_sqft = $area * 9;
            $area_in_marla = $area_in_sqft / 272;
            $area_in_new_marla = $area_in_sqft / 225;
            $area_in_sqyd = $area_in_sqft / 9;
            $area_in_sqm = $area_in_sqft / 10.7639;
            $area_in_kanal = $area_in_sqft / 5440;
            $area_in_new_kanal = $area_in_sqft / 4500;
        }
        if ($area_unit === 'Kanal') {
            $area_in_sqft = $area * 5440;
            $area_in_marla = $area_in_sqft / 272;
            $area_in_new_marla = $area_in_sqft / 225;
            $area_in_sqyd = $area_in_sqft / 9;
            $area_in_sqm = $area_in_sqft / 10.7639;
            $area_in_kanal = $area_in_sqft / 5440;
            $area_in_new_kanal = $area_in_sqft / 4500;
        }
        return [
            'new_marla' => $area_in_new_marla,
            'sqft' => $area_in_sqft,
            'sqyd' => $area_in_sqyd,
            'sqm' => $area_in_sqm,
            'marla' => $area_in_marla,
            'kanal' => $area_in_kanal,
            'new_kanal' => $area_in_new_kanal];

    }

    private function _imageValidation($type)
    {
        if ($type == 'image') {
            $error_msg = [];
            if (count(request()->file('image')) > 60) {
                $error_msg['image.' . 0] = 'Only 60 ' . ' images are allowed to upload.';
                return $error_msg;
            }
            foreach (request()->file('image') as $index => $file) {
                $mime = $file->getMimeType();
                $supported_mime_types = ['image/png', 'image/jpeg', 'image/jpg'];
                if (!in_array($mime, $supported_mime_types)) {
                    $error_msg['image.' . $index] = ' image' . ($index + 1) . 'must be a file of type: jpeg, png, jpg';
                }
            }
            return $error_msg;
        }
        if ($type == 'floor_plans') {
            $error_msg = [];
//            $allowed_height = 400;
//            $allowed_width = 750;
            if (count(request()->file('floor_plans')) > 2) {
                $error_msg['floor_plans.' . 0] = 'Only 2 ' . ' floor plans are allowed to upload.';
                return $error_msg;
            }
            foreach (request()->file('floor_plans') as $index => $file) {
                $mime = $file->getMimeType();
                $supported_mime_types = ['image/png', 'image/jpeg', 'image/jpg'];
                if (!in_array($mime, $supported_mime_types)) {
                    $error_msg['image.' . $index] = ' image' . ($index + 1) . 'must be a file of type: jpeg, png, jpg';
                }
            }
            return $error_msg;
        }
    }
}
