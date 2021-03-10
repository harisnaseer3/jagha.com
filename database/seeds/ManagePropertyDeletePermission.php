<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ManagePropertyDeletePermission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['guard_name' => 'admin', 'name' => 'Delete Properties']);
        $role = Role::create(['guard_name' => 'admin', 'name' => 'Delete Properties']);

        $role->givePermissionTo(['Delete Properties']);

        $super_role = Role::findByName('Super Admin','admin');

        $super_role->givePermissionTo(['Delete Properties']);
    }
}
