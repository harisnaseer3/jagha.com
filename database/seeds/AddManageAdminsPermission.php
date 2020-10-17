<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use App\Models\Admin;

class AddManageAdminsPermission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Permission::create(['guard_name' => 'admin', 'name' => 'Manage Admins']);
        $role = Role::create(['guard_name' => 'admin', 'name' => 'Admins Administrator']);
        $super_role = Role::findByName('Super Admin','admin');
        $super_role->givePermissionTo(['Manage Admins']);
        $role->givePermissionTo(['Manage Admins']);


    }
}
