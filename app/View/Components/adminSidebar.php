<?php

namespace App\View\Components;

use App\Models\User;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

class AdminSidebar extends Component
{
    public $activeRoute;
    public $user;
    public $compact = false;
    public $menuItems;
    public $bottomMenuItems;
    public $quickStats;
    public $activeStates = [];

    public function __construct($activeRoute = null, $compact = false)
    {
        $this->activeRoute = $activeRoute;
        $this->user = auth()->user();
        $this->compact = $compact;
        $this->menuItems = $this->getMenuItems();
        $this->bottomMenuItems = $this->getBottomMenuItems();
        $this->quickStats = $this->getQuickStats();
        $this->activeStates = $this->calculateActiveStates();
    }

    protected function getMenuItems()
    {
        $user = auth()->user();
        $pendingUsersCount = User::where('status', 'active')->count();
        $totalUserCount = User::count();
        $adminUserCount = User::role('admin')->count();
        $studentUserCount = User::role('student')->count();
        $teacherUserCount = User::role('teacher')->count();
        $parentUserCount = User::role('parent')->count();

        $items = [
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
                'route' => 'admin.teachers',
                'icon' => '👨‍🏫',
                'label' => 'Teachers',
                'description' => 'Faculty management',
                'badge' => $teacherUserCount,
                'badgeColor' => 'bg-green-500'
            ],
            // [
            //     'route' => 'admin.classes',
            //     'icon' => '🏫',
            //     'label' => 'Classes',
            //     'description' => 'Class management',
            //     'badge' => '15'
            // ],
             [
                'route' => 'admin.classes.index',
                'icon' => '🏫',
                'label' => 'Classes',
                'description' => 'Class management',
                'badge' => '15'
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
        return array_filter($items, function ($item) {
            try {
                return Route::has($item['route']);
            } catch (\Exception $e) {
                return false;
            }
        });
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
        $totalUserPending = User::where('status', 'pending')->count();
        return [
            'total_students' => $totalStudent,
            'total_teachers' => $totalTeacher,
            'attendance_today' => '94%',
            'pending_requests' => $totalUserPending,
        ];
    }

    protected function calculateActiveStates()
    {
        $activeStates = [];

        // Check all menu items
        foreach ($this->menuItems as $item) {
            try {
                $activeStates[$item['route']] = $this->isActive($item['route']);
            } catch (\Exception $e) {
                $activeStates[$item['route']] = false;
            }
        }

        // Check bottom menu items
        foreach ($this->bottomMenuItems as $item) {
            try {
                $activeStates[$item['route']] = $this->isActive($item['route']);
            } catch (\Exception $e) {
                $activeStates[$item['route']] = false;
            }
        }

        return $activeStates;
    }

    protected function isActive($route)
    {
        return $this->activeRoute === $route || Route::is($route . '*');
    }

    public function render()
    {
        return view('components.admin-sidebar', [
            'activeStates' => $this->activeStates,
        ]);
    }
}
