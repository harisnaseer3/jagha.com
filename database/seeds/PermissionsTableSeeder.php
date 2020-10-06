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

        //Creating Permissions


        Permission::create(['guard_name' => 'admin', 'name' => 'Manage Dashboard']);
        Permission::create(['guard_name' => 'admin', 'name' => 'Manage Users']);
        Permission::create(['guard_name' => 'admin', 'name' => 'Manage Roles and Permissions']);
        Permission::create(['guard_name' => 'admin', 'name' => 'Manage Property']);
        Permission::create(['guard_name' => 'admin', 'name' => 'Manage Agency']);
        Permission::create(['guard_name' => 'admin', 'name' => 'Manage Packages']);
//        Permission::create(['guard_name' => 'admin', 'name' => 'Manage Active Properties']);
//        Permission::create(['guard_name' => 'admin', 'name' => 'Manage Edited Properties']);
//        Permission::create(['guard_name' => 'admin', 'name' => 'Manage Pending Properties']);
//        Permission::create(['guard_name' => 'admin', 'name' => 'Manage Expired Properties']);
//        Permission::create(['guard_name' => 'admin', 'name' => 'Manage Deleted Properties']);
//        Permission::create(['guard_name' => 'admin', 'name' => 'Manage Rejected Properties']);
//        Permission::create(['guard_name' => 'admin', 'name' => 'Manage Sold Properties']);
//        Permission::create(['guard_name' => 'admin', 'name' => 'Edit Property']);
//        Permission::create(['guard_name' => 'admin', 'name' => 'Delete Property']);
//        Permission::create(['guard_name' => 'admin', 'name' => 'Update Property Status']);
//        Permission::create(['guard_name' => 'admin', 'name' => 'Manage Verified Agencies']);
//        Permission::create(['guard_name' => 'admin', 'name' => 'Manage Pending Agencies']);
//        Permission::create(['guard_name' => 'admin', 'name' => 'Manage Expired Agencies']);
//        Permission::create(['guard_name' => 'admin', 'name' => 'Manage Rejected Agencies']);
//        Permission::create(['guard_name' => 'admin', 'name' => 'Manage Deleted Agencies']);
//        Permission::create(['guard_name' => 'admin', 'name' => 'Add New Agency']);
//        Permission::create(['guard_name' => 'admin', 'name' => 'Add Agency Users']);
//        Permission::create(['guard_name' => 'admin', 'name' => 'Edit Agency']);
//        Permission::create(['guard_name' => 'admin', 'name' => 'Delete Agency']);
//        Permission::create(['guard_name' => 'admin', 'name' => 'Update Agency Status']);
//        Permission::create(['guard_name' => 'admin', 'name' => 'Add Admin']);
//        Permission::create(['guard_name' => 'admin', 'name' => 'Activate/Deactivate Admin']);



        // Creating roles
        $role1 = Role::create(['guard_name' => 'admin', 'name' => 'Property Manager']);
        $role2 = Role::create(['guard_name' => 'admin', 'name' => 'Agency Manager']);
        $role3 = Role::create(['guard_name' => 'admin', 'name' => 'Users Administrator']);

        // Creating SuperAdmin role and allotting all permissions
        $super_role = Role::create(['guard_name' => 'admin', 'name' => 'Super Admin']);
        $super_role->givePermissionTo(Permission::all());

        $role1->givePermissionTo(['Manage Dashboard','Manage Property']);
        $role2->givePermissionTo(['Manage Dashboard','Manage Agency']);
        $role3->givePermissionTo(['Manage Dashboard','Manage Users','Manage Roles and Permissions']);


    }
}
