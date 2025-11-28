@php
    $isActive = $sidebarActiveStates[$item['route']] ?? false;
    $baseClasses =
        'group flex items-center w-full px-4 py-3 text-left rounded-xl transition-all duration-200 ease-in-out';
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

    // Icon colors based on activity
    $iconBaseClasses = 'flex-shrink-0 w-8 h-8 flex items-center justify-center text-lg rounded-lg transition-colors';
    $iconActiveClasses = 'bg-blue-100 text-blue-600';
    $iconInactiveClasses = 'bg-gray-100 text-gray-600 group-hover:bg-gray-200';
    $iconClasses = $iconBaseClasses . ' ' . ($isActive ? $iconActiveClasses : $iconInactiveClasses);
@endphp

<a href="{{ $routeUrl }}" class="{{ $classes }}"
    @if ($routeUrl === '#') onclick="return false;" @endif>
    <span class="{{ $iconClasses }}">
        <span class="material-icons-sharp">{{ $item['icon'] }}</span>
    </span>
    <div class="ml-3 flex-1 min-w-0">
        <div class="flex items-center justify-between">
            <span class="text-sm font-medium truncate">{{ $item['label'] }}</span>
            @if (isset($item['badge']) && $item['badge'])
                <span
                    class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium text-white {{ $item['badgeColor'] ?? 'bg-red-500' }}">
                    {{ $item['badge'] }}
                </span>
            @endif
        </div>
        @if (isset($item['description']) && $item['description'])
            <p class="text-xs text-gray-500 truncate mt-0.5">{{ $item['description'] }}</p>
        @endif
    </div>
    @if ($isActive)
        <div class="w-1 h-6 bg-blue-500 rounded-full ml-2"></div>
    @else
        <span
            class="material-icons-sharp text-gray-400 text-sm opacity-0 group-hover:opacity-100 transition-opacity">chevron_right</span>
    @endif
</a>
