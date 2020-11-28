<?php

namespace App\Http\Controllers\AdminAuth;


use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;


class AuthController extends Controller
{
    use ThrottlesLogins;


    protected $redirectTo = '/';


    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin', ['except' => 'adminLogout']);
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return User
     */
    public function create(array $data)
    {
        return Admin::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);
    }


    public function adminLogin()
    {
        if(Auth::guard('web')->check())
        {
            Auth::guard('web')->logout();

        }

        return view('website.admin-pages.admin-login');
    }


    public function adminLoginPost(Request $request)
    {

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if(Auth::guard('web')->check())
        {
            Auth::guard('web')->logout();

        }
         $admin = Admin::getAdminByEmail($request->input('email'));
          if(!empty($admin) && $admin->is_active === '0')
          {
              return back()->with('error', 'Your account has been deactivated');
          }

        if (auth()->guard('admin')->attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {

            $user = auth()->guard('admin')->user();

            return redirect()->route('admin.dashboard');
        }
        else {
            return back()->with('error', 'Your username and password are wrong.');
        }
    }

    public function adminLogout(Request $request)
    {
        Auth::guard('admin')->logout();
        if ($request->ajax()) {
            return response()->json(['data' => 'success']);
        }
        return redirect()->route('admin.login');
    }
}
