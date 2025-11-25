@props(['active' => null])

@php
    $currentRoute = Route::currentRouteName();
@endphp

<nav class="p-4 space-y-2" {{ $attributes }}>
    @foreach($menuItems as $item)
        @php
            $isActive = $currentRoute === $item['route'];
            $baseClasses = "flex items-center space-x-3 p-3 rounded-lg transition-colors";
            $activeClasses = "bg-blue-50 text-blue-700 border border-blue-100";
            $inactiveClasses = "text-gray-700 hover:bg-gray-50 hover:text-gray-900";
            $classes = $baseClasses . ' ' . ($isActive ? $activeClasses : $inactiveClasses);
        @endphp

        <a href="{{ route($item['route']) }}" class="{{ $classes }}">
            <span class="material-icons-sharp {{ $isActive ? 'text-blue-600' : '' }}">
                {{ $item['icon'] }}
            </span>
            <span class="font-medium">{{ $item['label'] }}</span>

            @if($item['badge'])
                <span class="ml-auto bg-red-500 text-white text-xs rounded-full px-2 py-1">
                    {{ $item['badge'] }}
                </span>
            @endif
        </a>
    @endforeach
</nav>
