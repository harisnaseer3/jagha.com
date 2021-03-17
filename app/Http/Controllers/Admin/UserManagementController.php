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
use mysql_xdevapi\Table;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Notification;


class UserManagementController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    protected function validator($data)
    {
        return Validator::make($data, [
            'email' => 'bail|required|email',
            'role.*' => 'required',
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
//        $reg_users = User::getAllUsers();
//        $users = DB::table('user_logs')->orderBy('id','desc')->get()->all();
//        return view('website.admin-pages.manage-users', [
//            'register_users' => $reg_users,
//            'users' => $users,
//        ]
//        );
        return view('website.admin-pages.manage-users');
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
        $request->validate([
            'email' => 'bail|required|email',
            'role.*' => 'required',
        ]);
        $input = $request->input();
        $roles = $input['role'];
        $current_user = User::findUserByEmail($input['email']);

        if (!empty($current_user)) {
            $input['name'] = $current_user->name;
            $input['password'] = $current_user->password;
            $input['remember_token'] = $current_user->remember_token;
            $register = new AuthController();
            $admin = $register->create($input);
            $admin->assignRole($roles);


            return redirect()->route('admin.manage-admins')->with('success', 'Admin created successfully.');
        } else {
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
        $admin_roles = [];
        if (count($current_admin->roles) > 0) {
            foreach ($current_admin->roles as $role) {
                array_push($admin_roles, $role->name);
            }

        }
        $roles = Role::all();
        if (empty($current_admin)) {
            return redirect()->route('admin.manage-admins')->with('error', 'Something went wrong. Admin not found');
        }
        return view('website.admin-pages.edit-admin', [
            'admin' => $current_admin,
            'admin_roles' => $admin_roles,
            'roles' => $roles
        ]);
    }

    public function updateAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), Admin::$rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'Error storing record, try again.');
        }
        $current_admin = Admin::getAdminById($request->id);
        if (empty($current_admin)) {
            return redirect()->back()->with('error', 'Something went wrong. Admin not found');
        }
        $input = $request->all();
        $current_admin = Admin::updateAdmin($input);
        return redirect()->route('admin.manage-admins')->with('success', 'Admin roles updated successfully.');
    }

    public function adminDestroy($admin)
    {
        $current_admin = Admin::getAdminById($admin);
        if (empty($current_admin)) {
//            Flash::error(__('messages.not_found', ['model' => __('admin')]));
            return redirect()->route('admin.manage-admins')->with('error', 'Something went wrong. Admin not found');
        }
        $admin_status = Admin::destroy($current_admin->id);
        if ($admin_status === '1') {
            return redirect()->route('admin.manage-admins')->with('success', 'Admin activated successfully.');
        } elseif ($admin_status === '0') {
            return redirect()->route('admin.manage-admins')->with('success', 'Admin deactived successfully.');

        }
    }

    public function userDestroy($user)
    {
        $current_user = User::getUserById($user);
        if (empty($current_user)) {
            return redirect()->route('admin.manage-users')->with('error', 'Something went wrong. User not found');
        }
        $user_status = User::destroyUser($current_user->id);
        if ($user_status === '1') {
            return redirect()->route('admin.manage-users')->with('success', 'User activated successfully.');
        } elseif ($user_status === '0') {
            return redirect()->route('admin.manage-users')->with('success', 'User deactived successfully.');

        }
    }

    function getUserLogs()
    {
        $data['view'] = View('website.admin-pages.components.user-logs',
            ['users' => DB::table('user_logs')->orderBy('id', 'desc')->get()->all()
            ])->render();
        return $data;
    }

    function getRegisteredUser()
    {
        $data['view'] = View('website.admin-pages.components.registered-user',
            ['register_users' => User::getAllUsers()
            ])->render();
        return $data;
    }


}
