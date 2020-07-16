<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgencyUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $agencies = \App\Models\Agency::all();

        foreach ($agencies as $agency) {
            DB::table('agency_users')->insert([
                'user_id' => $agency->user_id,
                'agency_id' => $agency->id,
            ]);
        }
    }
}
