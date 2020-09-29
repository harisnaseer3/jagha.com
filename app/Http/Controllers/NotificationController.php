<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function ReadPropertyStatus(Request $request)
    {
        dd(auth()->user()
            ->unreadNotifications);
        if ($request->ajax()) {
            auth()->user()
                ->unreadNotifications
                ->when($request->input('id'), function ($query) use ($request) {
                    return $query->where('id', $request->input('notification_id'));
                })
                ->markAsRead();
            return response()->json(['status' => 200]);
        } else {
            return "not found";
        }
    }

}
