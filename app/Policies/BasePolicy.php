<?php

namespace App\Policies;

abstract class BasePolicy
{
    public function before($user)
    {
        if (! $user->isAdminOrVolunteer()) {
            return false;
        }

        if ($user->isAdmin()) {
            return true;
        }
    }
}
