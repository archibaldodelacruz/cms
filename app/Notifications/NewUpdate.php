<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewUpdate extends Notification
{
    use Queueable;

    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function via()
    {
        return ['database'];
    }

    public function toArray()
    {
        return [
            'text' => $this->data['text'],
            'link' => $this->data['link'],
        ];
    }
}
