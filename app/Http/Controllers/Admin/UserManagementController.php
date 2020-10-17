<?php

namespace App\Http\Controllers\Admin;


use App\Models\Admin;
use App\Models\Dashboard\User;
use App\Models\UserInvite;
use App\Notifications\registerNotification;
use App\Notifications\SendMailToJoinNotification;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AdminAuth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Notification;


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
        return view('website.admin-pages.manage-admins', [
            'admins' => $admins,
        ]);
    }
    public function getUsers()
    {
        $users = User::getAllUsers();
        return view('website.admin-pages.manage-users', [
            'users' => $users,
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
        $roles = $input['role'];
        $current_user = User::findUserByEmail($input['email']);

        if(!empty($current_user))
        {
            $input['name'] = $current_user->name;
            $input['password'] = $current_user->password;
            $input['remember_token'] = $current_user->remember_token;
            $register = new AuthController();
            $admin = $register->create($input);
            $admin->assignRole($roles);


            return redirect()->route('admin.manage-admins')->with('success', 'Admin created successfully.');
        }
        else {
            $new_email_users[] = $input['email'];
            DB::table('user_invites')
                ->updateOrInsert(
                    ['email' => $input['email']],
                    ['email' => $input['email']]
                );
            $new_user = UserInvite::where('email', '=', $input['email'])->first();
            //  send mail to new user
            Notification::send($new_user, new RegisterNotification($roles));
            return redirect()->route('admin.manage-admins')->with('success', 'Invitation to join property portal has been successfully send.');

        }

    }

    public function editAdmin($id)
    {
        $current_admin = Admin::getAdminById($id);
        $admin_role = '';
        if (count($current_admin->roles) > 0) {
            $admin_roles = $current_admin->roles;
        }
        $roles = Role::all();
        if (empty($current_admin)) {
            return redirect()->route('admin.manage-admins')->with('error', 'Something went wrong. Admin not found');
        }
        return view('website.admin-pages.edit-admin', [
            'admin' => $current_admin,
            'admin_role' => $admin_roles,
            'roles' => $roles
        ]);
    }

    public function updateAdmin($id, Request $request)
    {
        $this->validator($request->all(), $id, 'admins')->validate();
        $current_admin = Admin::getAdminById($id);
        if (empty($current_admin)) {
            return redirect()->route('admin.manage-admins')->with('error', 'Something went wrong. Admin not found');
        }
        $input = $request->all();
        $current_admin = Admin::updateAdmin($input, $id);
        return redirect()->route('admin.manage-admins')->with('success', 'Admin updated successfully.');
    }

    public function adminDestroy($admin)
    {
        $current_admin = Admin::getAdminById($admin);
        if (empty($current_admin)) {
//            Flash::error(__('messages.not_found', ['model' => __('admin')]));
            return redirect()->route('admin.manage-admins')->with('error', 'Something went wrong. Admin not found');
        }
        $admin_status = Admin::destroy($current_admin->id);
        if($admin_status === '1')
        {
            return redirect()->route('admin.manage-admins')->with('success', 'Admin activated successfully.');
        }
        elseif($admin_status === '0')
        {
            return redirect()->route('admin.manage-admins')->with('success', 'Admin deactived successfully.');

        }
    }


}
