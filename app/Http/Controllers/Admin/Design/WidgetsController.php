<?php

namespace App\Http\Controllers\Admin\Design;

use Illuminate\Http\Request;
use App\Helpers\Traits\FilterBy;
use App\Http\Requests\Widgets\StoreRequest;
use App\Http\Requests\Widgets\UpdateRequest;
use App\Http\Controllers\Admin\BaseAdminController;

class WidgetsController extends BaseAdminController
{
    use FilterBy;

    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
        $this->customAuthorize('admin.design');

        $total = $this->web->widgets()->count();
        $widgets = $this->filterBy($this->web->widgets(), $request, ['translations.title', 'side', 'type', 'order'])
            ->orderBy('side')
            ->orderBy('order', 'ASC')
            ->paginate(self::PAGINATION);

        return view('design.widgets.index', compact('widgets', 'request', 'total'));
    }

    public function deleted(Request $request)
    {
        $this->customAuthorize('admin.design');

        $total = $this->web->widgets()->onlyTrashed()->count();
        $widgets = $this->filterBy($this->web->widgets()->onlyTrashed(), $request, ['translations.title', 'side', 'type', 'order'])
            ->orderBy('side')
            ->orderBy('order', 'ASC')
            ->paginate(self::PAGINATION);

        return view('design.widgets.deleted', compact('widgets', 'request', 'total'));
    }

    public function create()
    {
        $this->customAuthorize('admin.design');

        return view('design.widgets.create');
    }

    public function store(StoreRequest $request)
    {
        $this->customAuthorize('admin.design');

        $widget = $this->web->widgets()
            ->create($request->all());

        if ($request->get('type') === 'menu') {
            $order = 1;
            foreach ($request->get('links') as $link) {
                $widget->links()->create([
                    'order'                   => $order,
                    'type'                    => 'link',
                    $request->get('langform') => [
                        'title' => $link['title'],
                        'link'  => $link['link'],
                    ],
                ]);

                $order++;
            }
        }

        flash('El bloque se ha creado correctamente.');

        return redirect()->route('admin::design::widgets::edit', ['id' => $widget->id]);
    }

    public function edit($id)
    {
        $this->customAuthorize('admin.design');

        $widget = $this->web->widgets()
            ->findOrFail($id);

        return view('design.widgets.edit', compact('widget'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $this->customAuthorize('admin.design');

        $widget = $this->web->widgets()->findOrFail($id);

        if ($request->get('type') === 'menu') {
            $links = [];
            foreach ($request->get('links') as $link) {
                if (isset($link['id'])) {
                    $links[] = (int) $link['id'];
                }
            }

            if ($widget->hasTranslation($request->get('langform'))) {
                foreach ($widget->links as $link) {
                    $link->deleteTranslations($request->get('langform'));
                }
            }

            $widget->links()->whereIn('id', array_diff($widget->links()->pluck('id')->toArray(), $links))->delete();

            $order = 1;
            foreach ($request->get('links') as $link) {
                if (isset($link['id'])) {
                    $widget->links()->findOrFail($link['id'])->update([
                        'order'                   => $order,
                        'type'                    => 'link',
                        $request->get('langform') => [
                            'title' => $link['title'],
                            'link'  => $link['link'],
                        ],
                    ]);
                } else {
                    $widget->links()->create([
                        'order'                   => $order,
                        'type'                    => 'link',
                        $request->get('langform') => [
                            'title' => $link['title'],
                            'link'  => $link['link'],
                        ],
                    ]);
                }

                $order++;
            }
        }

        $widget->update($request->all());

        flash('El bloque se ha actualizado correctamente.');

        return redirect()->to(route('admin::design::widgets::edit', ['id' => $id]).'?langform='.$request->get('langform'));
    }

    public function restore($id)
    {
        $this->customAuthorize('admin.design');

        $this->web->widgets()
            ->withTrashed()
            ->where('id', $id)->firstOrFail()
            ->restore();

        flash('El bloque se ha recuperado correctamente.');

        return redirect()->route('admin::design::widgets::index');
    }

    public function delete($id)
    {
        $this->customAuthorize('admin.design');

        $this->web->widgets()
            ->withTrashed()
            ->where('id', $id)
            ->firstOrFail()
            ->delete();

        flash('El bloque se ha eliminado correctamente.');

        return redirect()->route('admin::design::widgets::index');
    }

    public function delete_translation(Request $request, $id)
    {
        $this->customAuthorize('admin.design');

        $this->web->widgets()
            ->findOrFail($id)
            ->deleteTranslations($request->get('langform'));

        flash('La traducción del bloque se ha eliminado correctamente.');

        return redirect()->route('admin::design::widgets::edit', ['id' => $id]);
    }

    public function getSidebar()
    {
        return [
            [
                'title' => 'Diseño',
                'menu'  => [
                    'title'   => 'Diseño',
                    'icon'    => 'fa fa-picture-o',
                    'url'     => 'javascript:;',
                    'base'    => 'admin/design*',
                    'submenu' => [
                        [
                            'title'       => 'Principal',
                            'icon'        => 'fa fa-picture-o',
                            'url'         => route('admin::design::index'),
                            'permissions' => ['admin.design', 'admin.design.view'],
                        ],
                        [
                            'title'       => 'Configuración',
                            'icon'        => 'fa fa-cogs',
                            'url'         => route('admin::design::config'),
                            'permissions' => ['admin.design'],
                        ],
                        [
                            'title'       => 'CSS Personalizado',
                            'icon'        => 'fa fa-css3',
                            'url'         => route('admin::design::css'),
                            'permissions' => ['admin.design'],
                        ],
                    ],
                ],
            ],
            [
                'title' => 'Bloques',
                'menu'  => [
                    'title'   => 'Bloques',
                    'icon'    => 'fa fa-clone',
                    'url'     => 'javascript:;',
                    'base'    => 'admin/design*',
                    'submenu' => [
                        [
                            'title'       => 'Bloques',
                            'icon'        => 'fa fa-clone',
                            'url'         => route('admin::design::widgets::index'),
                            'permissions' => ['admin.design', 'admin.design.view'],
                        ],
                        [
                            'title'       => 'Crear bloque',
                            'icon'        => 'fa fa-plus-square',
                            'url'         => route('admin::design::widgets::create'),
                            'permissions' => ['admin.design'],
                        ],
                        [
                            'title'       => 'Bloques eliminados',
                            'icon'        => 'fa fa-trash',
                            'url'         => route('admin::design::widgets::deleted'),
                            'permissions' => ['admin.design'],
                        ],
                    ],
                ],
            ],
        ];
    }
}
