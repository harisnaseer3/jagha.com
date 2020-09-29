<?php

namespace App\Http\Controllers\Admin;


use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AdminAuth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;


class RoleManagementController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    public function index()
    {
        $admin = new Admin();
        $roles = Role::orderByDesc('id')->get();
        return view('website.admin-pages.manage-roles-permissions', [
            'roles' => $roles,
            'admin' => $admin,
        ]);
    }

}
