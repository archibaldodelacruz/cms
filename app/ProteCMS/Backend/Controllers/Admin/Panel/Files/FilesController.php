<?php

namespace App\ProteCMS\Backend\Controllers\Admin\Panel\Files;

use App\ProteCMS\Core\Models\Files\File;
use Illuminate\Http\Request;
use App\Helpers\Traits\FilterBy;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Files\StoreRequest;
use App\Http\Requests\Files\UpdateRequest;
use App\ProteCMS\Backend\Controllers\Admin\BaseAdminController;

class FilesController extends BaseAdminController
{
    use FilterBy;

    protected $file;

    public function __construct(File $file)
    {
        parent::__construct();

        $this->file = $file;
    }

    public function index(Request $request)
    {
        $this->authorize('view', File::class);

        $total = $this->file->count();
        $files = $this->filterBy($this->file, $request, ['title', 'description'])
            ->with(['author'])
            ->orderBy('created_at', 'DESC')
            ->paginate(25);

        return view('panel.files.index', compact('files', 'request', 'total'));
    }

    public function deleted(Request $request)
    {
        $this->authorize('view', File::class);

        $total = $this->file->onlyTrashed()->count();
        $files = $this->filterBy($this->file->onlyTrashed(), $request, ['title', 'description'])
            ->with(['author'])
            ->orderBy('created_at', 'DESC')
            ->paginate(25);

        return view('panel.files.deleted', compact('files', 'request', 'total'));
    }

    public function create()
    {
        $this->authorize('create', File::class);

        return view('panel.files.create');
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', File::class);

        if (Storage::exists($this->web->getStorageFolder(false, 'uploads/'.$request->file('file')->getClientOriginalName()))) {
            $name = time().'-'.$request->file('file')->getClientOriginalName();
        } else {
            $name = $request->file('file')->getClientOriginalName();
        }

        $request->file('file')->storeAs(
            $this->web->getStorageFolder('uploads', false), $name
        );

        $data = $request->except('file');

        $data['file'] = $name;
        $data['extension'] = $request->file('file')->getClientOriginalExtension();

        $file = $this->file
            ->create($data);

        flash('El archivo se ha creado correctamente.');

        return redirect()->route('admin::panel::files::edit', ['id' => $file->id]);
    }

    public function edit($id)
    {
        $file = $this->file
            ->with(['author'])
            ->findOrFail($id);

        $this->authorize('update', $file);

        return view('panel.files.edit', compact('file'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $file = $this->file
            ->findOrFail($id);

        $this->authorize('update', $file);

        $data = $request->except('file');

        if ($request->hasFile('file')) {
            if (Storage::exists($this->web->getStorageFolder(false, 'uploads/'.$request->file('file')->getClientOriginalName()))) {
                $name = time().'-'.$request->file('file')->getClientOriginalName();
            } else {
                $name = $request->file('file')->getClientOriginalName();
            }

            $request->file('file')->storeAs(
                $this->web->getStorageFolder('uploads', false), $name
            );

            $data['file'] = $name;
            $data['extension'] = $request->file('file')->getClientOriginalExtension();

            if (Storage::exists($this->web->getStorageFolder(false, 'uploads/'.$file->file))) {
                Storage::delete($this->web->getStorageFolder(false, 'uploads/'.$file->file));
            }
        }

        $file->update($data);

        flash('El archivo se ha actualizado correctamente.');

        return redirect()->route('admin::panel::files::edit', ['id' => $id]);
    }

    public function restore($id)
    {
        $file = $this->file
            ->withTrashed()
            ->where('id', $id)->firstOrFail();

        $this->authorize('delete', $file);
        $file->restore();

        flash('El archivo se ha recuperado correctamente.');

        return redirect()->route('admin::panel::files::index');
    }

    public function delete($id)
    {
        $file = $this->file
            ->withTrashed()
            ->where('id', $id)
            ->firstOrFail();

        $this->authorize('delete', $file);
        $file->delete();

        flash('El archivo se ha eliminado correctamente.');

        return redirect()->route('admin::panel::files::index');
    }
}
