<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertyCountByAgencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = DB::table('properties')
            ->select( 'properties.agency_id',
                DB::raw('COUNT(properties.id) AS count'))
            ->join('agencies', 'properties.agency_id', '=', 'agencies.id')
            ->where('properties.status', '=', 'active')
            ->groupBy('agency_id')
            ->get();

        foreach ($types as $type) {
            DB::table('property_count_by_agencies')->insert([
                'agency_id' => $type->agency_id,
                'property_count' => $type->count,
            ]);
        }
    }
}
