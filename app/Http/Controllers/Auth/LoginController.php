<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Dashboard\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use IpLocation;
use Browser;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    protected $redirectTo = RouteServiceProvider::HOME;

    public function showLoginForm()
    {
        return view('website.pages.login');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->passes()) {
            $user = User::getUserByEmail($request->input('email'));
            if (!empty($user) && $user->is_active === '0') {
                if ($request->ajax())
                    return response()->json(['error' => $validator->getMessageBag()->add('password', 'Your account has been deactivated!')]);
                else
                    throw ValidationException::withMessages([$this->username() => [trans('auth.failed')]]);
            }


            if (auth()->guard('web')->attempt(array('email' => $request->input('email'),
                'password' => $request->input('password')), $request->remember)) {
                $user = [
                    'name' => Auth::guard('web')->user()->name,
                    'id' => Auth::guard('web')->user()->getAuthIdentifier(),
                    'email' => Auth::guard('web')->user()->email,
                    'cell' => Auth::guard('web')->user()->cell,
                    'verified_at' => Auth::guard('web')->user()->email_verified_at,
                ];
                $this->insert_into_user_logs();
                if ($request->ajax()) {
                    return response()->json(['data' => 'success', 'user' => $user]);
                } else {
                    return redirect()->route('home');
                }

            }
            if ($request->ajax())
                return response()->json(['error' => $validator->getMessageBag()->add('password', 'Invalid email or password. Please Try again!')]);
            else
                throw ValidationException::withMessages([$this->username() => [trans('auth.failed')]]);
        }
        if ($request->ajax())
            return response()->json(['error' => $validator->errors()->all()]);
        else
            throw ValidationException::withMessages([$this->username() => [trans('auth.failed')]]);
    }

    protected function insert_into_user_logs()
    {
        $user = Auth::guard('web')->user();
        $ip = $_SERVER['REMOTE_ADDR'];
        $country = '';
        if ($ip_location = IpLocation::get($ip)) {
            $country = $ip_location->countryName;
            if($country == null)
                $country = 'unavailable';
        } else {

            $country = 'unavailable';
        }
        $id = DB::table('user_logs')->insertGetId(
            ['user_id' => $user->id, 'email' => $user->email, 'ip' => $_SERVER['REMOTE_ADDR'], 'ip_location' => $country,
        'browser' => Browser::browserName(), 'os' => Browser::platformName()]);
        Session::put('logged_user_session_id', $id);
    }

//    private function getBrowserInfo()
//    {
//        $user_agent = request()->header('User-Agent');
//        $bname = 'Unknown';
//        $platform = 'Unknown';
//
//        //First get the platform?
//        if (preg_match('/linux/i', $user_agent)) {
//            $platform = 'linux';
//        } elseif (preg_match('/macintosh|mac os x/i', $user_agent)) {
//            $platform = 'mac';
//        } elseif (preg_match('/windows|win32/i', $user_agent)) {
//            $platform = 'windows';
//        }
//
//
//        // Next get the name of the useragent yes seperately and for good reason
//        if (preg_match('/MSIE/i', $user_agent) && !preg_match('/Opera/i', $user_agent)) {
//            $bname = 'Internet Explorer';
//            $ub = "MSIE";
//        } elseif (preg_match('/Firefox/i', $user_agent)) {
//            $bname = 'Mozilla Firefox';
//            $ub = "Firefox";
//        } elseif (preg_match('/Chrome/i', $user_agent)) {
//            $bname = 'Google Chrome';
//            $ub = "Chrome";
//        } elseif (preg_match('/Safari/i', $user_agent)) {
//            $bname = 'Apple Safari';
//            $ub = "Safari";
//        } elseif (preg_match('/Opera/i', $user_agent)) {
//            $bname = 'Opera';
//            $ub = "Opera";
//        } elseif (preg_match('/Netscape/i', $user_agent)) {
//            $bname = 'Netscape';
//            $ub = "Netscape";
//        }
//
//        return ['browser' => $bname, 'os' => $platform];
//    }

    /**
     * The user has logged out of the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    /**
     * Log the user out of the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        if (Session::get('logged_user_session_id') !== null) {
            DB::table('user_logs')
                ->where('id', Session::get('logged_user_session_id'))
                ->update(['logout_at' => date('Y-m-d H:i:s')]);
        }
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }

}
