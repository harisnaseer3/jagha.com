<?php

use App\Models\Dashboard\User;
use App\Models\Property;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FavoriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Property = Property::all()->pluck('id')->toArray();
        $user = User::all()->pluck('id')->toArray();

        for ($x = 0; $x < 10; $x++) {
            DB::table('favorites')->insert([
                'user_id' => $user[array_rand($user, 1)],
                'property_id' => $Property[array_rand($Property, 1)],

                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
