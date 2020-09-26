<?php

namespace App\Http\Controllers\Admin;


use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AdminAuth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;


class UserManagementController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    protected function validator(array $data, $id, $model)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => 'required|string|email|unique:' . $model . ',email,' . $id,
        ]);
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
    public function registration(Request $request)
    {
        $input = $request->input();
        $register = new AuthController();
         $admin = $register->create($input);
            $admin->assignRole($input['role']);
        return redirect()->route('admin.manage-users');
    }
    public function editAdmin($id)
    {
        $current_admin = Admin::getAdminById($id);
        $admin_role = '';
        if (count($current_admin->roles) > 0) {
            $admin_role = $current_admin->roles[0]->name;
        }
        $roles = Role::all();
        if (empty($current_admin)) {
            Flash::error(__('messages.not_found', ['model' => __('admin')]));
            return redirect()->route('admin.manage-users');
        }
        return view('website.admin-pages.edit-admin', [
            'admin' => $current_admin,
            'admin_role' => $admin_role,
            'roles' => $roles
        ]);
    }
    public function updateAdmin($id, Request $request)
    {
        $this->validator($request->all(), $id, 'admins')->validate();
        $current_admin = Admin::getAdminById($id);
        if (empty($current_admin)) {
            return redirect()->route('admin.manage-users');
        }
        $input = $request->all();
        $current_admin = Admin::updateAdmin($input, $id);
        return redirect()->route('admin.manage-users');
    }


}
