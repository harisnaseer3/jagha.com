<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class AddPropertyInPackageListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        $property_id = $event->property_id;
        $package = $event->package;
        $property = DB::table('properties')->where('id', '=', $property_id)->first();
        if ($package->type == 'Gold') {

            DB::table('properties')
                ->where('id', $property->id)
                ->update([
                    'golden_listing' => 1
                ]);

            if (DB::table('property_count_by_listings')
                ->where('property_purpose', $property->purpose)
                ->where('listing_type', 'golden_listing')
                ->where('property_count', '>', 0)->exists()) {
                DB::table('property_count_by_listings')
                    ->where('property_purpose', $property->purpose)
                    ->where('listing_type', 'golden_listing')
                    ->where('property_count', '>', 0)
                    ->increment('property_count', 1);
            } else {
                DB::table('property_count_by_listings')
                    ->where('property_purpose', $property->purpose)
                    ->where('listing_type', 'golden_listing')
                    ->insert(['property_count' => 1]);
            }


        } elseif ($package->type == 'Silver') {
            DB::table('properties')
                ->where('id', $property->id)
                ->update([
                    'silver_listing' => 1
                ]);
            if (DB::table('property_count_by_listings')
                ->where('property_purpose', $property->purpose)
                ->where('listing_type', 'silver_listing')
                ->where('property_count', '>', 0)
                ->exists()) {
                DB::table('property_count_by_listings')
                    ->where('property_purpose', $property->purpose)
                    ->where('listing_type', 'silver_listing')
                    ->where('property_count', '>', 0)
                    ->increment('property_count', 1);
            } else {
                DB::table('property_count_by_listings')
                    ->where('property_purpose', $property->purpose)
                    ->where('listing_type', 'silver_listing')
                    ->insert(['property_count' => 1]);
            }

        }
    }
}
