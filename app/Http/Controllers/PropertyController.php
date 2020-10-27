<?php

namespace App\Http\Controllers;

use App\Events\NewPropertyActivatedEvent;
use App\Http\Controllers\Dashboard\LocationController;
use App\Models\Account;
use App\Models\Admin;
use App\Models\Agency;
use App\Models\Dashboard\City;
use App\Models\Dashboard\Location;
use App\Models\Dashboard\User;
use App\Models\FloorPlan;
use App\Models\Image;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\Video;
use App\Notifications\PropertyRejectionMail;
use App\Notifications\PropertyStatusChange;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Throwable;


class PropertyController extends Controller
{

    function listingFrontend()
    {
        return (new Property)
            ->select('properties.id', 'properties.reference', 'properties.purpose', 'properties.sub_purpose', 'properties.sub_type', 'properties.type', 'properties.title', 'properties.description',
                'properties.price', 'properties.land_area', 'properties.area_unit', 'properties.bedrooms', 'properties.bathrooms', 'properties.features', 'properties.premium_listing',
                'properties.super_hot_listing', 'properties.hot_listing', 'properties.magazine_listing', 'properties.contact_person', 'properties.phone', 'properties.cell',
                'properties.fax', 'properties.email', 'properties.favorites', 'properties.views', 'properties.status', 'f.user_id AS user_favorite', 'properties.created_at',
                'properties.updated_at', 'locations.name AS location', 'cities.name AS city', 'p.name AS image',
                'properties.area_in_sqft', 'area_in_sqyd', 'area_in_marla', 'area_in_new_marla', 'area_in_kanal', 'area_in_new_kanal', 'area_in_sqm',
                'agencies.title AS agency', 'agencies.featured_listing', 'agencies.logo AS logo', 'agencies.key_listing', 'agencies.status AS agency_status',
                'agencies.phone AS agency_phone', 'agencies.ceo_name AS agent', 'agencies.created_at AS agency_created_at', 'agencies.description AS agency_description',
                'property_count_by_agencies.property_count AS agency_property_count',
                'users.community_nick AS user_nick_name', 'users.name AS user_name')
            ->where('properties.status', '=', 'active')
            ->whereNull('properties.deleted_at')
            ->leftJoin('images as p', function ($q) {
                $q->on('p.property_id', '=', 'properties.id')
                    ->on('p.name', '=', DB::raw('(select name from images where images.property_id = properties.id  limit 1 )'));
            })
            ->join('locations', 'properties.location_id', '=', 'locations.id')
            ->join('cities', 'properties.city_id', '=', 'cities.id')
            ->leftjoin('agencies', 'properties.agency_id', '=', 'agencies.id')
            ->leftJoin('favorites as f', function ($f) {
                $f->on('properties.id', '=', 'f.property_id')
                    ->where('f.user_id', '=', Auth::user() ? Auth::user()->getAuthIdentifier() : 0);
            })
            ->leftJoin('property_count_by_agencies', 'agencies.id', '=', 'property_count_by_agencies.agency_id')
            ->join('users', 'properties.user_id', '=', 'users.id');
    }

    function sortPropertyListing($sort, $sort_area, $properties)
    {
        if ($sort_area === 'higher_area') $properties->orderBy('area_in_sqft', 'DESC');
        else if ($sort_area === 'lower_area') $properties->orderBy('area_in_sqft', 'ASC');

        if ($sort === 'newest') $properties->orderBy('created_at', 'DESC');
        else if ($sort === 'oldest') $properties->orderBy('created_at', 'ASC');
        else if ($sort === 'high_price') $properties->orderBy('price', 'DESC');
        else if ($sort === 'low_price') $properties->orderBy('price', 'ASC');
        return $properties;
    }

    public function getFeaturedProperties()
    {

        $featured_properties = $this->listingfrontend()
            ->where('properties.platinum_listing', '=', 1)
            ->orderBy('views', 'DESC')
            ->limit(10)
            ->get();
        $data['view'] = View('website.components.feature_properties',
            [
                'featured_properties' => $featured_properties
            ])->render();

        return $data;

    }

    public function getPopularPlaces()
    {

        $popular_locations = (new CountTableController())->popularLocations();
        $data['view'] = View('website.components.popular_places',
            [
                'popular_cities_homes_on_sale' => $popular_locations['popular_cities_homes_on_sale'],
                'popular_cities_plots_on_sale' => $popular_locations['popular_cities_plots_on_sale'],
                'city_wise_homes_data' => [
                    'karachi' => $popular_locations['city_wise_homes_data']['karachi'],
                    'peshawar' => $popular_locations['city_wise_homes_data']['peshawar'],
                    'lahore' => $popular_locations['city_wise_homes_data']['lahore'],
                    'Islamabad/Rawalpindi' => $popular_locations['city_wise_homes_data']['rawalpindi/Islamabad']
                ],
                'city_wise_plots_data' => [
                    'karachi' => $popular_locations['city_wise_plots_data']['karachi'],
                    'peshawar' => $popular_locations['city_wise_plots_data']['peshawar'],
                    'lahore' => $popular_locations['city_wise_plots_data']['lahore'],
                    'Islamabad/Rawalpindi' => $popular_locations['city_wise_plots_data']['rawalpindi/Islamabad']
                ],
                'city_wise_commercial_data' => [
                    'karachi' => $popular_locations['city_wise_commercial_data']['karachi'],
                    'peshawar' => $popular_locations['city_wise_commercial_data']['peshawar'],
                    'lahore' => $popular_locations['city_wise_commercial_data']['lahore'],
                    'Islamabad/Rawalpindi' => $popular_locations['city_wise_commercial_data']['rawalpindi/Islamabad']
                ],
                'popular_cities_commercial_on_sale' => $popular_locations['popular_cities_commercial_on_sale'],
                'popular_cities_property_on_rent' => $popular_locations['popular_cities_property_on_rent'],
            ])->render();

        return $data;

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
//            'key_agencies' => (new AgencyController())->keyAgencies(),
//            'featured_agencies' => (new AgencyController())->FeaturedAgencies(),
            'property_types' => $property_types,
            'localBusiness' => (new MetaTagController())->addScriptJsonldTag(),
            'recent_properties' => $footer_content[0],
            'footer_agencies' => $footer_content[1],
        ];
        return view('website.index', $data);
    }

