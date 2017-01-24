<?php

namespace App\Http\Controllers\Admin\Finances;

use App\Helpers\Traits\FilterBy;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Finances\StoreRequest;
use App\Http\Requests\Finances\UpdateRequest;
use App\Models\Finances\Finance;
use Illuminate\Http\Request;

class FinancesController extends BaseAdminController
{
    use FilterBy;

    protected $finance;

    public function __construct(Finance $finance)
    {
        parent::__construct();

        $this->finance = $finance;
    }

    public function index(Request $request)
    {
        $this->authorize('view', Finance::class);

        $total = $this->finance->count();
        $finances = $this->filterBy($this->finance, $request, ['title', 'type', 'amount', 'reason', 'executed_at'])
            ->orderBy('executed_at', 'DESC')
            ->paginate(25);

        return view('finances.index', compact('finances', 'request', 'total'));
    }

    public function stats()
    {
        $this->authorize('view', Finance::class);

        $finances = $this->finance;

        return view('finances.stats', compact('finances'));
    }

    public function deleted(Request $request)
    {
        $total = $this->finance->onlyTrashed()->count();
        $finances = $this->filterBy($this->finance->onlyTrashed(), $request, ['title', 'type', 'amount', 'reason', 'executed_at'])
            ->orderBy('executed_at', 'DESC')
            ->paginate(25);

        return view('finances.deleted', compact('finances', 'request', 'total'));
    }

    public function show($id)
    {
        $this->authorize('view', Finance::class);

        $finances = $this->finance
            ->findOrFail($id);

        return view('finances.show', compact('finances'));
    }

    public function create()
    {
        $this->authorize('create', Finance::class);

        return view('finances.create');
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', Finance::class);

        $finances = $this->finance
            ->create($request->all());

        flash('Registro creado correctamente.');

        return redirect()->route('admin::finances::edit', ['id' => $finances->id]);
    }

    public function edit($id)
    {
        $finances = $this->finance
            ->findOrFail($id);
        $this->authorize('update', $finances);

        return view('finances.edit', compact('finances'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $finances = $this->finance->findOrFail($id);
        $this->authorize('update', $finances);
        $finances->update($request->all());

        flash('Registro actualizado correctamente.');

        return redirect()->route('admin::finances::edit', ['id' => $id]);
    }

    public function restore(Request $request, $id)
    {
        $finances = $this->finance
            ->withTrashed()
            ->where('id', $id)->firstOrFail();

        $this->authorize('delete', $finances);

        $finances->restore();

        flash('Registro recuperado correctamente.');

        return redirect()->route('admin::finances::index');
    }

    public function delete($id)
    {
        $finances = $this->finance
            ->withTrashed()
            ->where('id', $id)
            ->firstOrFail();

        $this->authorize('delete', $finances);

        $finances->delete();

        flash('Registro eliminado correctamente.');

        return redirect()->route('admin::finances::index');
    }

    public function getSidebar()
    {
        return [
            [
                'title' => 'Finanzas',
                'menu'  => [
                    'title'   => 'Finanzas',
                    'icon'    => 'fa fa-bar-chart',
                    'url'     => 'javascript:;',
                    'base'    => 'admin/finances*',
                    'submenu' => [
                        [
                            'title' => 'Listado',
                            'icon'  => 'fa fa-reorder',
                            'url'   => route('admin::finances::index'),
                        ],
                        [
                            'title'       => 'Añadir registro',
                            'icon'        => 'fa fa-plus-square',
                            'url'         => route('admin::finances::create'),
                            'permissions' => ['admin.finances'],
                        ],
                        [
                            'title'       => 'Registros eliminados',
                            'icon'        => 'fa fa-trash',
                            'url'         => route('admin::finances::deleted'),
                            'permissions' => ['admin.finances'],
                        ],
                    ],
                ],
            ],
        ];
    }
}
