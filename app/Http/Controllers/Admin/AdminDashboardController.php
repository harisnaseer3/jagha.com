<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\PropertyLogController;
use App\Models\AgencyLog;
use App\Models\PropertyLog;
use App\Models\Visit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;


class AdminDashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $admin = Auth::guard('admin')->user();
        $admin_logs = DB::table('admin_session_logs')->orderBy('id','desc')->get()->all();
        $visit_logs = DB::table('visits')->orderBy('id','desc')->get()->all();

        return view('website.admin-pages.admin-dashboard', [
            'admin' => $admin,
            'property_log' => PropertyLog::orderBy('id','desc')->get(),
            'agency_log' => AgencyLog::orderBy('id','desc')->get(),
            'user_visit_log' => $visit_logs,
            'admin_log' => $admin_logs
        ]);
    }

    public function getUserCount(Request $request)
    {
        if ($request->ajax()) {
            $total_count = array();
            $date = array();
            $unique_count = array();
            $unique_result = Visit::select(DB::raw('Count(count) AS user_count'))->whereMonth('created_at', date('m'))->orderBy('date')->groupBy('date')->get()->toArray();
            $result = Visit::select(DB::raw('SUM(count) AS user_count'), 'date')->whereMonth('created_at', date('m'))->orderBy('date')->groupBy('date')->get()->toArray();

            foreach ($result as $data) {
                $total_count[] = $data['user_count'];
                $date[] = $data['date'];
            }
            foreach ($unique_result as $value) {
                $unique_count[] = $value['user_count'];
            }
            return response()->json(['data' => ['total_count' => $total_count, 'unique_count' => $unique_count, 'date' => $date], 'status' => 200]);
        } else {
            return 'Not Found';
        }

    }
}
