<?php

namespace App\Http\Controllers;

use App\Events\ContactAgentEvent;
use App\Http\Controllers\Controller;
use App\Mail\ContactAgentMail;
use App\Models\Agency;
use App\Models\Dashboard\User;
use App\Models\Property;
use App\Notifications\InquiryNotification;
use App\Notifications\SupportNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use IpLocation;

class ContactAgentController extends Controller
{
    public function store(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email',
//                'phone' => 'required|regex:/\+92-3\d{2}\d{7}/',
//                'message' => 'required',
                'agent' => 'string',
                'property' => 'string'
            ]);
            if ($validator->fails()) {
                return response()->json(['data' => $validator->errors(), 'status' => 201]);
            }
            $data = $request->all();
            $sent_to = '';
            $name = '';
            $property = '';
            $agency = '';
            if ($request->filled('agency')) {
                $agency = (new Agency)->select('email', 'user_id')->where('id', '=', $request->input('agency'))->first();
                $user = (new User)->select('name')->where('id', '=', $agency->user_id)->first();
                $sent_to = $agency->email;
                $name = $user->name;

            } else if ($request->filled('property')) {
                $property = (new Property)->select('email', 'contact_person')->where('id', '=', $request->input('property'))->first();
                $sent_to = $property->email;
                $name = $property->contact_person;
            }
            if ($sent_to != null || $sent_to != '') {

                $ip = $_SERVER['REMOTE_ADDR'];
                $country = '';
                if ($ip_location = IpLocation::get($ip)) {
                    $country = $ip_location->countryName;
                } else {

                    $country = 'unavailable';
                }


                if(Auth::check()){
                    DB::table('agent_inboxes')->insert([
                        'sender_id' => Auth::user()->getAuthIdentifier(),
                        'user_id' => User::getUserByEmail($sent_to)->id,
                        'name' => $request->has('name') ? $request->input('name') : Auth::user()->name,
                        'email' => $request->has('email') ? $request->input('email') : Auth::user()->email,
                        'cell' => $request->has('cell') ? $request->input('cell') : Auth::user()->cell,
                        'message' => $request->input('message'),
                        'type' => $request->input('i_am'),
                        'ip_location' => $country
                    ]);
                }

                $data['ip_location'] = $country;
                if ($property != '') {
                    $property = (new Property)->where('id', '=', $request->input('property'))->first();
                    Notification::send(User::getUserByEmail($sent_to), new InquiryNotification($data, $name, $property));
                }
                if ($agency != null) {
                    Mail::to($sent_to)->send(new ContactAgentMail($data, $name));
                }

                return response()->json(['data' => 'success', 'status' => 200]);
            } else
                return response()->json(['data' => 'no data available', 'status' => 200]);
//                return response()->json(['data' => $request->all(), 'status' => 200]);
        } else {
            return 'not found';
        }
    }
}
