<?php

namespace App\Http\Controllers\Api\WebServices\Auth;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Dashboard\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use App\Http\Resources\User as UserResource;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/'],
            'cell' => ['required'],
        ]);

        if ($validator->fails()) {
            return (new \App\Http\JsonResponse)->unprocessable($validator->errors()->all());
        }
        $dt = Carbon::now();

        $expiry = $dt->addHour()->toDateTimeString();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'cell' => $request->cell
        ]);
        DB::table('temp_users')->insert(['user_id' => $user->id, 'expire_at' => $expiry]);

//        $user->assignRole('customer');

        $token = $user->createToken('AboutPakistanProperties')->accessToken;

        $data = (object)[
            'user' => new UserResource($user),
            'token' => $token
        ];

        return (new \App\Http\JsonResponse)->success("User Registered Successfully", $data);
    }

    /**
     * Handles Login Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return (new \App\Http\JsonResponse)->notFound();
        }

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {

//            if(!auth()->user()->hasRole("customer")) {
//                return (new \App\Http\JsonResponse)->forbidden();
//            }

            $token = Auth::user()->createToken('AboutPakistanProperties')->accessToken;

            $data = (object)[
                'user' => new UserResource(auth()->user()),
                'token' => $token
            ];
            return (new \App\Http\JsonResponse)->success('Login Successful', $data);

        }

        return (new \App\Http\JsonResponse)->failed('Invalid Credentials');
    }

    public function forgotPassword(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return (new \App\Http\JsonResponse)->unprocessable($validator->errors()->all());
        }

        try {
            Password::sendResetLink($request->only('email'));
            return (new \App\Http\JsonResponse)->success('Reset Password Email Sent Successfully');
        } catch (\Swift_TransportException $ex) {
            return (new \App\Http\JsonResponse)->failed($ex->getMessage());
        } catch (\Exception $ex) {
            return (new \App\Http\JsonResponse)->failed($ex->getMessage());
        }
    }

    public function logout(Request $request)
    {
        auth('api')->user()->token()->revoke();
//        return (new \App\Http\JsonResponse)->success('Logout Successful');
        return response()->json([
            'message' => 'Logout Successful',
        ]);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'min:8|required',
            'new_password' => ['required', 'string', 'min:8', 'same:confirm_new_password', 'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/'],
        ]);


        if ($validator->fails()) {
            return (new \App\Http\JsonResponse)->unprocessable($validator->errors()->all());
        }

        if (!(Hash::check($request->get('current_password'), auth('api')->user()->password))) {
            return (new \App\Http\JsonResponse)->failed('Password Provided is incorrect');
        }

        auth('api')->user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        return (new \App\Http\JsonResponse)->success('Password Successfully Updated');
    }

    public function socialLogin(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'social_media_id' => 'required',
            'social_media_type' => 'required',
            'source' => 'required',
            'fcm_token' => 'required',
            'app_version' => 'required',
        ]);

        if ($validator->fails()) {
            return (new \App\Http\JsonResponse)->unprocessable($validator->errors()->all());
        }

        $user = User::updateOrCreate([
            'email' => $request->email
        ],
            [
                'name' => $request->name,
                'social_media_id' => $request->social_media_id,
                'social_media_type' => $request->social_media_type,
                'source' => $request->source,
                'fcm_token' => $request->fcm_token,
                'app_version' => $request->app_version,
                'password' => $request->has('password') ? $request->password : md5(rand(1, 10000)),
            ]);

        $token = $user->createToken('SocialMedia')->accessToken;

        $data = (object)[
            'user' => new UserResource($user),
            'token' => $token
        ];

        return (new \App\Http\JsonResponse)->success('success_social_login', $data);
    }


}
