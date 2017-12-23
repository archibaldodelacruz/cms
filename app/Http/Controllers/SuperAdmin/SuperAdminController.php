<?php

namespace App\Http\Controllers\SuperAdmin;

use Notification;
use Carbon\Carbon;
use App\ProteCMS\Core\Models\Webs\Web;
use App\ProteCMS\Core\Models\Posts\Post;
use App\ProteCMS\Core\Models\Users\User;
use Illuminate\Http\Request;
use Spatie\Analytics\Period;
use App\ProteCMS\Core\Models\Animals\Animal;
use App\ProteCMS\Core\Models\Partners\Partner;
use App\Notifications\NewUpdate;
use App\ProteCMS\Core\Models\Veterinarians\Veterinary;
use Spatie\Analytics\AnalyticsFacade as Analytics;
use App\Http\Controllers\Admin\BaseAdminController;

class SuperAdminController extends BaseAdminController
{
    public function __construct()
    {
        parent::__construct();

        $this->web = app('App\ProteCMS\Core\Models\Webs\Web');
    }

    public function index(Request $request)
    {
        return redirect()->route('superadmin::webs::index');
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

    public function stats()
    {
        $response = Analytics::performQuery(
            Period::days(30),
            'ga:pageviews,ga:users',
            [
                'dimensions' => 'ga:date',
                'sort'       => '-ga:date',
            ]
        );

        $google_analytics = collect($response['rows'] ?? [])
            ->map(function (array $row) {
                return [
                    'date'      => Carbon::createFromFormat('Ymd', $row[0]),
                    'pageViews' => (int) $row[1],
                    'visitors'  => (int) $row[2],
                ];
            });

        $analytics = [];
        for ($i = 0; $i < 30; $i++) {
            $now = Carbon::now()->subDays($i)->format('Y-m-d');
            $analytics['categories'][] = $now;

            foreach ($google_analytics as $analytic) {
                if ($analytic['date']->format('Y-m-d') === $now) {
                    $analytics['pageviews'][$now] = $analytic['pageViews'];
                    $analytics['users'][$now] = $analytic['visitors'];
                }
            }

            if (! isset($analytics['pageviews'][$now])) {
                $analytics['pageviews'][$now] = 0;
            }

            if (! isset($analytics['users'][$now])) {
                $analytics['users'][$now] = 0;
            }
        }

        $analytics['categories'] = array_reverse($analytics['categories']);
        ksort($analytics['pageviews']);
        ksort($analytics['users']);

        // Animals
        $animals = [];
        $animals['total'] = Animal::where('status', '!=', 'dead')->count();

        // Gender
        $animals['male'] = Animal::where('status', '!=', 'dead')->where('gender', 'male')->count();
        $animals['female'] = Animal::where('status', '!=', 'dead')->where('gender', 'female')->count();
        $animals['unknown'] = Animal::where('status', '!=', 'dead')->where('gender', 'unknown')->count();

        // Status
        $animals['adoption'] = Animal::where('status', '!=', 'dead')->where('status', 'adoption')->count();
        $animals['adopted'] = Animal::where('status', '!=', 'dead')->where('status', 'adopted')->count();
        $animals['reserved'] = Animal::where('status', '!=', 'dead')->where('status', 'reserved')->count();
        $animals['unavailable'] = Animal::where('status', '!=', 'dead')->where('status', 'unavailable')->count();
        $animals['found'] = Animal::where('status', '!=', 'dead')->where('status', 'found')->count();
        $animals['lost'] = Animal::where('status', '!=', 'dead')->where('status', 'lost')->count();

        // Location
        $animals['shelter'] = Animal::where('status', '!=', 'dead')->where('location', 'shelter')->count();
        $animals['temporary_home'] = Animal::where('status', '!=', 'dead')->where('location', 'temporary_home')->count();
        $animals['animal_home'] = Animal::where('status', '!=', 'dead')->where('location', 'animal_home')->count();
        $animals['street'] = Animal::where('status', '!=', 'dead')->where('location', 'street')->count();
        $animals['unknown'] = Animal::where('status', '!=', 'dead')->where('location', 'unknown')->count();
        $animals['family'] = Animal::where('status', '!=', 'dead')->where('location', 'family')->count();

        // Kind
        $animals['dog'] = Animal::where('status', '!=', 'dead')->where('kind', 'dog')->count();
        $animals['cat'] = Animal::where('status', '!=', 'dead')->where('kind', 'cat')->count();
        $animals['horse'] = Animal::where('status', '!=', 'dead')->where('kind', 'horse')->count();
        $animals['rodent'] = Animal::where('status', '!=', 'dead')->where('kind', 'rodent')->count();
        $animals['bird'] = Animal::where('status', '!=', 'dead')->where('kind', 'bird')->count();
        $animals['reptile'] = Animal::where('status', '!=', 'dead')->where('kind', 'reptile')->count();
        $animals['other'] = Animal::where('status', '!=', 'dead')->where('kind', 'other')->count();

        // Users
        $users['users'] = User::where('type', 'user')->count();
        $users['volunteers'] = User::where('type', 'volunteer')->count();
        $users['admins'] = User::where('type', 'admin')->count();

        // Partners
        $partners['partners'] = Partner::count();

        // Posts
        $posts['posts'] = Post::count();

        // Pages
        $pages['pages'] = Post::count();

        // Forms
        $forms['forms'] = Post::count();

        // Files
        $files['files'] = Post::count();

        // Veterinarians
        $veterinarians['veterinarians'] = Veterinary::count();

        $data = [
            'analytics'              => $analytics,
            'animals_total'          => $animals['total'],
            'animals_male'           => $animals['male'],
            'animals_female'         => $animals['female'],
            'animals_unknown'        => $animals['unknown'],
            'animals_adoption'       => $animals['adoption'],
            'animals_adopted'        => $animals['adopted'],
            'animals_reserved'       => $animals['reserved'],
            'animals_unavailable'    => $animals['unavailable'],
            'animals_found'          => $animals['found'],
            'animals_lost'           => $animals['lost'],
            'animals_shelter'        => $animals['shelter'],
            'animals_temporary_home' => $animals['temporary_home'],
            'animals_animal_home'    => $animals['animal_home'],
            'animals_street'         => $animals['street'],
            'animals_family'         => $animals['family'],
            'animals_dog'            => $animals['dog'],
            'animals_cat'            => $animals['cat'],
            'animals_horse'          => $animals['horse'],
            'animals_rodent'         => $animals['rodent'],
            'animals_bird'           => $animals['bird'],
            'animals_reptile'        => $animals['reptile'],
            'animals_other'          => $animals['other'],
            'users'                  => $users['users'],
            'volunteers'             => $users['volunteers'],
            'admins'                 => $users['admins'],
            'partners'               => $partners['partners'],
            'posts'                  => $posts['posts'],
            'pages'                  => $pages['pages'],
            'forms'                  => $forms['forms'],
            'files'                  => $files['files'],
            'veterinarians'          => $veterinarians['veterinarians'],
        ];

        return view('superadmin.stats', compact('data'));
    }

    public function set_web(Request $request)
    {
        $this->validate($request, [
            'web_id' => 'exists:webs,id',
        ]);

        if (! (int) $request->get('web_id')) {
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
                            'title' => 'Notificaciones',
                            'icon'  => 'fa fa-bell',
                            'url'   => route('superadmin::notifications'),
                        ],
                        [
                            'title' => 'Estadísticas',
                            'icon'  => 'fa fa-bar-chart',
                            'url'   => route('superadmin::stats'),
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
