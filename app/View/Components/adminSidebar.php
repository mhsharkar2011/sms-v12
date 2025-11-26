<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Route;

class AdminSidebar extends Component
{
    public $activeRoute;
    public $user;
    public $compact = false;
    public $menuItems;
    public $systemItems;
    public $accountItems;
    public $quickStats;
    public $activeStates = [];

    public function __construct($activeRoute = null, $compact = false)
    {
        $this->activeRoute = $activeRoute;
        $this->user = auth()->user();
        $this->compact = $compact;
        $this->menuItems = $this->getMenuItems();
        $this->systemItems = $this->getSystemItems();
        $this->accountItems = $this->getAccountItems();
        $this->quickStats = $this->getQuickStats();
        $this->activeStates = $this->calculateActiveStates();
    }

    protected function getMenuItems()
    {
        $items = [
            [
                'route' => 'admin.dashboard',
                'icon' => '📊',
                'label' => 'Dashboard',
                'description' => 'Overview & Analytics',
                'badge' => null
            ],
            [
                'route' => 'admin.users.index',
                'icon' => '👥',
                'label' => 'User Management',
                'description' => 'Manage all users',
                'badge' => '12'
            ],
            [
                'route' => 'admin.students',
                'icon' => '🎓',
                'label' => 'Students',
                'description' => 'Student records',
                'badge' => '245'
            ],
            [
                'route' => 'admin.teachers',
                'icon' => '👨‍🏫',
                'label' => 'Teachers',
                'description' => 'Faculty management',
                'badge' => '32'
            ],
            [
                'route' => 'admin.classes',
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
            return Route::has($item['route']);
        });
    }

    protected function getSystemItems()
    {
        $items = [
            [
                'route' => 'admin.settings',
                'icon' => '⚙️',
                'label' => 'System Settings',
                'description' => 'Platform configuration',
                'badge' => null
            ],
        ];

        // Only include backup if route exists
        if (Route::has('admin.backup')) {
            $items[] = [
                'route' => 'admin.backup',
                'icon' => '💾',
                'label' => 'Backup & Restore',
                'description' => 'Data management',
                'badge' => null
            ];
        }

        // Only include logs if route exists
        if (Route::has('admin.logs')) {
            $items[] = [
                'route' => 'admin.logs',
                'icon' => '📋',
                'label' => 'System Logs',
                'description' => 'Activity tracking',
                'badge' => '12'
            ];
        }

        return $items;
    }

    protected function getAccountItems()
    {
        $items = [
            [
                'route' => 'admin.profile',
                'icon' => '👤',
                'label' => 'My Profile',
                'description' => 'Account settings'
            ],
        ];

        // Only include notifications if route exists
        if (Route::has('admin.notifications')) {
            $items[] = [
                'route' => 'admin.notifications',
                'icon' => '🔔',
                'label' => 'Notifications',
                'description' => 'Alerts & messages',
                'badge' => '7'
            ];
        }

        // Always include logout
        $items[] = [
            'route' => 'logout',
            'icon' => '🚪',
            'label' => 'Logout',
            'description' => 'Sign out securely',
            'method' => 'POST'
        ];

        return $items;
    }

    protected function getQuickStats()
    {
        return [
            'total_students' => 1245,
            'total_teachers' => 45,
            'attendance_today' => '94%',
            'pending_requests' => 8,
        ];
    }

    protected function calculateActiveStates()
    {
        $activeStates = [];

        // Check all menu items
        foreach ($this->menuItems as $item) {
            $activeStates[$item['route']] = $this->isActive($item['route']);
        }

        // Check system items
        foreach ($this->systemItems as $item) {
            $activeStates[$item['route']] = $this->isActive($item['route']);
        }

        // Check account items
        foreach ($this->accountItems as $item) {
            $activeStates[$item['route']] = $this->isActive($item['route']);
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
