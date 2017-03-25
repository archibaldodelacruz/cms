<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class VerifyAdminAccess
{
    public function handle($request, Closure $next)
    {
        if ($request->user()
            && ! $request->user()->hasPermission('admin')
            || $request->user()->isBanned()
            || ! $request->user()->isAdminOrVolunteer()) {
            if ($request->path() === 'admin/panel') {
                Auth::logout();
                flash('No tienes permisos para acceder al panel de administración.', 'error');

                return redirect()->route('auth::login');
            }

            abort(401);
        }

        return $next($request);
    }
}
