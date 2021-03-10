<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ManageAgencyDeletePermission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['guard_name' => 'admin', 'name' => 'Delete Agencies']);
        $role = Role::create(['guard_name' => 'admin', 'name' => 'Delete Agencies']);

        $role->givePermissionTo(['Delete Agencies']);

        $super_role = Role::findByName('Super Admin','admin');

        $super_role->givePermissionTo(['Delete Agencies']);
    }
}
