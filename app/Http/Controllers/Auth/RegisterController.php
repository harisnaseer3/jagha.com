<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AgencyController;
use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Providers\RouteServiceProvider;
use App\Models\Dashboard\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    public function showRegistrationForm()
    {
        return view('website.pages.register');
    }

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';
//    protected function redirectTo()
//    {
//        $userName = Auth::user()->getAuthIdentifier();
//        //use your own route
//        return route('user.dashboard');
//    }


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/'],
            'mobile' => ['required'], // +92-3001234567
//            'mobile' => ['required','regex:/\+92-3\d{2}\d{7}/'], // +92-3001234567
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\Models\Dashboard\User
     */
    protected function create(array $data)
    {
        $dt = Carbon::now();

        $expiry = $dt->addHour()->toDateTimeString();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'cell' => $data['mobile']
        ]);
        DB::table('temp_users')->insert(['user_id' => $user->id, 'expire_at' => $expiry]);

        return $user;
    }
}
