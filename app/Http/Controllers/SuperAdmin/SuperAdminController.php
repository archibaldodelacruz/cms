<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\Users\User;
use App\Models\Webs\Web;
use App\Notifications\NewUpdate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Notification;
use Spatie\Analytics\AnalyticsFacade as Analytics;
use Spatie\Analytics\Period;

class SuperAdminController extends BaseAdminController
{
    public function __construct()
    {
        parent::__construct();

        $this->web = app('App\Models\Webs\Web');
    }

    public function index(Request $request)
    {
        return view('superadmin.index');
    }

    public function notifications()
    {
        return view('superadmin.notifications');
    }

    public function notifications_send(Request $request)
    {
        Notification::send(User::get(), new NewUpdate([
            'text' => $request->get('text'),
            'link' => $request->get('link'),
        ]));

        flash('Notificación enviada correctamente');

        return redirect()->back();
    }

    public function analytics()
    {
        $response = Analytics::performQuery(
            Period::days(30),
            'ga:pageviews,ga:users',
            [
                'dimensions' => 'ga:date,ga:hostname',
                'sort'       => '-ga:date',
                'filters'    => 'ga:hostname=='.$this->web->subdomain.'.protecms.com',
            ]
        );

        $analytics = collect($response['rows'] ?? [])
            ->map(function (array $row) {
                return [
                    'date'      => Carbon::createFromFormat('Ymd', $row[0]),
                    'hostname'  => $row[1],
                    'pageViews' => (int) $row[2],
                    'visitors'  => (int) $row[3],
                ];
            });

        return view('superadmin.analytics', compact('analytics'));
    }

    public function set_web(Request $request)
    {
        $this->validate($request, [
            'web_id' => 'exists:webs,id',
        ]);

        if (!(int) $request->get('web_id')) {
            $this->web->unsetConfig('web');
        } else {
            $this->web->setConfig('web', Web::find($request->get('web_id'))->id);
        }

        flash('Web cambiada correctamente');

        return back();
    }

    public function getSidebar()
    {
        return [
            [
                'title'       => 'Menú principal',
                'permissions' => ['admin'],
                'menu'        => [
                    'title'   => 'Menú principal',
                    'icon'    => 'fa fa-home',
                    'url'     => 'javascript:;',
                    'base'    => ['superadmin'],
                    'submenu' => [
                        [
                            'title' => 'Escritorio',
                            'icon'  => 'fa fa-home',
                            'url'   => route('superadmin::index'),
                        ],
                        [
                            'title' => 'Notificaciones',
                            'icon'  => 'fa fa-bell',
                            'url'   => route('superadmin::notifications'),
                        ],
                    ],
                ],
            ],
            [
                'title'       => 'Protectora',
                'permissions' => ['admin'],
                'menu'        => [
                    'title'   => 'Protectora',
                    'icon'    => 'fa fa-file-text-o',
                    'url'     => 'javascript:;',
                    'base'    => 'superadmin/webs*',
                    'submenu' => [
                        [
                            'title' => 'Listado',
                            'icon'  => 'fa fa-list-ul',
                            'url'   => route('superadmin::webs::index'),
                        ],
                        [
                            'title' => 'Nueva protectora',
                            'icon'  => 'fa fa-plus-square',
                            'url'   => route('superadmin::webs::create'),
                        ],
                    ],
                ],
            ],
        ];
    }
}
