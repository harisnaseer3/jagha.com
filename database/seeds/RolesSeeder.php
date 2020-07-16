<?php

use Illuminate\Database\Seeder;
use App\Models\Dashboard\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        (new Role)->truncate();

        (new Role)->create(['name' => 'Admin']);

        (new Role)->create(['name' => 'Owner/Investor']);
        (new Role)->create(['name' => 'Tenant']);
        (new Role)->create(['name' => 'Agent/Broker']);
        (new Role)->create(['name' => 'Appraiser']);
        (new Role)->create(['name' => 'Architect']);
        (new Role)->create(['name' => 'Builder']);
        (new Role)->create(['name' => 'Corporate Investor']);
        (new Role)->create(['name' => 'Developer']);
        (new Role)->create(['name' => 'Listing Administrator']);
        (new Role)->create(['name' => 'Mortgage Broker']);
        (new Role)->create(['name' => 'Partner']);
        (new Role)->create(['name' => 'Property/Asset Manager']);
        (new Role)->create(['name' => 'Researcher']);
    }
}
