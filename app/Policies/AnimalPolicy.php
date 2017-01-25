<?php

namespace App\Policies;

use App\Models\Users\User;
use App\Models\Animals\Animal;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnimalPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function view(User $user)
    {
        return $user->hasPermissions([
            'admin.panel.animals',
            'admin.panel.animals.view',
        ]);
    }

    public function create(User $user)
    {
        return $user->hasPermissions([
            'admin.panel.animals',
        ]);
    }

    public function update(User $user, Animal $animal)
    {
        if (!in_array($animal->kind, $user->animalsAllPermissions())) {
            return false;
        }

        return $user->hasPermissions([
            'admin.panel.animals',
        ]);
    }

    public function delete(User $user, Animal $animal)
    {
        if (!in_array($animal->kind, $user->animalsAllPermissions())) {
            return false;
        }

        return $user->hasPermissions([
            'admin.panel.animals',
        ]);
    }
}
