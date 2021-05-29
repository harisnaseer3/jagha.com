<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackagePriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = ['Gold', 'Diamond', 'Titanium'];
        $for = ['properties', 'agency'];
        foreach ($types as $index => $type) {
            foreach ($for as $index2 => $f) {
                (new App\Models\PackagePrice)->insert([
                    'type' => $type,
                    'package_for' => $f,
                    'price_per_unit' => 10 * ($index + 1),
                ]);
            }
        }
    }
}
