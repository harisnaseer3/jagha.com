<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CountTableController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\MetaTagController;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Dashboard\User;
use App\Models\PropertyType;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class InvestorLoginController extends Controller
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
    public function investorLogin(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();

        // Validate user role
        if (!$user || !$user->hasRole('Investor')) {
            return response()->json(['error' => ['Invalid email or you do not have access as an investor.']], 403);
        }

        // Validate user active status
        if ($user->is_active === '0') {
            return response()->json(['error' => ['Your account has been deactivated!']], 403);
        }

        // Attempt login
        if (auth()->attempt($request->only('email', 'password'), $request->remember)) {
            return response()->json(['data' => 'success']);
        }

        return response()->json(['error' => ['Invalid email or password.']], 401);
    }


//    public function investorLogin(Request $request)
//    {
//        $user = User::where('email', $request->input('email'))->first();
//
////        dd($user->hasRole('Investor'));
//        // Check if the user exists
//        if (!$user || !$user->hasRole('Investor')) {
//            if ($request->ajax()) {
//                return response()->json(['error' => ['Invalid email or you do not have access as an investor.']]);
//            }
//            return back()->withErrors(['email' => 'Invalid email or you do not have access as an investor.']);
//        }
//
//        // Check if the user is active
//        if ($user->is_active === '0') {
//            if ($request->ajax()) {
//                return response()->json(['error' => ['Your account has been deactivated!']]);
//            }
//            return back()->withErrors(['email' => 'Your account has been deactivated!']);
//        }
//
//        // Attempt login
//        if (auth()->guard('web')->attempt([
//            'email' => $request->input('email'),
//            'password' => $request->input('password')
//        ], $request->remember)) {
//            $loggedInUser = auth()->guard('web')->user();
//
//            // Insert into user logs
//            $this->insert_into_user_logs();
//
//            if ($request->ajax()) {
//                return response()->json(['data' => 'success', 'user' => [
//                    'name' => $loggedInUser->name,
//                    'id' => $loggedInUser->id,
//                    'email' => $loggedInUser->email,
//                    'cell' => $loggedInUser->cell,
//                    'verified_at' => $loggedInUser->email_verified_at,
//                ]]);
//            }
//            return redirect()->route('home');
//        }
//
//        // Invalid credentials
//        if ($request->ajax()) {
//            return response()->json(['error' => ['Invalid email or password. Please try again!']]);
//        }
//        return back()->withErrors(['password' => 'Invalid email or password. Please try again!']);
//    }

}
