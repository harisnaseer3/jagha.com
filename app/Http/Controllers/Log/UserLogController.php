<?php

namespace App\Http\Controllers\Log;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PropertyBackendListingController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\PropertyController;

class UserLogController extends Controller
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
        $counts =(new PropertyBackendListingController)->getPropertyListingCount(Auth::user()->getAuthIdentifier());
        return view('website.pages.user-logs',
            [
                'recent_properties' => (new FooterController)->footerContent()[0],
                'footer_agencies' => (new FooterController)->footerContent()[1],
                'counts' => $counts,
            ]);

    }
}
