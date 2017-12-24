<?php

namespace App\ProteCMS\Core\Controllers;

use App;
use App\ProteCMS\Core\Models\Webs\Web;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $web;

    public function __construct()
    {
        $this->web = shelter();
        App::setLocale($this->web->lang);

        if ($this->web->subdomain === 'admin' && $this->web->getConfig('web')) {
            $this->web = Web::find($this->web->getConfig('web'));
        }
    }
}
