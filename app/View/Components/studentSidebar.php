<?php

namespace App\View\Components;

use Illuminate\Container\Attributes\Auth;
use Illuminate\View\Component;

class StudentSidebar extends Component
{
    public $activeRoute;
    public $user;

    public function __construct($activeRoute = null)
    {
        $this->activeRoute = $activeRoute;
        $this->user = Auth::user();
    }

    public function menuItems()
    {
        return [
            [
                'route' => 'student.dashboard',
                'icon' => '🏠',
                'label' => 'Dashboard',
                'badge' => null,
                'description' => 'Overview & Analytics'
            ],
            [
                'route' => 'student.courses',
                'icon' => '📚',
                'label' => 'My Courses',
                'badge' => null,
                'description' => 'Enrolled Subjects'
            ],
            [
                'route' => 'student.timetable',
                'icon' => '🕒',
                'label' => 'Timetable',
                'badge' => null,
                'description' => 'Class Schedule'
            ],
            [
                'route' => 'student.attendance',
                'icon' => '📅',
                'label' => 'Attendance',
                'badge' => null,
                'description' => 'Track Presence'
            ],
            [
                'route' => 'student.assignments',
                'icon' => '📝',
                'label' => 'Assignments',
                'badge' => '3',
                'badgeColor' => 'bg-red-500',
                'description' => 'Homework & Tasks'
            ],
            [
                'route' => 'student.grades',
                'icon' => '📊',
                'label' => 'Grades',
                'badge' => null,
                'description' => 'Academic Performance'
            ],
            [
                'route' => 'student.exams',
                'icon' => '🧪',
                'label' => 'Exams',
                'badge' => '2',
                'badgeColor' => 'bg-orange-500',
                'description' => 'Tests & Results'
            ],
            [
                'route' => 'student.events',
                'icon' => '🎉',
                'label' => 'Events',
                'badge' => '5',
                'badgeColor' => 'bg-purple-500',
                'description' => 'School Activities'
            ],
            [
                'route' => 'student.messages',
                'icon' => '💬',
                'label' => 'Messages',
                'badge' => '3',
                'badgeColor' => 'bg-blue-500',
                'description' => 'Communications'
            ],
            [
                'route' => 'student.resources',
                'icon' => '📁',
                'label' => 'Resources',
                'badge' => null,
                'description' => 'Study Materials'
            ],
        ];
    }

    public function bottomMenuItems()
    {
        return [
            [
                'route' => 'student.profile',
                'icon' => '👤',
                'label' => 'Profile',
                'description' => 'Account Settings'
            ],
            [
                'route' => 'student.settings',
                'icon' => '⚙️',
                'label' => 'Settings',
                'description' => 'Preferences'
            ],
            [
                'route' => 'logout',
                'icon' => '🚪',
                'label' => 'Logout',
                'description' => 'Sign out',
                'method' => 'POST'
            ],
        ];
    }

    public function isActive($route)
    {
        return $this->activeRoute === $route || request()->routeIs($route);
    }

    public function render()
    {
        return view('components.student-sidebar');
    }
}
