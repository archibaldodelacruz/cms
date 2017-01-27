<?php

namespace App\Policies;

use App\Models\Users\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function view(User $user)
    {
        return $user->hasPermissions([
            'admin.panel.users',
            'admin.panel.users.view',
        ]);
    }

    public function create(User $user)
    {
        return $user->hasPermissions([
            'admin.panel.users',
        ]);
    }

    public function update(User $user, User $to_user)
    {
        return $user->hasPermissions([
            'admin.panel.users',
        ]);
    }

    public function delete(User $user, User $to_user)
    {
        return $user->hasPermissions([
            'admin.panel.users',
        ]);
    }
}
