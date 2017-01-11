<?php

namespace App\Http\Middleware;

use Closure;

class RedirectIfInstalled
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
        $web = app('App\Models\Webs\Web');

        if ($web->installed) {
            return redirect()->route('web::index');
        }

        return $next($request);
    }
}
