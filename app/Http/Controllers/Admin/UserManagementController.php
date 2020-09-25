<?php

namespace App\Http\Controllers\Admin;


use App\Admin;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class UserManagementController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        return view('website.admin-pages.admin-dashboard');
    }


}
