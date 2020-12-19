<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dashboard\City;
use App\Models\Dashboard\Location;
use App\Models\Property;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PropertySearchController extends Controller
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
        if ($sort_area === 'higher_area') $properties = $properties->orderBy('area_in_sqft', 'DESC');
        else if ($sort_area === 'lower_area') $properties = $properties->orderBy('area_in_sqft', 'ASC');

        if ($sort === 'newest') $properties = $properties->orderBy('created_at', 'DESC');
        else if ($sort === 'oldest') $properties = $properties->orderBy('created_at', 'ASC');
        else if ($sort === 'high_price') $properties = $properties->orderBy('price', 'DESC');
        else if ($sort === 'low_price') $properties = $properties->orderBy('price', 'ASC');

        return $properties;
    }

    /* search function for houses at different locations*/
    /* locations are going to be fixed  we use like or regexp to find that location*/

    public function searchForHousesAndPlots(string $type, string $city, string $location)
    {
        $purpose = 'sale';
        $city = City::select('id', 'name')->where('name', '=', $city)->first();

        $clean_location = str_replace('_', '-', str_replace('-', ' ', str_replace('BY', '/', $location)));

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

    private function _getLocationsWiseCount(string $purpose, string $sub_type, int $city_id, string $city_name, string $type)
    {
        if ($type === '') {
            if (in_array($sub_type, ['house', 'houses', 'flat', 'flats', 'upper-portion', 'lower-portion', 'farm-house', 'room', 'penthouse'])) $type = 'homes';
            elseif (in_array($sub_type, ['Residential Plot', 'Commercial Plot', 'Agricultural Land', 'Industrial Land', 'Plot File', 'Plot Form'])) $type = 'plots';
            elseif (in_array($sub_type, ['office', 'shop', 'warehouse', 'factory', 'building', 'other']))
                $type = 'commercial';

        }
        $condition = ['city_id' => $city_id, 'property_purpose' => $purpose, 'property_type' => $type];

//        $location_data['count'] = DB::table('property_count_by_property_purposes')->select('location_name', 'property_count', 'property_sub_type')->where($condition)->orderBy('property_count', 'DESC')->limit(50)->get();
        $location_data['count'] = DB::table('property_count_by_property_purposes')->select(DB::raw('SUM(property_count) as property_count'), 'location_name', 'property_type')
            ->where($condition)
            ->groupBy('location_name', 'property_type')
            ->orderBy('property_count', 'DESC')->limit(50)->get();
        $location_data['purpose'] = $purpose;
        $location_data['type'] = $type;
        $location_data['city'] = $city_name;
        return $location_data;
    }

    public function searchPropertyWithLocationName(string $type, string $purpose, string $city, string $location)
    {
        $city = City::select('id', 'name')->where('name', '=', $city)->first();

        $clean_location = str_replace('_', '-', str_replace('-', ' ', str_replace('BY', '/', $location)));

        /*change this part to locate some fix locations in location table */
        $location_data = Location::select('id')->where('city_id', '=', $city->id)
            ->where('name', '=', $clean_location)->get()->toArray();

//        $properties = $this->listingFrontend();
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

//        $properties = $this->sortPropertyListing($sort, $sort_area, $properties);
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


    /*   search from index page bottom property listing  */
    /* search function Popular Cities to Buy Properties (houses, flats, plots)*/
    public function searchWithArgumentsForProperty(string $sub_type, string $purpose, string $city, Request $request)
    {
        $location_city = City::select('id', 'name')->where('name', '=', str_replace('-', ' ', $city))->first();

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


        $location_data = $this->_getLocationsWiseCount($purpose, $sub_type, $location_city->id, $location_city->name, $type);

        $data = [
            'params' => $request->all(),
            'property_types' => $property_types,
            'locations_data' => $location_data,
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
//        dd($data['type']);

        if ($data['type'] !== '' && $data['type'] !== null) $properties->where('properties.type', '=', $data['type']);
        if ($data['subtype'] !== null && $data['subtype'] !== '') $properties->where('properties.sub_type', '=', str_replace('-', ' ', $data['subtype']));


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
//            dd('if min=0 and max == 0');
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
