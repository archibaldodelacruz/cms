<?php

namespace App\Policies;

use App\Models\Pages\Page;
use App\Models\Users\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PagePolicy
{
    use HandlesAuthorization;

    public function before($user)
    {
        if (! $user->isAdminOrVolunteer()) {
            return false;
        }
    }

    public function view(User $user)
    {
        return $user->hasPermissions([
            'admin.panel.pages',
            'admin.panel.pages.view',
            'admin.panel.pages.crud',
        ]);
    }

    public function create(User $user)
    {
        return $user->hasPermissions([
            'admin.panel.pages',
            'admin.panel.pages.crud',
        ]);
    }

    public function update(User $user, Page $page)
    {
        return $user->hasPermissions([
            'admin.panel.pages',
            'admin.panel.pages.crud',
        ]);
    }

    public function delete(User $user, Page $page)
    {
        return $user->hasPermissions([
            'admin.panel.pages',
            'admin.panel.pages.crud',
        ]);
    }
}
