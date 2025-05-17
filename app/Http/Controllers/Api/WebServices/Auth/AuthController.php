<?php

namespace App\Http\Controllers\Api\WebServices\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\InvestorLoginRequest;
use App\Http\Requests\Auth\UserRegisterRequest;
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

class AuthController extends BaseController
{
    public function register(UserRegisterRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'cell' => $request->cell
            ]);

            $user = User::find($user->id);

            $expiry = now()->addHour()->toDateTimeString();
            DB::table('temp_users')->insert([
                'user_id' => $user->id,
                'expire_at' => $expiry
            ]);

            $token = $user->createToken('Properties')->accessToken;

            $data = (object)[
                'user' => new UserResource($user),
                'token' => $token
            ];

            $user->sendApiEmailVerificationNotification();

            DB::commit();
            return $this->sendResponse($data, "User Registered Successfully");
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage(), $e->getCode() ?: 500);
        }
    }


    /**
     * Handles Login Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(InvestorLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

//            if(!auth()->user()->hasRole("customer")) {
//                return (new \App\Http\JsonResponse)->forbidden();
//            }
            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('Properties')->accessToken;

            $data = (object)[
                'user' => new UserResource(auth()->user()),
                'token' => $token
            ];
            return $this->sendResponse($data, "User Login Successfully");
        }
        return $this->sendError("Invalid Credentials", 401);
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
//        if (!auth()->guard('api')->user()->hasVerifiedEmail()) {
//            return (new \App\Http\JsonResponse)->forbidden();
//        }

        try {
            Password::sendResetLink($request->only('email'));
            return $this->sendResponse([], 'Password Reset Link sent on your email.');
        } catch (\Swift_TransportException $ex) {
            return $this->sendError($ex->getMessage(), $ex->getCode());
        } catch (\Exception $ex) {
            return $this->sendError($ex->getMessage(), $ex->getCode());
        }
    }

    public function logout(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated',
            ], 401);
        }
//        if (!$user) {
//            return response()->json([
//                'header' => $request->header('Authorization'),
//                'user' => auth()->user(),
//            ]);
//        }
        $request->user()->token()->revoke();

//        If you want to log out from all devices, use:
//        $request->user()->tokens()->delete();

        return $this->sendResponse([], "User Logout Successfully");
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        if (!auth()->guard('api')->user()->hasVerifiedEmail()) {
            return (new \App\Http\JsonResponse)->forbidden();
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
