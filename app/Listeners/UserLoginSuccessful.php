<?php

namespace App\Listeners;

use Carbon\Carbon;
use Illuminate\Auth\Events\Login;

class UserLoginSuccessful
{
    public function handle(Login $event)
    {
        $event->user->update([
            'last_login' => Carbon::now(),
        ]);
    }
}
