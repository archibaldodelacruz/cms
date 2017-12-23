<?php

namespace App\ProteCMS\Backend\Controllers\Admin\Panel\Animals;

use Illuminate\Http\Request;
use App\Helpers\Traits\FilterBy;
use App\ProteCMS\Core\Models\Animals\TemporaryHome;
use App\Http\Requests\TemporaryHomes\StoreRequest;
use App\ProteCMS\Backend\Controllers\Admin\BaseAdminController;
use App\Http\Requests\TemporaryHomes\UpdateRequest;

class TemporaryHomesController extends BaseAdminController
{
    use FilterBy;

    protected $temporary_home;

    public function __construct(TemporaryHome $temporary_home)
    {
        parent::__construct();

        $this->temporary_home = $temporary_home;
    }

    public function index(Request $request)
    {
        $this->authorize('view', TemporaryHome::class);

        $total = $this->temporary_home->count();
        $temporary_homes = $this->filterBy($this->temporary_home, $request, ['name', 'email', 'phone', 'status'])
            ->orderBy('name', 'ASC')
            ->paginate(30);

        return view('panel.temporaryhomes.index', compact('temporary_homes', 'request', 'total'));
    }

    public function deleted(Request $request)
    {
        $this->authorize('view', TemporaryHome::class);

        $total = $this->temporary_home->onlyTrashed()->count();
        $temporary_homes = $this->filterBy($this->temporary_home
            ->onlyTrashed(), $request, ['name', 'email', 'phone', 'status'])
            ->orderBy('name', 'ASC')
            ->paginate(25);

        return view('panel.temporaryhomes.deleted', compact('temporary_homes', 'request', 'total'));
    }

    public function show($id)
    {
        $this->authorize('view', TemporaryHome::class);

        $temporary_home = $this->temporary_home
            ->findOrFail($id);

        return view('panel.temporaryhomes.show', compact('temporary_home'));
    }

    public function create()
    {
        $this->authorize('create', TemporaryHome::class);

        return view('panel.temporaryhomes.create');
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', TemporaryHome::class);

        $temporary_home = $this->temporary_home
            ->create($request->all());

        flash('Casa de acogida creada correctamente.');

        return redirect()->route('admin::panel::temporaryhomes::edit', ['id' => $temporary_home->id]);
    }

    public function edit(Request $request, $id)
    {
        $temporary_home = $this->temporary_home
            ->findOrFail($id);

        $this->authorize('update', $temporary_home);

        return view('panel.temporaryhomes.edit', compact('temporary_home'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $temporary_home = $this->temporary_home
            ->findOrFail($id);

        $this->authorize('update', $temporary_home);
        $temporary_home->update($request->all());

        flash('Casa de acogida actualizada correctamente.');

        return redirect()->route('admin::panel::temporaryhomes::edit', ['id' => $id]);
    }

    public function restore($id)
    {
        $temporary_home = $this->temporary_home
            ->withTrashed()
            ->where('id', $id)
            ->firstOrFail();

        $this->authorize('delete', $temporary_home);
        $temporary_home->restore();

        flash('Casa de acogida recuperada correctamente.');

        return redirect()->route('admin::panel::temporaryhomes::edit', ['id' => $id]);
    }

    public function delete($id)
    {
        $temporary_home = $this->temporary_home
            ->where('id', $id)
            ->firstOrFail();

        $this->authorize('delete', $temporary_home);
        $temporary_home->delete();

        flash('Casa de acogida eliminada correctamente.');

        return redirect()->route('admin::panel::temporaryhomes::index');
    }
}
