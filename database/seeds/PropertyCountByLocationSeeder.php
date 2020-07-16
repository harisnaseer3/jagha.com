<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertyCountByLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('property_count_by_locations')->truncate();
        $locations =  DB::table('properties')
            ->select('properties.city_id', 'properties.location_id', 'cities.name AS city_name','locations.name AS location_name',
                DB::raw('COUNT(properties.id) AS count'))
            ->join('cities', 'properties.city_id', '=', 'cities.id')
            ->join('locations', 'properties.location_id', '=', 'locations.id')
            ->where('properties.status', '=', 'active')
            ->groupBy('properties.city_id','properties.location_id')
            ->get();
        foreach ($locations as $location) {
            DB::table('property_count_by_locations')->insert([
                'city_id' => $location->city_id,
                'city_name' => $location->city_name,
                'location_id' => $location->location_id,
                'location_name' => $location->location_name,
                'property_count' => $location->count,
            ]);
        }
    }
}
