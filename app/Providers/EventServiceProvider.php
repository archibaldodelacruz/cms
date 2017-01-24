<?php

namespace App\Providers;

use App\Listeners\ResizeImageUploadedLFM;
use App\Listeners\UserLoginSuccessful;
use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Unisharp\Laravelfilemanager\Events\ImageWasUploaded;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        ImageWasUploaded::class => [
            ResizeImageUploadedLFM::class,
        ],
        Login::class => [
            UserLoginSuccessful::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
