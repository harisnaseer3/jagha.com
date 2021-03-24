<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class InsertInCountTables implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $city, $location, $property;

    public function __construct($city, $location, $property)
    {
        $this->city = $city;
        $this->location = $location;
        $this->property = $property;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $city = $this->city;
        $location = $this->location;
        $property = $this->property;
        if (DB::table('property_count_by_cities')->where('city_id', '=', $city->id)->exists())
            DB::table('property_count_by_cities')->where('city_id', '=', $city->id)->increment('property_count');
        else
            DB::table('property_count_by_cities')->insert(['city_id' => $city->id, 'city_name' => $city->name, 'property_count' => 1]);

        if (DB::table('property_count_by_locations')->where('city_id', '=', $city->id)->where('location_id', '=', $location->id)->exists())
            DB::table('property_count_by_locations')->where('city_id', '=', $city->id)->where('location_id', '=', $location->id)->increment('property_count');
        else
            DB::table('property_count_by_locations')->insert(['city_id' => $city->id, 'city_name' => $city->name, 'location_id' => $location->id, 'location_name' => $location->name, 'property_count' => 1]);


        if (DB::table('property_count_by_property_types')->where('city_id', '=', $city->id)->where('location_id', '=', $location->id)->where('property_type', '=', $property->type)->where('property_sub_type', '=', $property->sub_type)->exists())
            DB::table('property_count_by_property_types')->where('city_id', '=', $city->id)->where('location_id', '=', $location->id)->where('property_type', '=', $property->type)->where('property_sub_type', '=', $property->sub_type)->increment('property_count');
        else
            DB::table('property_count_by_property_types')->insert(['city_id' => $city->id, 'city_name' => $city->name, 'location_id' => $location->id, 'location_name' => $location->name, 'property_type' => $property->type, 'property_sub_type' => $property->sub_type, 'property_count' => 1]);


        if (DB::table('property_count_by_property_purposes')->where('city_id', '=', $city->id)->where('location_id', '=', $location->id)->
        where('property_type', '=', $property->type)->where('property_sub_type', '=', $property->sub_type)->where('property_purpose', '=', $property->purpose)->exists())
            DB::table('property_count_by_property_purposes')->where('city_id', '=', $city->id)->where('location_id', '=', $location->id)->
            where('property_type', '=', $property->type)->where('property_sub_type', '=', $property->sub_type)->where('property_purpose', '=', $property->purpose)->
            increment('property_count');
        else
            DB::table('property_count_by_property_purposes')->insert(['city_id' => $city->id, 'city_name' => $city->name, 'location_id' => $location->id, 'location_name' => $location->name, 'property_type' => $property->type, 'property_sub_type' => $property->sub_type, 'property_purpose' => $property->purpose, 'property_count' => 1]);


        $property_count = DB::table('properties')->where('status', '=', 'active')->count();
        $agency_count = DB::table('agencies')->where('status', '=', 'verified')->count();
        $sale_count = (new \App\Models\Property())->where('purpose', '=', 'Sale')->where('status', '=', 'active')->count();
        $rent_count = (new \App\Models\Property())->where('purpose', '=', 'Rent')->where('status', '=', 'active')->count();
//        $cities_count = DB::table('cities')->count();

        DB::table('total_property_count')->update(['property_count' => $property_count, 'sale_property_count' => $sale_count, 'rent_property_count' => $rent_count, 'agency_count' => $agency_count]);

    }
}
