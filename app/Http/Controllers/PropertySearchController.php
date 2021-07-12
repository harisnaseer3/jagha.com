<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\HitRecord\HitController;
use App\Http\Controllers\Test\TrackUrlController;
use App\Models\Agency;
use App\Models\Dashboard\City;
use App\Models\Dashboard\Location;
use App\Models\Property;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PropertySearchController extends Controller
{
    function listingFrontend()
    {
        return (new Property)
            ->select('properties.id', 'properties.user_id', 'properties.reference', 'properties.purpose', 'properties.sub_purpose', 'properties.sub_type',
                'properties.type', 'properties.title', 'properties.description',
                'properties.price', 'properties.land_area', 'properties.area_unit', 'properties.bedrooms', 'properties.bathrooms', 'properties.features',
                'properties.silver_listing', 'properties.golden_listing', 'properties.platinum_listing',
                'properties.contact_person', 'properties.phone', 'properties.cell',
                'properties.fax', 'properties.email', 'properties.favorites', 'properties.views', 'properties.status', 'f.user_id AS user_favorite', 'properties.created_at', 'properties.activated_at',
                'properties.updated_at', 'locations.name AS location', 'cities.name AS city', 'p.name AS image',
                'properties.area_in_sqft', 'area_in_sqyd', 'area_in_marla', 'area_in_new_marla', 'area_in_kanal', 'area_in_new_kanal', 'area_in_sqm',
                'agencies.title AS agency', 'agencies.featured_listing', 'agencies.logo AS logo', 'agencies.key_listing', 'agencies.status AS agency_status',
                'agencies.phone AS agency_phone', 'agencies.cell AS agency_cell', 'agencies.ceo_name AS agent', 'agencies.created_at AS agency_created_at',
                'agencies.description AS agency_description', 'c.property_count AS agency_property_count',
                'users.community_nick AS user_nick_name', 'users.name AS user_name')
//            ->where('property_count_by_agencies.property_status', '=', 'active')
            ->where('properties.status', '=', 'active')
            ->whereNull('properties.deleted_at')
            ->leftJoin('images as p', function ($q) {
                $q->on('p.property_id', '=', 'properties.id')
                    ->on('p.name', '=', DB::raw('(select name from images where images.property_id = properties.id and images.deleted_at IS null ORDER BY images.order  limit 1 )'));
            })
            ->join('locations', 'properties.location_id', '=', 'locations.id')
            ->join('cities', 'properties.city_id', '=', 'cities.id')
            ->leftjoin('agencies', 'properties.agency_id', '=', 'agencies.id')
            ->leftJoin('favorites as f', function ($f) {
                $f->on('properties.id', '=', 'f.property_id')
                    ->where('f.user_id', '=', Auth::user() ? Auth::user()->getAuthIdentifier() : 0);
            })
            ->join('users', 'properties.user_id', '=', 'users.id')
            ->leftJoin('property_count_by_agencies as c', function ($c) {
                $c->on('properties.agency_id', '=', 'c.agency_id')
                    ->where('c.property_status', '=', 'active');
            });

    }

    function sortPropertyListing($sort, $sort_area, $properties)
    {
        $properties = $properties->orderBy('properties.platinum_listing', 'DESC');
        $properties = $properties->orderBy('properties.golden_listing', 'DESC');

        if ($sort_area === 'higher_area') $properties = $properties->orderBy('properties.area_in_sqft', 'DESC');
        else if ($sort_area === 'lower_area') $properties = $properties->orderBy('properties.area_in_sqft', 'ASC');

        if ($sort === 'newest') $properties = $properties->orderBy('properties.activated_at', 'DESC');
        else if ($sort === 'oldest') $properties = $properties->orderBy('properties.activated_at', 'ASC');
        else if ($sort === 'high_price') $properties = $properties->orderBy('properties.price', 'DESC');
        else if ($sort === 'low_price') $properties = $properties->orderBy('properties.price', 'ASC');


        return $properties;
    }

    /* search function for houses at different locations*/
    /* locations are going to be fixed  we use like or regexp to find that location*/

    public function searchForHousesAndPlots(string $type, string $city, string $location, Request $request)
    {
        $purpose = 'sale';
        $city = City::select('id', 'name')->where('name', '=', $city)->first();

        $clean_location = str_replace('_', '-', str_replace('-', ' ', str_replace('BY', '/', $location)));


        /*change this part to locate some fix locations in location table */
        $location_data = Location::select('id')->where('city_id', '=', $city->id)
            ->where('name', 'REGEXP', $clean_location)->get()->toArray();

        $total_count = DB::table('property_count_by_property_purposes')
            ->select(DB::raw('SUM(property_count) AS count'))
            ->where([
                ['city_id', '=', $city->id],
                ['property_purpose', '=', $purpose],
                ['property_type', '=', $type],
                ['location_name', 'REGEXP', $clean_location],
            ])->get()[0]->count;
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

        $page = (isset($request->page)) ? $request->page : 1;
        $last_id = ($page - 1) * $limit;
        $properties = $this->sortPropertyListing($sort, $sort_area, $properties);
        $properties = new Collection($properties->get());
        //Slice the collection to get the items to display in current page
        $properties = $properties->slice($last_id, $limit)->all();
        $paginatedSearchResults = new LengthAwarePaginator($properties, $total_count, $limit);
        $paginatedSearchResults->setPath($request->url());

        (new MetaTagController())->addMetaTagsAccordingToCity($city->name);

        $property_types = (new PropertyType)->all();
        $footer_content = (new FooterController)->footerContent();
        if ($request->ajax()) {
            $data['view'] = View('website.components.property-listings',
                [
                    'limit' => $limit,
                    'area_sort' => $sort_area,
                    'sort' => $sort,
                    'params' => $request->all(),
                    'properties' => $paginatedSearchResults
                ])->render();
            return $data;
        }
        $data = [
            'params' => request()->all(),
            'property_types' => $property_types,
            'properties' => $paginatedSearchResults,
            'recent_properties' => $footer_content[0],
            'footer_agencies' => $footer_content[1]
        ];

        return view('website.pages.property_listing', $data);
    }

    private function _getLocationsWiseCount(string $purpose, string $sub_type, int $city_id, string $city_name, string $type)
    {
        if ($type === '') {
            if (in_array($sub_type, ['house', 'houses', 'flat', 'flats', 'upper-portion', 'lower-portion', 'farm-house', 'room', 'penthouse'])) $type = 'homes';
            elseif (in_array($sub_type, ['residential-plot', 'commercial-plot', 'agricultural-land', 'industrial-land', 'plot-file', 'plot-form'])) $type = 'plots';
            elseif (in_array($sub_type, ['office', 'shop', 'warehouse', 'factory', 'building', 'other']))
                $type = 'commercial';

        }
        $condition = ['city_id' => $city_id, 'property_purpose' => $purpose, 'property_type' => $type, 'property_sub_type' => $sub_type];

//        $location_data['count'] = DB::table('property_count_by_property_purposes')->select('location_name', 'property_count', 'property_sub_type')->where($condition)->orderBy('property_count', 'DESC')->limit(50)->get();
        $location_data['count'] = DB::table('property_count_by_property_purposes')->select(DB::raw('SUM(property_count) as property_count'), 'location_name', 'property_type')
            ->where($condition)
            ->groupBy('location_name', 'property_type')
            ->orderBy('property_count', 'DESC')->limit(50)->get();
        $location_data['purpose'] = $purpose;
        $location_data['type'] = $type;
        $location_data['city'] = $city_name;
        $location_data['sub_type'] = $sub_type;
        return $location_data;
    }

    public function searchPropertyWithLocationName(Request $request, string $type, string $purpose, string $city, string $location)
    {
        $city = City::select('id', 'name')->where('name', '=', $city)->first();

        $clean_location = str_replace('_', '-', str_replace('-', ' ', str_replace('BY', '/', $location)));

        /*change this part to locate some fix locations in location table */
        $location_data = Location::select('id')->where('city_id', '=', $city->id)
            ->where('name', '=', $clean_location)->get()->toArray();

        $properties = $this->listingFrontend();
        $total_count = DB::table('property_count_by_property_purposes')
            ->select(DB::raw('SUM(property_count) AS count'))
            ->where([
                ['city_id', '=', $city->id],
                ['property_purpose', '=', $purpose],
                ['location_id', '=', $location_data[0]['id']],
            ]);

        if ($city !== null) $properties->where('properties.city_id', '=', $city->id);
        if ($type !== '') {
            if (in_array($type, ['homes', 'plots', 'commercial', 'Homes', 'Plots', 'Commercial'])) {
                $properties->where('properties.type', '=', $type);
                $total_count = $total_count->where('property_type', '=', $type);
            } elseif (in_array($type,
                ['house', 'houses', 'flat', 'flats', 'upper-portion', 'lower-portion', 'farm-house', 'room',
                    'penthouse', 'residential-plot', 'commercial-plot', 'agricultural-land', 'industrial-land',
                    'plot-file', 'plot-form', 'office', 'shop', 'warehouse', 'factory', 'building', 'other'])) {
                $properties->where('properties.sub_type', '=', $type);
                $total_count = $total_count->where('property_sub_type', '=', $type);
            }
        }
        $total_count = $total_count->first()->count;
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

        $page = (isset($request->page)) ? $request->page : 1;
        $last_id = ($page - 1) * $limit;
        $properties = $this->sortPropertyListing($sort, $sort_area, $properties);
        $properties = new Collection($properties->get());
        $properties = $properties->slice($last_id, $limit)->all();
        $paginatedSearchResults = new LengthAwarePaginator($properties, $total_count, $limit);
        $paginatedSearchResults->setPath($request->url());

        (new MetaTagController())->addMetaTagsAccordingToCity($city->name);

        $property_types = (new PropertyType)->all();
        if ($request->ajax()) {
            $data['view'] = View('website.components.property-listings',
                [
                    'limit' => $limit,
                    'area_sort' => $sort_area,
                    'sort' => $sort,
                    'params' => $request->all(),
                    'properties' => $paginatedSearchResults
                ])->render();
            return $data;
        }
        $footer_content = (new FooterController)->footerContent();

        $data = [
            'params' => request()->all(),
            'property_types' => $property_types,
            'properties' => $paginatedSearchResults,
            'recent_properties' => $footer_content[0],
            'footer_agencies' => $footer_content[1]
        ];
        return view('website.pages.property_listing', $data);
    }

    //   search for city property
    public function searchInCities(string $city, Request $request)
    {
        $city = str_replace('_', ' ', $city);
        $city = City::select('id', 'name')->where('name', '=', $city)->first();
        $total_count = DB::table('property_count_by_cities')
            ->select('property_count AS count')->where('city_id', '=', $city->id)->first()->count;
        $footer_content = (new FooterController)->footerContent();

        if ($city) {
//            $properties = $this->listingFrontend();
//            $properties->where('properties.city_id', '=', $city->id);

            $sort = '';
            $limit = '';
            $sort_area = '';
            $sort_area_value = '';
            $activated_at_value = 'DESC';
            $price_value = '';
            if (request()->input('sort') !== null) {
                $sort = request()->input('sort');
                if ($sort === 'newest') $activated_at_value = 'DESC';
                else if ($sort === 'oldest') $activated_at_value = 'ASC';
                else if ($sort === 'high_price') $price_value = 'DESC';
                else if ($sort === 'low_price') $price_value = 'ASC';

            } else
                $sort = 'newest';

            if (request()->input('limit') !== null)
                $limit = request()->input('limit');
            else
                $limit = '15';

            if (request()->input('area_sort') !== null) {
                $sort_area = request()->input('area_sort');
                if ($sort_area === 'higher_area') $sort_area_value = 'DESC';
                else if ($sort_area === 'lower_area') $sort_area_value = 'ASC';
            }


            $page = (isset($request->page)) ? $request->page : 1;
            $last_id = ($page - 1) * $limit;
            $properties = DB::select('call getPropertiesByCityId("' . $last_id . '","' . $city->id . '","' . $limit . '","' . $activated_at_value . '","' . $price_value . '","' . $sort_area_value . '")');
            $properties = new Collection($properties);

            $paginatedSearchResults = new LengthAwarePaginator($properties, $total_count, $limit);

            $paginatedSearchResults->setPath($request->url());

            $property_types = (new PropertyType)->all();
            (new MetaTagController())->addMetaTagsAccordingToCity($city->name);

            if ($request->ajax()) {
                $data['view'] = View('website.components.property-listings',
                    [
                        'limit' => $limit,
                        'area_sort' => $sort_area,
                        'sort' => $sort,
                        'params' => $request->all(),
                        'properties' => $paginatedSearchResults,
                    ])->render();
                return $data;
            }


            $data = [
                'params' => request()->all(),
                'property_types' => $property_types,
                'properties' => $paginatedSearchResults,
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

    //  display detail page
    public function searchWithID(Request $request)
    {        /*validate request params */
        if ($request->input('term') != null) {
            $footer_content = (new FooterController)->footerContent();
            if (preg_match('/^[0-9]*$/', $request->input('term'))) {
                $property = (new Property)->where('id', '=', $request->input('term'))->where('status', '=', 'active')->first();
                if ($property) {
                    //   TODO: remove this after test
//                    $args = array(
//                        'property_id' => $property->id,
//                        'url' => \request()->url(),
//                        'ip' => HitController::getIP(),
//                    );
//                    TrackUrlController::store($args);
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
//                    DB::table('google_api_log')->where('id', 2)->increment('count', 1);

                    return view('website.pages.property_detail', [
                        'property_count' => $property->agency_id !== null ? (new PropertyController())->agencyCountOnDetailPage($property->agency_id) : 0,
                        'property' => $property,
                        'is_favorite' => $is_favorite,
                        'property_types' => $property_types,
                        'recent_properties' => $footer_content[0],
                        'footer_agencies' => $footer_content[1],
                    ]);
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

                    return view('website.pages.property_listing', $data);
                }

            } else {
                $sort = '';
                $limit = '';
                $sort_area = '';
                $sort_area_value = '';
                $activated_at_value = '';
                $price_value = '';
                if (request()->input('sort') !== null) {
                    $sort = request()->input('sort');
                    if ($sort === 'newest') $activated_at_value = 'DESC';
                    else if ($sort === 'oldest') $activated_at_value = 'ASC';
                    else if ($sort === 'high_price') $price_value = 'DESC';
                    else if ($sort === 'low_price') $price_value = 'ASC';

                } else
                    $sort = 'newest';

                if (request()->input('limit') !== null)
                    $limit = request()->input('limit');
                else
                    $limit = '15';

                if (request()->input('area_sort') !== null) {
                    $sort_area = request()->input('area_sort');
                    if ($sort_area === 'higher_area') $sort_area_value = 'DESC';
                    else if ($sort_area === 'lower_area') $sort_area_value = 'ASC';
                }

                $property_types = (new PropertyType)->all();
                (new MetaTagController())->addMetaTags();

                $result2 = City::select('id')->where('name', 'LIKE', $request->input('term') . '%')->first();
                if ($result2) {
                    $footer_content = (new FooterController)->footerContent();
                    (new MetaTagController())->addMetaTags();
                    $total_count = DB::table('property_count_by_cities')
                        ->select('property_count AS count')->where('city_id', '=', $result2->id)->first()->count;


                    $page = (isset($request->page)) ? $request->page : 1;
                    $last_id = ($page - 1) * $limit;
                    $properties = DB::select('call getPropertiesByCityId("' . $last_id . '","' . $result2->id . '","' . $limit . '","' . $activated_at_value . '","' . $price_value . '","' . $sort_area_value . '")');
                    $properties = new Collection($properties);
                    $paginatedSearchResults = new LengthAwarePaginator($properties, $total_count, $limit);
                    $paginatedSearchResults->setPath($request->url());

                    $property_types = (new PropertyType)->all();

                    if ($request->ajax()) {
                        $data['view'] = View('website.components.property-listings',
                            [
                                'limit' => $limit,
                                'area_sort' => $sort_area,
                                'sort' => $sort,
                                'params' => $request->all(),
                                'properties' => $paginatedSearchResults
                            ])->render();
                        return $data;
                    } else {
                        $data = [
                            'params' => ['sort' => 'newest', 'search_term' => $request->input('term')],
                            'property_types' => $property_types,
                            'properties' => $paginatedSearchResults,
                            'recent_properties' => $footer_content[0],
                            'footer_agencies' => $footer_content[1]
                        ];
                        return view('website.pages.property_listing', $data);
                    }


                } else {
                    $result = Agency::select('id')->where('title', 'LIKE', $request->input('term') . '%')->get()->toArray();

                    if (count($result) > 0) {
                        $footer_content = (new FooterController)->footerContent();
                        (new MetaTagController())->addMetaTags();
                        $total_count = 0;
                        $total_counts = DB::table('property_count_by_agencies')
                            ->select('property_count AS count')->where('property_status', '=', 'active')->whereIn('agency_id', $result)->get()->toArray();
                        foreach ($total_counts as $count) {
                            $total_count += $count->count;
                        }

                        $properties = $this->listingFrontend()->whereIn('properties.agency_id', $result);
                        $page = (isset($request->page)) ? $request->page : 1;
                        $last_id = ($page - 1) * $limit;
                        $properties = $this->sortPropertyListing($sort, $sort_area, $properties);
                        $properties = new Collection($properties->take($limit)->skip($last_id)->get());
//                        $properties = $properties->slice($last_id, $limit)->all();
                        $paginatedSearchResults = new LengthAwarePaginator($properties, $total_count, $limit);
                        $paginatedSearchResults->setPath($request->url());
                        $property_types = (new PropertyType)->all();

                        if ($request->ajax()) {
                            $data['view'] = View('website.components.property-listings',
                                [
                                    'limit' => $limit,
                                    'area_sort' => $sort_area,
                                    'sort' => $sort,
                                    'params' => $request->all(),
                                    'properties' => $paginatedSearchResults
                                ])->render();
                            return $data;
                        } else {
                            $data = [
                                'params' => ['sort' => 'newest', 'search_term' => $request->input('term')],
                                'property_types' => $property_types,
                                'properties' => $paginatedSearchResults,
                                'recent_properties' => $footer_content[0],
                                'footer_agencies' => $footer_content[1]
                            ];
                            return view('website.pages.property_listing', $data);

                        }
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

                        return view('website.pages.property_listing', $data);
                    }

                }
            }
        } else {
            $properties = (new Property)->newCollection();

            $property_types = (new PropertyType)->all();
            (new MetaTagController())->addMetaTags();
            $data = [
                'params' => ['sort' => 'newest'],
                'property_types' => $property_types,
                'properties' => $properties,
                'recent_properties' => (new FooterController)->footerContent()[0],
                'footer_agencies' => (new FooterController)->footerContent()[1]
            ];

            return view('website.pages.property_listing', $data);
        }


    }

    /*   search from index page bottom property listing  */
    /* search function Popular Cities to Buy Properties (houses, flats, plots)*/
    public function searchWithArgumentsForProperty(string $sub_type, string $purpose, string $city, Request $request)
    {
        if ($city == 'Islamabad-Rawalpindi') {
            $location_city = City::select('id', 'name')->where('name', '=', str_replace('-', ' ', 'Islamabad'))->first();
        } else
            $location_city = City::select('id', 'name')->where('name', '=', str_replace('-', ' ', $city))->first();
        $total_count = 0;
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


        $property_types = (new PropertyType)->all();
        (new MetaTagController())->addMetaTags();
        $footer_content = (new FooterController)->footerContent();

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
                if ($city != '') {
                    $properties->where('properties.city_id', '=', $city->id);

                    $total_count = DB::table('property_count_by_property_purposes')
                        ->select(DB::raw('SUM(property_count) AS count'))
                        ->where([
                            ['city_id', '=', $city->id],
                            ['property_purpose', '=', $purpose],
                            ['property_type', '=', $type],
                        ])->first()->count;

                } else {
                    $properties
                        ->where('properties.city_id', '=', $city_1->id)
                        ->orwhere('properties.city_id', '=', $city_2->id);
                    $count_1 = DB::table('property_count_by_property_purposes')
                        ->select(DB::raw('SUM(property_count) AS count'))
                        ->where([
                            ['city_id', '=', $city_1->id],
                            ['property_purpose', '=', $purpose],
                            ['property_type', '=', $type],
                        ])->first()->count;
                    $count_2 = DB::table('property_count_by_property_purposes')
                        ->select(DB::raw('SUM(property_count) AS count'))
                        ->where([
                            ['city_id', '=', $city_2->id],
                            ['property_purpose', '=', $purpose],
                            ['property_type', '=', $type],
                        ])->first()->count;

                    $total_count = $count_1 + $count_2;

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

                $total_count = DB::table('property_count_by_property_purposes')
                    ->select(DB::raw('SUM(property_count) AS count'))
                    ->where([
                        ['city_id', '=', $city->id],
                        ['property_purpose', '=', $purpose],
                        ['property_type', '=', $type],
                    ]);

                if ($sub_type !== '') {
                    $total_count->where('property_sub_type', '=', $sub_type);
                    $properties->where('properties.sub_type', '=', $sub_type);
                }

                $total_count = $total_count->first()->count;

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
            $properties = $this->sortPropertyListing($sort, $sort_area, $properties);
            $location_data = $this->_getLocationsWiseCount($purpose, $sub_type, $location_city->id, $location_city->name, $type);
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
                'params' => $request->all(),
                'property_types' => $property_types,
                'locations_data' => $location_data,
                'properties' => $properties->paginate($limit),
                'recent_properties' => $footer_content[0],
                'footer_agencies' => $footer_content[1]
            ];
//        dd($properties->get());
            return view('website.pages.property_listing', $data);

        }
        $page = (isset($request->page)) ? $request->page : 1;
        $properties = $this->sortPropertyListing($sort, $sort_area, $properties);
        $properties = new Collection($properties->get());
        //Slice the collection to get the items to display in current page
        $properties = $properties->slice(($page - 1) * $limit, $limit)->all();
        $paginatedSearchResults = new LengthAwarePaginator($properties, $total_count, $limit);
        $paginatedSearchResults->setPath($request->url());


        $location_data = $this->_getLocationsWiseCount($purpose, $sub_type, $location_city->id, $location_city->name, $type);
        if ($request->ajax()) {
            $data['view'] = View('website.components.property-listings',
                [
                    'limit' => $limit,
                    'area_sort' => $sort_area,
                    'sort' => $sort,
                    'params' => $request->all(),
                    'properties' => $paginatedSearchResults
                ])->render();
            return $data;
        }

        $data = [
            'params' => $request->all(),
            'property_types' => $property_types,
            'locations_data' => $location_data,
            'properties' => $paginatedSearchResults,
            'recent_properties' => $footer_content[0],
            'footer_agencies' => $footer_content[1]
        ];
//        dd($properties->get());
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
            'area_unit' => ['string', Rule::in(['Marla', 'Square Feet', 'Square Yards', 'Square Meters', 'Kanal'])],
            'min_area' => ['nullable', 'string'],
            'max_area' => ['nullable', 'string'],
            'min_price' => ['nullable', 'string'],
            'max_price' => ['nullable', 'string'],
            'bedrooms' => ['nullable', 'string'],
        ]);
        if ($validator->fails()) {
            return (['error' => $validator->errors()]);
        }

//        $location = '';
        $city = (new City)->select('id', 'name')->where('name', '=', $data['city'])->first();

//        if ($data['location'] !== null && $data['location'] !== '')
//            $location = (new Location)->select('id')->where('city_id', '=', $city->id)->where('name', '=', $data['location'])->first();

        (new MetaTagController())->addMetaTagsAccordingToCity($city->name);
        $properties = $this->listingFrontend()->where('properties.status', '=', 'active')
            ->where('properties.city_id', '=', $city->id);

        $total_count = DB::table('property_count_by_property_purposes')
            ->select(DB::raw('SUM(property_count) AS count'))
            ->where([
                ['city_id', '=', $city->id],
            ]);

        if ($data['location'] !== null && $data['location'] !== '') {
            $loc = trim($data['location']);
            $pattern = "/{$data['city']}/i";
            if (preg_match($pattern, $loc, $match)) {
                $loc = trim(str_replace($match[0], '', $loc));
            }
            $properties = $properties->where('locations.name', 'LIKE', "%{$loc}%");
            $total_count = $total_count->where('location_name', 'LIKE', "%{$loc}%");
        }

        $properties->where('properties.purpose', '=', $data['purpose']);
        $total_count = $total_count->where('property_purpose', '=', $data['purpose']);

        if ($data['type'] !== '' && $data['type'] !== null) {
            $properties->where('properties.type', '=', $data['type']);
            $total_count = $total_count->where('property_type', '=', $data['type']);
        }
        if ($data['subtype'] !== null && $data['subtype'] !== '') {
            $properties->where('properties.sub_type', '=', str_replace('-', ' ', $data['subtype']));
            $total_count = $total_count->where('property_sub_type', '=', str_replace('-', ' ', $data['subtype']));
        }


        if ($data['beds']) $properties->where('properties.bedrooms', '=', $data['beds']);

//        if ($data['area_unit'] !== '') $properties->where('properties.area_unit', '=', $data['area_unit']);

        $min_price = intval(str_replace(',', '', $data['min_price']));
        $max_price = intval(str_replace(',', '', $data['max_price']));


        //        both filters have some custom values
        if ($min_price !== 0 and $max_price !== 0) {
            if ($min_price < $max_price) {
                $properties->where('price', '>=', $min_price)->where('price', '<=', $max_price);
            } elseif ($min_price > $max_price) {
                $properties->where('price', '>=', $max_price)->where('price', '<=', $min_price);
            }
        } //      if min price is selected
        else if ($min_price !== 0 and $max_price === 0) {
//            dd('if min!=0 and max != 0');
            $properties->where('price', '>=', $min_price);
        } //      if max price is selected
        else if ($min_price === 0 and $max_price !== 0) {
            $properties->where('price', '<=', $max_price);
        }

        //        both filters have some custom values
        $min_area = floatval(str_replace(',', '', $data['min_area']));
        $max_area = floatval(str_replace(',', '', $data['max_area']));


        if ($min_area < 0 or $max_area < 0) {
            $min_area = $max_area = 0.0;
        }


        $area_column_wrt_unit = '';

//        if ($data['area_unit'] === 'Marla') $area_column_wrt_unit = 'area_in_marla';
//        if ($data['area_unit'] === 'New Marla (225 Sqft)') $area_column_wrt_unit = 'area_in_new_marla';
        if ($data['area_unit'] === 'Marla') $area_column_wrt_unit = 'area_in_new_marla';
        if ($data['area_unit'] === 'Kanal') $area_column_wrt_unit = 'area_in_kanal';
//        if ($data['area_unit'] === 'New Kanal (16 Marla)') $area_column_wrt_unit = 'area_in_new_kanal';
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
}
