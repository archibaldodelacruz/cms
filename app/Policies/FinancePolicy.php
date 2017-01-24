<?php

namespace App\Policies;

use App\Models\Finances\Finance;
use App\Models\Users\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FinancePolicy
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
            'admin.finances',
            'admin.finances.view',
        ]);
    }

    public function create(User $user)
    {
        return $user->hasPermissions([
            'admin.finances',
        ]);
    }

    public function update(User $user, Finance $finance)
    {
        return $user->hasPermissions([
            'admin.finances',
        ]);
    }

    public function delete(User $user, Finance $finance)
    {
        return $user->hasPermissions([
            'admin.finances',
        ]);
    }
}
