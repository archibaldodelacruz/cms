<?php

namespace App\Http\Controllers\Admin\Panel\Animals;

use Exception;
use Illuminate\Http\Request;
use App\Models\Animals\Animal;
use App\Helpers\Traits\FilterBy;
use App\Http\Requests\Animals\StoreRequest;
use App\Http\Requests\Animals\UpdateRequest;
use App\Http\Controllers\Admin\BaseAdminController;
use Illuminate\Support\Facades\DB;

class AnimalsController extends BaseAdminController
{
    use FilterBy;

    protected $animal;

    public function __construct(Animal $animal)
    {
        parent::__construct();

        $this->animal = $animal;
    }

    public function index(Request $request)
    {
        $this->authorize('view', Animal::class);

        $total = $this->animal->permission()->count();
        $animals = $this->filterBy($this->animal->permission()
            ->with(['photos' => function ($query) {
                $query->orderBy('main', 'DESC');
            }]), $request, ['name', 'status', 'kind', 'gender', 'location', 'birth_date'])
            ->orderBy('name', 'ASC')
            ->paginate(30);

        return view('panel.animals.index', compact('animals', 'request', 'total'));
    }

    public function deleted(Request $request)
    {
        $this->authorize('delete', Animal::class);

        $total = $this->animal->permission()->onlyTrashed()->count();
        $animals = $this->filterBy($this->animal->permission()
            ->onlyTrashed(), $request, ['name', 'status', 'kind', 'gender', 'location'])
            ->orderBy('name', 'ASC')
            ->paginate(25);

        return view('panel.animals.deleted', compact('animals', 'request', 'total'));
    }

    public function show($id)
    {
        $this->authorize('view', Animal::class);

        $animal = $this->animal
            ->permission()
            ->findOrFail($id);

        return view('panel.animals.show', compact('animal'));
    }

    public function create()
    {
        $this->authorize('create', Animal::class);

        return view('panel.animals.create');
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', Animal::class);

        try {
            $animal = DB::transaction(function() use ($request) {
                return $this->animal->create($request->all());
            });
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors([
                'name' => 'Ha ocurrido un error al crear la ficha. Normalmente se debe a caracteres extraños en el texto del animal. Si el problema persiste, contacte con un administrador.'
            ]);
        }

        flash('Ficha creada correctamente.');

        return redirect()->route('admin::panel::animals::edit', ['id' => $animal->id]);
    }

    public function edit(Request $request, $id)
    {
        $animal = $this->animal
            ->with(['translations'])
            ->findOrFail($id);

        $this->authorize('update', $animal);

        return view('panel.animals.edit', compact('animal'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $animal = $this->animal
            ->findOrFail($id);

        $this->authorize('update', $animal);

        try {
            DB::transaction(function() use ($animal, $request) {
                $animal->update($request->all());
            });
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors([
                'name' => 'Ha ocurrido un error al actualizar la ficha. Normalmente se debe a caracteres extraños en el texto del animal. Si el problema persiste, contacte con un administrador.'
            ]);
        }

        flash('La ficha del animal se ha actualizado correctamente.');

        return redirect()->to(route('admin::panel::animals::edit', ['id' => $id]).'?langform='.$request->get('langform'));
    }

    public function restore($id)
    {
        $animal = $this->animal
            ->withTrashed()
            ->where('id', $id)
            ->firstOrFail();

        $this->authorize('delete', $animal);
        $animal->restore();

        flash('La ficha se ha recuperado correctamente.');

        return redirect()->route('admin::panel::animals::edit', ['id' => $id]);
    }

    public function delete($id)
    {
        $animal = $this->animal
            ->where('id', $id)
            ->firstOrFail();

        $this->authorize('delete', $animal);
        $animal->delete();

        flash('Ficha eliminada correctamente.');

        return redirect()->route('admin::panel::animals::index');
    }

    public function delete_translation(Request $request, $id)
    {
        $animal = $this->animal
            ->findOrFail($id);

        $this->authorize('delete', $animal);
        $animal->deleteTranslations($request->get('langform'));

        flash('La traducción de la ficha se ha eliminado correctamente.');

        return redirect()->route('admin::panel::animals::edit', ['id' => $id]);
    }
}
