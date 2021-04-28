<?php

namespace App\Http\Middleware;

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
                DB::beginTransaction();
                $nextRequest = $next($request); //The router will be dispatched here, but it will reach to controller's method sometimes, so that we have to use DB transaction.
                $pattern = 'dashboard';
                $pattern2 = 'admin';
                $pattern3 = '_debugbar';
                $pattern4 = 'register';
                $patterns = array($pattern, $pattern2, $pattern3,$pattern4);
                $regex = '/^(' . implode('|', $patterns) . ')/i';
                if (Route::current() == null) {
                    HitController::record();

                }

                if (Route::current() !== null && !(preg_match($regex, Route::current()->uri))) {
                    HitController::record();
                }
                return $nextRequest;


            } catch (\Exception $e) {
                dd($e->getMessage());
            }
        }

        return $next($request);
    }
}
