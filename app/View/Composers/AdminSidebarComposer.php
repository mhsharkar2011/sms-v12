<?php

namespace App\View\Composers;

use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

class AdminSidebarComposer
{
    public function compose(View $view)
    {
        $user = auth()->user();

        $view->with([
            'sidebarData' => $this->getSidebarData(),
            'activeRoute' => Route::currentRouteName(),
            'quickStats' => $this->getQuickStats(),
            'activeStates' => $this->calculateActiveStates(),
        ]);
    }

    protected function getSidebarData()
    {
        $pendingUsersCount = User::where('status', 'active')->count();
        $totalUserCount = User::count();
        $adminUserCount = User::role('admin')->count();
        $studentUserCount = User::role('student')->count();
        $teacherUserCount = User::role('teacher')->count();
        $parentUserCount = User::role('parent')->count();

        $menuItems = [
            [
                'route' => 'admin.dashboard',
                'icon' => '📊',
                'label' => 'Dashboard',
                'description' => 'Overview & Analytics',
                'badge' => $adminUserCount,
            ],
            [
                'route' => 'admin.users.index',
                'icon' => '👥',
                'label' => 'User Management',
                'description' => 'Manage all users',
                'badge' => $pendingUsersCount > 0 ? $pendingUsersCount : null,
                'badgeColor' => $pendingUsersCount > 0 ? 'bg-gray-400' : null
            ],
            [
                'route' => 'admin.students.index',
                'icon' => '🎓',
                'label' => 'Students',
                'description' => 'Student records',
                'badge' => $studentUserCount,
                'badgeColor' => 'bg-blue-500'
            ],
            [
                'route' => 'admin.teachers.index',
                'icon' => '👨‍🏫',
                'label' => 'Teachers',
                'description' => 'Faculty management',
                'badge' => $teacherUserCount,
                'badgeColor' => 'bg-green-500'
            ],
            [
                'route' => 'admin.classes.index',
                'icon' => '🏫',
                'label' => 'Classes',
                'description' => 'Class management',
                'badge' => SchoolClass::count(),
            ],
            [
                'route' => 'admin.subjects',
                'icon' => '📚',
                'label' => 'Subjects',
                'description' => 'Course catalog',
                'badge' => null
            ],
            [
                'route' => 'admin.attendance',
                'icon' => '📅',
                'label' => 'Attendance',
                'description' => 'Track presence',
                'badge' => '3'
            ],
            [
                'route' => 'admin.exams',
                'icon' => '📝',
                'label' => 'Exams',
                'description' => 'Tests & results',
                'badge' => '8'
            ],
            [
                'route' => 'admin.reports',
                'icon' => '📈',
                'label' => 'Reports',
                'description' => 'Analytics & insights',
                'badge' => null
            ],
        ];

        // Filter out items that don't have defined routes
        $filteredMenuItems = array_filter($menuItems, function ($item) {
            try {
                return Route::has($item['route']);
            } catch (\Exception $e) {
                return false;
            }
        });

        $bottomMenuItems = $this->getBottomMenuItems();

        return [
            'menuItems' => $filteredMenuItems,
            'bottomMenuItems' => $bottomMenuItems,
        ];
    }

    protected function getBottomMenuItems()
    {
        $unreadCount = 0;
        try {
            if (Schema::hasTable('notifications')) {
                $unreadCount = auth()->user()->unreadNotifications->count();
            }
        } catch (\Exception $e) {
            $unreadCount = 0;
        }

        return [
            [
                'route' => 'admin.profile',
                'icon' => '👤',
                'label' => 'My Profile',
                'description' => 'Account settings'
            ],
            [
                'route' => 'admin.notifications',
                'icon' => '🔔',
                'label' => 'Notifications',
                'description' => 'Alerts & messages',
                'badge' => $unreadCount > 0 ? $unreadCount : null,
                'badgeColor' => 'bg-red-500'
            ],
            [
                'route' => 'admin.settings',
                'icon' => '⚙️',
                'label' => 'Settings',
                'description' => 'System configuration'
            ],
            [
                'route' => 'logout',
                'icon' => '🚪',
                'label' => 'Logout',
                'description' => 'Sign out securely',
                'method' => 'POST'
            ],
        ];
    }

    protected function getQuickStats()
    {
        $totalStudent = User::role('student')->count();
        $totalTeacher = User::role('teacher')->count();
        $totalClass = SchoolClass::count();
        $totalUserPending = User::where('status', 'pending')->count();

        return [
            'total_students' => $totalStudent,
            'total_teachers' => $totalTeacher,
            'total_classes' => $totalClass,
            'attendance_today' => '94%',
            'pending_requests' => $totalUserPending,
        ];
    }

    protected function calculateActiveStates()
    {
        $activeStates = [];
        $currentRoute = Route::currentRouteName();

        $allItems = array_merge(
            $this->getSidebarData()['menuItems'],
            $this->getBottomMenuItems()
        );

        foreach ($allItems as $item) {
            $activeStates[$item['route']] = $this->isActive($item['route'], $currentRoute);
        }

        return $activeStates;
    }

    protected function isActive($route, $currentRoute)
    {
        return $currentRoute === $route || str_starts_with($currentRoute, $route . '.');
    }
}
