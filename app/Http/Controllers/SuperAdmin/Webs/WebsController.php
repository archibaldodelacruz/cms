<?php

namespace App\Http\Controllers\SuperAdmin\Webs;

use App\Mail\WebCreated;
use App\Models\Webs\Web;
use Illuminate\Http\Request;
use App\Helpers\Traits\FilterBy;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\SuperAdmin\SuperAdminController;

class WebsController extends SuperAdminController
{
    use FilterBy;

    public function __construct()
    {
        parent::__construct();

        $this->web = app('App\Models\Webs\Web');
    }

    public function index(Request $request)
    {
        $total = $this->web->count();
        $webs = $this->filterBy($this->web, $request, ['name', 'email', 'subdomain', 'domain', 'updated_at'])
            ->orderBy('updated_at', 'DESC')
            ->paginate(25);

        return view('superadmin.webs.index', compact('webs', 'request', 'total'));
    }

    public function create()
    {
        return view('superadmin.webs.create');
    }

    public function store(Request $request)
    {
        $web = (new Web())->forceCreate([
            'domain'    => $request->get('domain'),
            'subdomain' => $request->get('subdomain'),
            'email'     => $request->get('email'),
        ]);

        $install_code = mt_rand(00000, 99999);
        $web->setConfig('install_code', $install_code);

        Mail::to($web->email)->cc(['email' => config('mail.from.address')])->send(new WebCreated($web, $install_code));

        flash('Protectora creada correctamente');

        return redirect()->route('superadmin::index');
    }

    public function edit()
    {
        $web = $this->web;

        return view('superadmin.webs.edit', compact('web'));
    }

    public function update(Request $request)
    {
        $this->web->update($request->all());

        flash('Protectora actualizada correctamente');

        return redirect()->route('superadmin::webs::edit');
    }
}
