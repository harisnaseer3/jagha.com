<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mockery\Exception;

class SubscriberController extends Controller
{
    public function store(Request $request)
    {
        if ($request->ajax()) {
            $email = $request->input('email');
            try {
                if ((new Subscriber)->where('email', '=', $email)->exists()) {
                    return response()->json(['data' => 'success', 'msg' => 'already exists', 'status' => 200]);
                } else {
                    (new Subscriber)->Create([
                        'email' => $email,
                        'status' => 'active'
                    ]);
                    return response()->json(['data' => 'success', 'msg' => 'new subscriber', 'status' => 200]);
                }
            } catch (Exception $e) {
                return response()->json(['data' => 'error', 'status' => 201]);
            }
        } else {
            return "not found";
        }
    }

    public function addUser($user)
    {
        try {
            (new Subscriber)->updateOrCreate(['email' => $user->email], [
                'email' => $user->email,
                'status' => 'active'
            ]);
            dump('registered user successfully added to subscribers');
        } catch (Exception $e) {
            dump('Error in adding registered user in subscribers', $e);
        }
    }
}
