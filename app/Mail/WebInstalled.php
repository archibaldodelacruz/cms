<?php

namespace App\Mail;

use App\Models\Webs\Web;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WebInstalled extends Mailable
{
    use Queueable, SerializesModels;

    public $web;
    public $password;

    public function __construct(Web $web, string $password)
    {
        $this->web = $web;
        $this->password = $password;
    }

    public function build()
    {
        return $this->view('emails.web.new')
            ->subject('¡Página web creada correctamente!');
    }
}
