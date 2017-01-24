<?php

namespace App\Http\Controllers\Admin\Panel\Veterinarians;

use App\Helpers\Traits\FilterBy;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Veterinarians\StoreRequest;
use App\Http\Requests\Veterinarians\UpdateRequest;
use App\Models\Veterinarians\Veterinary;
use Illuminate\Http\Request;

class VeterinariansController extends BaseAdminController
{
    use FilterBy;

    protected $veterinary;

    public function __construct(Veterinary $veterinary)
    {
        parent::__construct();

        $this->veterinary = $veterinary;
    }

    public function index(Request $request)
    {
        $this->authorize('view', Veterinary::class);

        $total = $this->veterinary->count();
        $veterinarians = $this->filterBy($this->veterinary, $request, ['name', 'contact_name', 'email', 'phone', 'status'])
            ->orderBy('name')
            ->paginate(self::PAGINATION);

        return view('panel.veterinarians.index', compact('veterinarians', 'request', 'total'));
    }

    public function deleted(Request $request)
    {
        $this->authorize('delete', Veterinary::class);

        $total = $this->veterinary->onlyTrashed()->count();
        $veterinarians = $this->filterBy($this->veterinary->onlyTrashed(), $request, ['name', 'contact_name', 'email', 'phone', 'status'])
            ->orderBy('name')
            ->paginate(self::PAGINATION);

        return view('panel.veterinarians.deleted', compact('veterinarians', 'request', 'total'));
    }

    public function show($id)
    {
        $this->authorize('view', Veterinary::class);

        $veterinary = $this->veterinary
            ->findOrFail($id);

        return view('panel.veterinarians.show', compact('veterinary'));
    }

    public function create()
    {
        $this->authorize('create', Veterinary::class);

        return view('panel.veterinarians.create');
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', Veterinary::class);

        $veterinary = $this->veterinary
            ->create($request->all());

        flash('Veterinario creado correctamente.');

        return redirect()->route('admin::panel::veterinarians::edit', ['id' => $veterinary->id]);
    }

    public function edit($id)
    {
        $veterinary = $this->veterinary
            ->findOrFail($id);

        $this->authorize('update', $veterinary);

        return view('panel.veterinarians.edit', compact('veterinary'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $veterinary = $this->veterinary
            ->findOrFail($id);

        $this->authorize('update', $veterinary);
        $veterinary->update($request->all());

        flash('Veterinario actualizado correctamente.');

        return redirect()->route('admin::panel::veterinarians::edit', ['id' => $id]);
    }

    public function restore($id)
    {
        $veterinary = $this->veterinary
            ->withTrashed()
            ->where('id', $id)
            ->firstOrFail();

        $this->authorize('delete', $veterinary);
        $veterinary->restore();

        flash('El veterinario se ha recuperado correctamente.');

        return redirect()->route('admin::panel::veterinarians::index');
    }

    public function delete($id)
    {
        $veterinary = $this->veterinary
            ->withTrashed()
            ->where('id', $id)
            ->firstOrFail();

        $this->authorize('delete', $veterinary);
        $veterinary->delete();

        flash('El veterinario se ha eliminado correctamente.');

        return redirect()->route('admin::panel::veterinarians::index');
    }
}
