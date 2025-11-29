<?php

namespace App\Providers;

use App\View\Composers\AdminSidebarComposer;
use App\View\Composers\ParentSidebarComposer;
use App\View\Composers\StudentSidebarComposer;
use App\View\Composers\StudentStatsComposer;
use App\View\Composers\SystemInfoComposer;
use App\View\Composers\TeacherSidebarComposer;
use App\View\Composers\TeacherStatsComposer;
use App\View\Composers\UserStatsComposer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('components.admin-sidebar', AdminSidebarComposer::class);
        View::composer('components.teacher-sidebar', TeacherSidebarComposer::class);
        View::composer('components.student-sidebar', StudentSidebarComposer::class);
        View::composer('components.parent-sidebar', ParentSidebarComposer::class);
        View::composer('admin.dashboard', UserStatsComposer::class);
        View::composer('admin.*', TeacherStatsComposer::class);
        View::composer('admin.students.*', StudentStatsComposer::class);
        View::composer('admin.*', SystemInfoComposer::class);
    }
}
