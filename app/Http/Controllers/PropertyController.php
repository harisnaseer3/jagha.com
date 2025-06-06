<?php

namespace App\Http\Controllers;

use App\Events\NotifyAdminOfEditedProperty;
use App\Events\NotifyAdminOfNewProperty;
use App\Events\UserErrorEvent;
use App\Http\Controllers\Dashboard\LocationController;

use App\Jobs\SendNotificationOnPropertyUpdate;
use App\Models\Account;
use App\Models\Agency;
use App\Models\Dashboard\City;
use App\Models\Dashboard\Location;
use App\Models\Dashboard\User;
use App\Models\Property;
use App\Models\PropertyType;

use Exception;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Throwable;

class PropertyController extends Controller
{

//    list all featured properties
    public function featuredProperties(Request $request)
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
        if ($request->ajax()) {
            $data['view'] = View('website.components.property-listings',
                [
                    'limit' => $limit,
                    'area_sort' => $sort_area,
                    'sort' => $sort,
                    'params' => $request->all(),
                    'properties' => $properties->paginate($limit)
                ])->render();
            return $data;
        }
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
        if (!(User::findUserByEmail($request->has('contact_email')))) {
            if (!$request->input('contact_email'))
                return redirect()->back()->withInput()->with('error', 'User with the provided Contact Email not exist. Please Recheck your email.');
        }

        $validator = Validator::make($request->all(), Property::$rules);
        if ($validator->fails()) {
//            dd($validator->errors());
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Error storing record, try again.');
        }
        try {
            $area_values = $this->calculateArea($request->input('unit'), $request->input('land_area'));

            $json_features = '';
            $city = (new City)->select('id', 'name')->where('name', '=', str_replace('_', ' ', $request->input('city')))->first();

            $location = '';

            if ($request->has('location')) {
                $location = Location::select('id', 'name', 'latitude', 'longitude', 'is_active')->where('name', '=', $request->input('location'))->where('city_id', '=', $city->id)->first();
            } else if ($request->has('add_location')) {
                $location = Location::select('id', 'name', 'latitude', 'longitude', 'is_active')->where('name', '=', $request->input('add_location'))->where('city_id', '=', $city->id)->first();
                if (!$location) {
                    $location = (new LocationController)->store($request->input('add_location'), $city);
                }
            }

            if ($location->is_active && $location->longitude == null && $location->latitude == null) {
                (new LocationController)->getLngLat($location, $city);
            }


            $user_id = Auth::user()->getAuthIdentifier();

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
                    'property_agency-error'
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

//            $max_id = DB::table('properties')->select('id')->pluck('id')->last();
            $max_id = DB::table('properties')->select('id')->orderBy('id', 'desc')->first()->id;
            $max_id = $max_id + 1;

            $reference = date("Y") . '-' . str_pad($max_id, 8, 0, STR_PAD_LEFT);
            $agency = '';
            if ($request->has('agency')) {
                if (DB::table('agencies')->where('id', '=', $request->input('agency'))->exists()) {
                    $agency = $request->input('agency');
                }
            }


            $property_id = DB::table('properties')->insertGetId([
                'reference' => $reference,
                'user_id' => $user_id,
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

            $property = DB::table('properties')->where('id', $property_id)->first();

            if ($request->has('image') && $request->input('image') !== '' && $request->input('image') !== '[]' && $request->input('image') !== null) {
                (new ImageController)->storeImage($request->input('image'), $property);
            }

            if ($request->filled('video_link')) {
                (new VideoController)->store($request, $property);
            }
            (new CountTableController)->_insert_in_status_purpose_table($property);
            // insertion in count tables when property status is active
//            if ($request->has('status') && $request->input('status') === 'active') {
//                $property->activated_at = Carbon::now();
//                $dt = Carbon::now();
//
//                $expiry = $dt->addMonths(3)->toDateTimeString();
//                $property->expired_at = $expiry;
//                $property->save();
//
//                (new CountTableController)->_insertion_in_count_tables($city, $location, $property);

//                Add water mark on image
//                AddWaterMark::dispatch($property);
//                dd($property->images);
//                $this->dispatch(new AddWaterMark($property));
//            }
            event(new NotifyAdminOfNewProperty($property));

            return redirect()->route('properties.listings', ['pending', 'all', (string)$user_id, 'id', 'desc', '10'])->with('success', 'Record added successfully.Your ad will be live in 24 hours after verification of provided information.');
        } catch (Exception $e) {
            event(new UserErrorEvent($e->getMessage(), Auth::user()));
//            dd($e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Record not added, try again.');
        }
    }

    // Display detailed page of property
    public function show($slug, Property $property)
    {
        if ($property->id > 104280) {  //new properties have city name in url
            if ($slug !== Str::slug($property->city->name) . '-' . Str::slug($property->location->name) . '-' . Str::slug($property->title) . '-' . $property->reference)
                return redirect($property->property_detail_path_with_city($property->location->name));
        } else {
            if ($slug !== Str::slug($property->location->name) . '-' . Str::slug($property->title) . '-' . $property->reference)
                return redirect($property->property_detail_path($property->location->name));
        }
        //   TODO: remove this after test
//        $args = array(
//            'property_id' => $property->id,
//            'url' => \request()->url(),
//            'ip' => HitController::getIP(),
//        );
//        TrackUrlController::store($args);
        ///////////

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
//        DB::table('google_api_log')->where('id', 1)->increment('count', 1);

        return view('website.pages.property_detail', [
            'property_count' => $property->agency_id !== null ? $this->agencyCountOnDetailPage($property->agency_id) : 0,
            'property' => $property,
            'is_favorite' => $is_favorite,
            'property_types' => $property_types,
            'recent_properties' => $footer_content[0],
            'footer_agencies' => $footer_content[1],
        ]);
    }

//    public function agencyCountOnDetailPage($id)
//    {
//        return DB::table('agencies')->select('property_count_by_agencies.property_count AS count')->where('agencies.id', '=', $id)
//            ->leftJoin('property_count_by_agencies', 'property_count_by_agencies.agency_id', '=', 'agencies.id')
//            ->where('property_count_by_agencies.property_status', '=', 'active')->pluck('count')->toArray()[0];
//    }

    public function agencyCountOnDetailPage($id)
    {
        $count = DB::table('agencies')
            ->select('property_count_by_agencies.property_count AS count')
            ->where('agencies.id', '=', $id)
            ->leftJoin('property_count_by_agencies', 'property_count_by_agencies.agency_id', '=', 'agencies.id')
            ->where('property_count_by_agencies.property_status', '=', 'active')
            ->pluck('count')
            ->toArray();

        // Check if the array is empty
        if (empty($count)) {
            return 0;
        }

        // Directly return the first element as an integer
        return (int) $count[0];
    }

    public function edit(Property $property)
    {
        if (Auth::guard('web')->check()) {
            if (!(Property::getPropertyUpdateCountById($property))) {
                return redirect()->back()->with('error', 'Maximum Update Limit Reached for Property ID: ' . $property->id);
            }

        }

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
            [
                'agencies' => $agencies,
                'property' => $property,
                'property_types' => $property_types,
                'users' => $users,
                'counts' => $counts,
                'recent_properties' => $footer_content[0],
                'footer_agencies' => $footer_content[1]
            ]);
    }

