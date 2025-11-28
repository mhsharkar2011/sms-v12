@php
    $baseClasses = "flex items-center w-full px-3 py-2 text-sm font-medium rounded-lg transition-colors ";
    $activeClasses = $active
        ? "bg-blue-50 text-blue-700 border-r-2 border-blue-700 "
        : "text-gray-700 hover:bg-gray-100 ";
    $compactClasses = $compact ? "justify-center" : "";
@endphp

@if(isset($item['method']) && $item['method'] === 'POST')
    <form action="{{ route($item['route']) }}" method="POST" class="w-full">
        @csrf
        <button type="submit" class="{{ $baseClasses }}{{ $activeClasses }}{{ $compactClasses }}">
            <span class="text-lg mr-3">{{ $item['icon'] }}</span>
            @if(!$compact)
                <span class="flex-1 text-left">{{ $item['label'] }}</span>
            @endif
            @if(isset($item['badge']) && $item['badge'])
                <span class="ml-2 px-2 py-1 text-xs rounded-full {{ $item['badgeColor'] ?? 'bg-gray-200' }} text-gray-800">
                    {{ $item['badge'] }}
                </span>
            @endif
        </button>
    </form>
@else
    <a href="{{ route($item['route']) }}" class="{{ $baseClasses }}{{ $activeClasses }}{{ $compactClasses }}">
        <span class="text-lg {{ $compact ? '' : 'mr-3' }}">{{ $item['icon'] }}</span>
        @if(!$compact)
            <div class="flex-1 min-w-0">
                <div class="flex items-center justify-between">
                    <span class="truncate">{{ $item['label'] }}</span>
                    @if(isset($item['badge']) && $item['badge'])
                        <span class="ml-2 px-2 py-1 text-xs rounded-full {{ $item['badgeColor'] ?? 'bg-gray-200' }} text-gray-800">
                            {{ $item['badge'] }}
                        </span>
                    @endif
                </div>
                @if(isset($item['description']) && !$compact)
                    <p class="text-xs text-gray-500 truncate mt-1">{{ $item['description'] }}</p>
                @endif
            </div>
        @endif
    </a>
@endif
