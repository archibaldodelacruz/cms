<?php

namespace App\Policies;

use App\Models\Animals\Animal;
use App\Models\Users\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnimalPolicy
{
    use HandlesAuthorization;

    public function before($user)
    {
        if (!$user->isAdminOrVolunteer()) {
            return false;
        }
    }

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
        return $user->hasPermissions([
            'admin.panel.animals',
        ]);
    }

    public function delete(User $user)
    {
        return $user->hasPermissions([
            'admin.panel.animals',
        ]);
    }
}
