<?php

namespace App\Policies;

use App\Models\Users\User;
use App\Models\Partners\Partner;
use Illuminate\Auth\Access\HandlesAuthorization;

class PartnerPolicy extends BasePolicy
{
    use HandlesAuthorization;

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
