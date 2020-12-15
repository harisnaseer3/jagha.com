<?php

namespace App\Console\Commands;

use App\Models\Dashboard\User;
use App\Models\TempImage;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

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
    protected $description = 'Remove images and users from temp_images and temp_users tables after an hour';

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

        $data = DB::table('temp_users')->select('user_id')->where('expire_at', '<=', Carbon::now()->toDateTimeString());
        $user_delete = $data->get()->toArray();
        if (!empty($user_delete)) {
            foreach ($user_delete as $val) {
                User::where('id', $val->user_id)->where('email_verified_at', null)->forceDelete();
            }

        }
        $data->delete();
        echo("Hourly update completed successfully");
    }
}
