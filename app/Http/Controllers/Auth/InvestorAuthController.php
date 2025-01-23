<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AdminAuth\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CountTableController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\MetaTagController;
use App\Http\Requests\Auth\InvestorLoginRequest;
use App\Http\Requests\Auth\InvestorRegisterRequest;
use App\Models\Dashboard\City;
use App\Models\Dashboard\User;
use App\Models\PropertyType;
use App\Models\UserInvite;
use App\Models\Visit;
use App\Notifications\RegisterNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use IpLocation;
use Browser;

class InvestorAuthController extends Controller
{
    public function index()
    {
        (new MetaTagController())->addMetaTags();

        (new Visit)->hit();

        $property_types = (new PropertyType)->all();

        // property count table
        $total_count = DB::table('total_property_count')->select('property_count', 'sale_property_count', 'rent_property_count', 'agency_count', 'city_count')->first();
        $footer_content = (new FooterController)->footerContent();

        $data = [
            'total_count' => $total_count,
            'cities_count' => (new CountTableController())->getCitiesCount(),
            'property_types' => $property_types,
            'localBusiness' => (new MetaTagController())->addScriptJsonldTag(),
            'recent_properties' => $footer_content[0],
            'footer_agencies' => $footer_content[1],
        ];

        return view('website.pages.investor.investor_landing', $data);
    }

    public function getCities()
    {
        $cities = City::all();
        return view('website.layouts.investor-sign-in-modal', compact('cities'));
    }

    public function register(InvestorRegisterRequest $request)
    {
        $role = 'Investor';
        try {
            DB::beginTransaction();

            // Fetch the city name based on city_id
            $city = DB::table('cities')->where('id', $request->city_id)->first();
            if (!$city) {
                return redirect()->route('investor')->with('error', 'Invalid city selected.');
            }

            // Create the user
            $user = DB::table('users')->insertGetId([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'cnic' => $request->cnic,
                'city_name' => $city->name,
                'city_id' => $city->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Fetch the newly created user
            $createdUser = User::find($user);

            // Assign the role to the user
            $createdUser->assignRole($role);

            // Handle invitations
            DB::table('user_invites')->updateOrInsert(
                ['email' => $request->email],
                ['created_at' => now()]
            );

            // Send notification
            $new_user = UserInvite::where('email', $request->email)->first();
            Notification::send($new_user, new RegisterNotification($role));

            // Log the user in
            Auth::login($createdUser);

            DB::commit();
            return redirect()->route('investor')->with('success', 'Investor registered and invitation sent successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error during registration: ' . $e->getMessage());

            return redirect()->route('investor')->with('error', 'An error occurred. Please try again.');
        }
    }

    public function setPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:8',
        ]);

        // Assuming you have a session or other method to track the user being created
        $user = User::where('email', session('investor_email'))->firstOrFail();
        $user->update([
            'password' => bcrypt($request->password),
        ]);

        // Log the user in
        Auth::login($user);

        return redirect()->route('investor')->with('success', 'Account created successfully!');
    }

    public function investorLogin(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();

        // Check if the user exists
        if (!$user || !$user->hasRole('Investor')) {
            if ($request->ajax()) {
                return response()->json(['error' => ['Invalid email or you do not have access as an investor.']]);
            }
            return back()->withErrors(['email' => 'Invalid email or you do not have access as an investor.']);
        }

        // Check if the user is active
        if ($user->is_active === '0') {
            if ($request->ajax()) {
                return response()->json(['error' => ['Your account has been deactivated!']]);
            }
            return back()->withErrors(['email' => 'Your account has been deactivated!']);
        }

        // Attempt login
        if (auth()->guard('web')->attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ], $request->remember)) {
            $loggedInUser = auth()->guard('web')->user();

            // Insert into user logs
            $this->insert_into_user_logs();

            if ($request->ajax()) {
                return response()->json(['data' => 'success', 'user' => [
                    'name' => $loggedInUser->name,
                    'id' => $loggedInUser->id,
                    'email' => $loggedInUser->email,
                    'cell' => $loggedInUser->cell,
                    'verified_at' => $loggedInUser->email_verified_at,
                ]]);
            }
            return redirect()->route('investor');
        }

        // Invalid credentials
        if ($request->ajax()) {
            return response()->json(['error' => ['Invalid email or password. Please try again!']]);
        }
        return back()->withErrors(['password' => 'Invalid email or password. Please try again!']);
    }

    protected function insert_into_user_logs()
    {
        $user = Auth::guard('web')->user();
        $ip = $_SERVER['REMOTE_ADDR'];
        $country = '';
        $city = '';
        if ($ip_location = IpLocation::get($ip)) {
            $country = $ip_location->countryName;
            $city = $ip_location->cityName;
            if ($country == null)
                $country = (new CountryController())->Country_name();
            if ($city == '')
                $city = (new CountryController())->city_name();
        } else {
            $country = 'unavailable';
            $city = 'unavailable';
        }

        $id = DB::table('user_logs')->insertGetId(
            ['user_id' => $user->id, 'email' => $user->email, 'ip' => $_SERVER['REMOTE_ADDR'], 'ip_location' => $country, 'city' => $city,
                'browser' => Browser::browserName(), 'os' => Browser::platformName()]);
        Session::put('logged_user_session_id', $id);
    }

}
