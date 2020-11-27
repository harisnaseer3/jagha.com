<?php

namespace App\Console\Commands;

use App\Models\TempImage;
use Carbon\Carbon;
use Illuminate\Console\Command;

class HourlyUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hour:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove images from temp_images table after an hour';

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
        TempImage::where('expiry_time', '<=', Carbon::now()->toDateTimeString())->forceDelete();
        echo("Hourly update completed successfully");
    }
}
