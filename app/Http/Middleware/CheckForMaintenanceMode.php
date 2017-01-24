<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Http\Exceptions\MaintenanceModeException;

class CheckForMaintenanceMode
{
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function handle($request, Closure $next)
    {
        $ip = $request->getClientIp();

        if (session()->has('superadmin') || in_array($ip, explode(',', env('MAINTENANCE_IPS', '127.0.0.1')))) {
            return $next($request);
        }

        if ($this->app->isDownForMaintenance()) {
            $data = json_decode(file_get_contents($this->app->storagePath().'/framework/down'), true);

            throw new MaintenanceModeException($data['time'], $data['retry'], $data['message']);
        }

        return $next($request);
    }
}
