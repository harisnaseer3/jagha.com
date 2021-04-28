<?php

namespace App\Http\Middleware;

use App\Http\Controllers\HitRecord\HitController;
use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class logIncommingRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->ajax()) {

            try {
                DB::beginTransaction();
                $nextRequest = $next($request); //The router will be dispatched here, but it will reach to controller's method sometimes, so that we have to use DB transaction.
//                $pattern = 'dashboard';
//                $pattern2 = 'admin';
                $pattern3 = '_debugbar';
                $patterns = array($pattern3);
                $regex = '/^(' . implode('|', $patterns) . ')/i';
                if (Route::current() == null)
                    HitController::record();
                if (Route::current() !== null && !(preg_match($regex, Route::current()->uri))) {
                    HitController::record();
                }
                return $nextRequest;


            } catch (\Exception $e) {
                dd($e->getMessage());
            }
        }
    }
}
