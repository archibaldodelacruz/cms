<?php

namespace App\Policies;

use App\Models\Partners\Partner;
use App\Models\Users\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PartnerPolicy
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
            'admin.panel.partners',
            'admin.panel.partners.view',
        ]);
    }

    public function create(User $user)
    {
        return $user->hasPermissions([
            'admin.panel.partners',
        ]);
    }

    public function update(User $user, Partner $partner)
    {
        return $user->hasPermissions([
            'admin.panel.partners',
        ]);
    }

    public function delete(User $user)
    {
        return $user->hasPermissions([
            'admin.panel.partners',
        ]);
    }
}
