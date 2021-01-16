<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function ReadPropertyStatus(Request $request)
    {
        if ($request->ajax()) {
//            auth()->user()
//                ->unreadNotifications
//                ->when($request->input('id'), function ($query) use ($request) {
//                    return $query->where('id', $request->input('notification_id'));
//                })
//                ->markAsRead();
            if ($request->has('unread')) {
                if ($request->input('unread')) {
                    DB::table('notifications')->where('id', $request->input('notification_id'))
                        ->update(['read_at' => null]);

                    return response()->json(['status' => 200]);
                }
            }
            DB::table('notifications')->where('id', $request->input('notification_id'))
                ->update(['read_at' => Carbon::now()]);

            return response()->json(['status' => 200]);
        } else {
            return "not found";
        }
    }

//    public function ReadAgencyStatus(Request $request)
//    {
//        if ($request->ajax()) {
//            auth()->user()
//                ->unreadNotifications
//                ->when($request->input('id'), function ($query) use ($request) {
//                    return $query->where('id', $request->input('notification_id'));
//                })
//                ->markAsRead();
//            return response()->json(['status' => 200]);
//        } else {
//            return "not found";
//        }
//    }


    public function ReadInboxMessage(Request $request)
    {
        if ($request->ajax()) {
            if ($request->has('id')) {
                if (DB::table('agent_inboxes')->where('id', $request->input('id'))->exists()) {
                    DB::table('agent_inboxes')
                        ->where('id', $request->input('id'))
                        ->update(['read_at' => Carbon::now()]);
                    return response()->json(['status' => 200]);
                }
            }
        } else {
            return "not found";
        }
    }
}
