<?php

namespace App\Http\Controllers;

use App\Models\Webs\Web;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $web;

    public function __construct()
    {
        $this->web = app('App\Models\Webs\Web');

        if ($this->web->subdomain === 'admin' && $this->web->getConfig('web')) {
            $this->web = Web::find($this->web->getConfig('web'));
        }
    }
}
