<aside class="w-64 bg-white shadow-lg border-r border-gray-200 flex flex-col h-screen sticky top-0">
    <div class="p-6">
        <!-- Logo -->
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-graduation-cap text-white text-lg"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-900">EduParent</h1>
                <p class="text-xs text-gray-500">Portal</p>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="mt-6 px-4 space-y-2 flex-1">
        <!-- Dashboard -->
        <a href="{{ route('parent.dashboard') }}"
           class="flex items-center space-x-3 px-4 py-3 text-gray-700 bg-blue-50 rounded-lg border-l-4 border-blue-500">
            <i class="fas fa-home text-blue-600 w-5"></i>
            <span class="font-medium">Dashboard</span>
        </a>

        <!-- Children -->
        <a href="{{ route('parent.children') }}"
           class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg hover:text-gray-900 transition-colors">
            <i class="fas fa-users text-gray-400 w-5"></i>
            <span class="font-medium">My Children</span>
        </a>

        <!-- Attendance -->
        <a href="{{ route('parent.attendance') }}"
           class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg hover:text-gray-900 transition-colors">
            <i class="fas fa-calendar-check text-gray-400 w-5"></i>
            <span class="font-medium">Attendance</span>
        </a>

        <!-- Grades -->
        <a href="{{ route('parent.grades') }}"
           class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg hover:text-gray-900 transition-colors">
            <i class="fas fa-chart-bar text-gray-400 w-5"></i>
            <span class="font-medium">Grades & Reports</span>
        </a>

        <!-- Homework -->
        <a href="{{ route('parent.homework') }}"
           class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg hover:text-gray-900 transition-colors">
            <i class="fas fa-tasks text-gray-400 w-5"></i>
            <span class="font-medium">Homework</span>
            <span class="ml-auto bg-orange-100 text-orange-800 text-xs px-2 py-1 rounded-full">3</span>
        </a>

        <!-- Messages -->
        <a href="{{ route('parent.messages') }}"
           class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg hover:text-gray-900 transition-colors">
            <i class="fas fa-comments text-gray-400 w-5"></i>
            <span class="font-medium">Messages</span>
            <span class="ml-auto bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">5</span>
        </a>

        <!-- Events -->
        <a href="{{ route('parent.events') }}"
           class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg hover:text-gray-900 transition-colors">
            <i class="fas fa-calendar-alt text-gray-400 w-5"></i>
            <span class="font-medium">School Events</span>
        </a>

        <!-- Fees -->
        <a href="{{ route('parent.fees') }}"
           class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg hover:text-gray-900 transition-colors">
            <i class="fas fa-receipt text-gray-400 w-5"></i>
            <span class="font-medium">Fee Payments</span>
        </a>

        <!-- Divider -->
        <div class="border-t border-gray-200 my-4"></div>

        <!-- Settings -->
        <a href="{{ route('parent.settings') }}"
           class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg hover:text-gray-900 transition-colors">
            <i class="fas fa-cog text-gray-400 w-5"></i>
            <span class="font-medium">Settings</span>
        </a>

        <!-- Help -->
        <a href="{{ route('parent.help') }}"
           class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg hover:text-gray-900 transition-colors">
            <i class="fas fa-question-circle text-gray-400 w-5"></i>
            <span class="font-medium">Help & Support</span>
        </a>
    </nav>

    <!-- User Profile Section -->
    <div class="p-4 border-t border-gray-200 bg-white">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-600 rounded-full flex items-center justify-center text-white font-bold">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-500 truncate">Parent Account</p>
            </div>
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="p-2 text-gray-400 hover:text-gray-600 transition-colors"
               title="Logout">
                <i class="fas fa-sign-out-alt"></i>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    </div>
</aside>
