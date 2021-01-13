<?php

namespace App\Console\Commands;

use App\Http\Controllers\CountTableController;
use App\Models\Dashboard\City;
use App\Models\Dashboard\Location;
use App\Models\Property;
use Carbon\Carbon;
use Illuminate\Console\Command;

class StatusUpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'status:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Every day according to expiry date update the status of property ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //add  query to compare today's and expiry date of property
        $columns = (new Property)->whereDate('expired_at', '<=', Carbon::now()->toDateTimeString())->get();
        foreach ($columns as $column) {
            (new CountTableController())->_delete_in_status_purpose_table($column, $column->status);
            $column->status = 'expired';
            $column->save();
            (new CountTableController)->_insert_in_status_purpose_table($column);
        }
        echo("status updated");
    }
}
