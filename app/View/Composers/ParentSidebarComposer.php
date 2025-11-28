<?php

namespace App\View\Composers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;

class ParentSidebarComposer
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
            'menuItems' => $this->getParentMenuItems(),
            'activeStates' => $this->calculateActiveStates($currentRoute),
            'quickStats' => $this->getParentQuickStats(),
            'children' => $this->getChildren(),
        ]);
    }

    /**
     * Get menu items for parent sidebar
     */
    protected function getParentMenuItems()
    {
        return [
            [
                'route' => 'parent.dashboard',
                'icon' => '🏠',
                'label' => 'Dashboard',
                'description' => 'Overview & Updates',
            ],
            [
                'route' => 'parent.profile',
                'icon' => '👤',
                'label' => 'My Profile',
                'description' => 'Account settings',
            ],
            [
                'route' => 'parent.children',
                'icon' => '👨‍👩‍👧‍👦',
                'label' => 'My Children',
                'description' => 'Children management',
            ],
            [
                'route' => 'parent.attendance',
                'icon' => '📅',
                'label' => 'Attendance',
                'description' => 'Track presence',
            ],
            [
                'route' => 'parent.grades',
                'icon' => '📊',
                'label' => 'Grades & Reports',
                'description' => 'Academic performance',
            ],
            [
                'route' => 'parent.homework',
                'icon' => '📚',
                'label' => 'Homework',
                'description' => 'Assignments & projects',
            ],
            [
                'route' => 'parent.schedule',
                'icon' => '⏰',
                'label' => 'School Schedule',
                'description' => 'Timetable & events',
            ],
            [
                'route' => 'parent.payments',
                'icon' => '💰',
                'label' => 'Fee Payments',
                'description' => 'Payment history',
            ],
            [
                'route' => 'parent.communications',
                'icon' => '💬',
                'label' => 'Communications',
                'description' => 'Messages & notices',
            ],
        ];
    }

    /**
     * Get quick stats for parent sidebar
     */
    protected function getParentQuickStats()
    {
        $user = auth()->user();

        return Cache::remember('parent_quick_stats_' . $user->id, 300, function () use ($user) {
            return [
                'children_count' => 2, // This would come from your database
                'total_attendance' => '96%',
                'pending_homework' => 3,
                'upcoming_events' => 2,
                'unread_messages' => 5,
            ];
        });
    }

    /**
     * Get children data (you would replace this with actual database queries)
     */
    protected function getChildren()
    {
        return [
            [
                'name' => 'Emma Wilson',
                'grade' => 'Grade 5A',
                'avatar' => 'E',
                'attendance' => '98%',
                'performance' => 'Excellent',
            ],
            [
                'name' => 'Noah Wilson',
                'grade' => 'Grade 3B',
                'avatar' => 'N',
                'attendance' => '94%',
                'performance' => 'Good',
            ],
        ];
    }

    /**
     * Calculate active states for menu items
     */
    protected function calculateActiveStates($currentRoute)
    {
        $menuItems = $this->getParentMenuItems();
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
