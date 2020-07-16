<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $facilities_list = [
            'has_powder_room' => 'fas fa-restroom',
            'has_parking_place' => 'fas fa-garage-car',
            'has_double_glazed_window' => 'fas fa-window-frame-open',
            'has_flooring' => 'fas fa-transporter-empty',
            'has_false_ceiling' => 'fas fa-home-alt',
            'has_electricity_backup' => 'far fa-plug',
            'has_furnished' => 'far fa-couch',
            'has_wifi' => 'far fa-wifi',
            'has_cable' => 'far fa-tv-music',
            'has_saunna' => 'far fa-heat',
            'has_jacuzzi' => 'far fa-hot-tub',
            'has_maintenance_staff' => 'far fa-tools',
            'has_security_staff' => 'far fa-user-tie',
            'has_public_transport' => 'far fa-car-bus',
            'has_servant_quarter' => 'far fa-archway',
            'has_waste_disposal' => 'far fa-trash',
            'has_lobby' => 'far fa-door-open',
            'has_elevator' => 'far fa-sort-circle-up',
            'has_laundry_room' => 'far fa-washer',
            'has_conference_room' => 'far fa-users',
            'has_pet_policy' => 'far fa-paw',
            'has_atm_machine' => 'far fa-calculator'
        ];

        foreach ($facilities_list as $key => $value) {
            DB::table('facilities')->insert([
                'name' => $key,
                'icon' => $value,
                'is_active' => '1',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
