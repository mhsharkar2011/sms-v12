<?php
// app/View/Composers/TeacherComposer.php

namespace App\View\Composers;

use App\Models\User;
use Illuminate\View\View;

class TeacherStatsComposer
{
    public function compose(View $view)
    {
        $view->with([
            'stats' => $this->getTeacherStats(),
        ]);
    }

    protected function getTeacherStats()
    {
        return [
            'total_teachers' => User::role('teacher')->count(),
            'totalUsers' => User::count(),
            'activeUsers' => User::where('status','active')->count(),
            'pendingUsers' => User::where('status','pending')->count(),
            'inActiveUsers' => User::where('status','inactive')->count(),
            'active_teachers' => User::role('teacher')->where('status', 'active')->count(),
            'pending_teachers' => User::role('teacher')->where('status', 'pending')->count(),
            'inactive_teachers' => User::role('teacher')->where('status', 'inactive')->count(),
            'avg_class_size' => 25, // You can calculate this based on your data
        ];
    }
}
