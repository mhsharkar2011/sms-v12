<?php

namespace App\View\Components;

use App\Models\User;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;

class ParentSidebar extends Component
{
    public $activeRoute;
    public $user;
    public $menuItems;
    public $quickStats;
    public $children;
    public $activeStates;

    /**
     * Create a new component instance.
     */
    public function __construct($activeRoute = null)
    {
        $this->activeRoute = $activeRoute ?? Route::currentRouteName();
        $this->user = auth()->user();
        $this->menuItems = $this->getMenuItems();
        $this->quickStats = $this->getQuickStats();
        $this->children = $this->getChildren();
        $this->activeStates = $this->calculateActiveStates();
    }

    /**
     * Get menu items for parent sidebar
     */
    protected function getMenuItems()
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
    protected function getQuickStats()
    {
        return Cache::remember('parent_quick_stats_' . $this->user->id, 300, function () {
            // In a real application, you would fetch this data from your database
            return [
                'children_count' => 2,
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
        // In a real application, you would fetch this from your database
        // Example: return $this->user->children()->with('grade')->get();
        return [
            [
                'name' => 'Emma Wilson',
                'grade' => 'Grade 5A',
                'avatar' => 'E',
                'attendance' => '98%',
                'performance' => 'Excellent',
                'color' => 'blue',
            ],
            [
                'name' => 'Noah Wilson',
                'grade' => 'Grade 3B',
                'avatar' => 'N',
                'attendance' => '94%',
                'performance' => 'Good',
                'color' => 'green',
            ],
        ];
    }

    /**
     * Calculate active states for menu items
     */
    protected function calculateActiveStates()
    {
        $activeStates = [];

        foreach ($this->menuItems as $item) {
            $activeStates[$item['route']] = $this->isActive($item['route']);
        }

        return $activeStates;
    }

    /**
     * Check if a route is active
     */
    public function isActive($route)
    {
        return $this->activeRoute === $route || str_starts_with($this->activeRoute, $route . '.');
    }

    /**
     * Get the color class for performance badges
     */
    public function getPerformanceColor($performance)
    {
        return match($performance) {
            'Excellent' => 'bg-green-100 text-green-800',
            'Good' => 'bg-blue-100 text-blue-800',
            'Average' => 'bg-yellow-100 text-yellow-800',
            'Needs Improvement' => 'bg-orange-100 text-orange-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get the color class for child avatars
     */
    public function getAvatarColor($color)
    {
        return match($color) {
            'blue' => 'bg-blue-100 text-blue-600',
            'green' => 'bg-green-100 text-green-600',
            'purple' => 'bg-purple-100 text-purple-600',
            'orange' => 'bg-orange-100 text-orange-600',
            default => 'bg-gray-100 text-gray-600',
        };
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.parent-sidebar');
    }
}
