<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Creating roles
        $role1 = Role::create(['guard_name' => 'admin', 'name' => 'Property Manager']);
        $role2 = Role::create(['guard_name' => 'admin', 'name' => 'Agency Manager']);

        // Creating SuperAdmin role and allotting all permissions
        $super_role = Role::create(['guard_name' => 'admin', 'name' => 'Super Admin']);


    }
}
