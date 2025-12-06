<?php

namespace App\Providers;

use App\View\Composers\StudentSidebarComposer;
use App\View\Composers\TeacherSidebarComposer;
use App\View\Composers\GuardianSidebarComposer;
use App\View\Composers\AdminSidebarComposer;
use App\View\Composers\QuickStatsComposer;
use App\View\Composers\StudentStatsComposer;
use App\View\Composers\SystemInfoComposer;
use App\View\Composers\TeacherStatsComposer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('components.admin-sidebar', AdminSidebarComposer::class);
        View::composer('components.teacher-sidebar', TeacherSidebarComposer::class);
        View::composer('components.student-sidebar', StudentSidebarComposer::class);
        View::composer('components.guardian-sidebar', GuardianSidebarComposer::class);
        View::composer('dashboards.admin-dashboard', QuickStatsComposer::class);
        View::composer('admin.*', QuickStatsComposer::class);
        View::composer('admin.*', SystemInfoComposer::class);
    }
}
