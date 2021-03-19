<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use App\Models\Admin;

class AddManagePackagePermission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $role = Role::create(['guard_name' => 'admin', 'name' => 'Package Administrator']);
        $super_role = Role::findByName('Super Admin','admin');
        $super_role->givePermissionTo(['Manage Packages']);
        $role->givePermissionTo(['Manage Packages']);
    }
}
