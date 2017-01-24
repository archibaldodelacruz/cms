<?php

namespace App\Mail\Support;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendContact extends Mailable
{
    use Queueable, SerializesModels;

    public $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function build()
    {
        $build = $this->view('emails.support.contact')
            ->subject('Mensaje de soporte');

        if ($this->request->hasFile('attachments')) {
            foreach ($this->request->file('attachments') as $attachment) {
                $build = $build->attach($attachment->getPathname());
            }
        }

        return $build;
    }
}
