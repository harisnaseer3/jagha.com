<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GoogleApiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('google_key')->insert([
            'key' => 'AIzaSyCJ96oM2l7xI5zap1OZFdUtncEY92fKAF8',

        ]);
    }
}
