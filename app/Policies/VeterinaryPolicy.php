<?php

namespace App\Policies;

use App\Models\Users\User;
use App\Models\Veterinarians\Veterinary;
use Illuminate\Auth\Access\HandlesAuthorization;

class VeterinaryPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function view(User $user)
    {
        return $user->hasPermissions([
            'admin.panel.veterinarians',
            'admin.panel.veterinarians.view',
        ]);
    }

    public function create(User $user)
    {
        return $user->hasPermissions([
            'admin.panel.veterinarians',
        ]);
    }

    public function update(User $user, Veterinary $veterinary)
    {
        return $user->hasPermissions([
            'admin.panel.veterinarians',
        ]);
    }

    public function delete(User $user)
    {
        return $user->hasPermissions([
            'admin.panel.veterinarians',
        ]);
    }
}
