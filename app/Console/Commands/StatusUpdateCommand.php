<?php

namespace App\Console\Commands;

use App\Http\Controllers\CountTableController;
use App\Models\Dashboard\City;
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
            $column->status = 'expired';
            $column->save();

//            $city = (new City)->select('id', 'name')->where('id', '=', $column->city_id)->first();
//            $location = (new City)->select('id', 'name')->where('id', '=', $column->location_id)->first();

//            (new CountTableController())->_on_deletion_insertion_in_count_tables($city, $location, $column);
        }
        echo("status updated");
    }
}
