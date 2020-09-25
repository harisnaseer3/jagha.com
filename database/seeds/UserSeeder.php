<?php

use App\Models\Agency;
use App\Models\Dashboard\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use \App\Models\Dashboard\PropertyRole;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        factory(User::class, 1)->create();
        (new User)->truncate();
        DB::table('role_user')->truncate();

        $adminRole = (new PropertyRole)->where('name', '=', 'Admin')->first();
//        $adminRole = (new PropertyRole)->where('name', '=', 'admin')->first();
//        $propertyAgentRole = (new PropertyRole)->where('name', '=', 'property_agent')->first();
//        $genericUserRole = (new PropertyRole)->where('name', '=', 'user')->first();

        $admin = (new User)->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password')
        ]);
        $admin->roles()->attach($adminRole);

//        factory(User::class, 100)->create();
    }
}
