<?php

namespace App\Http\Controllers\Api\WebServices\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Dashboard\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    public function show(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
            ? redirect($this->redirectPath())
            : view('website.pages.verify');
    }

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */

    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api')->only('resend');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function verify(Request $request)
    {
//        auth()->loginUsingId($request->route('id'));

        if ($request->route('id') != $request->user()->getKey()) {
            throw new AuthorizationException;
        }

        if ($request->user()->hasVerifiedEmail()) {

//            return response(['message' => 'Already verified']);
            return (new \App\Http\JsonResponse)->success("Already verified");


            // return redirect($this->redirectPath());
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return (new \App\Http\JsonResponse)->success("Successfully verified");

    }

    /**
     * Resend the email verification notification.
     *
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {

//            return response(['message'=>'Already verified']);
            return (new \App\Http\JsonResponse)->success("Already verified");
        }

        $request->user()->sendApiEmailVerificationNotification();

        if ($request->wantsJson()) {
//            return response(['message' => 'Email Sent']);
            return (new \App\Http\JsonResponse)->success("Email Sent");
        }

        return back()->with('resent', true);
    }
}
