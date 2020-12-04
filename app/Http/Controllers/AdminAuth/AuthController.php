<?php

namespace App\Http\Controllers\AdminAuth;


use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use mysql_xdevapi\Table;


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

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();

        }
        $admin = Admin::getAdminByEmail($request->input('email'));

        if (!empty($admin) && $admin->is_active === '0') {
            return back()->with('error', 'Your account has been deactivated');
        }

        if (auth()->guard('admin')->attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {

            $user = auth()->guard('admin')->user();
            $result = $this->getBrowserInfo();

            $id = DB::table('admin_session_logs')->insertGetId(
                ['admin_id' => $user->id, 'email' => $user->email, 'ip' => $_SERVER['REMOTE_ADDR'],
                    'browser' => $result['browser'], 'os' => $result['os']]);
            Session::put('logged_admin_session_id', $id);


            return redirect()->route('admin.dashboard');
        } else {
            return back()->with('error', 'Your username and password are wrong.');
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

    private function getBrowserInfo()
    {
        $user_agent = request()->header('User-Agent');
        $bname = 'Unknown';
        $platform = 'Unknown';

        //First get the platform?
        if (preg_match('/linux/i', $user_agent)) {
            $platform = 'linux';
        } elseif (preg_match('/macintosh|mac os x/i', $user_agent)) {
            $platform = 'mac';
        } elseif (preg_match('/windows|win32/i', $user_agent)) {
            $platform = 'windows';
        }


        // Next get the name of the useragent yes seperately and for good reason
        if (preg_match('/MSIE/i', $user_agent) && !preg_match('/Opera/i', $user_agent)) {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        } elseif (preg_match('/Firefox/i', $user_agent)) {
            $bname = 'Mozilla Firefox';
            $ub = "Firefox";
        } elseif (preg_match('/Chrome/i', $user_agent)) {
            $bname = 'Google Chrome';
            $ub = "Chrome";
        } elseif (preg_match('/Safari/i', $user_agent)) {
            $bname = 'Apple Safari';
            $ub = "Safari";
        } elseif (preg_match('/Opera/i', $user_agent)) {
            $bname = 'Opera';
            $ub = "Opera";
        } elseif (preg_match('/Netscape/i', $user_agent)) {
            $bname = 'Netscape';
            $ub = "Netscape";
        }

        return ['browser' => $bname, 'os' => $platform];
    }
}
