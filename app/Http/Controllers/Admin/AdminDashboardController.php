<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\PropertyLogController;
use App\Models\AgencyLog;
use App\Models\PropertyLog;
use Illuminate\Support\Facades\Auth;
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

        return view('website.admin-pages.admin-dashboard', [
            'admin' => $admin,
            'property_log' => PropertyLog::all(),
            'agency_log' => AgencyLog::all(),
        ]);
    }


}
