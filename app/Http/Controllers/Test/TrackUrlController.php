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
        $area_unit = 'Marla';

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
        $properties = (new \App\Models\Property)->select('id', 'type', 'user_id', 'sub_type', 'purpose', 'price',
            'land_area', 'title', 'description', 'area_unit', 'bedrooms', 'bathrooms', 'golden_listing', 'platinum_listing', 'contact_person', 'phone', 'cell',
            'email', 'views', 'favorites AS favorite_count', 'activated_at', 'city_id', 'location_id', 'agency_id')
            ->where('purpose', $purpose)
            ->where('status', 'active')
            ->with(['city' => function ($query) {
                $query->select('name AS city', 'id');

            }])
            ->with(['location' => function ($query) {
                $query->select('name AS location');
                if ($loc = \request('location')) {
                    $query = $query->where('id', $loc);
                }
            }])
            ->with(['images' => function ($query) {
                $query->select('name', 'property_id')->limit(1);
            }])
            ->with(['favorites' => function ($query) {
                if (auth()->guard('api')->check()) {
                    $query->select('user_id AS user_favorite', 'property_id')
                        ->where('user_id', auth()->guard('api')->check() ? auth()->guard('api')->user()->getAuthIdentifier() : null);
                }
            }])
            ->with(['agency' => function ($query) {
                $query->select('title AS agency_title', 'logo', 'ceo_name', 'phone', 'cell', 'description');
            }]);
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


//        $count = sizeof($properties);
        $page = (isset($request->page)) ? $request->page : 1;
        $last_id = ($page - 1) * $limit;

//        $newproperties = array_slice($properties, $last_id, $limit);
//        $newproperties = array_slice($properties, $last_id, $limit);
        $newproperties = $properties->take($limit)->skip($last_id)->get();

        $newproperties = (new PropertyListingResource)->myToArray($newproperties);
        $newproperties = new Collection($newproperties);

        $paginatedSearchResults = new LengthAwarePaginator($newproperties, $count, $limit);
        $paginatedSearchResults->setPath($request->url());
        $paginatedSearchResults->appends(request()->query());
//        return (new \App\Http\JsonResponse)->success("Search Result", $paginatedSearchResults);


        return view('website.testapi', ['data' => $paginatedSearchResults]);


        $query = '(SELECT `properties`.`id`, `properties`.`user_id`, `properties`.`reference`,
           `properties`.`purpose`, `properties`.`sub_purpose`, `properties`.`sub_type`,
           `properties`.`type`, `properties`.`title`, `properties`.`description`,
           `properties`.`price`, `properties`.`land_area`, `properties`.`area_unit`,
           `properties`.`bedrooms`, `properties`.`bathrooms`, `properties`.`features`,
           `properties`.`silver_listing`, `properties`.`golden_listing`, `properties`.`platinum_listing`,
           `properties`.`contact_person`, `properties`.`phone`, `properties`.`cell`, `properties`.`fax`,
           `properties`.`email`, `properties`.`favorites`, `properties`.`views`, `properties`.`status`,
           `f`.`user_id` as `user_favorite`, `properties`.`created_at`, `properties`.`activated_at`,
           `properties`.`updated_at`, `locations`.`name` as `location`, `cities`.`name` as `city`,
           `p`.`name` as `image`, `properties`.`area_in_sqft`, `area_in_sqyd`, `area_in_marla`, `area_in_new_marla`,
           `area_in_kanal`, `area_in_new_kanal`, `area_in_sqm`, `agencies`.`title` as `agency`, `agencies`.`featured_listing`,
           `agencies`.`logo` as `logo`, `agencies`.`key_listing`, `agencies`.`status` as `agency_status`,
           `agencies`.`phone` as `agency_phone`, `agencies`.`cell` as `agency_cell`, `agencies`.`ceo_name` as `agent`,
           `agencies`.`created_at` as `agency_created_at`, `agencies`.`description` as `agency_description`,
           `users`.`community_nick` as `user_nick_name`,
           `users`.`name` as `user_name`
           FROM `properties`
           LEFT JOIN `images` as `p` on `p`.`property_id` = `properties`.`id` and `p`.`name` = (select name from images where images.property_id = properties.id and images.deleted_at IS null ORDER BY images.order  limit 1 )


           INNER JOIN `locations` on `properties`.`location_id` = `locations`.`id`
           INNER JOIN `cities` on `properties`.`city_id` = `cities`.`id`
           LEFT JOIN `agencies` on `properties`.`agency_id` = `agencies`.`id`
           LEFT JOIN `favorites` as `f` on `properties`.`id` = `f`.`property_id` and `f`.`user_id` = 0
           INNER JOIN `users` on `properties`.`user_id` = `users`.`id`

           WHERE  `properties`.`status` = \'active\'
           AND `properties`.`purpose` = \'' . $purpose . '\'
           ORDER BY `properties`.`activated_at`  DESC ,
           `properties`.`platinum_listing` DESC,
           `properties`.`golden_listing` DESC
            LIMIT 50000)';

        $criteria = "";
        $properties = DB::select("SELECT `t1`.* FROM " . $query . " `t1`  WHERE 1=1  {$criteria}");
