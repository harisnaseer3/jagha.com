<?php

namespace App\Http\Controllers;

use App\Events\ContactAgentEvent;
use App\Http\Controllers\Controller;
use App\Mail\ContactAgentMail;
use App\Models\Agency;
use App\Models\Dashboard\User;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactAgentController extends Controller
{
    public function store(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required|regex:/\+92-3\d{2}\d{7}/',
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
                Mail::to($sent_to)->send(new ContactAgentMail($data, $name));
                return response()->json(['data' => 'success', 'status' => 200]);
            } else
                return response()->json(['data' => 'no data available', 'status' => 200]);
        } else {
            return 'not found';
        }
    }
}
