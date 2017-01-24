<?php

namespace App\Http\Controllers\Admin\Panel\Webs;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Webs\UpdateRequest;

class WebsController extends BaseAdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return view('panel.webs.index');
    }

    public function update(UpdateRequest $request)
    {
        $this->web->update($request->all());

        flash('Datos actualizados correctamente');

        return redirect()->route('admin::panel::webs::index');
    }
}
