<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $property_types = [
            'Homes' => ['House', 'Flat', 'Upper Portion', 'Lower Portion', 'Farm House', 'Room', 'Penthouse'],
            'Plots' => ['Residential Plot', 'Commercial Plot', 'Agricultural Land', 'Industrial Land', 'Plot File', 'Plot Form'],
            'Commercial' => ['Office', 'Shop', 'Warehouse', 'Factory', 'Building', 'Other']
        ];

        foreach ($property_types as $key => $value) {
            DB::table('property_types')->insert([
                'user_id' => '1',
                'name' => $key,
                'sub_types' => json_encode($value),
                'is_active' => '1',
            ]);
        }
    }
}
