<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\Webs\Web;
use Laravel\Dusk\DuskServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Barryvdh\Debugbar\ServiceProvider as DebugBar;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Carbon::setLocale(config('app.locale'));

        if (! $this->app->runningInConsole()) {
            if ($this->app->environment() === 'dev') {
                $web = Web::where('subdomain', 'dev')->first();
                $this->app->bind('App\Models\Webs\Web', function () use ($web) {
                    return $web;
                });
            } else {
                $request = app('Illuminate\Http\Request');

                $domain = strrchr($request->getHost(), '.');
                $host = str_replace($domain, '', str_replace('www.', '', $request->getHost()));

                if (strstr($host, '.')) {
                    $findBy = 'subdomain';
                    $host = strstr($host, '.', true);
                } else {
                    $findBy = 'domain';
                    $host = $host.$domain;
                }

                $web = Web::where($findBy, $host)->with('config')->first();

                if (! $web) {
                    abort(404);
                }

                $this->app->bind('App\Models\Webs\Web', function () use ($web) {
                    return $web;
                });
            }
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local')) {
            $this->app->register(IdeHelperServiceProvider::class);
            $this->app->register(DebugBar::class);
        }

        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
        }
    }
}
