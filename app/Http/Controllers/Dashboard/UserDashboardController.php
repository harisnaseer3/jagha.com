<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FooterController;

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
        return view('website.user-dashboard.dashboard',
            [   'notifications' => Auth()->user()->unreadNotifications,
                'recent_properties' => (new FooterController)->footerContent()[0],
                'footer_agencies' => (new FooterController)->footerContent()[1]
            ]);

    }
}
