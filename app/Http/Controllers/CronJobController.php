<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\TempImage;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
            $column->status = 'expired';
            $column->save();
        }
        return true;
    }

    private function HourlyUpdate()
    {
        TempImage::where('expiry_time', '<=', Carbon::now()->toDateTimeString())->forceDelete();
        return true;
    }
}
