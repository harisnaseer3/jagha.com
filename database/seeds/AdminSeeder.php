<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $admin_id = DB::table('admins')->insertGetId([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'is_super' => '1',
            'password' => Hash::make('password')
        ]);
        $current_admin = Admin::find($admin_id);
        $current_admin->assignRole('Super Admin');
    }
}
