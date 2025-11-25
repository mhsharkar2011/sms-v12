<?php

namespace App\View\Components;

use Illuminate\View\Component;

class StudentSidebar extends Component
{
    public $active;

    public function __construct($active = null)
    {
        $this->active = $active;
    }

    public function menuItems()
    {
        return [
            [
                'route' => 'student.dashboard',
                'icon' => 'dashboard',
                'label' => 'Dashboard',
                'badge' => null
            ],
            [
                'route' => 'student.attendance',
                'icon' => 'calendar_today',
                'label' => 'Attendance',
                'badge' => null
            ],
            [
                'route' => 'student.timetable',
                'icon' => 'schedule',
                'label' => 'Timetable',
                'badge' => null
            ],
            [
                'route' => 'student.subjects',
                'icon' => 'menu_book',
                'label' => 'Subjects',
                'badge' => null
            ],
            [
                'route' => 'student.homework',
                'icon' => 'assignment',
                'label' => 'Homework',
                'badge' => '2'
            ],
            [
                'route' => 'student.grades',
                'icon' => 'grade',
                'label' => 'Grades',
                'badge' => null
            ],
            [
                'route' => 'student.events',
                'icon' => 'event',
                'label' => 'School Events',
                'badge' => '5'
            ],
            [
                'route' => 'student.messages',
                'icon' => 'message',
                'label' => 'Messages',
                'badge' => '3'
            ],
            [
                'route' => 'student.settings',
                'icon' => 'settings',
                'label' => 'Settings',
                'badge' => null
            ],
        ];
    }

    public function render()
    {
        return view('components.student-sidebar');
    }
}
