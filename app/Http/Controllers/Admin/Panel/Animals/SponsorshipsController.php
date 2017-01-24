<?php

namespace App\Http\Controllers\Admin\Panel\Animals;

use App\Helpers\Traits\FilterBy;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Animals\Sponsorships\StoreRequest;
use App\Http\Requests\Animals\Sponsorships\UpdateRequest;
use App\Models\Animals\Animal;
use Illuminate\Http\Request;

class SponsorshipsController extends BaseAdminController
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
        $sponsorships = $this->filterBy($animal->sponsorships(), $request, ['name', 'email', 'donation', 'status'])
            ->orderBy('name', 'ASC')
            ->paginate(self::PAGINATION);

        return view('panel.animals.sponsorships.index', compact('animal', 'sponsorships', 'request'));
    }

    public function create($id)
    {
        $animal = $this->web->animals()->findOrFail($id);

        return view('panel.animals.sponsorships.create', compact('animal'));
    }

    public function store(StoreRequest $request, $id)
    {
        $this->web->animals()
            ->findOrFail($id)
            ->sponsorships()
            ->create($request->all());

        flash('Apadrinamiento añadido correctamente');

        return redirect()->route('admin::panel::animals::sponsorships::index', ['id' => $id]);
    }

    public function edit($animal_id, $id)
    {
        $animal = $this->web->animals()->with('sponsorships')->findOrFail($animal_id);
        $sponsorship = $animal->sponsorships()->findOrFail($id);

        return view('panel.animals.sponsorships.edit', compact('animal', 'sponsorship'));
    }

    public function update(UpdateRequest $request, $animal_id, $id)
    {
        $this->web->animals()
            ->findOrFail($animal_id)
            ->sponsorships()
            ->findOrFail($id)
            ->update($request->all());

        flash('Apadrinamiento actualizado correctamente.');

        return redirect()->route('admin::panel::animals::sponsorships::edit', ['animal_id' => $animal_id, 'id' => $id]);
    }

    public function delete($animal_id, $id)
    {
        $this->web->animals()
            ->findOrFail($animal_id)
            ->sponsorships()
            ->findOrFail($id)
            ->delete();

        flash('Apadrinamiento eliminado correctamente.');

        return redirect()->route('admin::panel::animals::sponsorships::index', ['id' => $animal_id]);
    }
}
