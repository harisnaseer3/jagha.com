<?php

namespace App\Http\Middleware;

use App\Events\LogErrorEvent;
use App\Http\Controllers\HitRecord\HitController;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class LogRequest
{


    public function handle($request, Closure $next)
    {

        if (!$request->ajax()) {


            try {
                // DB::beginTransaction();
                $nextRequest = $next($request); //The router will be dispatched here, but it will reach to controller's method sometimes, so that we have to use DB transaction.
                $pattern = 'dashboard';
                $pattern2 = 'admin';
                $pattern3 = '_debugbar';
                $pattern4 = 'register';
                $pattern5 = 'password';
                $pattern6 = 'email';
                $pattern7 = '#_=_';
                $pattern8 = 'get-about-pakistan-properties';
                $pattern9 = '_ignition';
                $pattern10 = 'api';
                $pattern11 = 'search-id';
//                $pattern12 = 'housing_societies_status';
                $pattern13 = 'privacy-policy';
                $pattern14 = 'terms-and-conditions';
                $patterns = array($pattern, $pattern2, $pattern3, $pattern4, $pattern5, $pattern6, $pattern8, $pattern9, $pattern10, $pattern11, $pattern13, $pattern14);

                $regex = '/^(' . implode('|', $patterns) . ')/i';


                if (Route::current() == null) {
                    if (Auth::guard('web')->user() == null) {
                        HitController::record();
                        return $nextRequest;
                    }
                }

                if (Route::current() !== null && !(preg_match($regex, Route::current()->uri))) {
                    HitController::record();
                    return $nextRequest;
                } else
                    return $nextRequest;


            } catch (\Exception $e) {
                event(new LogErrorEvent($e->getMessage(), 'Error in logRequest middleware handle method'));
            }
        }
//dd($next, $request);
//        return $next($request);

        try {
            return $next($request);
        } catch (\Throwable $e) {
            logger()->error("Middleware error: " . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            throw $e; // Optional: rethrow if you want it to continue failing visibly
        }

    }
}
