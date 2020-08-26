<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TotalPropertyCountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $property_count = DB::table('properties')->select(DB::raw('COUNT(id) AS property_count'))->where('status','=','active')->get();
        $agency_count = DB::table('agencies')->select(DB::raw('COUNT(id) AS agency_count'))->where('status','=','verified')->get();
        $cities_count = DB::table('cities')->select(DB::raw('COUNT(id) AS city_count'))->get();
        DB::table('total_property_count')->insert([
            'property_count' => $property_count[0]->property_count,
            'agency_count' => $agency_count[0]->agency_count,
            'city_count' => $cities_count[0]->city_count,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
