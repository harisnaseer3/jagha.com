<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class PropertyLog implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $property;
    protected $admin_name;
    protected $admin_id;

    public function __construct($property, $admin_name, $admin_id)
    {
        $this->property = $property;
        $this->admin_name = $admin_name;
        $this->admin_id = $admin_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $property = $this->property;
        $admin_name = $this->admin_name;
        $admin_id = $this->admin_id;
        (new \App\Models\PropertyLog)->create([
            'admin_id' => $admin_id,
            'admin_name' => $admin_name,
            'property_id' => $property->id,
            'property_title' => $property->title,
            'status' => $property->status,
            'rejection_reason' => $property->rejection_reason,
        ]);
    }
}
