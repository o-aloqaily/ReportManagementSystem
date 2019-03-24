<?php

namespace App\Policies;

use App\User;
use App\Report;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\AuthorizationException;
use App\Policies\ParentPolicy;

class ReportPolicy extends ParentPolicy
{
    use HandlesAuthorization;

    public function show(User $user, Report $report)
    {
        return $user->groups->pluck('reports')->flatten()->contains($report);
    }

    public function store(User $user)
    {
        return $user->groups->contains(request()->group);
    }

    public function update(User $user, Report $report)
    {
        return $user->groups->pluck('reports')->flatten()->contains($report)
                && $user->groups->contains(request()->group);
    }

    public function delete(User $user, Report $report)
    {
        return $user->groups->pluck('reports')->flatten()->contains($report);
    }

    public function uploadFile(User $user, Report $report)
    {
        return $user->groups->pluck('reports')->flatten()->contains($report);
    }


}
