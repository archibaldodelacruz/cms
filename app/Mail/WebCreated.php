<?php

namespace App\Mail;

use App\Models\Webs\Web;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WebCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $web;
    public $install_code;

    public function __construct(Web $web, $install_code)
    {
        $this->web = $web;
        $this->install_code = $install_code;
    }

    public function build()
    {
        return $this->view('emails.web.created')
            ->subject('¡Bienvenidos a ProteCMS!');
    }
}
