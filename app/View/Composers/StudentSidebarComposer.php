<?php

namespace App\View\Composers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;

class StudentSidebarComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view)
    {
        $user = auth()->user();
        $currentRoute = Route::currentRouteName();

        $view->with([
            'sidebarUser' => $user,
            'menuItems' => $this->getStudentMenuItems(),
            'activeStates' => $this->calculateActiveStates($currentRoute),
            'quickStats' => $this->getStudentQuickStats(),
        ]);
    }

    /**
     * Get menu items for student sidebar
     */
    protected function getStudentMenuItems()
    {
        return [
            [
                'route' => 'student.dashboard',
                'icon' => '📊',
                'label' => 'Dashboard',
                'description' => 'Overview & Analytics',
            ],
            [
                'route' => 'student.profile',
                'icon' => '👤',
                'label' => 'My Profile',
                'description' => 'Personal information',
            ],
            [
                'route' => 'student.courses',
                'icon' => '📚',
                'label' => 'My Courses',
                'description' => 'Course materials',
            ],
            [
                'route' => 'student.grades',
                'icon' => '📝',
                'label' => 'Grades',
                'description' => 'View results',
            ],
            [
                'route' => 'student.attendance',
                'icon' => '📅',
                'label' => 'Attendance',
                'description' => 'Track presence',
            ],
            [
                'route' => 'student.schedule',
                'icon' => '⏰',
                'label' => 'Schedule',
                'description' => 'Class timetable',
            ],
        ];
    }

    /**
     * Get quick stats for student sidebar
     */
    protected function getStudentQuickStats()
    {
        $user = auth()->user();

        return [
            'current_gpa' => '3.8',
            'attendance_rate' => '94%',
            'completed_courses' => '12',
            'pending_assignments' => '3',
        ];
    }

    /**
     * Calculate active states for menu items
     */
    protected function calculateActiveStates($currentRoute)
    {
        $menuItems = $this->getStudentMenuItems();
        $activeStates = [];

        foreach ($menuItems as $item) {
            $activeStates[$item['route']] = $this->isActive($currentRoute, $item['route']);
        }

        return $activeStates;
    }

    /**
     * Check if a route is active
     */
    protected function isActive($currentRoute, $route)
    {
        return $currentRoute === $route || str_starts_with($currentRoute, $route . '.');
    }
}
