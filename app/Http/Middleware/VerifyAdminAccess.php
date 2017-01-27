<?php

namespace App\Http\Middleware;

use Closure;

class VerifyAdminAccess
{
    public function handle($request, Closure $next)
    {
        if ($request->user()
            && ! $request->user()->hasPermission('admin')
            || $request->user()->isBanned()
            || ! $request->user()->isAdminOrVolunteer()) {
            abort(401);
        }

        return $next($request);
    }
}
