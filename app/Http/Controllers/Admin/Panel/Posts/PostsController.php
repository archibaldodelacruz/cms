<?php

namespace App\Http\Controllers\Admin\Panel\Posts;

use Exception;
use App\ProteCMS\Core\Models\Posts\Post;
use Illuminate\Http\Request;
use App\Helpers\Traits\FilterBy;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Posts\StoreRequest;
use App\Http\Requests\Posts\UpdateRequest;
use App\Http\Controllers\Admin\BaseAdminController;

class PostsController extends BaseAdminController
{
    use FilterBy;

    protected $post;

    public function __construct(Post $post)
    {
        parent::__construct();

        $this->post = $post;
    }

    public function index(Request $request)
    {
        $this->authorize('view', Post::class);

        $total = $this->post->count();
        $posts = $this->filterBy($this->post, $request, ['translations.title', 'status', 'published_at', 'category_id'])
            ->with(['author', 'category'])
            ->orderBy('published_at', 'DESC')
            ->paginate(25);

        return view('panel.posts.index', compact('posts', 'request', 'total'));
    }

    public function deleted(Request $request)
    {
        $this->authorize('view', Post::class);

        $total = $this->post->onlyTrashed()->count();
        $posts = $this->filterBy($this->post->onlyTrashed(), $request, ['translations.title', 'status', 'published_at', 'category_id'])
            ->with(['author', 'category'])
            ->orderBy('published_at', 'DESC')
            ->paginate(25);

        return view('panel.posts.deleted', compact('posts', 'request', 'total'));
    }

    public function create()
    {
        $this->authorize('create', Post::class);

        return view('panel.posts.create');
    }

    public function show($id)
    {
        $this->authorize('view', Post::class);

        $post = $this->post
            ->with(['author', 'category'])
            ->findOrFail($id);

        return view('panel.posts.show', compact('post'));
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', Post::class);

        try {
            $post = DB::transaction(function () use ($request) {
                return $this->post
                    ->create($request->all());
            });
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors([
                config('app.locale').'.title' => 'Ha ocurrido un error al publicar el artículo. Normalmente se debe a caracteres extraños en el cuerpo del artículo. Si el problema persiste, contacte con un administrador.',
            ]);
        }

        flash('El artículo se ha creado correctamente.');

        return redirect()->route('admin::panel::posts::edit', ['id' => $post->id]);
    }

    public function edit($id)
    {
        $post = $this->post
            ->with(['author', 'category'])
            ->findOrFail($id);

        $this->authorize('update', $post);

        return view('panel.posts.edit', compact('post'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $post = $this->post->findOrFail($id);
        $this->authorize('update', $post);

        try {
            DB::transaction(function () use ($post, $request) {
                $post->update($request->all());
            });
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors([
                config('app.locale').'.title' => 'Ha ocurrido un error al actualizar el artículo. Normalmente se debe a caracteres extraños en el cuerpo del artículo. Si el problema persiste, contacte con un administrador.',
            ]);
        }

        flash('El artículo se ha actualizado correctamente.');

        return redirect()->to(route('admin::panel::posts::edit', ['id' => $id]).'?langform='.$request->get('langform'));
    }

    public function restore($id)
    {
        $post = $this->post
            ->withTrashed()
            ->where('id', $id)->firstOrFail();

        $this->authorize('delete', $post);

        $post->restore();

        flash('El artículo se ha recuperado correctamente.');

        return redirect()->route('admin::panel::posts::index');
    }

    public function delete($id)
    {
        $post = $this->post
            ->where('id', $id)
            ->firstOrFail();

        $this->authorize('delete', $post);

        $post->delete();

        flash('El artículo se ha eliminado correctamente.');

        return redirect()->route('admin::panel::posts::index');
    }

    public function delete_translation(Request $request, $id)
    {
        $this->post
            ->findOrFail($id)
            ->deleteTranslations($request->get('langform'));

        flash('La traducción del artículo se ha eliminado correctamente.');

        return redirect()->route('admin::panel::posts::index');
    }
}
