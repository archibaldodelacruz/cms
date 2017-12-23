<?php

namespace App\ProteCMS\Backend\Controllers\Admin\Panel\Webs;

use App\Http\Requests\Webs\UpdateRequest;
use App\ProteCMS\Backend\Controllers\Admin\BaseAdminController;

class WebsController extends BaseAdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->customAuthorize('admin.panel.web');

        return view('panel.webs.index');
    }

    public function update(UpdateRequest $request)
    {
        $this->customAuthorize('admin.panel.web');

        $this->web->update($request->all());

        flash('Datos actualizados correctamente');

        return redirect()->route('admin::panel::webs::index');
    }
}
