<?php

namespace App\View\Composers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;

class AdminSidebarComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view)
    {
        $user = auth()->user();
        $currentRoute = Route::currentRouteName();

        // Only add admin-specific data if user is admin
        if ($user->hasRole('admin')) {
            $adminMenuItems = $this->getAdminMenuItems();
            $view->with([
                'adminMenuItems' => $adminMenuItems,
                'sidebarActiveStates' => $this->calculateActiveStates($currentRoute, $adminMenuItems),
            ]);
        }

        // Always add basic data
        $view->with([
            'sidebarUser' => $user,
            'sidebarQuickStats' => $this->getQuickStats(),
            'sidebarCurrentRoute' => $currentRoute,
        ]);
    }

    /**
     * Get menu items for sidebar
     */
    protected function getAdminMenuItems()
    {
        return Cache::remember('admin_sidebar_menu', 3600, function () {
            $allMenuItems = [
                [
                    'route' => 'admin.dashboard',
                    'icon' => '📊',
                    'label' => 'Dashboard',
                    'description' => 'Overview & Analytics',
                    'badge' => User::role('admin')->count(),
                ],
                [
                    'route' => 'admin.users.index',
                    'icon' => '👥',
                    'label' => 'User Management',
                    'description' => 'Manage all users',
                    'badge' => User::where('status', 'active')->count(),
                    'badgeColor' => 'bg-gray-400'
                ],
                [
                    'route' => 'admin.students.index',
                    'icon' => '🎓',
                    'label' => 'Students',
                    'description' => 'Student records',
                    'badge' => User::role('student')->count(),
                    'badgeColor' => 'bg-blue-500'
                ],
                [
                    'route' => 'admin.teachers',
                    'icon' => '👨‍🏫',
                    'label' => 'Teachers',
                    'description' => 'Faculty management',
                    'badge' => User::role('teacher')->count(),
                    'badgeColor' => 'bg-green-500'
                ],
                [
                    'route' => 'admin.classes',
                    'icon' => '🏫',
                    'label' => 'Classes',
                    'description' => 'Class management',
                    'badge' => '15'
                ],
                // ... more items
            ];

            // Filter out items that don't have defined routes
            return array_filter($allMenuItems, function ($item) {
                try {
                    return Route::has($item['route']);
                } catch (\Exception $e) {
                    return false;
                }
            });
        });
    }

    /**
     * Get quick stats for sidebar
     */
    protected function getQuickStats()
    {
        return Cache::remember('admin_quick_stats', 300, function () {
            return [
                'total_students' => User::role('student')->count(),
                'total_teachers' => User::role('teacher')->count(),
                'total_admins' => User::role('admin')->count(),
                'pending_requests' => User::where('status', 'pending')->count(),
                'attendance_today' => '94%',
            ];
        });
    }

    /**
     * Calculate active states for menu items
     */
    protected function calculateActiveStates($currentRoute, $menuItems)
    {
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
        return $currentRoute === $route || (str_starts_with($currentRoute, $route . '.'));
    }
}
