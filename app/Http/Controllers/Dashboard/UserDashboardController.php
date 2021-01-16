<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Models\Dashboard\User;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FooterController;
use Illuminate\Support\Facades\DB;

class UserDashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
//        dd(Auth::user()->roles[0]->name);

        $user = (new User)->where('id', '=', Auth::user()->getAuthIdentifier())->first();
        $agencies = count((new Agency)->where('status', '=', 'verified')->whereIn('id', DB::table('agency_users')->select('agency_id')->where('user_id', '=', Auth::user()->getAuthIdentifier())->pluck('agency_id')->toArray())->get());

        $active_properties = count((new Property)->where('user_id', '=', Auth::user()->getAuthIdentifier())->where('status', '=', 'active')->get());
        $deleted_properties = count((new Property)->where('user_id', '=', Auth::user()->getAuthIdentifier())->where('status', '=', 'deleted')->get());
        $pending_properties = count((new Property)->where('user_id', '=', Auth::user()->getAuthIdentifier())->where('status', '=', 'pending')->get());
        return view('website.user-dashboard.dashboard',
            [
                'user' => $user,
                'agencies' => $agencies,
                'sale' => (new Property)->where('user_id', '=', Auth::user()->getAuthIdentifier())->where('purpose', '=', 'Sale')->orderBy('id','desc')->get(),
                'rent' => (new Property)->where('user_id', '=', Auth::user()->getAuthIdentifier())->where('purpose', '=', 'Rent')->orderBy('id','desc')->get(),
                'active_properties' => $active_properties,
                'pending_properties' => $pending_properties,
                'deleted_properties' => $deleted_properties,
//                'notifications' => Auth()->user()->unreadNotifications,
                'recent_properties' => (new FooterController)->footerContent()[0],
                'footer_agencies' => (new FooterController)->footerContent()[1]
            ]);

    }
}
