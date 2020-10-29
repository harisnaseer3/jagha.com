<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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
            if (auth()->attempt(array('email' => $request->input('email'),
                'password' => $request->input('password')), $request->remember)) {
                $user = [
                    'name' => Auth::guard('web')->user()->name,
                    'id' => Auth::guard('web')->user()->getAuthIdentifier(),
                    'email' => Auth::guard('web')->user()->email
                ];
                if ($request->ajax()) {
                    session()->forget('fav-key');
                    session()->put('fav-key', $user['id']);
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

//    public function logout(Request $request)
//    {
//        $this->guard()->logout();
//
//        $request->session()->invalidate();
//        $request->session()->regenerateToken();
//
//        return response()->json(['data' => 'success']);
//    }

//    protected function loggedOut(Request $request)
//    {
//        return response()->json(['data' => 'success']);
//
//    }

}
