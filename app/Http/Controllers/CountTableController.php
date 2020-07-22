<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class CountTableController extends Controller
{
//    fetch data for index page
    public function popularLocations()
    {
        $popular_cities_houses_on_sale = DB::table('property_count_by_property_purposes')
            ->select(DB::raw('SUM(property_count) AS property_count'), 'city_id', 'city_name', 'property_purpose', 'property_type', 'property_sub_type')
            ->where('property_type', '=', 'Homes')
            ->where('property_sub_type', '=', 'House')
            ->orWhere('property_sub_type', '=', 'Flat')
            ->where('property_purpose', '=', 'sale')
            ->groupBy('city_id', 'city_name', 'property_purpose', 'property_type', 'property_sub_type')->limit(10)->get();

        $popular_cities_plots_on_sale = DB::table('property_count_by_property_purposes')
            ->select(DB::raw('SUM(property_count) AS property_count'), 'city_id', 'city_name', 'property_purpose', 'property_type')
            ->where('property_type', '=', 'Plots')
            ->where('property_purpose', '=', 'sale')->groupBy('city_id', 'city_name', 'property_purpose', 'property_type')
            ->limit(10)->get();

        $popular_cities_commercial_on_sale = DB::table('property_count_by_property_purposes')
            ->select(DB::raw('SUM(property_count) AS property_count'), 'city_id', 'city_name', 'property_purpose', 'property_type', 'property_sub_type')
            ->where('property_type', '=', 'commercial')
            ->where('property_purpose', '=', 'sale')
            ->groupBy('city_id', 'city_name', 'property_purpose', 'property_type', 'property_sub_type')->limit(10)->get();

        $popular_cities_property_on_rent = DB::table('property_count_by_property_purposes')
            ->select(DB::raw('SUM(property_count) AS property_count'), 'city_id', 'city_name', 'property_purpose', 'property_type', 'property_sub_type')
            ->where('property_purpose', '=', 'rent')
            ->groupBy('city_id', 'city_name', 'property_purpose', 'property_type', 'property_sub_type')->limit(10)->get();


        $lahore_homes = DB::table('property_count_by_property_purposes')
            ->select(DB::raw('SUM(property_count) AS property_count'), 'city_id', 'city_name', 'property_purpose', 'property_type', 'location_id', 'location_name')
            ->where('property_type', '=', 'Homes')
            ->where('property_purpose', '=', 'sale')
            ->where('city_name', '=', 'lahore')->groupBy('city_id', 'city_name', 'property_purpose', 'property_type', 'location_id', 'location_name')
            ->limit(6)->get();

        $lahore_plots = DB::table('property_count_by_property_purposes')
            ->select(DB::raw('SUM(property_count) AS property_count'), 'city_id', 'city_name', 'property_purpose', 'property_type', 'location_id', 'location_name')
            ->where('property_type', '=', 'Plots')
            ->where('property_purpose', '=', 'sale')
            ->where('city_name', '=', 'lahore')->groupBy('city_id', 'city_name', 'property_purpose', 'property_type', 'location_id', 'location_name')
            ->limit(6)->get();

        $karachi_homes = DB::table('property_count_by_property_purposes')
            ->select(DB::raw('SUM(property_count) AS property_count'), 'city_id', 'city_name', 'property_purpose', 'property_type', 'location_id', 'location_name')
            ->where('property_type', '=', 'Homes')
            ->where('property_purpose', '=', 'sale')
            ->where('city_name', '=', 'karachi')->groupBy('city_id', 'city_name', 'property_purpose', 'property_type', 'location_id', 'location_name')
            ->limit(6)->get();

        $peshawar_plots = DB::table('property_count_by_property_purposes')
            ->select(DB::raw('SUM(property_count) AS property_count'), 'city_id', 'city_name', 'property_purpose', 'property_type', 'location_id', 'location_name')
            ->where('property_type', '=', 'Plots')
            ->where('property_purpose', '=', 'sale')
            ->where('city_name', '=', 'peshawar')->groupBy('city_id', 'city_name', 'property_purpose', 'property_type', 'location_id', 'location_name')
            ->limit(6)->get();

        $peshawar_homes = DB::table('property_count_by_property_purposes')
            ->select(DB::raw('SUM(property_count) AS property_count'), 'city_id', 'city_name', 'property_purpose', 'property_type', 'location_id', 'location_name')
            ->where('property_type', '=', 'Homes')
            ->where('property_purpose', '=', 'sale')
            ->where('city_name', '=', 'peshawar')->groupBy('city_id', 'city_name', 'property_purpose', 'property_type', 'location_id', 'location_name')
            ->limit(6)->get();

        $karachi_plots = DB::table('property_count_by_property_purposes')
            ->select(DB::raw('SUM(property_count) AS property_count'), 'city_id', 'city_name', 'property_purpose', 'property_type', 'location_id', 'location_name')
            ->where('property_type', '=', 'Plots')
            ->where('property_purpose', '=', 'sale')
            ->where('city_name', '=', 'karachi')->groupBy('city_id', 'city_name', 'property_purpose', 'property_type', 'location_id', 'location_name')
            ->limit(6)->get();

        $isb_homes = DB::table('property_count_by_property_purposes')
            ->select(DB::raw('SUM(property_count) AS property_count'), 'city_id', 'city_name', 'property_purpose', 'property_type', 'location_id', 'location_name')
            ->where('property_type', '=', 'Homes')
            ->where('property_purpose', '=', 'sale')
            ->where('city_name', '=', 'islamabad')
            ->orWhere('city_name', '=', 'rawalpindi')->groupBy('city_id', 'city_name', 'property_purpose', 'property_type', 'location_id', 'location_name')
            ->limit(6)->get();

        $isb_plots = DB::table('property_count_by_property_purposes')
            ->select(DB::raw('SUM(property_count) AS property_count'), 'city_id', 'city_name', 'property_purpose', 'property_type', 'location_id', 'location_name')
            ->where('property_type', '=', 'plots')
            ->where('property_purpose', '=', 'sale')
            ->where('city_name', '=', 'islamabad')
            ->orWhere('city_name', '=', 'rawalpindi')->groupBy('city_id', 'city_name', 'property_purpose', 'property_type', 'location_id', 'location_name')
            ->limit(6)->get();

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
            'popular_cities_commercial_on_sale' => $popular_cities_commercial_on_sale,
            'popular_cities_property_on_rent' => $popular_cities_property_on_rent
        ];
        return $popular_locations;
    }

    public function _insertion_in_count_tables($city, $location, $property)
    {
        // insertion in count tables
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
    }

    public function _on_deletion_insertion_in_count_tables($city, $location, $property)
    {
        // insertion in count tables
        DB::table('property_count_by_cities')->where('city_id', '=', $city->id)->decrement('property_count');
        DB::table('property_count_by_locations')->where('city_id', '=', $city->id)->where('location_id', '=', $location['location_id'])->decrement('property_count');
        DB::table('property_count_by_property_types')->where('city_id', '=', $city->id)->where('location_id', '=', $location['location_id'])->
        where('property_type', '=', $property->type)->where('property_sub_type', '=', $property->sub_type)->decrement('property_count');
        DB::table('property_count_by_property_purposes')->where('city_id', '=', $city->id)->where('location_id', '=', $location['location_id'])->
        where('property_type', '=', $property->type)->where('property_sub_type', '=', $property->sub_type)->where('property_purpose', '=', $property->purpose)->
        decrement('property_count');
    }
}
