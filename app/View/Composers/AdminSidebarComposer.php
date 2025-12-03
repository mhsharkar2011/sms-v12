<?php

namespace App\View\Composers;

use App\Models\Guardian;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

class AdminSidebarComposer
{
    public function compose(View $view)
    {
        $user = Auth::user();

        $view->with([
            'sidebarData' => $this->getSidebarData(),
            'activeRoute' => Route::currentRouteName(),
            'quickStats' => $this->getQuickStats(),
            'activeStates' => $this->calculateActiveStates(),
        ]);
    }

    protected function getSidebarData()
    {
        $totalUserCount = User::count();
        $adminUserCount = User::role('admin')->count();
        $totalStudent = Student::count();
        $totalTeacher = Teacher::count();
        $totalGuardian = Guardian::count();
        $totalClasses = SchoolClass::count();
        // $parentCount = Parent::count();

        $menuItems = [
            [
                'route' => 'admin.dashboard',
                'icon' => '📊',
                'label' => 'Dashboard',
                'description' => 'Overview & Analytics',
                'badge' => $adminUserCount,
                'badgeColor' => 'bg-blue-100'
            ],
            [
                'route' => 'admin.users.index',
                'icon' => '👥',
                'label' => 'User Management',
                'description' => 'Manage all users',
                'badge' => $totalUserCount,
                'badgeColor' => 'bg-green-100'
            ],
            [
                'route' => 'admin.students.index',
                'icon' => '🎓',
                'label' => 'Students',
                'description' => 'Student records',
                'badge' => $totalStudent,
                'badgeColor' => 'bg-red-100'
            ],
            [
                'route' => 'admin.teachers.index',
                'icon' => '👨‍🏫',
                'label' => 'Teachers',
                'description' => 'Faculty management',
                'badge' => $totalTeacher > 0 ? $totalTeacher : "NULL",
                'badgeColor' => $totalTeacher > 0 ? 'bg-green-100' : "bg-yellow-100",
            ],
             [
                'route' => 'admin.guardians.index',
                'icon' => '👨‍🏫',
                'label' => 'Guardians',
                'description' => 'GUardian management',
                'badge' => $totalGuardian > 0 ? $totalGuardian : "NULL",
                'badgeColor' => $totalGuardian > 0 ? 'bg-brown-100' : "bg-gray-100",
            ],
            [
                'route' => 'admin.classes.index',
                'icon' => '🏫',
                'label' => 'Classes',
                'description' => 'Class management',
                'badge' => $totalClasses,
                'badgeColor' => 'bg-purple-100'

            ],
            [
                'route' => 'admin.subjects.index',
                'icon' => '📚',
                'label' => 'Subjects',
                'description' => 'Course catalog',
                'badge' => Subject::where('is_active', true)->count(),
                'badgeColor' => 'bg-blue-200',

            ],
            [
                'route' => 'admin.attendance',
                'icon' => '📅',
                'label' => 'Attendance',
                'description' => 'Track presence',
                'badge' => '3',
                'badgeColor' => 'bg-red-100',
            ],
            [
                'route' => 'admin.exams',
                'icon' => '📝',
                'label' => 'Exams',
                'description' => 'Tests & results',
                'badge' => '8',
                'badgeColor' => 'bg-yellow-100',
            ],
            [
                'route' => 'admin.reports',
                'icon' => '📈',
                'label' => 'Reports',
                'description' => 'Analytics & insights',
                'badge' => "NULL",
                'badgeColor' => 'bg-yellow-100',
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
                $unreadCount = Auth::user()->unreadNotifications->count();
            }
        } catch (\Exception $e) {
            $unreadCount = 0;
        }

        return [
            [
                'label' => 'My Profile',
                'route' => 'profile.show',
                'params' => ['user' => auth()->user()],
                'icon' => '👤',
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
        $totalUserCount = User::count();
        $totalStudent = User::role('student')->count();
        $totalTeacher = User::role('teacher')->count();
        $totalClass = SchoolClass::count();
        $totalUserPending = User::where('status', 'pending')->count();

        return [
            'total_users' => $totalUserCount,
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
