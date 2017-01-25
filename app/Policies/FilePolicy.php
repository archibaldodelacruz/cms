<?php

namespace App\Policies;

use App\Models\Files\File;
use App\Models\Users\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FilePolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function view(User $user)
    {
        return $user->hasPermissions([
            'admin.panel.files',
            'admin.panel.files.view',
        ]);
    }

    public function create(User $user)
    {
        return $user->hasPermissions([
            'admin.panel.files',
        ]);
    }

    public function update(User $user, File $file)
    {
        return $user->hasPermissions([
            'admin.panel.files',
        ]);
    }

    public function delete(User $user, File $file)
    {
        return $user->hasPermissions([
            'admin.panel.files',
        ]);
    }
}
