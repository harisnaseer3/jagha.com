<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GoogleApiLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('google_api_log')->insert([
            'api' => 'front end',
            'count' => 0
        ]);
        DB::table('google_api_log')->insert([
            'api' => 'back end',
            'count' => 0
        ]);
    }
}
