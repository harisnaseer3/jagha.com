<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dashboard\City;
use App\Models\Dashboard\Location;
use App\Models\Dashboard\User;
use App\Models\Property;
use App\Models\TempImage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CronJobController extends Controller
{
    function executeTasks(Request $request)
    {
        if ($request->ajax()) {
            if ($this->updatePropertyStatus() && $this->HourlyUpdate()) {
                return response()->json(['data' => 'success', 'status' => 200]);
            } else {
                return response()->json(['data' => 'Error!', 'status' => 200]);
            }

        } else {
            return 'Not Found';
        }

    }

    private function updatePropertyStatus()
    {
        //add  query to compare today's and expiry date of property
        $columns = (new Property)->whereDate('expired_at', '<=', Carbon::now()->toDateTimeString())->get();
        foreach ($columns as $column) {
            (new CountTableController())->_delete_in_status_purpose_table($column, $column->status);
            $city = (new City)->select('id', 'name')->where('id', '=', $column->city_id)->first();
            $location_obj = (new Location)->select('id', 'name')->where('id', '=', $column->location_id)->first();
            $location = ['location_id' => $location_obj->id, 'location_name' => $location_obj->name];


            $column->status = 'expired';
            $column->save();
            (new CountTableController())->_on_deletion_insertion_in_count_tables($city, $location, $column);
            (new CountTableController)->_insert_in_status_purpose_table($column);
        }
        return true;
    }

    private function HourlyUpdate()
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
        return true;
    }
}
