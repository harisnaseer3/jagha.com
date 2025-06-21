<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
            'password' => Hash::make('hV1uQ9aV6nY4tG7')
        ]);
        $current_admin = Admin::find($admin_id);
        $current_admin->assignRole('Super Admin');
    }
}
