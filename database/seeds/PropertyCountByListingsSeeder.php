<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertyCountByListingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        DB::table('properties')
//            ->whereIn('agency_id', [6778, 4328, 2571])
//            ->update(['golden_listing' => 1]);
//
//        $golden_sale = DB::table('properties')->select(DB::raw('Count(id) AS count'))
//            ->where('purpose', 'sale')
//            ->where('status', 'active')
//            ->where('basic_listing', 1)
//            ->where('golden_listing', 1)
//            ->get()->pluck('count')[0];
//        $golden_rent = DB::table('properties')->select(DB::raw('Count(id) AS count'))
//            ->where('purpose', 'rent')
//            ->where('status', 'active')
//            ->where('basic_listing', 1)
//            ->where('golden_listing', 1)
//            ->get()->pluck('count')[0];
//        $basic_rent = DB::table('properties')->select(DB::raw('Count(id) AS count'))
//            ->where('purpose', 'rent')
//            ->where('status', 'active')
//            ->where('basic_listing', 1)
//            ->where('golden_listing', 0)
//            ->get()->pluck('count')[0];
//        $basic_sale = DB::table('properties')->select(DB::raw('Count(id) AS count'))
//            ->where('purpose', 'sale')
//            ->where('status', 'active')
//            ->where('basic_listing', 1)
//            ->where('golden_listing', 0)
//            ->get()->pluck('count')[0];
//
////        print($golden_sale . ', ' . $golden_rent . ', ' . $basic_sale . ', ' . $basic_rent);
//
//        DB::table('property_count_by_listings')->insert([
//            'property_purpose' => 'sale',
//            'listing_type' => 'basic_listing',
//            'property_count' => $basic_sale
//        ]);
//        DB::table('property_count_by_listings')->insert([
//            'property_purpose' => 'rent',
//            'listing_type' => 'basic_listing',
//            'property_count' => $basic_rent
//        ]);
//        DB::table('property_count_by_listings')->insert([
//            'property_purpose' => 'rent',
//            'listing_type' => 'golden_listing',
//            'property_count' => $golden_rent
//        ]);
//        DB::table('property_count_by_listings')->insert([
//            'property_purpose' => 'sale',
//            'listing_type' => 'golden_listing',
//            'property_count' => $golden_sale
//        ]);
//        DB::table('properties')
//            ->where('agency_id', 2571)
//            ->update([''
//
//            ]);

    }
}
