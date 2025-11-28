<?php

namespace App\View\Components;

use App\Models\User;
use Illuminate\Container\Attributes\Auth;
use Illuminate\View\Component;
use Symfony\Component\Routing\Route;

class StudentSidebar extends Component
{
    public $activeRoute;
    public $user;

    public function __construct($activeRoute = null)
    {
        $this->activeRoute = $activeRoute;
        $this->user = auth()->user();
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
            try {
                return Route::has($item['route']);
            } catch (\Exception $e) {
                return false;
            }
        });
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
