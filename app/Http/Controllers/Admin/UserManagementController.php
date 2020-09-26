<?php

namespace App\Http\Controllers\Admin;


use App\Models\Admin;
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

        $admins = Admin::getAllAdmins();
        return view('website.admin-pages.manage-users', [
            'admins' => $admins,
        ]);
    }
    public function showAdminRegisterForm()
    {
        $roles = \Spatie\Permission\Models\Role::all();
        return view('website.admin-pages.register', [
            'roles' => $roles
        ]);
    }


}
