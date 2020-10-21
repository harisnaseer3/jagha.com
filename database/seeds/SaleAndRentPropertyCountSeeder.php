<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SaleAndRentPropertyCountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $total_count = (new \App\Models\Property())->where('status', '=', 'active')->count();
        $sale_count = (new \App\Models\Property())->where('purpose', '=', 'Sale')->where('status', '=', 'active')->count();
        $rent_count = (new \App\Models\Property())->where('purpose', '=', 'Rent')->where('status', '=', 'active')->count();
        $city = (new \App\Models\Dashboard\City())->where('is_active', '=', '1')->count();
        $agency = (new \App\Models\Agency())->where('status', '=', 'verified')->count();

        DB::table('total_property_count')->where('id', '=', 1)->update([
            'property_count' => $total_count,
            'rent_property_count' => $rent_count,
            'sale_property_count' => $sale_count,
            'agency_count' => $agency,
            'city_count' => $city,
        ]);
    }
}
