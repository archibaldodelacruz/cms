<?php

namespace App\ProteCMS\Core\Middleware;

use Closure;

class RedirectIfInstalled
{
    public function handle($request, Closure $next)
    {
        $web = shelter();

        if ($web->installed) {
            return redirect()->route('web::index');
        }

        return $next($request);
    }
}
