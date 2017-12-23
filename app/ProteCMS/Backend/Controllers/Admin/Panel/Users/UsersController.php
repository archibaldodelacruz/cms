<?php

namespace App\ProteCMS\Backend\Controllers\Admin\Panel\Users;

use Auth;
use App\ProteCMS\Core\Models\Users\User;
use App\Mail\UserRegistered;
use Illuminate\Http\Request;
use App\Helpers\Traits\FilterBy;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Users\StoreRequest;
use App\Http\Requests\Users\UpdateRequest;
use App\ProteCMS\Backend\Controllers\Admin\BaseAdminController;

class UsersController extends BaseAdminController
{
    use FilterBy;

    protected $user;

    public function __construct(User $user)
    {
        parent::__construct();

        $this->user = $user;
    }

    public function index(Request $request)
    {
        $this->authorize('view', User::class);

        $total = $this->web->users()->count();
        $users = $this->filterBy($this->web->users(), $request, ['id', 'name', 'email', 'type', 'last_login'])
            ->orderBy('name')
            ->paginate(25);

        return view('panel.users.index', compact('users', 'request', 'total'));
    }

    public function show($id)
    {
        $this->authorize('view', User::class);

        $user = $this->web->users()
            ->findOrFail($id);

        return view('panel.users.show', compact('user'));
    }

    public function create()
    {
        $this->authorize('create', User::class);

        return view('panel.users.create');
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', User::class);

        $user = $this->web->users()
            ->create($request->all());

        if ($request->get('notification') === 'yes') {
            Mail::to($user)->send(new UserRegistered($user, $request));
        }

        flash('Usuario creado correctamente.');

        return redirect()->route('admin::panel::users::edit', ['id' => $user->id]);
    }

    public function edit($id)
    {
        $user = $this->web->users()
            ->findOrFail($id);

        $this->authorize('update', $user);

        return view('panel.users.edit', compact('user'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $data = $request->all();

        if (empty($request->get('password'))) {
            unset($data['password']);
        }

        $user = $this->web->users()
            ->findOrFail($id);

        $this->authorize('update', $user);
        $user->managePermissions($request)
            ->update($data);

        flash('Usuario actualizado correctamente.');

        return redirect()->route('admin::panel::users::edit', ['id' => $id]);
    }

    public function delete($id)
    {
        $user = $this->web->users()
            ->where('id', $id)
            ->firstOrFail();

        $this->authorize('delete', $user);

        if ($user->isAdminOrVolunteer() && $admin = $this->web->users()->where('id', '!=', $user->id)->where('type', 'admin')->first()) {
            foreach ($user->posts as $post) {
                $post->where('user_id', $user->id)->update([
                    'user_id' => $admin->id,
                ]);
            }

            foreach ($user->pages as $page) {
                $page->where('user_id', $user->id)->update([
                    'user_id' => $admin->id,
                ]);
            }
        }

        $user->delete();

        flash('El usuario se ha eliminado correctamente.');

        return redirect()->route('admin::panel::users::index');
    }

    public function read_notifications()
    {
        Auth::user()->unreadNotifications->markAsRead();

        return response()->json([
            'status' => 'success',
        ]);
    }
}
