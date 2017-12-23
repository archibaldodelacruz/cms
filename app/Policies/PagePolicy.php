<?php

namespace App\Policies;

use App\ProteCMS\Core\Models\Pages\Page;
use App\ProteCMS\Core\Models\Users\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PagePolicy extends BasePolicy
{
    use HandlesAuthorization;

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

    public function update(User $user, page $page)
    {
        if ($user->hasPermission('admin.panel.pages.crud')) {
            return $page->user_id === $user->id;
        }

        return $user->hasPermission('admin.panel.pages');
    }

    public function delete(User $user, page $page)
    {
        if ($user->hasPermission('admin.panel.pages.crud')) {
            return $page->user_id === $user->id;
        }

        return $user->hasPermission('admin.panel.pages');
    }
}
