<?php

namespace App\Http\Controllers\Admin\Panel\Pages;

use Exception;
use App\Models\Pages\Page;
use Illuminate\Http\Request;
use App\Helpers\Traits\FilterBy;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Pages\StoreRequest;
use App\Http\Requests\Pages\UpdateRequest;
use App\Http\Controllers\Admin\BaseAdminController;

class PagesController extends BaseAdminController
{
    use FilterBy;

    protected $page;

    public function __construct(Page $page)
    {
        parent::__construct();

        $this->page = $page;
    }

    public function index(Request $request)
    {
        $this->authorize('view', Page::class);

        $total = $this->page->count();
        $pages = $this->filterBy($this->page, $request, ['translations.title', 'status', 'published_at'])
            ->with(['author'])
            ->orderBy('published_at', 'DESC')
            ->paginate(25);

        return view('panel.pages.index', compact('pages', 'request', 'total'));
    }

    public function deleted(Request $request)
    {
        $this->authorize('view', Page::class);

        $total = $this->page->onlyTrashed()->count();
        $pages = $this->filterBy($this->page->onlyTrashed(), $request, ['translations.title', 'status', 'published_at'])
            ->with(['author'])
            ->orderBy('published_at', 'DESC')
            ->paginate(25);

        return view('panel.pages.deleted', compact('pages', 'request', 'total'));
    }

    public function create()
    {
        $this->authorize('create', Page::class);

        return view('panel.pages.create');
    }

    public function show($id)
    {
        $this->authorize('view', Page::class);

        $page = $this->page
            ->with(['author'])
            ->findOrFail($id);

        return view('panel.pages.show', compact('page'));
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', Page::class);

        try {
            $page = DB::transaction(function () use ($request) {
                return $page = $this->page
                    ->create($request->all());
            });
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors([
                config('app.locale').'.title' => 'Ha ocurrido un error al publicar la página. Normalmente se debe a caracteres extraños en el cuerpo del artículo. Si el problema persiste, contacte con un administrador.',
            ]);
        }

        flash('La página se ha creado correctamente.');

        return redirect()->route('admin::panel::pages::edit', ['id' => $page->id]);
    }

    public function edit($id)
    {
        $page = $this->page
            ->with(['author'])
            ->findOrFail($id);

        $this->authorize('update', $page);

        return view('panel.pages.edit', compact('page'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $page = $this->page->findOrFail($id);
        $this->authorize('update', $page);

        try {
            DB::transaction(function () use ($page, $request) {
                $page->update($request->all());
            });
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors([
                config('app.locale').'.title' => 'Ha ocurrido un error al actualizar la página. Normalmente se debe a caracteres extraños en el cuerpo del artículo. Si el problema persiste, contacte con un administrador.',
            ]);
        }

        flash('La página se ha actualizado correctamente.');

        return redirect()->to(route('admin::panel::pages::edit', ['id' => $id]).'?langform='.$request->get('langform'));
    }

    public function restore($id)
    {
        $page = $this->page
            ->withTrashed()
            ->where('id', $id)
            ->firstOrFail();

        $this->authorize('delete', $page);
        $page->restore();

        flash('La página se ha recuperado correctamente.');

        return redirect()->route('admin::panel::pages::index');
    }

    public function delete($id)
    {
        $page = $this->page
            ->withTrashed()
            ->where('id', $id)
            ->firstOrFail();

        $this->authorize('delete', $page);
        $page->delete();

        flash('La página se ha eliminado correctamente.');

        return redirect()->route('admin::panel::pages::index');
    }

    public function delete_translation(Request $request, $id)
    {
        $page = $this->page
            ->findOrFail($id);

        $this->authorize('delete', $page);
        $page->deleteTranslations($request->get('langform'));

        flash('La traducción de la página se ha eliminado correctamente.');

        return redirect()->route('admin::panel::pages::index');
    }
}