//        print_r('ko');
//        exit();


//        $count = $properties->count();
//        $properties = $properties->get();


//
//        if ($beds = $request->bedrooms) {
//            $properties = $properties->whereIn('properties.bedrooms', $beds);
//        }
//        if ($baths = $request->bathrooms) {
//            $properties->whereIn('properties.bathrooms', $baths);
//        }


//        print_r($properties->paginate(10));
//        exit();


//        if ($beds = $request->bedrooms) {
//            $properties = $properties->filter(function ($property) use ($beds) {
//                return array_search($property->bedrooms, $beds);
//            });
//        }
//        print($count);
//        exit();


//        print_r($properties->paginate(10));
//        exit();


//        $properties->appends(request()->query());
//        $properties = PropertyResource::collection($properties);
//        $newproperties = (new PropertyListingResource)->dataCleaning($properties);
//        $newproperties = new Collection($newproperties);

        $paginatedSearchResults = new LengthAwarePaginator($properties, $count, $limit);
        $paginatedSearchResults->setPath($request->url());
        $paginatedSearchResults->appends(request()->query());
        return (new \App\Http\JsonResponse)->success("Search Result", $paginatedSearchResults);


        print_r($properties);
        exit();


        if ($c = $request->city) {

//            $properties->where('properties.city_id', $c);
            $criteria .= " AND `properties`.`city_id` = '" . $c . "'";

        }

        if ($loc = $request->location) {
            $loc = trim($loc);
            if ($city) {
                $pattern = "/{$city->name}/i";
                if (preg_match($pattern, $loc, $match)) {
                    $loc = trim(str_replace($match[0], '', $loc));
                }
            }
//            $properties = $properties->where('locations.name', 'LIKE', "%{$loc}%");
            $criteria .= " AND `locations`.`name` = '" . $c . "'";
//            $properties = $properties->where('properties.location_id', $loc);
//            $properties = $properties->join('locations', 'properties.location_id', '=', $request->location_id);
        }
        // purpose = rent ,buy
//        if ($p = $request->purpose) {
//            if ($p == 'buy') {
////                $properties->where('properties.purpose', 'sale');
//                $criteria .= " AND `t1`.`purpose` =   'sale'";
//            } else {
////                $properties->where('properties.purpose', $p);
//                $criteria .= " AND `t1`.`purpose` = '" . $p . "'";
//            }
//
//        }

        if ($beds = $request->bedrooms) {
//            $properties->whereIn('properties.bedrooms', $beds);
            $beds = str_replace('"', "'", str_replace(']', '', str_replace('[', '', json_encode($beds))));
            $criteria .= " AND `t1`.`bedrooms` IN( " . $beds . ")";
        }

        if ($baths = $request->bathrooms) {
//            $properties->whereIn('properties.bathrooms', $baths);
//            $baths = str_replace(']', '', str_replace('[', '', json_encode($baths)));
            $baths = str_replace('"', "'", str_replace(']', '', str_replace('[', '', json_encode($baths))));
            $criteria .= " AND `t1`.`bathrooms` IN( " . $baths . ")";
        }

        if ($request->has('area_unit')) {
            $area_unit = str_replace('_', ' ', $request->area_unit);

        }

//        if ($area_unit = $request->area_unit)
//            $properties->where('properties.area_unit', ucwords(str_replace('-', ' ', $area_unit)));


        // type = homes, plots, commercial

        if ($st = $request->sub_types) {
            if (!in_array('all', $st)) {
//                $properties = $properties->whereIn('sub_type', $st);
//                $st = str_replace(']', '', str_replace('[', '', json_encode($st)));
                $st = str_replace('"', "'", str_replace(']', '', str_replace('[', '', json_encode($st))));


                $criteria .= " AND `t1`.`sub_type` IN( " . $st . ")";
            }

        }
//        print($criteria);
//        exit();

        //apply sorting

        $properties = DB::select("SELECT `t1`.* FROM " . $query . " `t1`  WHERE 1=1  {$criteria}");

        print('ll');
        exit();

    }
}
