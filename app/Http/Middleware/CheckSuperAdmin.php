<?php

namespace App\Http\Middleware;

use Closure;

class CheckSuperAdmin
{
    public function handle($request, Closure $next)
    {
        if (!$request->user() || $request->user() && $request->user()->web->subdomain !== 'admin') {
            abort(401);
        }

        return $next($request);
    }
}
