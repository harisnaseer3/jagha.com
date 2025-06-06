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
        DB::table('property_count_by_agencies')->truncate();

        $statuses = ['active', 'edited', 'pending', 'expired', 'deleted', 'rejected', 'sold'];
        $purposes = ['sale', 'rent', 'wanted'];
        foreach ($statuses as $status) {
//            foreach ($purposes as $purpose) {
                $data = DB::table('properties')
                    ->select('properties.agency_id',
                        DB::raw('COUNT(properties.id) AS count'))
                    ->join('agencies', 'properties.agency_id', '=', 'agencies.id')
                    ->where('properties.status', '=', $status)
                    ->where('properties.basic_listing', '=', 1)
                    ->groupBy('properties.agency_id')
                    ->get()->toArray();
                foreach ($data as $value) {
                    if ($value->count > 0) {
                        DB::table('property_count_by_agencies')->insert([
                            'agency_id' => $value->agency_id,
                            'property_count' => $value->count,
                            'property_status' => $status,
                            'listing_type' => 'basic_listing',
                        ]);
                    }
                    echo $value->agency_id . ', ';
                }
            }
//        }
    }
}

