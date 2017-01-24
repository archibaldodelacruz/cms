<?php

namespace App\Policies;

use App\Models\Posts\Post;
use App\Models\Users\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
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
            'admin.panel.posts',
            'admin.panel.posts.view',
            'admin.panel.posts.crud',
        ]);
    }

    public function create(User $user)
    {
        return $user->hasPermissions([
            'admin.panel.posts',
            'admin.panel.posts.crud',
        ]);
    }

    public function update(User $user, Post $post)
    {
        return $user->hasPermissions([
            'admin.panel.posts',
            'admin.panel.posts.crud',
        ]);
    }

    public function delete(User $user, Post $post)
    {
        return $user->hasPermissions([
            'admin.panel.posts',
            'admin.panel.posts.crud',
        ]);
    }
}