//    list all featured properties
    public function featuredProperties(Request $request)
    {
//        on a specific limit if last page greater than first page return to page 1
        $properties = $this->listingfrontend()
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

        $properties = $this->sortPropertyListing($sort, $sort_area, $properties);
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

    public function create()
    {
        $unit = (new Account)->select('default_area_unit')->where('user_id', '=', Auth::user()->getAuthIdentifier())->first();

        $property_types = (new PropertyType)->all();
        $counts = $this->getPropertyListingCount(Auth::user()->getAuthIdentifier());

        $agency_ids = [];
        $agencies_ids = DB::table('agency_users')->select('agency_id')->where('user_id', '=', Auth::user()->getAuthIdentifier())->get()->toArray();
        foreach ($agencies_ids as $ids) {
            array_push($agency_ids, $ids->agency_id);
        }

        $agencies_data = (new Agency)->whereIn('id', $agency_ids)->where('status', '=', 'verified')->get();

        $agencies = [];
        foreach ($agencies_data as $agency) {
            $agencies = array_merge($agencies, [$agency->title => $agency->title]);
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

    private function _imageValidation($type)
    {
        if ($type == 'image') {
            $error_msg = [];
            $allowed_height = 600;
            $allowed_width = 750;

            if (count(request()->file('image')) > 60) {
                $error_msg['image.' . 0] = 'Only 60 ' . ' images are allowed to upload.';
                return $error_msg;
            }
            foreach (request()->file('image') as $index => $file) {
                $width = getimagesize($file)[0];
                $height = getimagesize($file)[1];
                if ($height == $allowed_height && $width == $allowed_width) {
                    continue;
                } else {
                    $error_msg['image.' . $index] = 'image' . ($index + 1) . ' has invalid image dimensions';
                }

            }
            return $error_msg;
        }
        if ($type == 'floor_plans') {
            $error_msg = [];
            $allowed_height = 400;
            $allowed_width = 750;

            if (count(request()->file('floor_plans')) > 2) {
                $error_msg['floor_plans.' . 0] = 'Only 2 ' . ' floor plans are allowed to upload.';
                return $error_msg;
            }
            foreach (request()->file('floor_plans') as $index => $file) {
                $width = getimagesize($file)[0];
                $height = getimagesize($file)[1];
                if ($height == $allowed_height && $width == $allowed_width) {
                    continue;
                } else {
                    $error_msg['floor_plans.' . $index] = 'floor_plans' . ($index + 1) . ' has invalid image dimensions';
                }
            }
            return $error_msg;
        }
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
            if ($request->input('agency')) {
                $agency = DB::table('agencies')->select('id')->where('title', '=', $request->input('agency'))->where('user_id', '=', $user_id)->first();
            }

            $property = (new Property)->Create([
                'reference' => $reference,
                'user_id' => $user_id,
                'city_id' => $city->id,
                'location_id' => $location['location_id'],
                'agency_id' => $agency != '' ? $agency->id : null,
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
//            dd($e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Record not added, try again.');
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

        if ($area_unit === 'New Marla (225 sqft)') {
            $area_in_sqft = $area * 225;
            $area_in_marla = $area_in_sqft / 272;
            $area_in_new_marla = $area_in_sqft / 225;
            $area_in_sqyd = $area_in_sqft / 9;
            $area_in_sqm = $area_in_sqft / 10.7639;
            $area_in_kanal = $area_in_sqft / 5440;
            $area_in_new_kanal = $area_in_sqft / 4500;
        }
        if ($area_unit === 'Old Marla (272 sqft)') {
            $area_in_sqft = $area * 272;
            $area_in_marla = $area_in_sqft / 272;
            $area_in_new_marla = $area_in_sqft / 225;
            $area_in_sqyd = $area_in_sqft / 9;
            $area_in_sqm = $area_in_sqft / 10.7639;
            $area_in_kanal = $area_in_sqft / 5440;
            $area_in_new_kanal = $area_in_sqft / 5440;
//            $area_in_new_kanal = $area_in_sqft / 4500;
        }
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

    //    Display detailed page of property
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
        $agency_ids = [];
        $agencies_ids = DB::table('agency_users')->select('agency_id')->where('user_id', '=', $property->user_id)->get()->toArray();

        foreach ($agencies_ids as $ids) {
            array_push($agency_ids, $ids->agency_id);
        }
        $agencies_data = (new Agency)->whereIn('id', $agency_ids)->where('status', '=', 'verified')->get();

        $agencies = [];
        foreach ($agencies_data as $agency) {
            $agencies = array_merge($agencies, [$agency->title => $agency->title]);
        }
//        get name of assigned agency of property
//        $agency
        $city = $property->location->city->name;
        $property->location = $property->location->name;
        $property->city = $city;
        $property->image = (new Property)->find($property->id)->images()->where('name', '<>', 'null')->get(['name', 'id']);
        $property->video = (new Property)->find($property->id)->videos()->where('name', '<>', 'null')->get(['name', 'id', 'host']);
        $property->floor_plan = (new Property)->find($property->id)->floor_plans()->where('name', '<>', 'null')->get(['name', 'id', 'title']);
        if ((new Agency())->select('title')->where('id', '=', $property->agency_id)->first()) {
            $property->agency = (new Agency())->select('title')->where('id', '=', $property->agency_id)->first()->title;
        }
        $property_types = (new PropertyType)->all();
        $counts = $this->getPropertyListingCount(Auth::user()->getAuthIdentifier());

        if (Auth::guard('admin')->user()) {
            return view('website.admin-pages.portfolio',
                [
                    'agencies' => $agencies,
                    'property' => $property,
                    'property_types' => $property_types,
                    'counts' => $counts,
                ]);
        }
        $footer_content = (new FooterController)->footerContent();


        return view('website.pages.portfolio',
            [
                'agencies' => $agencies,
                'property' => $property,
                'property_types' => $property_types,
                'counts' => $counts,
                'recent_properties' => $footer_content()[0],
                'footer_agencies' => $footer_content()[1]
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

            $agency = '';
            if ($request->input('agency')) {
                $agency = DB::table('agencies')->select('id')->
                where('title', '=', $request->input('agency'))->where('user_id', '=', $property->user_id)->first();
            }

            $property = (new Property)->updateOrCreate(['id' => $property->id], [
                'reference' => $property->reference,
                'user_id' => $property->user_id,
                'city_id' => $city->id,
                'location_id' => $location['location_id'],
                'agency_id' => $agency != '' ? $agency->id : $property->agency_id,
                'purpose' => $request->input('purpose'),
                'sub_purpose' => $request->has('wanted_for') ? $request->has('wanted_for') : null,
                'type' => $request->input('property_type'),
                'sub_type' => $subtype,
                'title' => $request->input('property_title'),
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
            if ($request->has('status') && $request->input('status') === 'active') {
                $dt = Carbon::now();
                $property->activated_at = $dt;

                $expiry = $dt->addMonths(3)->toDateTimeString();
                $property->expired_at = $expiry;
                $property->save();
                event(new NewPropertyActivatedEvent($property));
                (new CountTableController())->_insertion_in_count_tables($city, $location, $property);
            }
            $user = User::where('id', '=', $property->user_id)->first();
            $user->notify(new PropertyStatusChange($property));

            if ($status_before_update === 'active' && in_array($request->input('status'), ['edited', 'pending', 'expired', 'uploaded', 'hidden', 'deleted', 'rejected']))
                (new CountTableController())->_on_deletion_insertion_in_count_tables($city, $location, $property);

            (new PropertyLogController())->store($property);
            $footer_content = (new FooterController)->footerContent();


            if (Auth::guard('admin')->user())
                return redirect()->route('admin.properties.listings', ['edited', 'all', (string)Auth::user()->getAuthIdentifier(), 'id', 'asc', '50'])->with('success', 'Property updated successfully');

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

                $city = (new City)->select('id', 'name')->where('id', '=', $property->city_id)->first();
                $location_obj = (new Location)->select('id', 'name')->where('id', '=', $property->location_id)->first();
                $location = ['location_id' => $location_obj->id, 'location_name' => $location_obj->name];

                if ($status_before_update === 'active' && in_array($request->input('status'), ['edited', 'pending', 'expired', 'uploaded', 'hidden', 'deleted', 'rejected']))
                    (new CountTableController())->_on_deletion_insertion_in_count_tables($city, $location, $property);

                return redirect()->back()->with('success', 'Record deleted successfully');
            } catch (Throwable $e) {
                return redirect()->back()->with('error', 'Error deleting record, please try again');
            }
        }
        return redirect()->back()->with('error', 'Record not found');
    }

    /*
     * Display the specified resource under various categories like Active, Edited, Pending, Expired, Uploaded, Hidden, Deleted, Rejected, Rejected Images, Rejected Videos
     *
     * @param string status     required    active|edited|pending|expired|uploaded|hidden|deleted|rejected|rejected_images|rejected_videos
     * @param string user       optional    id|all
     */

    private function listingsCount($status, $user)
    {
        $condition = ['property_status' => $status, 'user_id' => $user];
        return DB::table('property_count_by_status_and_purposes')->select(DB::raw('sum(property_count) as count'))->where($condition);

    }

    private function _listings(string $status, string $user)
    {
        // TODO: make migration for handling quota_used and image_views
        $listings = (new Property)
            ->select('properties.id', 'sub_type AS type', 'properties.expired_at', 'properties.reference',
                'properties.status', 'locations.name AS location', 'cities.name as city',
                'properties.activated_at', 'properties.expired_at', 'properties.reviewed_by', 'properties.basic_listing', 'properties.bronze_listing', 'properties.silver_listing', 'properties.golden_listing', 'properties.platinum_listing',
                'price', 'properties.created_at AS listed_date', DB::raw("'0' AS quota_used"),
                DB::raw("'0' AS image_views"))
            ->join('locations', 'properties.location_id', '=', 'locations.id')
            ->join('cities', 'properties.city_id', '=', 'cities.id')
            ->whereNull('properties.deleted_at');
        // user
//        TODO: based on property role admin
//        if (!Auth::user()->hasRole('Admin')) {
        if (!Auth::guard('admin')->user()) {
            if (empty($user)) {
                $user = Auth::user()->getAuthIdentifier();
            } elseif ($user === 'all') {
                // listing of all users of the agency
                $listings->whereIn('properties.user_id', DB::table('agency_users')
                    ->select('agency_users.user_id')
                    ->where('agency_id', '=', DB::table('agencies')
                        ->join('agency_users', 'agencies.id', '=', 'agency_users.agency_id')
                        ->select('agencies.id')
                        ->where('agency_users.user_id', '=', Auth::user()->getAuthIdentifier())->value('agencies.id'))
                    ->pluck('agency_users.user_id'));
            } else {
                if (intval($user) === Auth::user()->getAuthIdentifier()) {
                    // listing of logged in user
                    $listings->where('properties.user_id', '=', $user);
                } else {
                    $agency_users = DB::table('agency_users')
                        ->select('agency_users.user_id')->where('agency_id', '=', DB::table('agency_users')
                            ->select('agency_id')
                            ->where('agency_users.user_id', '=', Auth::user()->getAuthIdentifier())->value('agency_id'));

                    // check if user is member of the agency
                    if ($agency_users->count() === 0) {
                        return redirect()->back(302)->withInput()->withErrors(['message', 'Invalid user provided.']);
                    }

                    // listing of user who is member of the agency
                    $listings->whereIn('properties.user_id', $agency_users->get()->toArray());
                }
            }
        }
        return $listings->where('status', '=', $status);
    }

    /*
     * Display the specified resource under various categories like Active, Edited, Pending, Expired, Uploaded, Hidden, Deleted, Rejected, Rejected Images, Rejected Videos
     *
     * @param string status     required    active|edited|pending|expired|uploaded|hidden|deleted|rejected|rejected_images|rejected_videos
     * @param string purpose    required    all|sale|rent|wanted|super_hot_listing|hot_listing|magazine_listing
     * @param string user       optional    id|all
     * @param string sort       optional    id|type|location|price|expiry|views|image_count
     * @param string order      optional    asc|desc
     * @param string page       optional    10|15|30|50
     */

    private function _getPropertiesByPurpose($purpose, $condition, $status, $order, $user, $sort, $page)
    {
        $all = null;
        $sale = null;
        $rent = null;
        $wanted = null;
        $golden = null;
        $silver = null;
        $basic = null;
        $bronze = null;
        $platinum = null;
        if ($purpose === 'all') {
            $all = $this->_listings($status, $user)->where($condition)->orderBy($sort, $order)->paginate($page);
        }
        if ($purpose === 'sale') {
            $sale = $this->_listings($status, $user)->where('purpose', '=', 'sale')->orderBy($sort, $order)->where($condition)->paginate($page);
        }
        if ($purpose === 'rent') {
            $rent = $this->_listings($status, $user)->where('purpose', '=', 'rent')->orderBy($sort, $order)->where($condition)->paginate($page);
        }
        if ($purpose === 'wanted') {
            $wanted = $this->_listings($status, $user)->where('purpose', '=', 'wanted')->orderBy($sort, $order)->where($condition)->paginate($page);
        }
        if ($purpose === 'golden') {
            $golden = $this->_listings($status, $user)->where('golden_listing', '=', 1)->orderBy($sort, $order)->where($condition)->paginate($page);
        }
        if ($purpose === 'silver') {
            $silver = $this->_listings($status, $user)->where('silver_listing', '=', 1)->orderBy($sort, $order)->where($condition)->paginate($page);
        }
        if ($purpose === 'basic') {
            $basic = $this->_listings($status, $user)->where('basic_listing', '=', 1)->orderBy($sort, $order)->where($condition)->paginate($page);
        }
        if ($purpose === 'bronze') {
            $bronze = $this->_listings($status, $user)->where('bronze_listing', '=', 1)->orderBy($sort, $order)->where($condition)->paginate($page);
        }
        if ($purpose === 'platinum') {
            $platinum = $this->_listings($status, $user)->where('platinum_listing', '=', 1)->orderBy($sort, $order)->where($condition)->paginate($page);
        }
        return ['all' => $all, 'sale' => $sale, 'rent' => $rent, 'wanted' => $wanted, 'golden' => $golden, 'platinum' => $platinum, 'silver' => $silver, 'basic' => $basic, 'bronze' => $bronze];
    }

    public function listings(string $status, string $purpose, string $user, string $sort, string $order, string $page, Request $request)
    {
        $property_count = $this->getPropertyListingCount($user);
        $footer_content = (new FooterController)->footerContent();

        if ($request->has('id')) {
            $condition = ['properties.id' => $request->input('id')];
            $result = $this->_getPropertiesByPurpose($purpose, $condition, $status, $order, $user, $sort, $page);
            $data = [
                'params' => [
                    'status' => $status,
                    'purpose' => $purpose,
                    'user' => 'admin',
                    'sort' => $sort,
                    'order' => $order,
                    'page' => $page,
                ],
                'counts' => $property_count,
                'listings' => [
                    'all' => $result['all'],
                    'sale' => $result['sale'],
                    'rent' => $result['rent'],
                    'wanted' => $result['wanted'],
                    'basic' => $result['basic'],
                    'silver' => $result['silver'],
                    'bronze' => $result['bronze'],
                    'golden' => $result['golden'],
                    'platinum' => $result['platinum'],
                ],
            ];

            return view('website.admin-pages.listings', $data);
        } else if ($request->has('reference')) {
            $condition = ['properties.reference' => $request->input('reference')];
            $result = $this->_getPropertiesByPurpose($purpose, $condition, $status, $order, $user, $sort, $page);
            $data = [
                'params' => [
                    'status' => $status,
                    'purpose' => $purpose,
                    'user' => $user,
                    'sort' => $sort,
                    'order' => $order,
                    'page' => $page,
                ],
                'notifications' => Auth()->user()->unreadNotifications,
                'counts' => $property_count,
                'listings' => [
                    'all' => $result['all'],
                    'sale' => $result['sale'],
                    'rent' => $result['rent'],
                    'wanted' => $result['wanted'],
                    'basic' => $result['basic'],
                    'silver' => $result['silver'],
                    'bronze' => $result['bronze'],
                    'golden' => $result['golden'],
                    'platinum' => $result['platinum'],
                ],
                'recent_properties' => $footer_content[0],
                'footer_agencies' => $footer_content[1]
            ];
            if ($data['listings']['all'])
                return redirect()->back()->withInput()->with('error', 'Property not found.');

            return view('website.pages.listings', $data);
        }

        // TODO: implement code where status is rejected_images or rejected_videos, remove after
        if (in_array($status, ['rejected_images', 'rejected_videos'])) {
            return abort(404, 'Missing implementation');
        }

        // listing of status
        $status = strtolower($status);
        if (!in_array($status, ['active', 'edited', 'pending', 'expired', 'uploaded', 'hidden', 'deleted', 'rejected', 'sold', 'rejected_images', 'rejected_videos'])) {
            return redirect()->back(302)->withInput()->withErrors(['message', 'Invalid status provided.']);
        }

        // sort by field
        $sort = strtolower($sort);
        if (!in_array($sort, ['id', 'type', 'location', 'price', 'expiry', 'views', 'image_count'])) {
            $sort = 'id';
        } elseif ($sort === 'image_count') {
            // TODO: find image count and make it part of query
            // $listings->join('images', 'properties.id', '=', 'images.properties.id');
            $sort = 'id';
        } else {
            if ($sort === 'id') $sort = 'properties.id';
            elseif ($sort === 'type') $sort = 'sub_type';
            elseif ($sort === 'location') $sort = 'locations.name';
            elseif ($sort === 'expiry') $sort = 'created_at';
        }


        // order -> ascending or descending
        $order = strtolower($order);
        if (!in_array($order, ['asc', 'desc'])) {
            $order = 'asc';
        }

        // pagination
        if (!in_array($page, [10, 15, 30, 50])) {
            $page = 10;
        }

        if (Auth::guard('admin')->user()) {
            $condition = [];
            $result = $this->_getPropertiesByPurpose($purpose, $condition, $status, $order, $user, $sort, $page);

            $data = [
                'params' => [
                    'status' => $status,
                    'purpose' => $purpose,
                    'user' => $user,
                    'sort' => $sort,
                    'order' => $order,
                    'page' => $page,
                ],
                'counts' => $property_count,
                'listings' => [
                    'all' => $result['all'],
                    'sale' => $result['sale'],
                    'rent' => $result['rent'],
                    'wanted' => $result['wanted'],
                    'basic' => $result['basic'],
                    'silver' => $result['silver'],
                    'bronze' => $result['bronze'],
                    'golden' => $result['golden'],
                    'platinum' => $result['platinum'],
                ],
            ];

            return view('website.admin-pages.listings', $data);
        }
        $condition = [];
        $result = $this->_getPropertiesByPurpose($purpose, $condition, $status, $order, $user, $sort, $page);
        $data = [
            'params' => [
                'status' => $status,
                'purpose' => $purpose,
                'user' => $user,
                'sort' => $sort,
                'order' => $order,
                'page' => $page,
            ],
            'notifications' => Auth()->user()->unreadNotifications,
            'counts' => $property_count,
            'listings' => [
                'all' => $result['all'],
                'sale' => $result['sale'],
                'rent' => $result['rent'],
                'wanted' => $result['wanted'],
                'basic' => $result['basic'],
                'silver' => $result['silver'],
                'bronze' => $result['bronze'],
                'golden' => $result['golden'],
                'platinum' => $result['platinum'],
            ],
            'recent_properties' => $footer_content[0],
            'footer_agencies' => $footer_content[1]
        ];
        return view('website.pages.listings', $data);
    }

    /*
     * Count specified resource under various categories like Active, Edited, Pending, Expired, Uploaded, Hidden, Deleted, Rejected, Rejected Images, Rejected Videos
     *
     * @param string user       optional    id|all
     * @param string sort       optional    id|type|location|price|expiry|views|image_count
     * @param string order      optional    asc|desc
     */
    public function getPropertyListingCount(string $user)
    {
        $counts = [];
        foreach (['active', 'edited', 'pending', 'expired', 'uploaded', 'hidden', 'deleted', 'rejected', 'sold'] as $status) {
            $counts[$status]['all'] = $this->listingsCount($status, $user)->first()->count;
            $counts[$status]['sale'] = $this->listingsCount($status, $user)->where('property_purpose', '=', 'sale')->first()->count;
            $counts[$status]['rent'] = $this->listingsCount($status, $user)->where('property_purpose', '=', 'rent')->first()->count;
            $counts[$status]['wanted'] = $this->listingsCount($status, $user)->where('property_purpose', '=', 'wanted')->first()->count;

            if ($status === 'active') {
                $counts[$status]['basic'] = $this->listingsCount($status, $user)->where('listing_type', '=', 'basic_listing')->first()->count;
                $counts[$status]['silver'] = $this->listingsCount($status, $user)->where('listing_type', '=', 'silver_listing')->first()->count;
                $counts[$status]['bronze'] = $this->listingsCount($status, $user)->where('listing_type', '=', 'bronze_listing')->first()->count;
                $counts[$status]['golden'] = $this->listingsCount($status, $user)->where('listing_type', '=', 'golden_listing')->first()->count;
                $counts[$status]['platinum'] = $this->listingsCount($status, $user)->where('listing_type', '=', 'platinum_listing')->first()->count;
            }
        }
        return $counts;
    }

    private function _getPropertyAggregates()
    {
        // fetch count of properties by city
        $cities = (new Property)
            ->select('cities.name AS city_name', DB::raw('COUNT(properties.id) AS count'))
            ->join('cities', 'properties.city_id', '=', 'cities.id')
            ->where('properties.status', '=', 'active')
            ->groupBy('properties.city_id')
            ->orderBy('cities.id')
            ->get();

        // fetch min/max land_area, count of properties on rent/sale/wanted, count of homes/plots/commercial properties
        $properties_area_range = DB::table('properties')
            ->select(DB::raw('MIN(land_area) AS min_area'), DB::raw('MAX(land_area) AS max_area'))
            ->where('status', '=', 'active')
            ->first();
        $properties_rent_count = DB::table('properties')->where('purpose', '=', 'Rent')->where('status', '=', 'active')->count();
        $properties_sale_count = DB::table('properties')->where('purpose', '=', 'Sale')->where('status', '=', 'active')->count();
        $properties_wanted_count = DB::table('properties')->where('purpose', '=', 'Wanted')->where('status', '=', 'active')->count();
        $properties_homes_count = DB::table('properties')->where('type', '=', 'Homes')->where('status', '=', 'active')->count();
        $properties_plots_count = DB::table('properties')->where('type', '=', 'Plots')->where('status', '=', 'active')->count();
        $properties_commercial_count = DB::table('properties')->where('type', '=', 'Commercial')->where('status', '=', 'active')->count();

        return [
            'cities' => $cities,
            'min_area' => $properties_area_range->min_area,
            'max_area' => $properties_area_range->max_area,
            'rent_count' => $properties_rent_count,
            'sale_count' => $properties_sale_count,
            'wanted_count' => $properties_wanted_count,
            'homes_count' => $properties_homes_count,
            'plots_count' => $properties_plots_count,
            'commercial_count' => $properties_commercial_count,
        ];
    }

    /* function call from top header (nav bar)*/
    public function getPropertyListing(Request $request, string $type)
    {
        $properties = $this->listingFrontend()
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

        $properties = $this->sortPropertyListing($sort, $sort_area, $properties);
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

    /*   search from index page bottom property listing  */
    /* search function Popular Cities to Buy Properties (houses, flats, plots)*/
    public function searchWithArgumentsForProperty(string $sub_type, string $purpose, string $city, Request $request)
    {
        if (count($request->all()) == 2 && $request->filled('sort') && $request->filled('limit') ||
            count($request->all()) == 3 && $request->filled('sort') && $request->filled('limit') && $request->filled('page')) {
//            to handle the request for city name
            if (in_array($sub_type, ['homes', 'plots', 'commercial'])) {
                $type = $sub_type;
                $sub_type = '';
                $city1 = $city2 = $city_1 = $city_2 = '';

                if ($city == 'Islamabad-Rawalpindi') {
                    $city1 = explode('-', $city)[0];
                    $city2 = explode('-', $city)[1];
                    $city = '';
                }
                if ($city1 !== $city2) {
                    $city_1 = City::select('id')->where('name', '=', $city1)->first();
                    $city_2 = City::select('id')->where('name', '=', $city2)->first();

                    (new MetaTagController())->addMetaTagsAccordingToCity($city_1->name);

                } else {

                    $city = City::select('id')->where('name', '=', $city)->first();
                    (new MetaTagController())->addMetaTagsAccordingToCity($city->name);
                }
                $properties = $this->listingFrontend();
                if ($city != '') $properties->where('properties.city_id', '=', $city->id);
                else {
                    $properties
                        ->where('properties.city_id', '=', $city_1->id)
                        ->orwhere('properties.city_id', '=', $city_2->id);
                }
                $properties->where('properties.purpose', '=', $purpose);
                $properties->where('properties.type', '=', $type);
                (new MetaTagController())->addMetaTags();

            } else {
                $type = '';
                if (in_array($sub_type, ['house', 'houses', 'flat', 'flats', 'upper-portion', 'lower-portion', 'farm-house', 'room', 'penthouse'])) $type = 'homes';
                if ($sub_type === 'plots') $type = 'plots';
                if (in_array($sub_type, ['office', 'shop', 'warehouse', 'factory', 'building', 'other']))
                    $type = 'commercial';

                if ($sub_type === 'houses' || $sub_type === 'house') $sub_type = 'house';
                elseif ($sub_type === 'flats' || $sub_type === 'flat') $sub_type = 'flat';
                elseif (in_array($sub_type, ['house', 'flat', 'upper-portion', 'lower-portion', 'farm-house', 'room', 'penthouse', 'office', 'shop', 'warehouse', 'factory', 'building', 'other']))
                    $sub_type = str_replace('-', ' ', $sub_type);
                else $sub_type = '';
                $city = City::select('id')->where('name', '=', $city)->first();

                (new MetaTagController())->addMetaTagsAccordingToCity($city->name);

                $properties = $this->listingFrontend();

                $properties->where('properties.city_id', '=', $city->id);
                $properties->where('properties.purpose', '=', $purpose);
                $properties->where('properties.type', '=', $type);
                if ($sub_type !== '') $properties->where('properties.sub_type', '=', $sub_type);
            }


        } else {
            str_replace('-', ' ', $sub_type);
            $city = str_replace('-', ' ', $city);
            $type = '';
            $location = '';
            $min_price = '';
            $min_area = '';
            $max_area = '';
            $max_price = '';
            $beds = '';
            $area_unit = '';
            if (in_array($sub_type, ['homes', 'plots', 'commercial'])) {
                $type = $sub_type;
                $sub_type = '';
            }
            if ($request->filled('location')) $location = $request->input('location');
            if ($request->filled('min_price')) $min_price = $request->input('min_price');
            if ($request->filled('max_price')) $max_price = $request->input('max_price');
            if ($request->filled('min_area')) $min_area = $request->input('min_area');
            if ($request->filled('max_area')) $max_area = $request->input('max_area');
            if ($request->filled('bedrooms')) $beds = $request->input('bedrooms');
            if ($request->filled('area_unit')) $area_unit = $request->input('area_unit');
            if ($location !== '') $location = str_replace('_', '-', str_replace('-', ' ', $location));
            if ($area_unit !== '') $area_unit = ucwords(str_replace('-', ' ', $area_unit));

            $form_data = [
                'purpose' => $purpose,
                'type' => $type,
                'city' => $city,
                'location' => $location,
                'subtype' => $sub_type,
                'min_area' => $min_area,
                'max_area' => $max_area,
                'min_price' => $min_price,
                'max_price' => $max_price,
                'area_unit' => $area_unit,
                'beds' => $beds
            ];
            $search_result = $this->search($form_data);
            if (array_key_exists('error', $search_result)) {
                return redirect('/');
            }
            $properties = $search_result['properties'];
        }

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

        $properties = $this->sortPropertyListing($sort, $sort_area, $properties);
        $property_count = $properties->count();

        if ($request->has('page') && $request->input('page') > ceil($property_count / $limit)) {
            $lastPage = ceil((int)$property_count / $limit);
            $request->merge(['page' => (int)$lastPage]);
        }

        $property_types = (new PropertyType)->all();
        (new MetaTagController())->addMetaTags();
        $footer_content = (new FooterController)->footerContent();

        $data = [
            'params' => $request->all(),
            'property_types' => $property_types,
            'properties' => $properties->paginate($limit),
            'recent_properties' => $footer_content[0],
            'footer_agencies' => $footer_content[1]
        ];
        return view('website.pages.property_listing', $data);

    }

    /* search function for houses at different locations*/
    /* locations are going to be fixed to we use like or regexp to find that location*/

    public function searchForHousesAndPlots(string $type, string $city, string $location, string $purpose = 'sale')
    {
        $city = City::select('id', 'name')->where('name', '=', $city)->first();

        $clean_location = str_replace('_', '-', str_replace('-', ' ', $location));

        /*change this part to locate some fix locations in location table */
        $location_data = Location::select('id')->where('city_id', '=', $city->id)
            ->where('name', 'REGEXP', $clean_location)->get()->toArray();

        $properties = $this->listingFrontend();

        if ($city !== null) $properties->where('properties.city_id', '=', $city->id);
        if ($type !== '') $properties->where('properties.type', '=', $type);
        $properties->where('properties.purpose', '=', $purpose);
        $properties->whereIn('properties.location_id', $location_data);
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

        $properties = $this->sortPropertyListing($sort, $sort_area, $properties);
        $property_count = $properties->count();

        if (request()->has('page') && request()->input('page') > ceil($property_count / $limit)) {
            $lastPage = ceil((int)$property_count / $limit);
            request()->merge(['page' => (int)$lastPage]);
        }

        (new MetaTagController())->addMetaTagsAccordingToCity($city->name);

        $property_types = (new PropertyType)->all();
        $footer_content = (new FooterController)->footerContent();

        $data = [
            'params' => request()->all(),
            'property_types' => $property_types,
            'properties' => $properties->paginate($limit),
            'recent_properties' => $footer_content[0],
            'footer_agencies' => $footer_content[1]
        ];
        return view('website.pages.property_listing', $data);
    }

    //  search from main  page
    public function search($data)
    {
        $validator = Validator::make($data, [
            'purpose' => ['required', Rule::in(['sale', 'rent', 'wanted'])],
            'type' => [Rule::in(['homes', 'plots', 'commercial'])],
            'subtype' => ['nullable', 'string'],
            'location' => ['nullable', 'string'],
            'city' => ['required', 'string'],
            'area_unit' => ['string', Rule::in(['Marla', 'New Marla (225 Sqft)', 'Square Feet', 'Square Yards', 'Square Meters', 'Kanal', 'New Kanal (16 Marla)'])],
            'min_area' => ['nullable', 'string'],
            'max_area' => ['nullable', 'string'],
            'min_price' => ['nullable', 'string'],
            'max_price' => ['nullable', 'string'],
            'bedrooms' => ['nullable', 'string'],
        ]);
        if ($validator->fails()) {
            return (['error' => $validator->errors()]);
        }
        $location = '';
        $city = (new City)->select('id', 'name')->where('name', '=', $data['city'])->first();

        if ($data['location'] !== null && $data['location'] !== '')
            $location = (new Location)->select('id')->where('city_id', '=', $city->id)->where('name', '=', $data['location'])->first();

        (new MetaTagController())->addMetaTagsAccordingToCity($city->name);
        $properties = $this->listingFrontend()
            ->where('properties.status', '=', 'active')
            ->where('properties.city_id', '=', $city->id);

        if ($location !== null && $location !== '') $properties->where('location_id', '=', $location->id);

        $properties->where('properties.purpose', '=', $data['purpose']);
//        dd($properties->get());
//        dd($data['purpose']);


        if ($data['type'] !== '' && $data['type'] !== null) $properties->where('properties.type', '=', $data['type']);
        if ($data['subtype'] !== null && $data['subtype'] !== '') $properties->where('properties.sub_type', '=', str_replace('-', ' ', $data['subtype']));


        if ($data['beds']) $properties->where('properties.bedrooms', '=', $data['beds']);

//        if ($data['area_unit'] !== '') $properties->where('properties.area_unit', '=', $data['area_unit']);

        $min_price = intval(str_replace(',', '', $data['min_price']));
        $max_price = intval(str_replace(',', '', $data['max_price']));

        //        both filters have some custom values
        if ($min_price !== 0 and $max_price !== 0) {
            if ($min_price < $max_price) $properties->whereBetween('price', [$min_price, $max_price]);
        } //      if min price is selected
        else if ($min_price !== 0 and $max_price === 0) {
            $properties->where('price', '>=', $min_price);
        } //      if max price is selected
        else if ($min_price === 0 and $max_price !== 0) {
            $properties->where('price', '<=', $max_price);
        }


        //        both filters have some custom values
        $min_area = floatval(str_replace(',', '', $data['min_area']));
        $max_area = floatval(str_replace(',', '', $data['max_area']));

        $area_column_wrt_unit = '';

        if ($data['area_unit'] === 'Marla') $area_column_wrt_unit = 'area_in_marla';
        if ($data['area_unit'] === 'New Marla (225 Sqft)') $area_column_wrt_unit = 'area_in_new_marla';
        if ($data['area_unit'] === 'Kanal') $area_column_wrt_unit = 'area_in_kanal';
        if ($data['area_unit'] === 'New Kanal (16 Marla)') $area_column_wrt_unit = 'area_in_new_kanal';
        if ($data['area_unit'] === 'Square Feet') $area_column_wrt_unit = 'area_in_sqft';
        if ($data['area_unit'] === 'Square Yards') $area_column_wrt_unit = 'area_in_sqyd';
        if ($data['area_unit'] === 'Square Meters') $area_column_wrt_unit = 'area_in_sqm';


        if ($min_area !== 0.0 and $max_area !== 0.0) {
            if ($min_area < $max_area) $properties->whereBetween($area_column_wrt_unit, [$min_area, $max_area]);
        } //      if min area is selected
        else if ($min_area !== 0.0 and $max_area === 0.0) {
            $properties->where($area_column_wrt_unit, '>=', $min_area);
        } //      if max price is selected
        else if ($min_area === 0.0 and $max_area !== 0.0) {
            $properties->where($area_column_wrt_unit, '<=', $max_area);
        }
        return ['properties' => $properties];
    }

    //  display detail page
    public function searchWithID(Request $request)
    {
        /*validate request params */
        if ($request->input('id') != null && preg_match('$(20\d{2}-)\d{8}$', $request->input('id'))) {
            $property = (new Property)->where('reference', '=', strtoupper($request->input('id')))->first();
            if ($property) {
                return response()->json(['data' => $property->property_detail_path($property->location->name), 'status' => 200]);
            } else
                return response()->json(['data' => 'not found', 'status' => 201]);
        }
        return response()->json(['data' => 'invalid value', 'status' => 202]);
    }

    //   search for city property
    public function searchInCities(string $city)
    {
        $city = str_replace('_', ' ', $city);
        $city = City::select('id', 'name')->where('name', '=', $city)->first();
        $footer_content = (new FooterController)->footerContent();

        if ($city) {
            $properties = $this->listingFrontend();
            $properties->where('properties.city_id', '=', $city->id);

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

            $properties = $this->sortPropertyListing($sort, $sort_area, $properties);
            $property_count = $properties->count();

            if (request()->has('page') && request()->input('page') > ceil($property_count / $limit)) {
                $lastPage = ceil((int)$property_count / $limit);
                request()->merge(['page' => (int)$lastPage]);
            }

            $property_types = (new PropertyType)->all();
            (new MetaTagController())->addMetaTagsAccordingToCity($city->name);

            $data = [
                'params' => request()->all(),
                'property_types' => $property_types,
                'properties' => $properties->paginate($limit),
                'recent_properties' => $footer_content[0],
                'footer_agencies' => $footer_content[1]
            ];
        } else {
            $properties = (new Property)->newCollection();

            $property_types = (new PropertyType)->all();
            (new MetaTagController())->addMetaTags();
            $data = [
                'params' => ['sort' => 'newest'],
                'property_types' => $property_types,
                'properties' => $properties,
                'recent_properties' => $footer_content[0],
                'footer_agencies' => $footer_content[1]
            ];
        }
        return view('website.pages.property_listing', $data);
    }

    //  ajax calls
    public function getAreaValue(Request $request)
    {
        if ($request->ajax()) {
            $result = (new Property)->select('land_area')->WHERE('area_unit', '=', $request->area_unit)->distinct()->inRandomOrder()->orderBy('land_area', 'ASC')->limit(8)->get()->toArray();
            return response()->json(['data' => $result, 'status' => 200]);
        } else {
            return "not found";
        }
    }

//    ajax to change status by the user
    public function changePropertyStatus(Request $request)
    {
        if ($request->ajax()) {
            (new Property)->WHERE('id', '=', $request->id)->update(['status' => $request->status]);

            $property = (new Property)->WHERE('id', '=', $request->id)->first();
            $city = (new City)->select('id', 'name')->where('id', '=', $property->city_id)->first();
            $location_obj = (new Location)->select('id', 'name')->where('id', '=', $property->location_id)->first();
            $location = ['location_id' => $location_obj->id, 'location_name' => $location_obj->name];
            $user = User::where('id', '=', $property->user_id)->first();
            $user->notify(new PropertyStatusChange($property));

            if ($request->status == 'sold' || $request->status == 'expired') {
                (new CountTableController())->_on_deletion_insertion_in_count_tables($city, $location, $property);

                if (Auth::guard('admin')->user()) {
                    (new PropertyLogController())->store($property);
                }

            }
//            if ($request->status === 'active') {
//                $dt = Carbon::now();
//                $property->activated_at = $dt;
//
//                $expiry = $dt->addMonths(3)->toDateTimeString();
//                $property->expired_at = $expiry;
//                $property->save();
//
//                event(new NewPropertyActivatedEvent($property));
//                (new CountTableController())->_insertion_in_count_tables($city, $location, $property);
//            }
            return response()->json(['status' => 200]);
        } else {
            return "not found";
        }
    }

    public function adminPropertySearch(Request $request)
    {
        $property = (new Property)->where('id', '=', $request->property_id)->first();
        if (!$property)
            return redirect()->back()->withInput()->with('error', 'Property not found.');
        else {
            $status = lcfirst($property->status);
            $purpose = lcfirst($property->purpose);

            return redirect()->route('admin.properties.listings',
                ['status' => $status, 'purpose' => $purpose, 'user' => \Illuminate\Support\Facades\Auth::guard('admin')->user()->getAuthIdentifier(),
                    'sort' => 'id', 'order' => 'asc', 'page' => 50, 'id' => $request->property_id]);
        }

    }

    public function userPropertySearch(Request $request)
    {
        if ($request->input('property_ref') != null && preg_match('$(20\d{2}-)\d{8}$', $request->input('property_ref'))) {
            $property = (new Property)->where('reference', '=', $request->property_ref)->first();
            if (!$property)
                return redirect()->back()->withInput()->with('error', 'Property not found.');
            else {
                $status = lcfirst($property->status);
                $purpose = lcfirst($property->purpose);
                return redirect()->route('properties.listings',
                    ['status' => $status, 'purpose' => $purpose, 'user' => \Illuminate\Support\Facades\Auth::user()->getAuthIdentifier(),
                        'sort' => 'id', 'order' => 'asc', 'page' => 50, 'reference' => $request->property_ref]);
            }
        } else
            return redirect()->back()->withInput()->with('error', 'Please enter property reference.');
    }

}
