<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ParentPolicy
{
    use HandlesAuthorization;


    public function before(User $user, $ability)
    {
        // super admin can access everything
        if ($user->isAdmin()) {
            return true;
        }

        return null; //fall through to the policy method
    }
}
