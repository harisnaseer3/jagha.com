<?php

namespace App\Http\Controllers\Api\WebServices\Property;

use App\Http\Controllers\Controller;
use App\Http\Resources\Property as PropertyResource;
use App\Http\Resources\PropertyListing as PropertyListingResource;
use App\Models\Agency;
use App\Models\Dashboard\City;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PropertySearchController extends Controller
{

    function listingFrontend()
    {
        return DB::table('properties')
            ->select('properties.id', 'properties.user_id', 'properties.purpose', 'properties.sub_purpose', 'properties.sub_type',
                'properties.type', 'properties.title', 'properties.description', 'properties.price', 'properties.land_area', 'properties.area_unit',
                'properties.bedrooms', 'properties.bathrooms', 'properties.golden_listing', 'properties.platinum_listing',
                'properties.contact_person', 'properties.phone', 'properties.cell', 'properties.fax', 'properties.email', 'properties.favorites',
                'properties.views', 'properties.status', 'f.user_id AS user_favorite', 'properties.created_at', 'properties.activated_at',
                'properties.updated_at', 'locations.name AS location', 'cities.name AS city', 'p.name AS image',
                'properties.area_in_sqft', 'properties.area_in_sqyd', 'properties.area_in_marla', 'properties.area_in_new_marla', 'properties.area_in_kanal',
                'properties.area_in_new_kanal', 'properties.area_in_sqm',
                'agencies.title AS agency', 'agencies.featured_listing', 'agencies.logo AS logo', 'agencies.key_listing', 'agencies.status AS agency_status',
                'agencies.phone AS agency_phone', 'agencies.cell AS agency_cell', 'agencies.ceo_name AS agent', 'agencies.created_at AS agency_created_at',
                'agencies.description AS agency_description', 'c.property_count AS agency_property_count')
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
                    ->where('f.user_id', '=', auth()->guard('api')->check() ? auth()->guard('api')->user()->getAuthIdentifier() : null);
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

//        if ($sort_area === 'higher_area') $properties = $properties->orderBy('properties.area_in_sqft', 'DESC');
//        else if ($sort_area === 'lower_area') $properties = $properties->orderBy('properties.area_in_sqft', 'ASC');

        if ($sort === 'newest') $properties = $properties->orderBy('properties.activated_at', 'DESC');
        else if ($sort === 'oldest') $properties = $properties->orderBy('properties.activated_at', 'ASC');
        else if ($sort === 'high_price') $properties = $properties->orderBy('properties.price', 'DESC');
        else if ($sort === 'low_price') $properties = $properties->orderBy('properties.price', 'ASC');


        return $properties;
    }

    public function search(Request $request)
    {
        $city = null;
        $area_unit = 'Marla';

        $sort_area = 'higher_area';
        if (request()->input('sort') !== null)
            $sort = request()->input('sort');
        else
            $sort = 'newest';
        $limit = 10;


//        if ((count($request->all()) == 0 || count($request->all()) <= 2) && ($request->has('page') || $request->has('area_unit'))) {
//            print('ll');
//            exit();
//
//            $area_unit = str_replace('_', ' ', $request->area_unit);
//
//            $properties = $this->listingFrontend();
//            $total_count = DB::table('total_property_count')->select('property_count')->first()->property_count;
//
//
//            $page = (isset($request->page)) ? $request->page : 1;
//            $last_id = ($page - 1) * $limit;
//            $properties = $this->sortPropertyListing($sort, $sort_area, $properties);
//            $properties = $properties->take($limit)->skip($last_id)->get();
//            $properties = (new PropertyListingResource)->myToArray($properties, $area_unit);
//            $properties = new Collection($properties);
//
//            $paginatedSearchResults = new LengthAwarePaginator($properties, $total_count, $limit);
//            $paginatedSearchResults->setPath($request->url());
//            $paginatedSearchResults->appends(request()->query());
//            return (new \App\Http\JsonResponse)->success("Search Result", $paginatedSearchResults);
//
//        }


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

        $properties = (new \App\Models\Property)->select('id', 'type', 'user_id', 'sub_type', 'purpose', 'price',
            'land_area', 'title', 'description', 'area_unit', 'bedrooms', 'bathrooms', 'golden_listing', 'platinum_listing', 'contact_person', 'phone', 'cell',
            'email', 'views', 'activated_at', 'favorites', 'city_id', 'location_id', 'agency_id')
            ->where('purpose', $purpose)
            ->where('status', 'active');

        if ($c = $request->city) {
            $properties->where('city_id', $c);
        } else {
            $properties->where('city_id', 1);
        }

        if ($loc = $request->location) {
            $properties->where('location_id', $loc);
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


        $count = $properties->select()->count();


//
        $page = (isset($request->page)) ? $request->page : 1;
        $last_id = ($page - 1) * $limit;
        $newproperties = $properties->limit($limit)->skip($last_id);
        $user_id = auth()->guard('api')->check() ? auth()->guard('api')->user()->getAuthIdentifier() : null;
        $newproperties = $this->sortPropertyListing($sort, $sort_area, $newproperties)
            ->with(['images' => function ($query) {
                $query->select('name','property_id');
            }])
            ->with(['city' => function ($query) {
                $query->select('name', 'id');
            }])
            ->with(['location' => function ($query) {
                $query->select('name', 'id');
            }])
            ->with(['userFavorites' => function ($query) use ($user_id) {
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
        return (new \App\Http\JsonResponse)->success("Search Result", $paginatedSearchResults);
    }

    public function genericSearch(Request $request)
    {
        if ($request->has('term')) {
            if ($request->input('term') != null) {
                if (preg_match('/^[0-9]*$/', $request->input('term'))) {
                    $property = (new Property)->where('id', '=', $request->input('term'))->where('status', 'active')->first();
                    if ($property) {

//                        $views = $property->views;
//                        $property->views = $views + 1;
//                        $property->save();

                        $is_favorite = false;

                        if (Auth::guard('api')->check()) {
                            $is_favorite = DB::table('favorites')->select('id')
                                ->where([
                                    ['user_id', '=', auth::guard('api')->user()->getAuthIdentifier()],
                                    ['property_id', '=', $property->id],
                                ])->exists();
                        }
                        $property->city = $property->city->name;
                        $property->location = $property->location->name;


                        $similar_properties = $this->listingFrontend()
                            ->where([
                                ['properties.id', '<>', $property->id],
                                ['properties.city_id', $property->city_id],
                                ['properties.type', $property->type],
                                ['properties.sub_type', $property->sub_type],
                                ['properties.purpose', $property->purpose],
                            ]);

                        $sort_area = 'higher_area';
                        $sort = 'newest';

                        $similar_properties = $this->sortPropertyListing($sort, $sort_area, $similar_properties);

                        $similar_properties = $similar_properties->limit(50)->get();

                        if ($similar_properties->count()) {
                            $similar_properties = (new PropertyListingResource)->myToArray($similar_properties);
                        } else
                            $similar_properties = [];


                        $data = (object)[
                            'property' => new PropertyResource($property),
                            'similar_properties' => $similar_properties
                        ];

                        return (new \App\Http\JsonResponse)->success("Property Details", $data);

                    } else {
                        return (new \App\Http\JsonResponse)->successNoContent();
                    }

                } else {
                    $sort = '';
                    $limit = '';
                    $sort_area = '';
                    $sort_area_value = '';
                    $activated_at_value = '';
                    $price_value = '';
                    if (request()->input('sort') !== null) {
                        $sort = $request->input('sort');
                        if ($sort === 'newest') $activated_at_value = 'DESC';
                        else if ($sort === 'oldest') $activated_at_value = 'ASC';
                        else if ($sort === 'high_price') $price_value = 'DESC';
                        else if ($sort === 'low_price') $price_value = 'ASC';

                    } else
                        $sort = 'newest';

                    if (request()->input('limit') !== null)
                        $limit = request()->input('limit');
                    else
                        $limit = '10';

                    if (request()->input('area_sort') !== null) {
                        $sort_area = request()->input('area_sort');
                        if ($sort_area === 'higher_area') $sort_area_value = 'DESC';
                        else if ($sort_area === 'lower_area') $sort_area_value = 'ASC';
                    }

                    $result3 = DB::table('cities')->select('id')->where('name', 'LIKE', $request->input('term') . '%')->first();
                    if ($result3) {
                        $total_count = DB::table('property_count_by_cities')
                            ->select('property_count AS count')->where('city_id', '=', $result3->id)->first()->count;


                        $page = (isset($request->page)) ? $request->page : 1;
                        $last_id = ($page - 1) * $limit;
                        $properties = DB::select('call getPropertiesByCityId("' . $last_id . '","' . $result3->id . '","' . $limit . '","' . $activated_at_value . '","' . $price_value . '","' . $sort_area_value . '")');
                        $properties = (new PropertyListingResource)->myToArray($properties);
                        $properties = new Collection($properties);
                        $paginatedSearchResults = new LengthAwarePaginator($properties, $total_count, $limit);
                        $paginatedSearchResults->setPath($request->url());
                        $paginatedSearchResults->appends(request()->query());

                        return (new \App\Http\JsonResponse)->success("Property Search Results", $paginatedSearchResults);
                    } else {
                        $result = Agency::select('id')->where('title', 'LIKE', $request->input('term') . '%')->get()->toArray();
                        if (count($result) > 0) {
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
                            $properties = $properties->take($limit)->skip($last_id)->get();
                            $properties = (new PropertyListingResource)->myToArray($properties);
                            $properties = new Collection($properties);

                            $paginatedSearchResults = new LengthAwarePaginator($properties, $total_count, $limit);
                            $paginatedSearchResults->setPath($request->url());
                            $paginatedSearchResults->appends(request()->query());


                            return (new \App\Http\JsonResponse)->success("Property Details", $paginatedSearchResults);
                        } else {
                            $result2 = DB::table('cities')->select('id')->whereRaw(DB::raw('INSTR("' . $request->input('term') . '",`name`)'))->get();

                            if (!$result2->isEmpty()) {
                                $result2 = $result2[0];
//                                $total_count = DB::table('property_count_by_cities')
//                                    ->select('property_count AS count')->where('city_id', '=', $result2->id)->first()->count;


                                $page = (isset($request->page)) ? $request->page : 1;
                                $last_id = ($page - 1) * $limit;
                                $properties = DB::select('call getPropertiesByGenericCitySearch("' . $last_id . '","' . $result2->id . '","' . $limit . '","' . $activated_at_value . '","' . $price_value . '","' . $sort_area_value . '","' . $request->input('term') . '")');
                                $properties = (new PropertyListingResource)->myToArray($properties);
                                $properties = new Collection($properties);
                                $paginatedSearchResults = new LengthAwarePaginator($properties, $properties->count(), $limit);
                                $paginatedSearchResults->setPath($request->url());
                                $paginatedSearchResults->appends(request()->query());

                                return (new \App\Http\JsonResponse)->success("Property Search Results", $paginatedSearchResults);


                            } else
                                return (new \App\Http\JsonResponse)->successNoContent();
                        }
                    }
                }
            } else
                return (new \App\Http\JsonResponse)->unprocessable();
        } else
            return (new \App\Http\JsonResponse)->unprocessable();

    }

    public function count()
    {
        return $this->prepareCountQuery()->count();
    }

    protected function prepareCountQuery()
    {
        $builder = clone $this->query;
        return $builder;
    }
}
