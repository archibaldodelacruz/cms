<?php

namespace App\Http\Controllers\Admin\Panel\Animals;

use Illuminate\Http\Request;
use App\ProteCMS\Core\Models\Animals\Animal;
use App\Helpers\Traits\FilterBy;
use App\Http\Requests\Animals\Notes\StoreRequest;
use App\Http\Requests\Animals\Notes\UpdateRequest;
use App\Http\Controllers\Admin\BaseAdminController;

class NotesController extends BaseAdminController
{
    use FilterBy;

    protected $animal;

    public function __construct(Animal $animal)
    {
        parent::__construct();

        $this->animal = $animal;
    }

    public function index(Request $request, $id)
    {
        $animal = $this->web->animals()->findOrFail($id);
        $notes = $this->filterBy($animal->notes(), $request, ['translations.title', 'published_at', 'status'])
            ->orderBy('published_at', 'DESC')
            ->paginate(self::PAGINATION);

        return view('panel.animals.notes.index', compact('animal', 'notes', 'request'));
    }

    public function create($id)
    {
        $animal = $this->web->animals()->findOrFail($id);

        return view('panel.animals.notes.create', compact('animal'));
    }

    public function store(StoreRequest $request, $id)
    {
        $this->web->animals()
            ->findOrFail($id)
            ->notes()
            ->create($request->all());

        flash('Nota añadida correctamente');

        return redirect()->route('admin::panel::animals::notes::index', ['id' => $id]);
    }

    public function edit($animal_id, $id)
    {
        $animal = $this->web->animals()->with('notes')->findOrFail($animal_id);
        $note = $animal->notes()->findOrFail($id);

        return view('panel.animals.notes.edit', compact('animal', 'note'));
    }

    public function update(UpdateRequest $request, $animal_id, $id)
    {
        $this->web->animals()
            ->findOrFail($animal_id)
            ->notes()
            ->findOrFail($id)
            ->update($request->all());

        flash('Nota actualizada correctamente.');

        return redirect()->route('admin::panel::animals::notes::edit', ['animal_id' => $animal_id, 'id' => $id]);
    }

    public function delete($animal_id, $id)
    {
        $this->web->animals()
            ->findOrFail($animal_id)
            ->notes()
            ->findOrFail($id)
            ->delete();

        flash('Nota eliminada correctamente.');

        return redirect()->route('admin::panel::animals::notes::index', ['id' => $animal_id]);
    }
}
