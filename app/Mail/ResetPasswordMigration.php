<?php

namespace App\Mail;

use App\Models\Users\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMigration extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $web;
    public $password;

    public function __construct(User $user, string $password)
    {
        $this->web = app('App\Models\Webs\Web');
        $this->user = $user;
        $this->password = $password;
    }

    public function build()
    {
        return $this->view('emails.reset_password_migration')
            ->subject('Reincio de contraseña');
    }
}
