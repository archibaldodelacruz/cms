<?php

namespace App\Http\Middleware;

use Closure;

class RedirectIFHasDomain
{
    public function handle($request, Closure $next)
    {
        $domain = app('App\Models\Webs\Web')->domain;

        if ($request->path() !== '/') {
            $redirect = app('App\Models\Webs\Web')->getUrl().'/'.$request->path();
        } else {
            $redirect = app('App\Models\Webs\Web')->getUrl();
        }

        if ($domain && $request->getHost() !== $domain) {
            return redirect($redirect, 301);
        }

        return $next($request);
    }
}
