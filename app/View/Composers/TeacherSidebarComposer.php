<?php

namespace App\View\Composers;

use Illuminate\View\View;

class TeacherSidebarComposer
{
    public function compose(View $view)
    {
        $menuItems = [
            [
                'label' => 'Dashboard',
                'route' => 'teacher.dashboard',
                'icon' => 'fas fa-home',
            ],
            [
                'label' => 'Classes',
                'route' => 'teacher.classes',
                'icon' => 'fas fa-graduation-cap',
            ],
            [
                'label' => 'Students',
                'route' => 'teacher.students',
                'icon' => 'fas fa-users',
            ],
            [
                'label' => 'Assignments',
                'route' => 'teacher.assignments',
                'icon' => 'fas fa-tasks',
            ],
            [
                'label' => 'Grades',
                'route' => 'teacher.grades',
                'icon' => 'fas fa-chart-bar',
            ],
            [
                'label' => 'Profile',
                'route' => 'teacher.profile',
                'icon' => 'fas fa-user',
            ],
        ];

        $view->with('menuItems', $menuItems);
    }
}
