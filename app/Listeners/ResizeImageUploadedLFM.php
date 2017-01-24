<?php

namespace App\Listeners;

use Intervention\Image\Facades\Image;
use Unisharp\Laravelfilemanager\Events\ImageWasUploaded;

class ResizeImageUploadedLFM
{
    public function handle(ImageWasUploaded $event)
    {
        Image::make($event->path())->resize(1200, 1200, function ($constraint) {
            $constraint->upsize();
            $constraint->aspectRatio();
        })->save($event->path());
    }
}
