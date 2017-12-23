<?php

namespace App\ProteCMS\Frontend\Controllers;

use Theme;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        Theme::set("frontend_{$this->web->getConfig('theme')}");

        $widgets = $this->web->widgets()->active()->with(['links' => function ($query) {
            $query->orderBy('order', 'ASC');
        }])->orderBy('order')->get();

        view()->share('web', $this->web);
        view()->share('widgets_left', $widgets->where('side', 'left'));
        view()->share('widgets_right', $widgets->where('side', 'right'));
    }
}
