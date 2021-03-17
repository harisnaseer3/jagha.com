<?php

namespace App\Jobs;

use App\Models\AgencyLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateDBTables implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $agency;
    protected $user;
    protected $admin_id;
    protected $admin_name;

    public function __construct($agency, $user, $admin_id, $admin_name)
    {
        $this->agency = $agency;
        $this->user = $user;
        $this->admin_id = $admin_id;
        $this->admin_name = $admin_name;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DB::table('agencies')
            ->where('id', '=', $this->agency->id)
            ->update(
                ['user_id' => $this->user->id]
            );
        DB::table('agency_users')
            ->where('agency_id', '=', $this->agency->id)
            ->update(
                ['user_id' => $this->user->id]
            );
        DB::table('properties')
            ->where('agency_id', '=', $this->agency->id)
            ->update(
                ['user_id' => $this->user->id,
                    'contact_person' => $this->user->name,
                    'email' => $this->user->email,
                ]
            );
        DB::table('property_count_by_user')
            ->updateOrInsert(
                ['agency_id' => $this->agency->id],
                ['user_id' => $this->user->id]
            );
        $sale_active_count = DB::table('property_count_by_user')->select('agency_count')
            ->where('user_id', '=', $this->user->id)
            ->where('agency_id', '=', $this->agency->id)
            ->where('property_purpose', '=', 'sale')
            ->where('property_status', '=', 'active')->first();


        $rent_active_count = DB::table('property_count_by_user')->select('agency_count')
            ->where('user_id', '=', $this->user->id)
            ->where('agency_id', '=', $this->agency->id)
            ->where('property_purpose', '=', 'rent')
            ->where('property_status', '=', 'active')->first();
        if ($sale_active_count) {

            $sale_active_count = $sale_active_count->agency_count;

            DB::table('property_count_by_status_and_purposes')->select('property_count')
                ->where('user_id', '=', 1)
                ->where('property_purpose', '=', 'sale')
                ->where('property_status', '=', 'active')
                ->where('listing_type', '=', 'basic_listing')
                ->where('property_count', '>=', $sale_active_count)
                ->decrement('property_count', $sale_active_count);

            DB::table('property_count_by_status_and_purposes')
                ->where('user_id', '=', $this->user->id)
                ->where('property_purpose', '=', 'sale')
                ->where('property_status', '=', 'active')
                ->where('listing_type', '=', 'basic_listing')
                ->increment('property_count', $sale_active_count);
        }
        if ($rent_active_count) {
            $rent_active_count = $rent_active_count->agency_count;
            DB::table('property_count_by_status_and_purposes')
                ->where('user_id', '=', 1)
                ->where('property_purpose', '=', 'rent')
                ->where('property_status', '=', 'active')
                ->where('listing_type', '=', 'basic_listing')
                ->where('property_count', '>=', $rent_active_count)
                ->decrement('property_count', $rent_active_count);

            DB::table('property_count_by_status_and_purposes')
                ->where('user_id', '=', $this->user->id)
                ->where('property_purpose', '=', 'rent')
                ->where('property_status', '=', 'active')
                ->where('listing_type', '=', 'basic_listing')
                ->increment('property_count', $rent_active_count);
        }

        (new AgencyLog)->create([
            'admin_id' => $this->admin_id,
            'admin_name' => $this->admin_name,
            'agency_id' => $this->agency->id,
            'agency_title' => $this->agency->title,
            'status' => 'Add Agency Owner',
            'rejection_reason' => $this->agency->rejection_reason,
        ]);
    }
}
