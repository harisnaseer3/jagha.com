<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class InsertInStatusPurposeTable implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $property;

    public function __construct($property)
    {
        $this->property = $property;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $property = $this->property;
        if (DB::table('property_count_for_admin')->where('property_status', '=', $property->status)
            ->where('property_purpose', '=', $property->purpose)->exists()) {
            DB::table('property_count_for_admin')->where('property_status', '=', $property->status)
                ->where('property_purpose', '=', $property->purpose)->increment('property_count');
        } else {
            DB::table('property_count_for_admin')->insert(['property_status' => $property->status, 'property_purpose' => $property->purpose, 'property_count' => 1]);
        }
        if (isset($property->agency_id)) {
            if (DB::table('property_count_by_user')->where('property_status', '=', $property->status)
                ->where('property_purpose', '=', $property->purpose)
                ->where('user_id', '=', $property->user_id)
                ->where('agency_id', '=', $property->agency_id)
                ->where('listing_type', '=', 'basic_listing')->exists())
                DB::table('property_count_by_user')
                    ->where('property_status', '=', $property->status)
                    ->where('property_purpose', '=', $property->purpose)
                    ->where('user_id', '=', $property->user_id)
                    ->where('agency_id', '=', $property->agency_id)
                    ->where('listing_type', '=', 'basic_listing')
                    ->increment('agency_count');
            else
                DB::table('property_count_by_user')->insert(['property_status' => $property->status, 'property_purpose' => $property->purpose,
                    'agency_id' => $property->agency_id, 'user_id' => $property->user_id, 'listing_type' => 'basic_listing', 'agency_count' => 1]);

            if (DB::table('property_count_by_agencies')->where('agency_id', '=', $property->agency_id)
                ->where('property_status', '=', $property->status)->exists()) {
                DB::table('property_count_by_agencies')->where('agency_id', '=', $property->agency_id)
                    ->where('property_status', '=', $property->status)->increment('property_count');

            } else {
                DB::table('property_count_by_agencies')->insert(
                    ['agency_id' => $property->agency_id, 'property_status' => $property->status,
                        'listing_type' => 'basic_listing', 'property_count' => 1]);
            }

        } else if ($property->agency_id == null) {
            if (DB::table('property_count_by_user')
                ->where('property_status', '=', $property->status)
                ->where('property_purpose', '=', $property->purpose)
                ->where('agency_id', '=', null)
                ->where('user_id', '=', $property->user_id)
                ->where('listing_type', '=', 'basic_listing')->exists())
                DB::table('property_count_by_user')
                    ->where('property_status', '=', $property->status)
                    ->where('property_purpose', '=', $property->purpose)
                    ->where('user_id', '=', $property->user_id)
                    ->where('agency_id', '=', null)
                    ->where('listing_type', '=', 'basic_listing')
                    ->increment('individual_count');
            else
                DB::table('property_count_by_user')->insert([
                    'property_status' => $property->status,
                    'property_purpose' => $property->purpose,
                    'agency_id' => null, 'user_id' => $property->user_id,
                    'listing_type' => 'basic_listing', 'individual_count' => 1]);

        }
    }
}
