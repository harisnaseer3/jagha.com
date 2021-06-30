<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    protected $guards;

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @return string|null
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $this->guards = $guards;

        return parent::handle($request, $next, ...$guards);
    }

    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {

            if (Arr::first($this->guards) === 'admin') {
                return route('admin.login');
            }
            if (Arr::first($this->guards) === 'web') {
                return route('login');
            }
        }

    }
}
