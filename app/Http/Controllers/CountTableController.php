<?php

namespace App\Http\Controllers;

use App\Models\Dashboard\City;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class CountTableController extends Controller
{
//    fetch data for index page
    public function popularLocations()
    {
        $popular_cities_houses_on_sale = DB::table('property_count_by_property_purposes')
            ->select(DB::raw('SUM(property_count) AS property_count'), 'city_id', 'city_name', 'property_purpose', 'property_type', 'property_sub_type')
            ->where([
                ['property_purpose', '=', 'sale'],
                ['property_type', '=', 'Homes'],
                ['property_sub_type', '=', 'House'],
            ])
            ->orwhere([
                ['property_purpose', '=', 'sale'],
                ['property_type', '=', 'Homes'],
                ['property_sub_type', '=', 'Flat'],
            ])
            ->orderBy('property_count', 'DESC')
            ->groupBy('city_id', 'city_name', 'property_purpose', 'property_type', 'property_sub_type')
            ->limit(6)->get();

        $popular_cities_plots_on_sale = DB::table('property_count_by_property_purposes')
            ->select(DB::raw('SUM(property_count) AS property_count'), 'city_id', 'city_name', 'property_purpose', 'property_type')
            ->where('property_type', '=', 'Plots')
            ->where('property_purpose', '=', 'sale')
            ->orderBy('property_count', 'DESC')
            ->groupBy('city_id', 'city_name', 'property_purpose', 'property_type')
            ->limit(6)->get();

        $popular_cities_commercial_on_sale = DB::table('property_count_by_property_purposes')
            ->select(DB::raw('SUM(property_count) AS property_count'), 'city_id', 'city_name', 'property_purpose', 'property_type', 'property_sub_type')
            ->where('property_type', '=', 'commercial')
            ->where('property_purpose', '=', 'sale')
            ->orderBy('property_count', 'DESC')
            ->groupBy('city_id', 'city_name', 'property_purpose', 'property_type', 'property_sub_type')
            ->limit(6)->get();


        $popular_cities_property_on_rent = DB::table('property_count_by_property_purposes')
            ->select(DB::raw('SUM(property_count) AS property_count'), 'city_id', 'city_name', 'property_purpose', 'property_type', 'property_sub_type')
            ->where('property_purpose', '=', 'rent')
            ->orderBy('property_count', 'DESC')
            ->groupBy('city_id', 'city_name', 'property_purpose', 'property_type', 'property_sub_type')
            ->limit(6)->get();

        $lahore_homes = DB::select(DB::raw('SELECT SUM(`property_count`) AS \'property_count\' ,  `city_popular_locations`.`location_name`,  `property_count_by_property_purposes`.`city_name`,
                    `property_count_by_property_purposes`.`property_purpose`,`property_count_by_property_purposes`.`property_type`
                    FROM `property_count_by_property_purposes`
                    INNER JOIN `city_popular_locations` ON `property_count_by_property_purposes`.`city_id` = `city_popular_locations`.`city_id`
                    WHERE `city_popular_locations`.`property_type` = \'homes\'
                    AND `property_count_by_property_purposes`.`property_type` = \'homes\'
                    AND  `property_count_by_property_purposes`.`city_id` = 3
                    AND  `property_count_by_property_purposes`.`property_purpose` = \'sale\'
                    AND `property_count_by_property_purposes`. `location_name` REGEXP `city_popular_locations`.`location_name`
                    GROUP BY  `city_popular_locations`.`location_name`, `property_count_by_property_purposes`.`city_name`,
                    `property_count_by_property_purposes`.`property_purpose`,`property_count_by_property_purposes`.`property_type`
                    ORDER BY property_count DESC LIMIT 6'));

        $lahore_plots = DB::select(DB::raw('SELECT SUM(`property_count`) AS \'property_count\' ,  `city_popular_locations`.`location_name`,  `property_count_by_property_purposes`.`city_name`,
                    `property_count_by_property_purposes`.`property_purpose`,`property_count_by_property_purposes`.`property_type`
                    FROM `property_count_by_property_purposes`
                    INNER JOIN `city_popular_locations` ON `property_count_by_property_purposes`.`city_id` = `city_popular_locations`.`city_id`
                    WHERE `city_popular_locations`.`property_type` = \'plots\'
                    AND `property_count_by_property_purposes`.`property_type` = \'plots\'
                    AND  `property_count_by_property_purposes`.`city_id` = 3
                    AND  `property_count_by_property_purposes`.`property_purpose` = \'sale\'
                    AND `property_count_by_property_purposes`. `location_name` REGEXP `city_popular_locations`.`location_name`
                    GROUP BY  `city_popular_locations`.`location_name`, `property_count_by_property_purposes`.`city_name`,
                    `property_count_by_property_purposes`.`property_purpose`,`property_count_by_property_purposes`.`property_type`
                    ORDER BY property_count DESC LIMIT 6'));

        $lahore_commercial = DB::select(DB::raw('SELECT SUM(`property_count`) AS \'property_count\' ,  `city_popular_locations`.`location_name`,  `property_count_by_property_purposes`.`city_name`,
                    `property_count_by_property_purposes`.`property_purpose`,`property_count_by_property_purposes`.`property_type`
                    FROM `property_count_by_property_purposes`
                    INNER JOIN `city_popular_locations` ON `property_count_by_property_purposes`.`city_id` = `city_popular_locations`.`city_id`
                    WHERE `city_popular_locations`.`property_type` = \'commercial\'
                    AND `property_count_by_property_purposes`.`property_type` = \'commercial\'
                    AND  `property_count_by_property_purposes`.`city_id` = 3
                    AND  `property_count_by_property_purposes`.`property_purpose` = \'sale\'
                    AND `property_count_by_property_purposes`. `location_name` REGEXP `city_popular_locations`.`location_name`
                    GROUP BY  `city_popular_locations`.`location_name`, `property_count_by_property_purposes`.`city_name`,
                    `property_count_by_property_purposes`.`property_purpose`,`property_count_by_property_purposes`.`property_type`
                    ORDER BY property_count DESC LIMIT 6'));

        $karachi_homes = DB::select(DB::raw('SELECT SUM(`property_count`) AS \'property_count\' ,  `city_popular_locations`.`location_name`,  `property_count_by_property_purposes`.`city_name`,
                    `property_count_by_property_purposes`.`property_purpose`,`property_count_by_property_purposes`.`property_type`
                    FROM `property_count_by_property_purposes`
                    INNER JOIN `city_popular_locations` ON `property_count_by_property_purposes`.`city_id` = `city_popular_locations`.`city_id`
                    WHERE `city_popular_locations`.`property_type` = \'homes\'
                    AND `property_count_by_property_purposes`.`property_type` = \'homes\'
                    AND  `property_count_by_property_purposes`.`city_id` = 2
                    AND  `property_count_by_property_purposes`.`property_purpose` = \'sale\'
                    AND `property_count_by_property_purposes`. `location_name` REGEXP `city_popular_locations`.`location_name`
                    GROUP BY  `city_popular_locations`.`location_name`, `property_count_by_property_purposes`.`city_name`,
                    `property_count_by_property_purposes`.`property_purpose`,`property_count_by_property_purposes`.`property_type`
                    ORDER BY property_count DESC LIMIT 6'));

        $karachi_plots = DB::select(DB::raw('SELECT SUM(`property_count`) AS \'property_count\' ,  `city_popular_locations`.`location_name`,  `property_count_by_property_purposes`.`city_name`,
                    `property_count_by_property_purposes`.`property_purpose`,`property_count_by_property_purposes`.`property_type`
                    FROM `property_count_by_property_purposes`
                    INNER JOIN `city_popular_locations` ON `property_count_by_property_purposes`.`city_id` = `city_popular_locations`.`city_id`
                    WHERE `city_popular_locations`.`property_type` = \'plots\'
                    AND `property_count_by_property_purposes`.`property_type` = \'plots\'
                    AND  `property_count_by_property_purposes`.`city_id` = 2
                    AND  `property_count_by_property_purposes`.`property_purpose` = \'sale\'
                    AND `property_count_by_property_purposes`. `location_name` REGEXP `city_popular_locations`.`location_name`
                    GROUP BY  `city_popular_locations`.`location_name`, `property_count_by_property_purposes`.`city_name`,
                    `property_count_by_property_purposes`.`property_purpose`,`property_count_by_property_purposes`.`property_type`
                    ORDER BY property_count DESC LIMIT 6'));

        $karachi_commercial = DB::select(DB::raw('SELECT SUM(`property_count`) AS \'property_count\' ,  `city_popular_locations`.`location_name`,  `property_count_by_property_purposes`.`city_name`,
                    `property_count_by_property_purposes`.`property_purpose`,`property_count_by_property_purposes`.`property_type`
                    FROM `property_count_by_property_purposes`
                    INNER JOIN `city_popular_locations` ON `property_count_by_property_purposes`.`city_id` = `city_popular_locations`.`city_id`
                    WHERE `city_popular_locations`.`property_type` = \'commercial\'
                    AND `property_count_by_property_purposes`.`property_type` = \'commercial\'
                    AND  `property_count_by_property_purposes`.`city_id` = 2
                    AND  `property_count_by_property_purposes`.`property_purpose` = \'sale\'
                    AND `property_count_by_property_purposes`. `location_name` REGEXP `city_popular_locations`.`location_name`
                    GROUP BY  `city_popular_locations`.`location_name`, `property_count_by_property_purposes`.`city_name`,
                    `property_count_by_property_purposes`.`property_purpose`,`property_count_by_property_purposes`.`property_type`
                    ORDER BY property_count DESC LIMIT 6'));

        $peshawar_plots = DB::select(DB::raw('SELECT SUM(`property_count`) AS \'property_count\' ,  `city_popular_locations`.`location_name`,  `property_count_by_property_purposes`.`city_name`,
                    `property_count_by_property_purposes`.`property_purpose`,`property_count_by_property_purposes`.`property_type`
                    FROM `property_count_by_property_purposes`
                    INNER JOIN `city_popular_locations` ON `property_count_by_property_purposes`.`city_id` = `city_popular_locations`.`city_id`
                    WHERE `city_popular_locations`.`property_type` = \'plots\'
                    AND `property_count_by_property_purposes`.`property_type` = \'plots\'
                    AND  `property_count_by_property_purposes`.`city_id` = 153
                    AND  `property_count_by_property_purposes`.`property_purpose` = \'sale\'
                    AND `property_count_by_property_purposes`. `location_name` REGEXP `city_popular_locations`.`location_name`
                    GROUP BY  `city_popular_locations`.`location_name`, `property_count_by_property_purposes`.`city_name`,
                    `property_count_by_property_purposes`.`property_purpose`,`property_count_by_property_purposes`.`property_type`
                    ORDER BY property_count DESC LIMIT 6'));


        $peshawar_homes = DB::select(DB::raw('SELECT SUM(`property_count`) AS \'property_count\' ,  `city_popular_locations`.`location_name`,  `property_count_by_property_purposes`.`city_name`,
                    `property_count_by_property_purposes`.`property_purpose`,`property_count_by_property_purposes`.`property_type`
                    FROM `property_count_by_property_purposes`
                    INNER JOIN `city_popular_locations` ON `property_count_by_property_purposes`.`city_id` = `city_popular_locations`.`city_id`
                    WHERE `city_popular_locations`.`property_type` = \'homes\'
                    AND `property_count_by_property_purposes`.`property_type` = \'homes\'
                    AND  `property_count_by_property_purposes`.`city_id` = 153
                    AND  `property_count_by_property_purposes`.`property_purpose` = \'sale\'
                    AND `property_count_by_property_purposes`. `location_name` REGEXP `city_popular_locations`.`location_name`
                    GROUP BY  `city_popular_locations`.`location_name`, `property_count_by_property_purposes`.`city_name`,
                    `property_count_by_property_purposes`.`property_purpose`,`property_count_by_property_purposes`.`property_type`
                    ORDER BY property_count DESC LIMIT 6'));

        $peshawar_commercial = DB::select(DB::raw('SELECT SUM(`property_count`) AS \'property_count\' ,  `city_popular_locations`.`location_name`,  `property_count_by_property_purposes`.`city_name`,
                    `property_count_by_property_purposes`.`property_purpose`,`property_count_by_property_purposes`.`property_type`
                    FROM `property_count_by_property_purposes`
                    INNER JOIN `city_popular_locations` ON `property_count_by_property_purposes`.`city_id` = `city_popular_locations`.`city_id`
                    WHERE `city_popular_locations`.`property_type` = \'commercial\'
                    AND `property_count_by_property_purposes`.`property_type` = \'commercial\'
                    AND  `property_count_by_property_purposes`.`city_id` = 153
                    AND  `property_count_by_property_purposes`.`property_purpose` = \'sale\'
                    AND `property_count_by_property_purposes`. `location_name` REGEXP `city_popular_locations`.`location_name`
                    GROUP BY  `city_popular_locations`.`location_name`, `property_count_by_property_purposes`.`city_name`,
                    `property_count_by_property_purposes`.`property_purpose`,`property_count_by_property_purposes`.`property_type`
                    ORDER BY property_count DESC LIMIT 6'));

        $isb_homes = DB::select(DB::raw('SELECT SUM(`property_count`) AS \'property_count\' ,  `city_popular_locations`.`location_name`,  `property_count_by_property_purposes`.`city_name`,
                    `property_count_by_property_purposes`.`property_purpose`,`property_count_by_property_purposes`.`property_type`
                    FROM `property_count_by_property_purposes`
                    INNER JOIN `city_popular_locations` ON `property_count_by_property_purposes`.`city_id` = `city_popular_locations`.`city_id`
                    WHERE `city_popular_locations`.`property_type` = \'homes\'
                    AND `property_count_by_property_purposes`.`property_type` = \'homes\'
                    AND  `property_count_by_property_purposes`.`city_id` = 1
                    AND  `property_count_by_property_purposes`.`property_purpose` = \'sale\'
                    AND `property_count_by_property_purposes`. `location_name` REGEXP `city_popular_locations`.`location_name`
                    GROUP BY  `city_popular_locations`.`location_name`, `property_count_by_property_purposes`.`city_name`,
                    `property_count_by_property_purposes`.`property_purpose`,`property_count_by_property_purposes`.`property_type`
                    ORDER BY property_count DESC LIMIT 3'));

        $pwd_homes = DB::select(DB::raw('SELECT SUM(`property_count`) AS \'property_count\' ,  `city_popular_locations`.`location_name`,  `property_count_by_property_purposes`.`city_name`,
                    `property_count_by_property_purposes`.`property_purpose`,`property_count_by_property_purposes`.`property_type`
                    FROM `property_count_by_property_purposes`
                    INNER JOIN `city_popular_locations` ON `property_count_by_property_purposes`.`city_id` = `city_popular_locations`.`city_id`
                    WHERE `city_popular_locations`.`property_type` = \'homes\'
                    AND `property_count_by_property_purposes`.`property_type` = \'homes\'
                    AND  `property_count_by_property_purposes`.`city_id` = 4
                    AND  `property_count_by_property_purposes`.`property_purpose` = \'sale\'
                    AND `property_count_by_property_purposes`. `location_name` REGEXP `city_popular_locations`.`location_name`
                    GROUP BY  `city_popular_locations`.`location_name`, `property_count_by_property_purposes`.`city_name`,
                    `property_count_by_property_purposes`.`property_purpose`,`property_count_by_property_purposes`.`property_type`
                    ORDER BY property_count DESC LIMIT 3'));
        foreach ($pwd_homes as $data) {
            array_push($isb_homes, $data);
        }


        $isb_plots = DB::select(DB::raw('SELECT SUM(`property_count`) AS \'property_count\' ,  `city_popular_locations`.`location_name`,  `property_count_by_property_purposes`.`city_name`,
                    `property_count_by_property_purposes`.`property_purpose`,`property_count_by_property_purposes`.`property_type`
                    FROM `property_count_by_property_purposes`
                    INNER JOIN `city_popular_locations` ON `property_count_by_property_purposes`.`city_id` = `city_popular_locations`.`city_id`
                    WHERE `city_popular_locations`.`property_type` = \'plots\'
                    AND `property_count_by_property_purposes`.`property_type` = \'plots\'
                    AND  `property_count_by_property_purposes`.`city_id` = 1
                    AND  `property_count_by_property_purposes`.`property_purpose` = \'sale\'
                    AND `property_count_by_property_purposes`. `location_name` REGEXP `city_popular_locations`.`location_name`
                    GROUP BY  `city_popular_locations`.`location_name`, `property_count_by_property_purposes`.`city_name`,
                    `property_count_by_property_purposes`.`property_purpose`,`property_count_by_property_purposes`.`property_type`
                    ORDER BY property_count DESC LIMIT 3'));

        $pwd_plots = DB::select(DB::raw('SELECT SUM(`property_count`) AS \'property_count\' ,  `city_popular_locations`.`location_name`,  `property_count_by_property_purposes`.`city_name`,
                    `property_count_by_property_purposes`.`property_purpose`,`property_count_by_property_purposes`.`property_type`
                    FROM `property_count_by_property_purposes`
                    INNER JOIN `city_popular_locations` ON `property_count_by_property_purposes`.`city_id` = `city_popular_locations`.`city_id`
                    WHERE `city_popular_locations`.`property_type` = \'plots\'
                    AND `property_count_by_property_purposes`.`property_type` = \'plots\'
                    AND  `property_count_by_property_purposes`.`city_id` = 4
                    AND  `property_count_by_property_purposes`.`property_purpose` = \'sale\'
                    AND `property_count_by_property_purposes`. `location_name` REGEXP `city_popular_locations`.`location_name`
                    GROUP BY  `city_popular_locations`.`location_name`, `property_count_by_property_purposes`.`city_name`,
                    `property_count_by_property_purposes`.`property_purpose`,`property_count_by_property_purposes`.`property_type`
                    ORDER BY property_count DESC LIMIT 3'));

        foreach ($pwd_plots as $data) {
            array_push($isb_plots, $data);
        }

        $isb_commercial = DB::select(DB::raw('SELECT SUM(`property_count`) AS \'property_count\' ,  `city_popular_locations`.`location_name`,  `property_count_by_property_purposes`.`city_name`,
                    `property_count_by_property_purposes`.`property_purpose`,`property_count_by_property_purposes`.`property_type`
                    FROM `property_count_by_property_purposes`
                    INNER JOIN `city_popular_locations` ON `property_count_by_property_purposes`.`city_id` = `city_popular_locations`.`city_id`
                    WHERE `city_popular_locations`.`property_type` = \'commercial\'
                    AND `property_count_by_property_purposes`.`property_type` = \'commercial\'
                    AND  `property_count_by_property_purposes`.`city_id` = 1
                    AND  `property_count_by_property_purposes`.`property_purpose` = \'sale\'
                    AND `property_count_by_property_purposes`. `location_name` REGEXP `city_popular_locations`.`location_name`
                    GROUP BY  `city_popular_locations`.`location_name`, `property_count_by_property_purposes`.`city_name`,
                    `property_count_by_property_purposes`.`property_purpose`,`property_count_by_property_purposes`.`property_type`
                    ORDER BY property_count DESC LIMIT 3'));

        $pwd_commercial = DB::select(DB::raw('SELECT SUM(`property_count`) AS \'property_count\' ,  `city_popular_locations`.`location_name`,  `property_count_by_property_purposes`.`city_name`,
                    `property_count_by_property_purposes`.`property_purpose`,`property_count_by_property_purposes`.`property_type`
                    FROM `property_count_by_property_purposes`
                    INNER JOIN `city_popular_locations` ON `property_count_by_property_purposes`.`city_id` = `city_popular_locations`.`city_id`
                    WHERE `city_popular_locations`.`property_type` = \'commercial\'
                    AND `property_count_by_property_purposes`.`property_type` = \'commercial\'
                    AND  `property_count_by_property_purposes`.`city_id` = 4
                    AND  `property_count_by_property_purposes`.`property_purpose` = \'sale\'
                    AND `property_count_by_property_purposes`. `location_name` REGEXP `city_popular_locations`.`location_name`
                    GROUP BY  `city_popular_locations`.`location_name`, `property_count_by_property_purposes`.`city_name`,
                    `property_count_by_property_purposes`.`property_purpose`,`property_count_by_property_purposes`.`property_type`
                    ORDER BY property_count DESC LIMIT 3'));

        foreach ($pwd_commercial as $data) {
            array_push($isb_commercial, $data);
        }


        $popular_locations = [
            'popular_cities_homes_on_sale' => $popular_cities_houses_on_sale,
            'popular_cities_plots_on_sale' => $popular_cities_plots_on_sale,
            'city_wise_homes_data' => [
                'karachi' => $karachi_homes,
                'peshawar' => $peshawar_homes,
                'lahore' => $lahore_homes,
                'rawalpindi/Islamabad' => $isb_homes
            ],
            'city_wise_plots_data' => [
                'karachi' => $karachi_plots,
                'peshawar' => $peshawar_plots,
                'lahore' => $lahore_plots,
                'rawalpindi/Islamabad' => $isb_plots
            ],
            'city_wise_commercial_data' => [
                'karachi' => $karachi_commercial,
                'peshawar' => $peshawar_commercial,
                'lahore' => $lahore_commercial,
                'rawalpindi/Islamabad' => $isb_commercial
            ],
            'popular_cities_commercial_on_sale' => $popular_cities_commercial_on_sale,
            'popular_cities_property_on_rent' => $popular_cities_property_on_rent
        ];
        return $popular_locations;
    }

    public function _insert_in_status_purpose_table($property)
    {
        //        TODO : testing pending
        $listing_type = '';
        if ($property->basic_listing)
            $listing_type = 'basic_listing';
        elseif ($property->silver_listing)
            $listing_type = 'silver_listing';
        elseif ($property->bronze_listing)
            $listing_type = 'bronze_listing';
        elseif ($property->golden_listing)
            $listing_type = 'golden_listing';
        elseif ($property->platinum_listing)
            $listing_type = 'platinum_listing';

//        if (Auth::guard('web')->user()) {
        if (DB::table('property_count_by_status_and_purposes')->where('property_status', '=', $property->status)
            ->where('property_purpose', '=', $property->purpose)->where('user_id', '=', $property->user_id)
            ->where('listing_type', '=', $listing_type)->exists()) {
            DB::table('property_count_by_status_and_purposes')->where('property_status', '=', $property->status)
                ->where('property_purpose', '=', $property->purpose)
                ->where('user_id', '=', $property->user_id)
                ->where('listing_type', '=', $listing_type)->increment('property_count');
        } else {
            DB::table('property_count_by_status_and_purposes')->insert(['property_status' => $property->status, 'property_purpose' => $property->purpose,
                'user_id' => $property->user_id, 'listing_type' => $listing_type, 'property_count' => 1]);
        }
        if ($property->user_id != 1) {
            DB::table('property_count_by_status_and_purposes')->where('property_status', '=', $property->status)
                ->where('property_purpose', '=', $property->purpose)
                ->where('user_id', '=', 1)
                ->where('listing_type', '=', $listing_type)->increment('property_count');
        }
        if (isset($property->agency_id)) {
            if (DB::table('property_count_by_agencies')->where('property_status', '=', $property->status)
                ->where('property_purpose', '=', $property->purpose)
                ->where('agency_id', '=', $property->agency_id)
                ->where('listing_type', '=', $listing_type)->exists())
                DB::table('property_count_by_agencies')
                    ->where('property_status', '=', $property->status)
                    ->where('property_purpose', '=', $property->purpose)
                    ->where('agency_id', '=', $property->agency_id)
                    ->increment('property_count');
            else
                DB::table('property_count_by_agencies')->insert(['property_status' => $property->status, 'property_purpose' => $property->purpose,
                    'agency_id' => $property->agency_id, 'listing_type' => $listing_type, 'property_count' => 1]);

        }

//        }
//        if (Auth::guard('admin')->user()) {
//            if (DB::table('property_count_by_status_and_purposes')->where('property_status', '=', $property->status)
//                ->where('property_purpose', '=', $property->purpose)
//                ->where('user_id', '=', $property->user_id)
//                ->where('listing_type', '=', $listing_type)->exists()) {
//                DB::table('property_count_by_status_and_purposes')->where('property_status', '=', $property->status)
//                    ->where('property_purpose', '=', $property->purpose)
//                    ->where('user_id', '=', $property->user_id)
//                    ->where('listing_type', '=', $listing_type)->increment('property_count');
//            } else {
//                DB::table('property_count_by_status_and_purposes')->insert(['property_status' => $property->status, 'property_purpose' => $property->purpose,
//                    'user_id' => $property->user_id, 'listing_type' => $listing_type, 'property_count' => 1]);
//            }
//            DB::table('property_count_by_status_and_purposes')->where('property_status', '=', $property->status)
//                ->where('property_purpose', '=', $property->purpose)
//                ->where('user_id', '=', 1)
//                ->where('listing_type', '=', $listing_type)->increment('property_count');
//        }

    }

    public function _delete_in_status_purpose_table($property, $status)
    {
        $listing_type = '';
        if ($property->basic_listing)
            $listing_type = 'basic_listing';
        elseif ($property->silver_listing)
            $listing_type = 'silver_listing';
        elseif ($property->bronze_listing)
            $listing_type = 'bronze_listing';
        elseif ($property->golden_listing)
            $listing_type = 'golden_listing';
        elseif ($property->platinum_listing)
            $listing_type = 'platinum_listing';

        if (DB::table('property_count_by_status_and_purposes')
            ->where('property_status', '=', $status)->where('property_purpose', '=', $property->purpose)
            ->where('user_id', '=', $property->user_id)
            ->where('listing_type', '=', $listing_type)->exists()) {
            DB::table('property_count_by_status_and_purposes')->where('property_status', '=', $status)
                ->where('property_purpose', '=', $property->purpose)
                ->where('user_id', '=', $property->user_id)
                ->where('listing_type', '=', $listing_type)->where('property_count', '>', 0)->decrement('property_count');
        }
        if ($property->user_id != 1) {
            DB::table('property_count_by_status_and_purposes')->where('property_status', '=', $status)
                ->where('property_purpose', '=', $property->purpose)
                ->where('user_id', '=', 1)
                ->where('listing_type', '=', $listing_type)->where('property_count', '>', 0)->decrement('property_count');
        }
        if (isset($property->agency_id)) {
            if (DB::table('property_count_by_agencies')->where('property_status', '=', $property->status)
                ->where('property_purpose', '=', $property->purpose)
                ->where('agency_id', '=', $property->agency_id)
                ->where('listing_type', '=', $listing_type)->exists())
                DB::table('property_count_by_agencies')->where('property_status', '=', $status)
                    ->where('property_purpose', '=', $property->purpose)
                    ->where('agency_id', '=', $property->agency_id)
                    ->where('listing_type', '=', $listing_type)->where('property_count', '>', 0)->decrement('property_count');
        }
    }

    public function _insertion_in_count_tables($city, $location, $property)
    {       // insertion in count tables
//        if (isset($property->agency_id)) {
//            if (DB::table('property_count_by_agencies')->where('agency_id', '=', $property->agency_id)->exists())
//                DB::table('property_count_by_agencies')->where('agency_id', '=', $property->agency_id)->increment('property_count');
//            else {
//                $listing_type = '';
//                if ($property->basic_listing)
//                    $listing_type = 'basic_listing';
//                elseif ($property->silver_listing)
//                    $listing_type = 'silver_listing';
//                elseif ($property->bronze_listing)
//                    $listing_type = 'bronze_listing';
//                elseif ($property->golden_listing)
//                    $listing_type = 'golden_listing';
//                elseif ($property->platinum_listing)
//                    $listing_type = 'platinum_listing';
//
//                DB::table('property_count_by_agencies')->insert(['agency_id' => $property->agency_id,
//                    'property_count' => 1, 'property_purpose' => $property->purpose, 'property_status' => $property->status, 'listing_type' => $listing_type]);
//            }
//
//        }

        if (DB::table('property_count_by_cities')->where('city_id', '=', $city->id)->exists())
            DB::table('property_count_by_cities')->where('city_id', '=', $city->id)->increment('property_count');
        else
            DB::table('property_count_by_cities')->insert(['city_id' => $city->id, 'city_name' => $city->name, 'property_count' => 1]);

        if (DB::table('property_count_by_locations')->where('city_id', '=', $city->id)->where('location_id', '=', $location['location_id'])->exists())
            DB::table('property_count_by_locations')->where('city_id', '=', $city->id)->where('location_id', '=', $location['location_id'])->increment('property_count');
        else
            DB::table('property_count_by_locations')->insert(['city_id' => $city->id, 'city_name' => $city->name, 'location_id' => $location['location_id'], 'location_name' => $location['location_name'], 'property_count' => 1]);


        if (DB::table('property_count_by_property_types')->where('city_id', '=', $city->id)->where('location_id', '=', $location['location_id'])->where('property_type', '=', $property->type)->where('property_sub_type', '=', $property->sub_type)->exists())
            DB::table('property_count_by_property_types')->where('city_id', '=', $city->id)->where('location_id', '=', $location['location_id'])->where('property_type', '=', $property->type)->where('property_sub_type', '=', $property->sub_type)->increment('property_count');
        else
            DB::table('property_count_by_property_types')->insert(['city_id' => $city->id, 'city_name' => $city->name, 'location_id' => $location['location_id'], 'location_name' => $location['location_name'], 'property_type' => $property->type, 'property_sub_type' => $property->sub_type, 'property_count' => 1]);


        if (DB::table('property_count_by_property_purposes')->where('city_id', '=', $city->id)->where('location_id', '=', $location['location_id'])->
        where('property_type', '=', $property->type)->where('property_sub_type', '=', $property->sub_type)->where('property_purpose', '=', $property->purpose)->exists())
            DB::table('property_count_by_property_purposes')->where('city_id', '=', $city->id)->where('location_id', '=', $location['location_id'])->
            where('property_type', '=', $property->type)->where('property_sub_type', '=', $property->sub_type)->where('property_purpose', '=', $property->purpose)->
            increment('property_count');
        else
            DB::table('property_count_by_property_purposes')->insert(['city_id' => $city->id, 'city_name' => $city->name, 'location_id' => $location['location_id'], 'location_name' => $location['location_name'], 'property_type' => $property->type, 'property_sub_type' => $property->sub_type, 'property_purpose' => $property->purpose, 'property_count' => 1]);

        $this->updateTotalPropertyCount();
    }

    public function _on_deletion_insertion_in_count_tables($city, $location, $property)
    {

        // insertion in count tables
//        DB::table('property_count_by_agencies')->where('agency_id', '=', $property->agency_id)->decrement('property_count');

        DB::table('property_count_by_cities')->where('city_id', '=', $city->id)->decrement('property_count');
        DB::table('property_count_by_locations')->where('city_id', '=', $city->id)->where('location_id', '=', $location['location_id'])->decrement('property_count');
        DB::table('property_count_by_property_types')->where('city_id', '=', $city->id)->where('location_id', '=', $location['location_id'])->
        where('property_type', '=', $property->type)->where('property_sub_type', '=', $property->sub_type)->decrement('property_count');
        DB::table('property_count_by_property_purposes')->where('city_id', '=', $city->id)->where('location_id', '=', $location['location_id'])->
        where('property_type', '=', $property->type)->where('property_sub_type', '=', $property->sub_type)->where('property_purpose', '=', $property->purpose)->
        decrement('property_count');
        $this->updateTotalPropertyCount();
    }

    public function updateTotalPropertyCount()
    {
        $property_count = DB::table('properties')->where('status', '=', 'active')->count();
        $agency_count = DB::table('agencies')->where('status', '=', 'verified')->count();
        $sale_count = (new \App\Models\Property())->where('purpose', '=', 'Sale')->where('status', '=', 'active')->count();
        $rent_count = (new \App\Models\Property())->where('purpose', '=', 'Rent')->where('status', '=', 'active')->count();
//        $cities_count = DB::table('cities')->count();

        DB::table('total_property_count')->update(['property_count' => $property_count, 'sale_property_count' => $sale_count, 'rent_property_count' => $rent_count, 'agency_count' => $agency_count]);

    }

    public function getCitiesCount()
    {
        $cities_count = DB::table('property_count_by_cities')
            ->select('property_count AS count', 'city_name AS city')->orderBy('property_count', 'DESC')->limit(10)->get();
        return $cities_count;
    }

    public function getAllCities(string $type, string $purpose)
    {
        $cities = '';
        $result_type = '';
        $result_purpose = '';
        if ($type == 1 && $purpose == 1) {
            $result_type = 'Houses & Flats';
            $result_purpose = 'Sale';
            $houses = DB::table('property_count_by_property_purposes')
                ->select(DB::raw('SUM(property_count) AS property_count'), 'city_id', 'city_name', 'property_purpose', 'property_type', 'property_sub_type')
                ->where([
                    ['property_purpose', '=', 'sale'],
                    ['property_type', '=', 'Homes'],
                    ['property_sub_type', '=', 'House'],
                ])
                ->orderBy('property_count', 'DESC')
                ->groupBy('city_id', 'city_name', 'property_purpose', 'property_type', 'property_sub_type')
                ->get();
            $flats = DB::table('property_count_by_property_purposes')
                ->select(DB::raw('SUM(property_count) AS property_count'), 'city_id', 'city_name', 'property_purpose', 'property_type', 'property_sub_type')
                ->where([
                    ['property_purpose', '=', 'sale'],
                    ['property_type', '=', 'Homes'],
                    ['property_sub_type', '=', 'Flat'],
                ])
                ->orderBy('property_count', 'DESC')
                ->groupBy('city_id', 'city_name', 'property_purpose', 'property_type', 'property_sub_type')
                ->get();
            $cities = ['houses' => $houses, 'flats' => $flats];
        } else if ($type == 1 && $purpose == 2) {
            $result_type = 'Plots';
            $result_purpose = 'Sale';
            $plots = DB::table('property_count_by_property_purposes')
                ->select(DB::raw('SUM(property_count) AS property_count'), 'city_id', 'city_name', 'property_purpose', 'property_type')
                ->where('property_type', '=', 'Plots')
                ->where('property_purpose', '=', 'sale')
                ->orderBy('property_count', 'DESC')
                ->groupBy('city_id', 'city_name', 'property_purpose', 'property_type')->get();
            $cities = ['plots' => $plots];
        } else if ($type == 1 && $purpose == 3) {
            $result_type = 'Commercial';
            $result_purpose = 'Sale';
            $commercial = DB::table('property_count_by_property_purposes')
                ->select(DB::raw('SUM(property_count) AS property_count'), 'city_id', 'city_name', 'property_purpose', 'property_type')
                ->where('property_type', '=', 'commercial')
                ->where('property_purpose', '=', 'sale')
                ->orderBy('property_count', 'DESC')
                ->groupBy('city_id', 'city_name', 'property_purpose', 'property_type')->get();

            $cities = ['commercial' => $commercial];
        } else if ($type == 2 && $purpose == 1) {
            $result_type = 'Property';
            $result_purpose = 'Rent';


            $rent = DB::table('property_count_by_property_purposes')
                ->select(DB::raw('SUM(property_count) AS property_count'), 'city_id', 'city_name', 'property_purpose', 'property_type')
                ->where('property_purpose', '=', 'rent')
                ->orderBy('property_count', 'DESC')
                ->groupBy('city_id', 'city_name', 'property_purpose', 'property_type')->get();
            $cities = ['property' => $rent];
        } else
            abort(404);

        (new MetaTagController())->addMetaTags();
        $footer_content = (new FooterController)->footerContent();

        $data = [
            'type' => $result_type,
            'purpose' => $result_purpose,
            'cities' => $cities,
            'recent_properties' => $footer_content[0],
            'footer_agencies' => $footer_content[1]
        ];
        return view('website.pages.all_cities_listing_wrt_property', $data);
    }

    public function getCitywisePropertyCount(string $type, Request $request)
    {

        (new MetaTagController())->addMetaTags();
        if ($request->ajax()) {
            if ($request->sort === 'sort-alpha') {
                $properties = DB::table('property_count_by_property_purposes')
                    ->select(DB::raw('SUM(property_count) AS property_count'), 'city_id', 'city_name', 'property_purpose', 'property_type')
                    ->where([
                        ['property_purpose', '=', 'sale'],
                        ['property_type', '=', $type],
                    ])
                    ->orderBy('city_name')
                    ->groupBy('city_id', 'city_name', 'property_purpose', 'property_type')
                    ->get();
                $sort = 'checked';
            } else if ($request->sort === 'unsort-alpha') {
                $properties = DB::table('property_count_by_property_purposes')
                    ->select(DB::raw('SUM(property_count) AS property_count'), 'city_id', 'city_name', 'property_purpose', 'property_type')
                    ->where([
                        ['property_purpose', '=', 'sale'],
                        ['property_type', '=', $type],
                    ])
                    ->orderBy('property_count', 'DESC')
                    ->groupBy('city_id', 'city_name', 'property_purpose', 'property_type')
                    ->get();
                $sort = 'unchecked';

            }
            $data['view'] = View('website.components.property_count_by_city',
                [
                    'properties' => $properties,
                    'sort' => $sort
                ])->render();

            return $data;
        }

        $properties = DB::table('property_count_by_property_purposes')
            ->select(DB::raw('SUM(property_count) AS property_count'), 'city_id', 'city_name', 'property_purpose', 'property_type')
            ->where([
                ['property_purpose', '=', 'sale'],
                ['property_type', '=', $type],
            ])
            ->orderBy('property_count', 'DESC')
            ->groupBy('city_id', 'city_name', 'property_purpose', 'property_type')
            ->get();
        $footer_content = (new FooterController)->footerContent();
        $data = [
            'type' => $type,
            'properties' => $properties,
            'recent_properties' => $footer_content[0],
            'footer_agencies' => $footer_content[1]
        ];
        return view('website.pages.property_count_by_city', $data);

    }

    public function getLocationsCount(string $type, string $purpose, string $city)
    {
        $footer_content = (new FooterController)->footerContent();

        $city_data = City::select('id', 'name')->where('name', '=', $city)->first();
        $city_id = $city_data->id;
        $city_name = $city_data->name;
        $sub_type = '';

        if (in_array($type, ['house', 'houses', 'flat', 'flats', 'upper-portion', 'lower-portion', 'farm-house', 'room', 'penthouse'])) {
            $sub_type = $type;
            $type = 'homes';
        } elseif (in_array($type, ['residential-plot', 'commercial-plot', 'agricultural-land', 'industrial-land', 'plot-file', 'plot-form'])) {
            $sub_type = $type;
            $type = 'plots';
        } elseif (in_array($type, ['office', 'shop', 'warehouse', 'factory', 'building', 'other'])) {
            $sub_type = $type;
            $type = 'commercial';
        }
        $condition = ['city_id' => $city_id, 'property_purpose' => $purpose, 'property_type' => $type, 'property_sub_type' => $sub_type];

        $location_data['count'] = DB::table('property_count_by_property_purposes')->select('location_name', 'property_count', 'property_sub_type')->where($condition)->orderBy('property_count', 'DESC')->get();
        $location_data['purpose'] = $purpose;
        $location_data['type'] = $type;
        $location_data['city'] = $city_name;
        $location_data['sub_type'] = $sub_type;
        $data = [
            'locations_data' => $location_data,
            'recent_properties' => $footer_content[0],
            'footer_agencies' => $footer_content[1]
        ];
        return view('website.pages.all_locations_in_city', $data);
    }
}
