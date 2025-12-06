{{-- resources/views/components/admin-sidebar.blade.php --}}
<aside class="bg-white border-r border-gray-200 w-64 flex flex-col flex-shrink-0 {{ $compact ? 'compact' : '' }}">
    <!-- Logo/Brand -->
    <div class="p-6 border-b border-gray-200">
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold">
                <img class="h-12 w-12 rounded-xl object-cover border-2 border-white shadow-sm"
                    src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('images/default-avatar.png') }}"
                    alt="{{ auth()->user()->name }}">
            </div>
            @if (!$compact)
                <div>
                    <h1 class="text-lg font-bold text-gray-900">{{ auth()->user()->name }}</h1>
                    <p class="text-xs text-gray-500">{{ auth()->user()->roles()->first()->name }}</p>
                </div>
            @endif
        </div>
    </div>

    {{-- <!-- Quick Stats -->
    @if (!$compact && !empty($quickStats))
        <div class="p-4 border-b border-gray-200 bg-gray-50">
            <div class="space-y-2">
                <div class="flex justify-between text-xs">
                    <span class="text-gray-600">Students</span>
                    <span class="font-semibold">{{ $quickStats['total_students'] }}</span>
                </div>
                <div class="flex justify-between text-xs">
                    <span class="text-gray-600">Teachers</span>
                    <span class="font-semibold">{{ $quickStats['total_teachers'] }}</span>
                </div>
                <div class="flex justify-between text-xs">
                    <span class="text-gray-600">Classes</span>
                    <span class="font-semibold">{{ $quickStats['total_classes'] }}</span>
                </div>
            </div>
        </div>
    @endif --}}

    <!-- Navigation Menu -->
    <nav class="flex-1 overflow-y-auto py-4">
        <div class="space-y-1 px-3">
            @foreach ($sidebarData['menuItems'] ?? [] as $item)
                <x-sidebar-menu-item :item="$item" :active="$activeStates[$item['route']] ?? false" :compact="$compact" />
            @endforeach
        </div>
    </nav>

    <!-- Bottom Menu -->
    <div class="border-t border-gray-200 p-4 space-y-1">
        @foreach ($sidebarData['bottomMenuItems'] ?? [] as $item)
            <x-sidebar-menu-item :item="$item" :active="$activeStates[$item['route']] ?? false" :compact="$compact" />
        @endforeach
    </div>
</aside>
