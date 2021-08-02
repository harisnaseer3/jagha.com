<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Http\Resources\PropertyListing as PropertyListingResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TrackUrlController extends Controller
{
//    public static function store($args)
//    {
//        DB::table('track_urls')->insert($args);
//    }

    public function search(Request $request)
    {

        $city = null;

        $sort_area = 'higher_area';
        if (request()->input('sort') !== null)
            $sort = request()->input('sort');
        else
            $sort = 'newest';
        $limit = 10;


        $purpose = 'sale';
        if ($p = $request->purpose) {
            if ($p == 'rent') $purpose = 'rent';
        }
        if ($au = $request->area_unit) {
            $area_unit = $au;
        }
        $user_id = auth()->guard('api')->check() ? auth()->guard('api')->user()->getAuthIdentifier() : null;
        $properties = (new \App\Models\Property)->select('id', 'type', 'user_id', 'sub_type', 'purpose', 'price',
            'land_area', 'title', 'description', 'area_unit', 'bedrooms', 'bathrooms', 'golden_listing', 'platinum_listing', 'contact_person', 'phone', 'cell',
            'email', 'views', 'activated_at', 'favorites As favorite_count', 'city_id', 'location_id', 'agency_id')
            ->where('purpose', $purpose)
            ->where('status', 'active');

        if ($c = $request->city) {
            $properties->where('city_id', $c);
        }

        if ($beds = $request->bedrooms) {
            $properties->whereIntegerInRaw('properties.bedrooms', $beds);
        }

        if ($baths = $request->bathrooms) {
            $properties->whereIntegerInRaw('properties.bathrooms', $baths);
        }

        $types = ['homes', 'plots', 'commercial'];
        if ($t = $request->types) {
            if (!(array_diff($types, $t) === array_diff($t, $types))) {
                $properties = $properties->whereIn('type', $t);
            }
        }

        if ($st = $request->sub_types) {
            $properties = $properties->whereIn('sub_type', $st);
        }


        $min_price = 0;
        $min_area = 0.0;
        $max_area = 0.0;
        $max_price = 0;

        if ($request->has('min_price') || $request->has('max_price')) {
            if ($request->has('min_price')) $min_price = intval(str_replace(',', '', $request->min_price));
            if ($request->has('max_price')) $max_price = intval(str_replace(',', '', $request->max_price));

            if ($min_price !== 0 and $max_price !== 0) {
                if ($min_price < $max_price) {
                    $properties->where('properties.price', '>=', $min_price)->where('price', '<=', $max_price);
                } elseif ($min_price > $max_price) {
                    $properties->where('properties.price', '>=', $max_price)->where('price', '<=', $min_price);
                }
            } else if ($min_price !== 0 and $max_price === 0) {
                $properties->where('properties.price', '>=', $min_price);
            } else if ($min_price === 0 and $max_price !== 0) {
                $properties->where('properties.price', '<=', $max_price);
            }
        }

        if ($request->has('min_area') || $request->has('max_area')) {
            if ($min_area < 0 or $max_area < 0) {
                $min_area = $max_area = 0.0;
            }

            if ($request->has('min_area')) $min_area = floatval(str_replace(',', '', $request->min_area));
            if ($request->has('max_area')) $max_area = floatval(str_replace(',', '', $request->max_area));
            $area_column_wrt_unit = '';


            if (ucwords($area_unit) === 'Marla') $area_column_wrt_unit = 'properties.area_in_new_marla';
            else if (ucwords($area_unit) === 'Kanal') $area_column_wrt_unit = 'properties.area_in_new_kanal';
            else if (ucwords($area_unit) === 'Square Feet') $area_column_wrt_unit = 'properties.area_in_sqft';
            else if (ucwords($area_unit) === 'Square Yards') $area_column_wrt_unit = 'properties.area_in_sqyd';
            else if (ucwords($area_unit) === 'Square Meters') $area_column_wrt_unit = 'properties.area_in_sqm';
            else
                $area_column_wrt_unit = 'properties.area_in_marla';


            if ($min_area !== 0.0 and $max_area !== 0.0) {
                if ($min_area < $max_area) {
                    $properties->whereBetween($area_column_wrt_unit, [$min_area, $max_area]);
                }
            } else if ($min_area !== 0.0 and $max_area === 0.0) {
                $properties->where($area_column_wrt_unit, '>=', $min_area);
            } else if ($min_area === 0.0 and $max_area !== 0.0) {
                $properties->where($area_column_wrt_unit, '<=', $max_area);
            }
        }


        $count = $properties->count();


        $page = (isset($request->page)) ? $request->page : 1;
        $last_id = ($page - 1) * $limit;


        $newproperties = $properties->limit($limit)->skip($last_id);
        $newproperties = $this->sortPropertyListing($sort, $sort_area, $newproperties)
            ->with(['city' => function ($query) {
                $query->select('name', 'id');
            }])
            ->with(['location' => function ($query) {
                $query->select('name', 'id');
                if ($loc = \request('location')) {
                    $query = $query->where('id', $loc);
                }
            }])
            ->with(['images' => function ($query) {
                $query->select('name', 'property_id')->limit(1);
            }])
            ->with(['favorites' => function ($query) use ($user_id) {
                $query->select('user_id', 'property_id')
                    ->where('user_id', $user_id);
            }])
            ->with(['agency' => function ($query) {
                $query->select('title AS agency_title', 'logo', 'ceo_name', 'phone', 'cell', 'description', 'id');
            }])
            ->get();


        $newproperties = (new PropertyListingResource)->dataCleaning($newproperties, $area_unit);
        $newproperties = new Collection($newproperties);

        $paginatedSearchResults = new LengthAwarePaginator($newproperties, $count, $limit);
        $paginatedSearchResults->setPath($request->url());
        $paginatedSearchResults->appends(request()->query());
        return view('website.testapi', ['data' => $paginatedSearchResults]);


    }

    function sortPropertyListing($sort, $sort_area, $properties)
    {
        $properties = $properties->orderBy('properties.platinum_listing', 'DESC');
        $properties = $properties->orderBy('properties.golden_listing', 'DESC');

//        if ($sort_area === 'higher_area') $properties = $properties->orderBy('properties.area_in_sqft', 'DESC');
//        else if ($sort_area === 'lower_area') $properties = $properties->orderBy('properties.area_in_sqft', 'ASC');

        if ($sort === 'newest') $properties = $properties->orderBy('properties.activated_at', 'DESC');
        else if ($sort === 'oldest') $properties = $properties->orderBy('properties.activated_at', 'ASC');
        else if ($sort === 'high_price') $properties = $properties->orderBy('properties.price', 'DESC');
        else if ($sort === 'low_price') $properties = $properties->orderBy('properties.price', 'ASC');


        return $properties;
    }
}
