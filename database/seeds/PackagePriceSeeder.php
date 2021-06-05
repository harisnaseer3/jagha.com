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
        (new App\Models\PackagePrice)->truncate();
        $types = ['Gold', 'Platinum'];
        $for = ['properties', 'agency'];
        foreach ($types as $index => $type) {
            foreach ($for as $index2 => $f) {
                if ($f == 'agency'){
                    (new App\Models\PackagePrice)->insert([
                        'type' => $type,
                        'package_for' => $f,
                        'price_per_unit' =>$type == 'Platinum'?  2000 : 3000
                    ]);
                }
                else{
                    (new App\Models\PackagePrice)->insert([
                        'type' => $type,
                        'package_for' => $f,
                        'price_per_unit' => $type == 'Platinum'?  2000 : 1000
                    ]);
                }

            }
        }
    }
}
