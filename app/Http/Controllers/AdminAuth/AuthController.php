<?php

namespace App\Http\Controllers\AdminAuth;


use App\Http\Controllers\CountryController;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Browser;
use IpLocation;

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
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();

        }

        return view('website.admin-pages.admin-login');
    }


    public function adminLoginPost(Request $request)
    {
        try {
            // Validate the request data
            $this->validate($request, [
                'email' => 'required|email',
                'password' => 'required',
            ]);

            // Logout if a user is already logged in
            if (Auth::guard('web')->check()) {
                Auth::guard('web')->logout();
            }

            // Retrieve admin by email
            $admin = Admin::getAdminByEmail($request->input('email'));

            // Check if the admin account is deactivated
            if (!empty($admin) && $admin->is_active === '0') {
                return back()->with('error', 'Your account has been deactivated');
            }

            // Attempt to authenticate the admin
            if (auth()->guard('admin')->attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
                $user = auth()->guard('admin')->user();
                $ip = $_SERVER['REMOTE_ADDR'];
                $country = '';

                // Get the IP location
                if ($ip_location = '206.84.164.188') {
                    $country = $ip_location->countryName ?? (new CountryController())->Country_name();
                } else {
                    $country = 'unavailable';
                }
                // Log the admin session
                $id = DB::table('admin_session_logs')->insertGetId([
                    'admin_id' => $user->id,
                    'email' => $user->email,
                    'ip' => $ip,
                    'ip_location' => $country,
                    'browser' => Browser::browserName(),
                    'os' => Browser::platformName(),
                ]);

                Session::put('logged_admin_session_id', $id);
                return redirect()->route('admin.dashboard');
            } else {
                return back()->with('error', 'Your username and password are incorrect.');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            // Log the exception for debugging
            \Log::error('Admin login error: ' . $e->getMessage());

            // Return a generic error message to the user
            return back()->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }

    public function adminLogout(Request $request)
    {
        if (Session::get('logged_admin_session_id') !== null) {
            DB::table('admin_session_logs')
                ->where('id', Session::get('logged_admin_session_id'))
                ->update(['logout_at' => date('Y-m-d H:i:s')]);
        }
        Auth::guard('admin')->logout();

        if ($request->ajax()) {
            return response()->json(['data' => 'success']);
        }
        return redirect()->route('admin.login');
    }
}
