@props(['active' => null])

@php
    $menuItems = [
        [
            'route' => 'admin.dashboard',
            'icon' => 'dashboard',
            'label' => 'Dashboard',
            'badge' => null,
        ],
        [
            'route' => 'admin.users',
            'icon' => 'people',
            'label' => 'User Management',
            'badge' => null,
        ],
        [
            'route' => 'admin.students',
            'icon' => 'school',
            'label' => 'Students',
            'badge' => '45',
        ],
        [
            'route' => 'admin.teachers',
            'icon' => 'person',
            'label' => 'Teachers',
            'badge' => '12',
        ],
        [
            'route' => 'admin.classes',
            'icon' => 'class',
            'label' => 'Classes',
            'badge' => null,
        ],
        [
            'route' => 'admin.subjects',
            'icon' => 'menu_book',
            'label' => 'Subjects',
            'badge' => null,
        ],
        [
            'route' => 'admin.attendance',
            'icon' => 'calendar_today',
            'label' => 'Attendance',
            'badge' => null,
        ],
        [
            'route' => 'admin.exams',
            'icon' => 'quiz',
            'label' => 'Exams & Results',
            'badge' => '3',
        ],
        [
            'route' => 'admin.reports',
            'icon' => 'assessment',
            'label' => 'Reports',
            'badge' => null,
        ],
        [
            'route' => 'admin.settings',
            'icon' => 'settings',
            'label' => 'Settings',
            'badge' => null,
        ],
    ];

    $currentRoute = Route::currentRouteName();
@endphp

<nav class="p-4 space-y-2" {{ $attributes }}>
    @foreach ($menuItems as $item)
        @php
            $isActive = $currentRoute === $item['route'];
            $baseClasses = 'flex items-center space-x-3 p-3 rounded-lg transition-colors';
            $activeClasses = 'bg-blue-50 text-blue-700 border border-blue-100';
            $inactiveClasses = 'text-gray-700 hover:bg-gray-50 hover:text-gray-900';
            $classes = $baseClasses . ' ' . ($isActive ? $activeClasses : $inactiveClasses);
        @endphp

        <a href="{{ route($item['route']) }}" class="{{ $classes }}">
            <span class="material-icons-sharp {{ $isActive ? 'text-blue-600' : 'text-gray-500' }}">
                {{ $item['icon'] }}
            </span>
            <span class="font-medium">{{ $item['label'] }}</span>

            @if ($item['badge'])
                <span class="ml-auto bg-red-500 text-white text-xs rounded-full px-2 py-1">
                    {{ $item['badge'] }}
                </span>
            @endif
        </a>
    @endforeach
</nav>
