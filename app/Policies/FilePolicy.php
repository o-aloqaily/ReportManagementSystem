<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Policies\ParentPolicy;

class FilePolicy extends ParentPolicy
{
    use HandlesAuthorization;


    public function accessReportFile(User $user, $filePath) {
        // the file is belonging to one of the groups that the user is given
        // the permissions for.
        return $user->groups->pluck('reports')->flatten()->pluck('files')
            ->flatten()->contains('path', $filePath);
    }


}
