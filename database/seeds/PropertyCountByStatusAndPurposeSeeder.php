<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertyCountByStatusAndPurposeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $purposes = ['Sale', 'Rent', 'Wanted'];
        $statuses = ['active', 'edited', 'pending', 'expired', 'deleted', 'rejected'];
        $listing_types = ['basic_listing', 'silver_listing', 'bronze_listing', 'golden_listing', 'platinum_listing'];
        foreach ($purposes as $purpose) {
            foreach ($statuses as $status) {
                foreach ($listing_types as $listing_type) {
                    if ($status == 'active') {
                        $data = DB::table('properties')
                            ->select(DB::raw('COUNT(properties.id) AS count'))
                            ->where('properties.status', '=', $status)
                            ->where('properties.purpose', '=', $purpose)
                            ->where('user_id', '=', 1)
                            ->where($listing_type, '=', 1)
                            ->get();
                        DB::table('property_count_by_status_and_purposes')->insert([
                            'user_id' => 1,
                            'listing_type' => $listing_type,
                            'property_purpose' => $purpose,
                            'property_status' => $status,
                            'property_count' => $data[0]->count,
                        ]);
                    }
                    else if($listing_type == 'basic_listing'){
                        $data = DB::table('properties')
                            ->select(DB::raw('COUNT(properties.id) AS count'))
                            ->where('properties.status', '=', $status)
                            ->where('properties.purpose', '=', $purpose)
                            ->where('user_id', '=', 1)
                            ->where('basic_listing', '=', 1)
                            ->get();
                        DB::table('property_count_by_status_and_purposes')->insert([
                            'user_id' => 1,
                            'listing_type' => 'basic_listing',
                            'property_purpose' => $purpose,
                            'property_status' => $status,
                            'property_count' => $data[0]->count,
                        ]);
                    }
                    else

                        continue;
                }
            }
        }
    }
}
