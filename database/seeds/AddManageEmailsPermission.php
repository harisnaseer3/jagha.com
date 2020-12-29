<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use App\Models\Admin;

class AddManageEmailsPermission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Permission::create(['guard_name' => 'admin', 'name' => 'Manage Emails']);
        $role = Role::create(['guard_name' => 'admin', 'name' => 'Emails Administrator']);
        $super_role = Role::findByName('Super Admin','admin');
        $super_role->givePermissionTo(['Manage Emails']);
        $role->givePermissionTo(['Manage Emails']);


    }
}
