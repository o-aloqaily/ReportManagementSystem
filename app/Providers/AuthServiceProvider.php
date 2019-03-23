<?php

namespace App\Providers;

use App\Report;
use App\File;
use App\Group;
use App\Policies\ReportPolicy;
use App\Policies\FilePolicy;
use App\Policies\GroupPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Report::class => ReportPolicy::class,
        Group::class => GroupPolicy::class,
        File::class => FilePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Gate::define('accessReportFile', function ($user, $filePath) {
        //     if ($user->isAdmin())
        //         return true;

        //     foreach($user->groups as $group) {
        //         foreach($group->reports as $report) {
        //             if ($report->files->contains('path', $filePath))
        //                return true;
        //         }
        //     }
        //     return false;
        // });
    }
}
