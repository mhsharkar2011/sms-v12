<aside
    class="w-80 bg-gradient-to-b from-white to-gray-50 border-r border-gray-200 h-screen flex flex-col sticky top-0 transition-all duration-300 {{ $compact ? 'w-20' : '' }}">
    <!-- Header -->
    <div class="p-6 border-b border-gray-200 bg-white">
        <div class="flex items-center space-x-4">
            @if (!$compact)
                <div class="relative flex-shrink-0">
                    <img class="h-12 w-12 rounded-2xl object-cover border-2 border-white shadow-lg"
                        src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/admin-avatar.png') }}"
                        alt="{{ $user->name ?? 'Admin' }}">
                    <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-400 border-2 border-white rounded-full">
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <h2 class="text-lg font-bold text-gray-900 truncate">{{ $user->name ?? 'Administrator' }}</h2>
                    <p class="text-sm text-gray-500 truncate">Administrator</p>
                    <p class="text-xs text-gray-400 mt-1">Last login:
                        {{ $user->last_login_at?->diffForHumans() ?? 'Recently' }}</p>
                </div>
            @else
                <div class="w-full flex justify-center">
                    <div class="relative">
                        <img class="h-10 w-10 rounded-xl object-cover border-2 border-white shadow"
                            src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/admin-avatar.png') }}"
                            alt="{{ $user->name ?? 'Admin' }}">
                        <div
                            class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-400 border-2 border-white rounded-full">
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Quick Stats -->
    @if (!$compact)
        <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-blue-100">
            <div class="grid grid-cols-2 gap-3">
                <div class="text-center">
                    <p class="text-2xl font-bold text-blue-900">{{ $quickStats['total_students'] }}</p>
                    <p class="text-xs text-blue-700 font-medium">Students</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-indigo-900">{{ $quickStats['total_teachers'] }}</p>
                    <p class="text-xs text-indigo-700 font-medium">Teachers</p>
                </div>
                <div class="text-center">
                    <p class="text-xl font-bold text-green-900">{{ $quickStats['attendance_today'] }}</p>
                    <p class="text-xs text-green-700 font-medium">Attendance</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-orange-900">{{ $quickStats['pending_requests'] }}</p>
                    <p class="text-xs text-orange-700 font-medium">Pending</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Navigation Menu -->
    <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1">
        <!-- Main Navigation -->
        <div class="mb-4">
            @if (!$compact && count($menuItems) > 0)
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 mb-2">Admin Panel</p>
            @endif

            @foreach ($menuItems as $item)
                @php
                    $isActive = $activeStates[$item['route']] ?? false;
                    $baseClasses =
                        'group flex items-center w-full px-4 py-3 text-left rounded-xl transition-all duration-200 ease-in-out';
                    $activeClasses = 'bg-blue-50 text-blue-700 border border-blue-100 shadow-sm';
                    $inactiveClasses = 'text-gray-700 hover:bg-gray-50 hover:text-gray-900 hover:shadow-sm';
                    $classes = $baseClasses . ' ' . ($isActive ? $activeClasses : $inactiveClasses);
                @endphp

                @if (Route::has($item['route']))
                    <a href="{{ route($item['route']) }}" class="{{ $classes }}">
                        <span
                            class="flex-shrink-0 w-8 h-8 flex items-center justify-center text-lg rounded-lg {{ $isActive ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-600 group-hover:bg-gray-200' }}">
                            {{ $item['icon'] }}
                        </span>

                        @if (!$compact)
                            <div class="ml-3 flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium truncate">{{ $item['label'] }}</span>
                                    @if ($item['badge'])
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium text-white {{ $item['badgeColor'] ?? 'bg-red-500' }}">
                                            {{ $item['badge'] }}
                                        </span>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-500 truncate mt-0.5">{{ $item['description'] }}</p>
                            </div>
                        @endif

                        @if ($isActive && !$compact)
                            <div class="w-1 h-6 bg-blue-500 rounded-full ml-2"></div>
                        @endif
                    </a>
                @endif
            @endforeach
        </div>

        <!-- System Management -->
        @if (count($systemItems) > 0)
            <div class="mb-4">
                @if (!$compact)
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 mb-2">System</p>
                @endif

                @foreach ($systemItems as $item)
                    @php
                        $isActive = $activeStates[$item['route']] ?? false;
                        $baseClasses =
                            'group flex items-center w-full px-4 py-3 text-left rounded-xl transition-all duration-200 ease-in-out';
                        $activeClasses = 'bg-purple-50 text-purple-700 border border-purple-100 shadow-sm';
                        $inactiveClasses = 'text-gray-700 hover:bg-gray-50 hover:text-gray-900 hover:shadow-sm';
                        $classes = $baseClasses . ' ' . ($isActive ? $activeClasses : $inactiveClasses);
                    @endphp

                    @if (Route::has($item['route']))
                        <a href="{{ route($item['route']) }}" class="{{ $classes }}">
                            <span
                                class="flex-shrink-0 w-8 h-8 flex items-center justify-center text-lg rounded-lg {{ $isActive ? 'bg-purple-100 text-purple-600' : 'bg-gray-100 text-gray-600 group-hover:bg-gray-200' }}">
                                {{ $item['icon'] }}
                            </span>

                            @if (!$compact)
                                <div class="ml-3 flex-1 min-w-0">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-medium truncate">{{ $item['label'] }}</span>
                                        @if ($item['badge'])
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium text-white bg-orange-500">
                                                {{ $item['badge'] }}
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-gray-500 truncate mt-0.5">{{ $item['description'] }}</p>
                                </div>
                            @endif
                        </a>
                    @endif
                @endforeach
            </div>
        @endif

        <!-- Notifications Menu Item -->
        <div class="mb-4">
            @if (!$compact)
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 mb-2">Alerts</p>
            @endif

            @php
                $isNotificationsActive = request()->routeIs('admin.notifications');
                $baseClasses =
                    'group flex items-center w-full px-4 py-3 text-left rounded-xl transition-all duration-200 ease-in-out';
                $activeClasses = 'bg-red-50 text-red-700 border border-red-100 shadow-sm';
                $inactiveClasses = 'text-gray-700 hover:bg-gray-50 hover:text-gray-900 hover:shadow-sm';
                $notificationsClasses =
                    $baseClasses . ' ' . ($isNotificationsActive ? $activeClasses : $inactiveClasses);
                $unreadCount = auth()->user()->unreadNotifications->count();
            @endphp

            <a href="{{ route('admin.notifications') }}" class="{{ $notificationsClasses }}">
                <span
                    class="relative flex-shrink-0 w-8 h-8 flex items-center justify-center text-lg rounded-lg
                    {{ $isNotificationsActive ? 'bg-red-100 text-red-600' : 'bg-gray-100 text-gray-600 group-hover:bg-gray-200' }}">
                    <i class="fas fa-bell"></i>

                    <!-- Notification Badge for Compact Mode -->
                    @if ($compact && $unreadCount > 0)
                        <span
                            class="notification-badge-compact absolute -top-1 -right-1 w-4 h-4 bg-red-500 border-2 border-white rounded-full flex items-center justify-center">
                            <span class="text-xs font-bold text-white" style="font-size: 8px;">
                                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                            </span>
                        </span>
                    @endif
                </span>

                @if (!$compact)
                    <div class="ml-3 flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium truncate">Notifications</span>
                            @if ($unreadCount > 0)
                                <span
                                    class="notification-badge inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-500 rounded-full min-w-[20px]">
                                    {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                                </span>
                            @else
                                <span class="notification-badge hidden"></span>
                            @endif
                        </div>
                        <p class="text-xs text-gray-500 truncate mt-0.5">
                            {{ $unreadCount > 0 ? $unreadCount . ' unread notifications' : 'No new notifications' }}
                        </p>
                    </div>
                @endif

                @if ($isNotificationsActive && !$compact)
                    <div class="w-1 h-6 bg-red-500 rounded-full ml-2"></div>
                @endif
            </a>
        </div>
    </nav>

    <!-- Account Section -->
    <div class="border-t border-gray-200 bg-white p-4 space-y-1">
        @if (!$compact && count($accountItems) > 0)
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 mb-2">Account</p>
        @endif

        @foreach ($accountItems as $item)
            @php
                $isActive = $activeStates[$item['route']] ?? false;
                $baseClasses =
                    'group flex items-center w-full px-4 py-3 text-left rounded-xl transition-all duration-200 ease-in-out';
                $activeClasses = 'bg-gray-50 text-gray-900';
                $inactiveClasses = 'text-gray-600 hover:bg-gray-50 hover:text-gray-900';
                $classes = $baseClasses . ' ' . ($isActive ? $activeClasses : $inactiveClasses);
            @endphp

            @if (Route::has($item['route']))
                @if (isset($item['method']) && $item['method'] === 'POST')
                    <form method="POST" action="{{ route($item['route']) }}" class="inline w-full">
                        @csrf
                        <button type="submit" class="{{ $classes }} w-full">
                            <span
                                class="flex-shrink-0 w-8 h-8 flex items-center justify-center text-lg rounded-lg bg-gray-100 text-gray-600 group-hover:bg-gray-200">
                                {{ $item['icon'] }}
                            </span>
                            @if (!$compact)
                                <div class="ml-3 flex-1 min-w-0 text-left">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-medium block">{{ $item['label'] }}</span>
                                        @if (isset($item['badge']))
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium text-white bg-blue-500">
                                                {{ $item['badge'] }}
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-gray-500 truncate mt-0.5">{{ $item['description'] }}</p>
                                </div>
                            @endif
                        </button>
                    </form>
                @else
                    <a href="{{ route($item['route']) }}" class="{{ $classes }}">
                        <span
                            class="flex-shrink-0 w-8 h-8 flex items-center justify-center text-lg rounded-lg bg-gray-100 text-gray-600 group-hover:bg-gray-200">
                            {{ $item['icon'] }}
                        </span>
                        @if (!$compact)
                            <div class="ml-3 flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium block">{{ $item['label'] }}</span>
                                    @if (isset($item['badge']))
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium text-white bg-blue-500">
                                            {{ $item['badge'] }}
                                        </span>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-500 truncate mt-0.5">{{ $item['description'] }}</p>
                            </div>
                        @endif
                    </a>
                @endif
            @endif
        @endforeach
    </div>
</aside>

@push('scripts')
    <script>
        // Auto-refresh notification badge every 30 seconds
        function updateNotificationBadge() {
            fetch('{{ route('notifications.unread-count') }}')
                .then(response => response.json())
                .then(data => {
                    const unreadCount = data.unread_count || 0;

                    // Update regular badge
                    const badges = document.querySelectorAll('.notification-badge');
                    badges.forEach(badge => {
                        if (unreadCount > 0) {
                            badge.textContent = unreadCount > 99 ? '99+' : unreadCount;
                            badge.classList.remove('hidden');
                            badge.classList.add('inline-flex');
                        } else {
                            badge.classList.add('hidden');
                            badge.classList.remove('inline-flex');
                        }
                    });

                    // Update compact badge
                    const compactBadges = document.querySelectorAll('.notification-badge-compact');
                    compactBadges.forEach(badge => {
                        if (unreadCount > 0) {
                            const countElement = badge.querySelector('span');
                            if (countElement) {
                                countElement.textContent = unreadCount > 9 ? '9+' : unreadCount;
                            }
                            badge.style.display = 'flex';
                        } else {
                            badge.style.display = 'none';
                        }
                    });

                    // Update description text
                    const descriptionElements = document.querySelectorAll('.notification-description');
                    descriptionElements.forEach(element => {
                        if (unreadCount > 0) {
                            element.textContent = unreadCount + ' unread notifications';
                        } else {
                            element.textContent = 'No new notifications';
                        }
                    });
                })
                .catch(error => console.error('Error updating notification badge:', error));
        }

        // Initialize and set up auto-refresh
        document.addEventListener('DOMContentLoaded', function() {
            // Initial update
            updateNotificationBadge();

            // Set up auto-refresh every 30 seconds
            setInterval(updateNotificationBadge, 30000);

            // Also update when the page becomes visible again
            document.addEventListener('visibilitychange', function() {
                if (!document.hidden) {
                    updateNotificationBadge();
                }
            });
        });
    </script>
@endpush
