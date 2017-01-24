<?php

namespace App\Mail;

use App\Models\Webs\Web;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WebInstalled extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Web
     */
    public $web;

    /**
     * @var string
     */
    public $password;

    /**
     * Create a new message instance.
     *
     * @param Web    $web
     * @param string $password
     */
    public function __construct(Web $web, string $password)
    {
        $this->web = $web;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.web.new')
            ->subject('¡Página web creada correctamente!');
    }
}
