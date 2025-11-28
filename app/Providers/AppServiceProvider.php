<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('components.admin-sidebar', \App\View\Composers\AdminSidebarComposer::class);
        // Teacher sidebar composer
        View::composer('components.teacher-sidebar', \App\View\Composers\TeacherSidebarComposer::class);
        // Student sidebar composer
        View::composer('components.student-sidebar', \App\View\Composers\StudentSidebarComposer::class);
        // Parent sidebar composer
        View::composer('components.parent-sidebar', \App\View\Composers\ParentSidebarComposer::class);
        View::composer('admin.dashboard', \App\View\Composers\UserStatsComposer::class);
        View::composer('admin.*', \App\View\Composers\SystemInfoComposer::class);
    }
}
