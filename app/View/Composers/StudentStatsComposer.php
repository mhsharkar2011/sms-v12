<?php
// app/View/Composers/StudentStatsComposer.php

namespace App\View\Composers;

use App\Models\User;
use Illuminate\View\View;

class StudentStatsComposer
{
    public function compose(View $view)
    {
        $view->with([
            'stats' => $this->getStudentStats(),
            'roles' => $this->getRoles(),
        ]);
    }

    protected function getStudentStats()
    {
        $totalStudents = User::role('student')->count();
        $activeStudents = User::role('student')->where('status', 'active')->count();
        $pendingStudents = User::role('student')->where('status', 'pending')->count();
        $inactiveStudents = User::role('student')->where('status', 'inactive')->count();

        return [
            'totalStudents' => $totalStudents,
            'activeStudents' => $activeStudents,
            'pendingStudents' => $pendingStudents,
            'inactiveStudents' => $inactiveStudents,
            'activePercentage' => $totalStudents > 0 ? ($activeStudents / $totalStudents) * 100 : 0,
            'pendingPercentage' => $totalStudents > 0 ? ($pendingStudents / $totalStudents) * 100 : 0,
            'inactivePercentage' => $totalStudents > 0 ? ($inactiveStudents / $totalStudents) * 100 : 0,
        ];
    }

    protected function getRoles()
    {

        return \Spatie\Permission\Models\Role::all();
    }
}
