<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertyCountByUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('property_count_by_user')->truncate();
        $statuses = ['active', 'edited', 'pending', 'expired', 'deleted', 'rejected', 'sold'];
        $purposes = ['sale', 'rent', 'wanted'];
        foreach ($statuses as $status) {
            foreach ($purposes as $purpose) {
                $data1 = DB::table('properties')
                    ->select('properties.agency_id', 'properties.user_id',
                        DB::raw('COUNT(properties.id) AS count'))
                    ->join('agencies', 'properties.agency_id', '=', 'agencies.id')
                    ->where('properties.status', '=', $status)
                    ->where('properties.purpose', '=', $purpose)
                    ->where('properties.basic_listing', '=', 1)
                    ->where('properties.deleted_at', '=', null)
                    ->groupBy('properties.agency_id', 'properties.user_id')
                    ->get()->toArray();
                foreach ($data1 as $value) {
                    if ($value->count > 0) {
                        DB::table('property_count_by_user')->insert([
                            'user_id' => $value->user_id,
                            'agency_id' => $value->agency_id,
                            'agency_count' => $value->count,
                            'property_purpose' => $purpose,
                            'property_status' => $status,
                            'listing_type' => 'basic_listing',
                        ]);
                    }
                    echo $value->agency_id . ', ';
                }


                $data2 = DB::table('properties')
                    ->select('properties.user_id',
                        DB::raw('COUNT(properties.id) AS count'))
                    ->where('properties.status', '=', $status)
                    ->where('properties.purpose', '=', $purpose)
                    ->where('properties.basic_listing', '=', 1)
                    ->where('properties.agency_id', '=', null)
                    ->where('properties.deleted_at', '=', null)

                    ->groupBy( 'properties.user_id')
                    ->get()->toArray();
                foreach ($data2 as $value) {
                    if ($value->count > 0) {
                        DB::table('property_count_by_user')->updateOrInsert([
                            'user_id' => $value->user_id,
                            'property_purpose' => $purpose,
                            'property_status' => $status,
                            'agency_id' => null,
                            'listing_type' => 'basic_listing',
                        ], [
                            'user_id' => $value->user_id,
                            'individual_count' => $value->count,
                            'property_purpose' => $purpose,
                            'property_status' => $status,
                            'listing_type' => 'basic_listing',
                        ]);
                    }
                    echo $value->user_id . ', ';
                }
            }
        }
    }
}
