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
                <p class="text-sm text-gray-500 truncate">
                    @if($sidebarUser->hasRole('admin'))
                        <span class="inline-flex items-center px-2 py-1 bg-purple-100 text-purple-800 text-xs rounded-full">
                            <span class="w-1.5 h-1.5 bg-purple-500 rounded-full mr-1"></span>
                            Administrator
                        </span>
                    @elseif($sidebarUser->hasRole('teacher'))
                        <span class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                            <span class="w-1.5 h-1.5 bg-blue-500 rounded-full mr-1"></span>
                            Teacher
                        </span>
                    @elseif($sidebarUser->hasRole('student'))
                        <span class="inline-flex items-center px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1"></span>
                            Student
                        </span>
                    @else
                        <span class="inline-flex items-center px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">
                            <span class="w-1.5 h-1.5 bg-gray-500 rounded-full mr-1"></span>
                            User
                        </span>
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="p-4 border-b border-gray-200 bg-white">
        <div class="grid grid-cols-2 gap-2">
            <!-- Create Class Button -->
            <a href="{{ route('admin.classes.create') }}"
               class="flex items-center justify-center space-x-2 bg-blue-600 text-white px-3 py-2 rounded-lg text-sm hover:bg-blue-700 transition-colors">
                <span class="material-icons-sharp text-sm">add</span>
                <span>New Class</span>
            </a>

            <!-- Quick Assign -->
            <div class="relative group">
                <button class="w-full flex items-center justify-center space-x-2 border border-gray-300 text-gray-700 px-3 py-2 rounded-lg text-sm hover:bg-gray-50 transition-colors">
                    <span class="material-icons-sharp text-sm">group_add</span>
                    <span>Assign</span>
                </button>
                <!-- Dropdown Menu -->
                <div class="absolute left-0 right-0 mt-1 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-10 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                    <a href="#" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center space-x-2">
                        <span class="material-icons-sharp text-sm text-green-600">person_add</span>
                        <span>Assign Student</span>
                    </a>
                    <a href="#" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center space-x-2">
                        <span class="material-icons-sharp text-sm text-blue-600">person</span>
                        <span>Assign Teacher</span>
                    </a>
                    <a href="#" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center space-x-2">
                        <span class="material-icons-sharp text-sm text-purple-600">class</span>
                        <span>Assign Class</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    @if(isset($adminMenuItems) && count($adminMenuItems) > 0)
    <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1">
        <!-- Dashboard Section -->
        <div class="mb-4">
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 mb-3">Main Navigation</h3>
            @foreach ($adminMenuItems as $item)
                @if(!isset($item['section']) || $item['section'] === 'main')
                    @include('admin.partials.sidebar-menu-item', ['item' => $item])
                @endif
            @endforeach
        </div>

        <!-- Academic Section -->
        @php $academicItems = array_filter($adminMenuItems, fn($item) => ($item['section'] ?? '') === 'academic') @endphp
        @if(count($academicItems) > 0)
        <div class="mb-4">
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 mb-3">Academic</h3>
            @foreach ($academicItems as $item)
                @include('admin.partials.sidebar-menu-item', ['item' => $item])
            @endforeach
        </div>
        @endif

        <!-- Management Section -->
        @php $managementItems = array_filter($adminMenuItems, fn($item) => ($item['section'] ?? '') === 'management') @endphp
        @if(count($managementItems) > 0)
        <div class="mb-4">
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 mb-3">Management</h3>
            @foreach ($managementItems as $item)
                @include('admin.partials.sidebar-menu-item', ['item' => $item])
            @endforeach
        </div>
        @endif

        <!-- System Section -->
        @php $systemItems = array_filter($adminMenuItems, fn($item) => ($item['section'] ?? '') === 'system') @endphp
        @if(count($systemItems) > 0)
        <div class="mb-4">
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 mb-3">System</h3>
            @foreach ($systemItems as $item)
                @include('admin.partials.sidebar-menu-item', ['item' => $item])
            @endforeach
        </div>
        @endif
    </nav>
    @else
    <div class="flex-1 flex items-center justify-center">
        <div class="text-center">
            <span class="material-icons-sharp text-gray-300 text-4xl mb-2">menu</span>
            <p class="text-gray-500 text-sm">No menu items available</p>
        </div>
    </div>
    @endif

    <!-- Quick Stats -->
    <div class="border-t border-gray-200 bg-white p-4 space-y-3">
        <!-- System Stats -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-100 p-4">
            <h4 class="text-xs font-semibold text-blue-900 uppercase tracking-wider mb-3">Quick Stats</h4>
            <div class="grid grid-cols-2 gap-4 text-center">
                <div>
                    <p class="text-xs font-medium text-blue-700">Students</p>
                    <p class="text-lg font-bold text-blue-900">{{ $sidebarQuickStats['total_students'] ?? 0 }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-indigo-700">Teachers</p>
                    <p class="text-lg font-bold text-indigo-900">{{ $sidebarQuickStats['total_teachers'] ?? 0 }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-purple-700">Classes</p>
                    <p class="text-lg font-bold text-purple-900">{{ $sidebarQuickStats['total_classes'] ?? 0 }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-green-700">Active</p>
                    <p class="text-lg font-bold text-green-900">{{ $sidebarQuickStats['active_classes'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- System Status -->
        <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl border border-green-100 p-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                    <span class="text-xs font-medium text-green-800">System Online</span>
                </div>
                <span class="text-xs text-green-600">{{ now()->format('h:i A') }}</span>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="border-t border-gray-200 bg-white p-4">
        <div class="flex items-center justify-between">
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="flex items-center space-x-2 text-sm text-gray-600 hover:text-gray-900 transition-colors">
                <span class="material-icons-sharp text-sm">logout</span>
                <span>Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>

            <a href="{{ route('admin.settings') }}"
               class="flex items-center space-x-2 text-sm text-gray-600 hover:text-gray-900 transition-colors">
                <span class="material-icons-sharp text-sm">settings</span>
                <span>Settings</span>
            </a>
        </div>
    </div>
</aside>
