<?php

namespace App\Policies;

use App\ProteCMS\Core\Models\Forms\Form;
use App\ProteCMS\Core\Models\Users\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FormPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function view(User $user)
    {
        return $user->hasPermissions([
            'admin.panel.forms',
        ]);
    }

    public function create(User $user)
    {
        return $user->hasPermissions([
            'admin.panel.forms',
        ]);
    }

    public function update(User $user, Form $form)
    {
        return $user->hasPermissions([
            'admin.panel.forms',
        ]);
    }

    public function delete(User $user, Form $form)
    {
        return $user->hasPermissions([
            'admin.panel.forms',
        ]);
    }
}
