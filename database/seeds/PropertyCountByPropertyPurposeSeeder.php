<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertyCountByPropertyPurposeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = DB::table('properties')
            ->select('properties.type', 'properties.purpose', 'properties.sub_type', 'properties.city_id', 'properties.location_id', 'cities.name AS city_name', 'locations.name AS location_name',
                DB::raw('COUNT(properties.id) AS count'))
            ->join('cities', 'properties.city_id', '=', 'cities.id')
            ->join('locations', 'properties.location_id', '=', 'locations.id')
            ->where('properties.status', '=', 'active')
            ->groupBy('properties.city_id', 'properties.location_id', 'properties.type', 'properties.sub_type', 'properties.purpose')
            ->get();

        foreach ($types as $type) {
            DB::table('property_count_by_property_purposes')->insert([
                'city_id' => $type->city_id,
                'city_name' => $type->city_name,
                'location_id' => $type->location_id,
                'location_name' => $type->location_name,
                'property_type' => $type->type,
                'property_sub_type' => $type->sub_type,
                'property_purpose' => $type->purpose,
                'property_count' => $type->count,
            ]);
        }

    }
}
