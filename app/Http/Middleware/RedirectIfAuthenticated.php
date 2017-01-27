<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin::panel::index');
            }

            return redirect()->route('web::index');
        }

        return $next($request);
    }
}
