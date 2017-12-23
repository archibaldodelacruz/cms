<?php

namespace App\Policies;

use App\ProteCMS\Core\Models\Posts\Post;
use App\ProteCMS\Core\Models\Users\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy extends BasePolicy
{
    use HandlesAuthorization;

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
        if ($user->hasPermission('admin.panel.posts.crud')) {
            return $post->user_id === $user->id;
        }

        return $user->hasPermission('admin.panel.posts');
    }

    public function delete(User $user, Post $post)
    {
        if ($user->hasPermission('admin.panel.posts.crud')) {
            return $post->user_id === $user->id;
        }

        return $user->hasPermission('admin.panel.posts');
    }
}
