<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertyCountByCitySeeder extends Seeder
{
    public function run()
    {
        $cities = DB::table('properties')
            ->select('properties.city_id', 'cities.name AS city_name', DB::raw('COUNT(properties.id) AS count'))
            ->join('cities', 'properties.city_id', '=', 'cities.id')
            ->where('properties.status', '=', 'active')
            ->groupBy('properties.city_id')
            ->orderBy('cities.id')
            ->get();
        foreach ($cities as $city) {
            DB::table('property_count_by_cities')->insert([
                'city_id' => $city->city_id,
                'city_name' => $city->city_name,
                'property_count' => $city->count,
            ]);
        }
    }
}
