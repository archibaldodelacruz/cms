<?php

namespace App\Policies;

use App\Models\Users\User;
use App\Models\Animals\TemporaryHome;
use Illuminate\Auth\Access\HandlesAuthorization;

class TemporaryHomePolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function view(User $user)
    {
        return $user->hasPermissions([
            'admin.panel.temporaryhomes',
            'admin.panel.temporaryhomes.view',
        ]);
    }

    public function create(User $user)
    {
        return $user->hasPermissions([
            'admin.panel.temporaryhomes',
        ]);
    }

    public function update(User $user, TemporaryHome $temporaryhome)
    {
        return $user->hasPermissions([
            'admin.panel.temporaryhomes',
        ]);
    }

    public function delete(User $user, TemporaryHome $temporaryhome)
    {
        return $user->hasPermissions([
            'admin.panel.temporaryhomes',
        ]);
    }
}