    public function update(Request $request, Property $property)
    {

        if ($request->has('contact_email')) {
            if (!(new User)->where('email', $request->input('contact_email'))->exists())
                return redirect()->back()->withInput()->with('error', 'User with the provided Contact Email not exist. Please Recheck your email.');
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

            $area_values = $this->calculateArea($request->input('unit'), $request->input('land_area'));
            $status_before_update = $property->status;
            (new CountTableController)->_delete_in_status_purpose_table($property, $status_before_update);

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

            $city = DB::table('cities')->select('id', 'name')->where('name', '=', str_replace('_', ' ', $request->input('city')))->first();
            $location = DB::table('locations')->select('id', 'name')->where('name', '=', $request->input('location'))->where('city_id', '=', $city->id)->first();

            $this->dispatch(new SendNotificationOnPropertyUpdate($property));

            if ($status_before_update === 'active') {
                (new CountTableController())->_on_deletion_insertion_in_count_tables($city, $location, $property);


            }
            if ($property->status == 'pending')
                event(new NotifyAdminOfEditedProperty($property));

            $footer_content = (new FooterController)->footerContent();


            return redirect()->route('properties.listings',
                ['pending', 'all', (string)Auth::user()->getAuthIdentifier(), 'id', 'desc', '10',
                    'recent_properties' => $footer_content[0],
                    'footer_agencies' => $footer_content[1]])->with('success', 'Property with ID ' . $property->id . ' updated successfully.');
        } catch (Exception $e) {
//            dd($e->getMessage());
            event(new UserErrorEvent($e->getMessage(), Auth::user()));
            return redirect()->back()->withInput()->with('error', 'Record not updated, try again.');
        }
    }

    public function destroy(Request $request)
    {
//        $user_id = Auth::user()->getAuthIdentifier();
        $property = (new Property)->where('id', '=', $request->input('record_id'))->first();

        if ($request->has('status') && $request->input('status') == 'deleted') {
            if (Auth()->guard('admin')->check()) {
                if (!Auth::guard('admin')->user()->can('Delete Properties')) {
                    return redirect()->back()->with('error', 'User does not have the right permissions.');
                }
            }
        }
        $status_before_update = $property->status;

        if ($property->exists) {
            try {
                if (Auth::guard('admin')->user())
                    $property->reviewed_by = Auth::guard('admin')->user()->name;

                $property->status = 'deleted';
                $property->activated_at = null;
                $property->save();

                $this->dispatch(new SendNotificationOnPropertyUpdate($property));

                $city = (new City)->select('id', 'name')->where('id', '=', $property->city_id)->first();
                $location = Location::select('id', 'name')->where('id', '=', $property->location_id)->where('city_id', '=', $city->id)->first();

                if ($status_before_update === 'active') {
                    (new CountTableController())->_on_deletion_insertion_in_count_tables($city, $location, $property);
                }

                (new CountTableController)->_delete_in_status_purpose_table($property, $status_before_update);
                (new CountTableController)->_insert_in_status_purpose_table($property);

                return redirect()->back()->with('success', 'Record deleted successfully');
            } catch (Throwable $e) {
                event(new UserErrorEvent($e->getMessage(), Auth::user()));
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
