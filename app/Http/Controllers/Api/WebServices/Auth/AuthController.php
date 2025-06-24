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
use App\Models\Dashboard\City;

class AuthController extends BaseController
{
    public function register(UserRegisterRequest $request)
    {
        try {
            DB::beginTransaction();

            // Validate city exists
            $city = City::find($request->city_id);
            if (!$city) {
                return $this->sendError('Invalid city ID provided.', [], 422);
            }

            // Create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'cell' => $request->cell,
                'city_id' => $city->id,
                'city_name' => $city->name,
                'is_active' => 1
            ]);

            // Insert into temp_users table
            DB::table('temp_users')->insert([
                'user_id' => $user->id,
                'expire_at' => now()->addHour()->toDateTimeString(),
            ]);

            // Create access token
            $token = $user->createToken('Properties')->accessToken;

            // Send email verification
            $user->sendApiEmailVerificationNotification();

            DB::commit();

            // Return flat user data with token
            $data = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'cell' => $user->cell,
                'city_id' => $user->city_id,
                'city_name' => $user->city_name,
                'is_active' => $user->is_active,
                'token' => $token,
            ];

            return $this->sendResponse($data, "User Registered Successfully");
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError('Registration failed.', $e->getMessage(), 500);
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

    public function getAllCities()
    {
        try {
            $cities = City::all();

            return $this->sendResponse($cities, 'Cities fetched successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Failed to fetch cities.', $e->getMessage(), 500);
        }
    }

    public function deleteAccount(User $user)
    {
        try {
            DB::beginTransaction();

            // Optionally check if the authenticated user is authorized
            if (auth()->id() !== $user->id) {
                return $this->sendError('Unauthorized action.', [], 403);
            }

            // $user->properties()->delete();   //property belongs to many users so property should not deleted
            $user->agencies()->delete();
            $user->delete();

            DB::commit();
            return $this->sendResponse([], 'Account and associated properties deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError('Failed to delete account.', $e->getMessage(), 500);
        }
    }

    public function activateOrDeactivateAccount($id)
    {
        try {
            $user = User::findOrFail($id);

            // Optionally ensure the authenticated user is updating their own account
            if (auth()->id() !== $user->id) {
                return $this->sendError('Unauthorized action.', [], 403);
            }

            // Toggle status
            $user->is_active = $user->is_active === '1' ? '0' : '1';
            $user->save();

            $status = $user->is_active === '1' ? 'activated' : 'deactivated';

            return $this->sendResponse(['is_active' => $user->is_active], "User account has been {$status} successfully.");
        } catch (\Exception $e) {
            return $this->sendError('Failed to update account status.', $e->getMessage(), 500);
        }
    }

    public function showProfile()
    {
        try {
            $user = auth()->guard('api')->user();

            if (!$user) {
                return $this->sendError('Unauthorized.', [], 401);
            }

            // Eager load properties with related models if needed
//            $user->load('property');
            $user->load(['property.images', 'property.videos', 'property.floor_plans']);

            return $this->sendResponse($user, 'User profile fetched successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong while fetching profile.', $e->getMessage(), 500);
        }
    }


}
