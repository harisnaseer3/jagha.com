<?php

namespace App\Http\Controllers\MessageCenter;

use App\Http\Controllers\Controller;
use App\Models\AgentInbox;
use App\Models\Support;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FooterController;

class MessageCenterController extends Controller
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
        return view('website.message-center.notifications',
            [
                'notifications' => Auth()->user()->Notifications,
                'recent_properties' => (new FooterController)->footerContent()[0],
                'footer_agencies' => (new FooterController)->footerContent()[1]
            ]);

    }
    public function inbox()
    {
        $user_id = Auth::guard('web')->user()->getAuthIdentifier();
        $agent_inboxes = (new AgentInbox)->where('user_id',$user_id)->get();

        return view('website.message-center.inbox',
            [
                'agent_inboxes' =>  $agent_inboxes,
                'recent_properties' => (new FooterController)->footerContent()[0],
                'footer_agencies' => (new FooterController)->footerContent()[1]
            ]);

    }
    public function sent()
    {
        $user_id = Auth::guard('web')->user()->getAuthIdentifier();
        $user_supports = (new Support)->where('user_id',$user_id)->get();
        $agent_inboxes = (new AgentInbox)->where('sender_id',$user_id)->get();
        return view('website.message-center.sent',
            [
                'agent_inboxes' => $agent_inboxes,
                'user_supports' => $user_supports,
                'recent_properties' => (new FooterController)->footerContent()[0],
                'footer_agencies' => (new FooterController)->footerContent()[1]
            ]);

    }
}
