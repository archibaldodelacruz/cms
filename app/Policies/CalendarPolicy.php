<?php

namespace App\Policies;

use App\Models\Users\User;
use App\Models\Calendar\Calendar;
use Illuminate\Auth\Access\HandlesAuthorization;

class CalendarPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function view(User $user)
    {
        return $user->hasPermissions([
            'admin.calendar',
            'admin.calendar.view',
        ]);
    }

    public function create(User $user)
    {
        return $user->hasPermissions([
            'admin.calendar',
        ]);
    }

    public function update(User $user, Calendar $calendar)
    {
        return $user->hasPermissions([
            'admin.calendar',
        ]);
    }

    public function delete(User $user, Calendar $calendar)
    {
        return $user->hasPermissions([
            'admin.calendar',
        ]);
    }
}
