<?php

namespace App\Http\Controllers;

use App\Events\NewPropertyActivatedEvent;
use App\Http\Controllers\Dashboard\LocationController;
use App\Models\Agency;
use App\Models\Dashboard\City;
use App\Models\Dashboard\Location;
use App\Models\FloorPlan;
use App\Models\Image;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\Video;
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
                'agencies.title AS agency', 'agencies.featured_listing','agencies.logo AS logo','agencies.key_listing', 'agencies.status AS agency_status', 'agencies.phone AS agency_phone', 'agencies.ceo_name AS agent')
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
            });
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

//    display data on index page
    public function index()
    {
        (new MetaTagController())->addMetaTags();

        $property_types = (new PropertyType)->all();

        // Popular posts based upon max views
        $featured_properties = $this->listingfrontend()
            ->where('properties.premium_listing', '=', 1)
            ->orderBy('views', 'DESC')
            ->limit(10)
            ->get();
        $data = [
            'cities_count' => (new CountTableController())->getCitiesCount(),
            'featured_properties' => $featured_properties,
            'key_agencies' => (new AgencyController())->keyAgencies(),
            'featured_agencies' => (new AgencyController())->FeaturedAgencies(),
            'popular_cities_homes_on_sale' => (new CountTableController())->popularLocations()['popular_cities_homes_on_sale'],
            'popular_cities_plots_on_sale' => (new CountTableController())->popularLocations()['popular_cities_plots_on_sale'],
            'city_wise_homes_data' => [
                'karachi' => (new CountTableController())->popularLocations()['city_wise_homes_data']['karachi'],
                'peshawar' => (new CountTableController())->popularLocations()['city_wise_homes_data']['peshawar'],
                'lahore' => (new CountTableController())->popularLocations()['city_wise_homes_data']['lahore'],
                'Islamabad/Rawalpindi' => (new CountTableController())->popularLocations()['city_wise_homes_data']['rawalpindi/Islamabad']
            ],
            'city_wise_plots_data' => [
                'karachi' => (new CountTableController())->popularLocations()['city_wise_plots_data']['karachi'],
                'peshawar' => (new CountTableController())->popularLocations()['city_wise_plots_data']['peshawar'],
                'lahore' => (new CountTableController())->popularLocations()['city_wise_plots_data']['lahore'],
                'Islamabad/Rawalpindi' => (new CountTableController())->popularLocations()['city_wise_plots_data']['rawalpindi/Islamabad']
            ],
            'city_wise_commercial_data' => [
                'karachi' => (new CountTableController())->popularLocations()['city_wise_commercial_data']['karachi'],
                'peshawar' => (new CountTableController())->popularLocations()['city_wise_commercial_data']['peshawar'],
                'lahore' => (new CountTableController())->popularLocations()['city_wise_commercial_data']['lahore'],
                'Islamabad/Rawalpindi' => (new CountTableController())->popularLocations()['city_wise_commercial_data']['rawalpindi/Islamabad']
            ],
            'popular_cities_commercial_on_sale' => (new CountTableController())->popularLocations()['popular_cities_commercial_on_sale'],
            'popular_cities_property_on_rent' => (new CountTableController())->popularLocations()['popular_cities_property_on_rent'],
            'property_types' => $property_types,
            'blogs' => (new BlogController)->recentBlogsOnMainPage(),
            'localBusiness' => (new MetaTagController())->addScriptJsonldTag(),
            'recent_properties' => (new FooterController)->footerContent()[0],
            'footer_agencies' => (new FooterController)->footerContent()[1],
        ];
        return view('website.index', $data);
    }

