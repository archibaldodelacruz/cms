<?php

namespace App\Http\Controllers\Admin\Support;

use App\Mail\Support\SendContact;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Support\ContactRequest;
use App\Http\Controllers\Admin\BaseAdminController;

class SupportController extends BaseAdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->customAuthorize('admin.support');

        return view('support.index');
    }

    public function faq()
    {
        $this->customAuthorize('admin.support');

        return view('support.faq');
    }

    public function contact()
    {
        $this->customAuthorize('admin.support');

        return view('support.contact');
    }

    public function contact_post(ContactRequest $request)
    {
        $this->customAuthorize('admin.support');

        Mail::to('web@protecms.com')->send(new SendContact($request));

        flash('Sugerencia enviada correctamente. Gracias.');

        return redirect()->route('admin::support::contact');
    }

    public function changelog()
    {
        $this->customAuthorize('admin.support');

        return view('support.changelog');
    }

    public function getSidebar()
    {
        return [
            [
                'title' => 'Soporte',
                'menu'  => [
                    'title'   => 'Soporte',
                    'icon'    => 'fa fa-question-circle',
                    'url'     => 'javascript:;',
                    'base'    => 'admin/support*',
                    'submenu' => [
                        [
                            'title' => 'Inicio',
                            'icon'  => 'fa fa-home',
                            'url'   => route('admin::support::index'),
                        ],
                        [
                            'title' => 'Preguntas frecuentes',
                            'icon'  => 'fa fa-question-circle',
                            'url'   => route('admin::support::faq'),
                        ],
                        [
                            'title' => 'Contacto',
                            'icon'  => 'fa fa-envelope',
                            'url'   => route('admin::support::contact'),
                        ],
                        [
                            'title' => 'Historial de cambios',
                            'icon'  => 'fa fa-list-ul',
                            'url'   => route('admin::support::changelog'),
                        ],
                    ],
                ],
            ],
        ];
    }
}
