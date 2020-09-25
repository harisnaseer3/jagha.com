<?php

use Illuminate\Database\Seeder;
use App\Models\Dashboard\PropertyRole;

class PropertyRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        (new PropertyRole)->truncate();

        (new PropertyRole)->create(['name' => 'Admin']);

        (new PropertyRole)->create(['name' => 'Owner/Investor']);
        (new PropertyRole)->create(['name' => 'Tenant']);
        (new PropertyRole)->create(['name' => 'Appraiser']);
        (new PropertyRole)->create(['name' => 'Architect']);
        (new PropertyRole)->create(['name' => 'Builder']);
        (new PropertyRole)->create(['name' => 'Corporate Investor']);
        (new PropertyRole)->create(['name' => 'Developer']);
        (new PropertyRole)->create(['name' => 'Mortgage Broker']);
        (new PropertyRole)->create(['name' => 'Partner']);
        (new PropertyRole)->create(['name' => 'Property/Asset Manager']);
        (new PropertyRole)->create(['name' => 'Researcher']);
    }
}
