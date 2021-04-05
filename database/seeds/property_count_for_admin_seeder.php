<?php

use Illuminate\Database\Seeder;

class property_count_for_admin_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('property_count_for_admin')->truncate();

        $purposes = ['Sale', 'Rent', 'Wanted'];
        $statuses = ['active', 'edited', 'pending', 'expired', 'deleted', 'rejected','sold'];
        foreach ($purposes as $purpose) {
            foreach ($statuses as $status) {
                $data = DB::table('properties')
                    ->select(DB::raw('COUNT(properties.id) AS count'))
                    ->where('properties.status', '=', $status)
                    ->where('properties.purpose', '=', $purpose)
                    ->get();
                print('count=> ' . $data[0]->count . ', status => . ' . $status . ', purpose => ' . $purpose);
                DB::table('property_count_for_admin')->insert([
                    'property_purpose' => $purpose,
                    'property_status' => $status,
                    'property_count' => $data[0]->count,
                ]);
            }
        }
    }
}