//    list all featured properties
    public function featuredProperties(Request $request)
    {
//        on a specific limit if last page greater than first page return to page 1
        $properties = $this->listingfrontend()
            ->where('properties.premium_listing', '=', 1);

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
        if (request()->has('page') && request()->input('page') > ceil($properties->count() / $limit)) {
            $lastPage = ceil((int)$properties->count() / $limit);
            request()->merge(['page' => (int)$lastPage]);
        }
        $property_types = (new PropertyType)->all();
        (new MetaTagController())->addMetaTags();
        $data = [
            'params' => request()->all(),
            'property_types' => $property_types,
            'properties' => $properties->paginate($limit),
            'recent_properties' => (new FooterController)->footerContent()[0],
            'footer_agencies' => (new FooterController)->footerContent()[1],
        ];
        return view('website.pages.property_listing', $data);
    }

    public function create()
    {
        $property_types = (new PropertyType)->all();
        $counts = $this->getPropertyListingCount(Auth::user()->getAuthIdentifier());

        return view('website.pages.portfolio', ['property_types' => $property_types, 'counts' => $counts, 'recent_properties' => (new FooterController)->footerContent()[0],
            'footer_agencies' => (new FooterController)->footerContent()[1]]);
    }

    private function _imageValidation($type)
    {
        if ($type == 'image') {
            $error_msg = [];
            $allowed_height = 600;
            $allowed_width = 750;

            if (count(request()->file('image')) > 10) {
                $error_msg['image.' . 0] = 'Only 10 ' . ' images are allowed to upload.';
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
//        TODO: add conversions of land_area based on new /old marla, kanal
        if (request()->hasFile('image')) {
            $error_msg = $this->_imageValidation('image');
            if (count($error_msg)) {
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

            $max_id = DB::select("SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'property_management' AND TABLE_NAME = 'properties'")[0]->AUTO_INCREMENT;

            $reference = date("Y") . '-' . str_pad($max_id, 8, 0, STR_PAD_LEFT);

            $agency = DB::table('agency_users')
                ->select('agency_users.agency_id AS id')
                ->where('user_id', '=', $user_id)->first();

            $property = (new Property)->Create([
                'reference' => $reference,
                'user_id' => $user_id,
                'city_id' => $city->id,
                'location_id' => $location['location_id'],
                'agency_id' => $agency === null ? null : $agency->id,
                'purpose' => $request->input('purpose'),
                'sub_purpose' => $request->input('wanted_for') ? $request->has('wanted_for') : null,
                'type' => $request->input('property_type'),
                'sub_type' => $subtype,
                'title' => $request->input('property_title'),
                'description' => $request->input('description'),
                'price' => $request->input('all_inclusive_price'),
                'land_area' => $request->input('land_area'),
                'area_unit' => ucwords(implode(' ', explode('_', $request->input('unit')))),
                'bedrooms' => $request->has('bedrooms') ? $request->has('bedrooms') : 0,
                'bathrooms' => $request->has('bathrooms') ? $request->has('bathrooms') : 0,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'features' => $request->has('features') ? json_encode($json_features) : null,
                'status' => $request->has('status') ? $request->has('status') : 'pending',
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
                (new CountTableController)->_insertion_in_count_tables($city, $location, $property);
            }

            return redirect()->route('properties.listings', ['pending', 'all', (string)$user_id, 'id', 'asc', '10'])->with('success', 'Record added successfully');
        } catch (Exception $e) {
//            dd($e);
            return redirect()->back()->withInput()->with('error', 'Record not added, try again.');
        }
    }

    //    Display detailed page of property
    public function show($slug, Property $property)
    {
        if ($slug !== Str::slug($property->location->name) . '-' . Str::slug($property->title) . '-' . $property->reference)
            return redirect($property->property_detail_path($property->location->name));

        $views = $property->views;
        $property->views = $views + 1;
        $property->save();

        $agency = (new Agency)->where('id', '=', $property->agency_id)->first();

        $images = (new Image)->select('images.name')->where('images.property_id', '=', $property->id)->pluck('name')->toArray();
        $video = (new Video)->select('name', 'host')->where('property_id', '=', $property->id)->whereNull('deleted_at')->get()->toArray();
        $floor_plans = (new FloorPlan)->select('name', 'title')->where('floor_plans.property_id', '=', $property->id)->get()->toArray();
        $is_favorite = false;

        if (Auth::check()) {
            $is_favorite = DB::table('favorites')->select('id')
                ->where([
                    ['user_id', '=', Auth::user()->getAuthIdentifier()],
                    ['property_id', '=', $property->id],
                ])->exists();
        }
        $property_types = (new PropertyType)->all();

        $data = (new Property)
            ->select('properties.reference', 'properties.id', 'purpose', 'sub_purpose', 'sub_type', 'type', 'title', 'description', 'price', 'land_area', 'area_unit', 'bedrooms', 'bathrooms',
                'features', 'premium_listing', 'super_hot_listing', 'hot_listing', 'magazine_listing', 'contact_person', 'phone', 'cell', 'fax', 'email', 'views', 'status',
                'properties.created_at', 'properties.updated_at', 'locations.name AS location', 'cities.name AS city', 'properties.favorites', 'properties.latitude',
                'properties.longitude')
            ->join('locations', 'properties.location_id', '=', 'locations.id')
            ->join('cities', 'properties.city_id', '=', 'cities.id')
            ->where('properties.id', '=', $property->id)
            ->whereNull('properties.deleted_at')->first();

        (new MetaTagController())->addMetaTagsAccordingToPropertyDetail($data);


        //similar properties criteria same city, type and subtype
        $similar_properties = $this->listingFrontend()
            ->where([
                ['properties.id', '<>', $property->id],
                ['properties.city_id', '=', $property->city_id],
                ['properties.type', '=', $property->type],
                ['properties.sub_type', '=', $property->sub_type],
            ])
            ->whereNull('properties.deleted_at')->limit(3)->get();

        $aggregates = $this->_getPropertyAggregates();
        return view('website.pages.property_detail', [
            'property' => $data,
            'images' => $images,
            'video' => $video,
            'floor_plans' => $floor_plans,
            'is_favorite' => $is_favorite,
            'agency' => $agency,
            'similar_properties' => $similar_properties,
            'property_types' => $property_types,
            'aggregates' => $aggregates,
            'recent_properties' => (new FooterController)->footerContent()[0],
            'footer_agencies' => (new FooterController)->footerContent()[1],
        ]);
    }

    public function edit(Property $property)
    {
//        check if property has a agency and agency has status of verified then property status change to active

        $city = $property->location->city->name;
        $property->location = $property->location->name;
        $property->city = $city;
        $property->image = (new Property)->find($property->id)->images()->where('name', '<>', 'null')->get(['name', 'id']);
        $property->video = (new Property)->find($property->id)->videos()->where('name', '<>', 'null')->get(['name', 'id', 'host']);
        $property->floor_plan = (new Property)->find($property->id)->floor_plans()->where('name', '<>', 'null')->get(['name', 'id', 'title']);
        $property_types = (new PropertyType)->all();
        $counts = $this->getPropertyListingCount(Auth::user()->getAuthIdentifier());

        return view('website.pages.portfolio', ['property' => $property, 'property_types' => $property_types, 'counts' => $counts, 'recent_properties' => (new FooterController)->footerContent()[0],
            'footer_agencies' => (new FooterController)->footerContent()[1]]);
    }

    public function update(Request $request, Property $property)
    {
        if (request()->hasFile('image')) {
            $error_msg = $this->_imageValidation('images');
            if (count($error_msg)) {
                return redirect()->back()->withErrors($error_msg)->withInput()->with('error', 'Error storing record, try again.');
            }
        }
        if (request()->hasFile('floor_plans')) {
            $error_msg = $this->_imageValidation('floor plans');
            if (count($error_msg)) {
                return redirect()->back()->withErrors($error_msg)->withInput()->with('error', 'Error storing record, try again.');
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

            $property = (new Property)->updateOrCreate(['id' => $property->id], [
                'reference' => $property->reference,
                'user_id' => $property->user_id,
                'city_id' => $city->id,
                'location_id' => $location['location_id'],
                'agency_id' => $property->agency_id,
                'purpose' => $request->input('purpose'),
                'sub_purpose' => $request->has('wanted_for') ? $request->has('wanted_for') : null,
                'type' => $request->input('property_type'),
                'sub_type' => $subtype,
                'title' => $request->input('property_title'),
                'description' => $request->input('description'),
                'price' => $request->input('all_inclusive_price'),
                'land_area' => $request->input('land_area'),
                'area_unit' => ucwords(implode(' ', explode('_', $request->input('unit')))),
                'bedrooms' => $request->has('bedrooms') ? $request->has('bedrooms') : 0,
                'bathrooms' => $request->has('bathrooms') ? $request->has('bathrooms') : 0,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'features' => $request->has('features') ? json_encode($json_features) : null,
                'status' => $request->has('status') ? $request->input('status') : 'edited',
                'contact_person' => $request->input('contact_person'),
                'phone' => $request->input('phone'),
                'cell' => $request->input('mobile'),
                'fax' => $request->input('fax'),
                'email' => $request->input('contact_email'),
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
                event(new NewPropertyActivatedEvent($property));
                (new CountTableController())->_insertion_in_count_tables($city, $location, $property);
            }
            if ($status_before_update === 'active' && in_array($request->input('status'), ['edited', 'pending', 'expired', 'uploaded', 'hidden', 'deleted', 'rejected']))
                (new CountTableController())->_on_deletion_insertion_in_count_tables($city, $location, $property);

            return redirect()->route('properties.listings', ['edited', 'all', (string)Auth::user()->getAuthIdentifier(), 'id', 'asc', '10', 'recent_properties' => (new FooterController)->footerContent()[0],
                'footer_agencies' => (new FooterController)->footerContent()[1]])->with('success', 'Property updated successfully');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Record not updated, try again.');
        }
    }

    public function destroy(Request $request)
    {
        $user_id = Auth::user()->getAuthIdentifier();
        $property = (new Property)->where('id', '=', $request->input('record_id'))->first();
        $status_before_update = $property->status;
        if ($property->exists) {
            try {
                $property->status = 'deleted';
                $property->save();

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


    private function _listings(string $status, string $user)
    {
        // TODO: make migration for handling quota_used and image_views
        $listings = (new Property)
            ->select('properties.id', 'sub_type AS type', 'locations.name AS location', 'price', 'properties.created_at AS listed_date', DB::raw("'0' AS quota_used"), DB::raw("'0' AS image_views"))
            ->join('locations', 'properties.location_id', '=', 'locations.id')
            ->whereNull('properties.deleted_at');

        // user
        if (!Auth::user()->hasRole('Admin')) {
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
    public function listings(string $status, string $purpose, string $user, string $sort, string $order, string $page)
    {
        // TODO: implement code where status is rejected_images or rejected_videos, remove after
        if (in_array($status, ['rejected_images', 'rejected_videos'])) {
            return abort(404, 'Missing implementation');
        }

        // listing of status
        $status = strtolower($status);
        if (!in_array($status, ['active', 'edited', 'pending', 'expired', 'uploaded', 'hidden', 'deleted', 'rejected', 'rejected_images', 'rejected_videos'])) {
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

        $data = [
            'params' => [
                'status' => $status,
                'purpose' => $purpose,
                'user' => $user,
                'sort' => $sort,
                'order' => $order,
                'page' => $page,
            ],
            'counts' => $this->getPropertyListingCount($user),
            'listings' => [
                'all' => $this->_listings($status, $user)->orderBy($sort, $order)->paginate($page),
                'sale' => $this->_listings($status, $user)->where('purpose', '=', 'sale')->orderBy($sort, $order)->paginate($page),
                'rent' => $this->_listings($status, $user)->where('purpose', '=', 'rent')->orderBy($sort, $order)->paginate($page),
                'wanted' => $this->_listings($status, $user)->where('purpose', '=', 'wanted')->orderBy($sort, $order)->paginate($page),
                'super_hot' => $this->_listings($status, $user)->where('super_hot_listing', true)->orderBy($sort, $order)->paginate($page),
                'hot' => $this->_listings($status, $user)->where('hot_listing', true)->orderBy($sort, $order)->paginate($page),
                'magazine' => $this->_listings($status, $user)->where('magazine_listing', true)->orderBy($sort, $order)->paginate($page),
            ],
            'recent_properties' => (new FooterController)->footerContent()[0],
            'footer_agencies' => (new FooterController)->footerContent()[1]
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
        foreach (['active', 'edited', 'pending', 'expired', 'uploaded', 'hidden', 'deleted', 'rejected'] as $status) {
            $counts[$status]['all'] = $this->_listings($status, $user)->count();
            $counts[$status]['sale'] = $this->_listings($status, $user)->where('purpose', '=', 'sale')->count();
            $counts[$status]['rent'] = $this->_listings($status, $user)->where('purpose', '=', 'rent')->count();
            $counts[$status]['wanted'] = $this->_listings($status, $user)->where('purpose', '=', 'wanted')->count();

            if ($status === 'active') {
                $counts[$status]['super_hot'] = $this->_listings($status, $user)->where('super_hot_listing', true)->count();
                $counts[$status]['hot'] = $this->_listings($status, $user)->where('hot_listing', true)->count();
                $counts[$status]['magazine'] = $this->_listings($status, $user)->where('magazine_listing', true)->count();
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

        if ($request->has('page') && $request->input('page') > ceil($properties->count() / $limit)) {
            $lastPage = ceil((int)$properties->count() / $limit);
            $request->merge(['page' => (int)$lastPage]);
        }
        (new MetaTagController())->addMetaTags();

        $property_types = (new PropertyType)->all();

        $data = [
            'params' => $request->all(),
            'property_types' => $property_types,
            'properties' => $properties->paginate($limit),
            'recent_properties' => (new FooterController)->footerContent()[0],
            'footer_agencies' => (new FooterController)->footerContent()[1],

        ];
        return view('website.pages.property_listing', $data);
    }

    /*   search from index page bottom property listing  */
    /* search function Popular Cities to Buy Properties (houses, flats, plots)*/
    public function searchWithArgumentsForProperty(string $sub_type, string $purpose, string $city, Request $request)
    {
        if (count($request->all()) == 2 && $request->filled('sort') && $request->filled('limit') ||
            count($request->all()) == 3 && $request->filled('sort') && $request->filled('limit') && $request->filled('page'))
        {
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


        }
        else {
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

        if ($request->has('page') && $request->input('page') > ceil($properties->count() / $limit)) {
            $lastPage = ceil((int)$properties->count() / $limit);
            $request->merge(['page' => (int)$lastPage]);
        }

        $property_types = (new PropertyType)->all();
        (new MetaTagController())->addMetaTags();
        $data = [
            'params' => $request->all(),
            'property_types' => $property_types,
            'properties' => $properties->paginate($limit),
            'recent_properties' => (new FooterController)->footerContent()[0],
            'footer_agencies' => (new FooterController)->footerContent()[1]
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

        if (request()->has('page') && request()->input('page') > ceil($properties->count() / $limit)) {
            $lastPage = ceil((int)$properties->count() / $limit);
            request()->merge(['page' => (int)$lastPage]);
        }

        (new MetaTagController())->addMetaTagsAccordingToCity($city->name);

        $property_types = (new PropertyType)->all();

        $data = [
            'params' => request()->all(),
            'property_types' => $property_types,
            'properties' => $properties->paginate($limit),
            'recent_properties' => (new FooterController)->footerContent()[0],
            'footer_agencies' => (new FooterController)->footerContent()[1]
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
//        dd($data['area_unit']);
        $location = '';

        $city = (new City)->select('id', 'name')->where('name', '=', $data['city'])->first();

        if ($data['location'] !== null)
            $location = (new Location)->select('id')->where('city_id', '=', $city->id)->where('name', '=', $data['location'])->first();

        (new MetaTagController())->addMetaTagsAccordingToCity($city->name);
        $properties = $this->listingFrontend()
            ->where('properties.status', '=', 'active')
            ->where('properties.city_id', '=', $city->id);
        if ($location !== null) $properties->where('location_id', '=', $location->id);
        $properties->where('properties.purpose', '=', $data['purpose']);


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
        if ($request->input('id') != null && preg_match('$(2020-)\d{8}$', $request->input('id'))) {
            $property = (new Property)->where('reference', '=', strtoupper($request->input('id')))->first();
            if ($property) {
                return response()->json(['data' => $property->property_detail_path($property->location->name), 'status' => 200]);
            } else
                return response()->json(['data' => 'not found', 'status' => 201]);
        }
        return response()->json(['data' => 'invalid value', 'status' => 202]);
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

    //   search for city property
    public function searchInCities(string $city)
    {
        $city = str_replace('_', ' ', $city);
        $city = City::select('id', 'name')->where('name', '=', $city)->first();
        $data = [];
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

            if (request()->has('page') && request()->input('page') > ceil($properties->count() / $limit)) {
                $lastPage = ceil((int)$properties->count() / $limit);
                request()->merge(['page' => (int)$lastPage]);
            }

            $property_types = (new PropertyType)->all();
            (new MetaTagController())->addMetaTagsAccordingToCity($city->name);

            $data = [
                'params' => request()->all(),
                'property_types' => $property_types,
                'properties' => $properties->paginate($limit),
                'recent_properties' => (new FooterController)->footerContent()[0],
                'footer_agencies' => (new FooterController)->footerContent()[1]
            ];
        } else {
            $properties = (new Property)->newCollection();

            $property_types = (new PropertyType)->all();
            $data = [
                'params' => ['sort' => 'newest'],
                'property_types' => $property_types,
                'properties' => $properties,
                'recent_properties' => (new FooterController)->footerContent()[0],
                'footer_agencies' => (new FooterController)->footerContent()[1]
            ];
        }
        return view('website.pages.property_listing', $data);
    }
}
