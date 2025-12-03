<?php
// app/View/Composers/StudentStatsComposer.php

namespace App\View\Composers;

use App\Models\Guardian;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\View\View;

class QuickStatsComposer
{
    public function compose(View $view)
    {
        $view->with([
            'stats' => $this->getQuickStats(),
            'roles' => $this->getRoles(),
        ]);
    }

    protected function getQuickStats()
    {
        $totalUserCount = User::count();
        $totalStudents = Student::count();
        $totalTeachers = Teacher::count();
        $totalParents = Guardian::count();
        $activeUsers = User::where('status', 'active')->count();
        $pendingUsers = User::where('status', 'pending')->count();
        $inactiveUsers = User::where('status', 'inactive')->count();
        $activeStudents = User::role('student')->where('status', 'active')->count();
        $pendingStudents = User::role('student')->where('status', 'pending')->count();
        $inactiveStudents = User::role('student')->where('status', 'inactive')->count();

        return [
            'active_users' => $activeUsers,
            'pending_users' => $pendingUsers,
            'inactive_users' => $inactiveUsers,
            'total_users' => $totalUserCount,
            'total_students' => $totalStudents,
            'total_teachers' => $totalTeachers,
            'total_guardians' => $totalParents,
            'activeStudents' => $activeStudents,
            'pendingStudents' => $pendingStudents,
            'inactiveStudents' => $inactiveStudents,
            'active_percentage' => $totalStudents > 0 ? ($activeStudents / $totalStudents) * 100 : 0,
            'pendingPercentage' => $totalStudents > 0 ? ($pendingStudents / $totalStudents) * 100 : 0,
            'inactivePercentage' => $totalStudents > 0 ? ($inactiveStudents / $totalStudents) * 100 : 0,
        ];
    }

    protected function getRoles()
    {

        return \Spatie\Permission\Models\Role::all();
    }
}
