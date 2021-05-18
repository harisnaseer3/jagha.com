<?php

namespace App\Http\Middleware;

use App\Events\LogErrorEvent;
use App\Http\Controllers\HitRecord\HitController;
use Closure;
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
                $patterns = array($pattern, $pattern2, $pattern3,$pattern4,$pattern5,$pattern6,$pattern8,$pattern9);

                $regex = '/^(' . implode('|', $patterns) . ')/i';
                if (Route::current() == null) {
                    HitController::record();
					return $nextRequest;
                }

                if (Route::current() !== null && !(preg_match($regex, Route::current()->uri))) {
                    HitController::record();
					return $nextRequest;
                }
				else
				return $nextRequest;



            } catch (\Exception $e) {
                event(new LogErrorEvent($e->getMessage(), 'Error in logRequest middleware handle method'));
            }
        }

        return $next($request);
    }
}
