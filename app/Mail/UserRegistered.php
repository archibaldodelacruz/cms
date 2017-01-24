<?php

namespace App\Mail;

use App\Models\Users\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRegistered extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $web;
    public $request;

    public function __construct(User $user, $request)
    {
        $this->web = app('App\Models\Webs\Web');
        $this->user = $user;
        $this->request = $request;
    }

    public function build()
    {
        return $this->view('emails.auth.register');
    }
}
