@php
    // Set default values if variables are not defined
    $menuItems = $menuItems ?? [];
    $activeStates = $activeStates ?? [];
    $sidebarUser = $sidebarUser ?? auth()->user();
    $quickStats = $quickStats ?? [];
@endphp

<aside class="w-80 bg-gradient-to-b from-white to-gray-50 border-r border-gray-200 h-screen flex flex-col sticky top-0">
    <!-- Header -->
    <div class="p-6 border-b border-gray-200 bg-white">
        <div class="flex items-center space-x-4">
            <div class="relative">
                <img class="h-12 w-12 rounded-2xl object-cover border-2 border-white shadow-sm"
                    src="{{ $sidebarUser->avatar ? asset('storage/' . $sidebarUser->avatar) : asset('images/default-avatar.png') }}"
                    alt="{{ $sidebarUser->name }}">
                <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-400 border-2 border-white rounded-full"></div>
            </div>
            <div class="flex-1 min-w-0">
                <h2 class="text-lg font-bold text-gray-900 truncate">{{ $sidebarUser->name }}</h2>
                <p class="text-sm text-gray-500 truncate">Student</p>
                <p class="text-xs text-gray-400 mt-1">ID: {{ $sidebarUser->id }}</p>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    @if(count($menuItems) > 0)
    <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-2">
        @foreach ($menuItems as $item)
            @php
                $isActive = $activeStates[$item['route']] ?? false;
                $baseClasses = 'group flex items-center w-full px-4 py-3 text-left rounded-xl transition-all duration-200 ease-in-out';
                $activeClasses = 'bg-blue-50 text-blue-700 border border-blue-100 shadow-sm';
                $inactiveClasses = 'text-gray-700 hover:bg-gray-50 hover:text-gray-900 hover:shadow-sm';
                $classes = $baseClasses . ' ' . ($isActive ? $activeClasses : $inactiveClasses);

                // Safe route URL generation
                try {
                    $routeUrl = route($item['route']);
                } catch (\Exception $e) {
                    $routeUrl = '#';
                    $classes .= ' opacity-50 cursor-not-allowed';
                }
            @endphp

            <a href="{{ $routeUrl }}" class="{{ $classes }}"
               @if($routeUrl === '#') onclick="return false;" @endif>
                <span class="flex-shrink-0 w-8 h-8 flex items-center justify-center text-lg rounded-lg {{ $isActive ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-600 group-hover:bg-gray-200' }}">
                    {{ $item['icon'] }}
                </span>
                <div class="ml-3 flex-1 min-w-0">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium truncate">{{ $item['label'] }}</span>
                        @if (isset($item['badge']) && $item['badge'])
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium text-white {{ $item['badgeColor'] ?? 'bg-gray-400' }}">
                                {{ $item['badge'] }}
                            </span>
                        @endif
                    </div>
                    <p class="text-xs text-gray-500 truncate mt-0.5">{{ $item['description'] }}</p>
                </div>
                @if ($isActive)
                    <div class="w-1 h-6 bg-blue-500 rounded-full ml-2"></div>
                @endif
            </a>
        @endforeach
    </nav>
    @else
    <div class="flex-1 flex items-center justify-center">
        <p class="text-gray-500 text-sm">No menu items available</p>
    </div>
    @endif

    <!-- Quick Stats -->
    @if(count($quickStats) > 0)
    <div class="border-t border-gray-200 bg-white p-4">
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-100 p-4">
            <div class="grid grid-cols-2 gap-4 text-center">
                <div>
                    <p class="text-xs font-medium text-blue-700">GPA</p>
                    <p class="text-lg font-bold text-blue-900">{{ $quickStats['current_gpa'] ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-indigo-700">Attendance</p>
                    <p class="text-lg font-bold text-indigo-900">{{ $quickStats['attendance_rate'] ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif
</aside>
