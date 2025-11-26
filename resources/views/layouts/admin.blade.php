<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Admin Sidebar -->
        <x-admin-sidebar active-route="{{ request()->route()->getName() }}" :compact="false" />

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">@yield('title', 'Admin Dashboard')</h1>
                            <p class="text-gray-600 mt-1">@yield('subtitle', 'School Management System')</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <!-- Search, notifications, etc. -->
                            <button class="p-2 text-gray-400 hover:text-gray-600 transition-colors">
                                🔔
                                <span
                                    class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">3</span>
                            </button>
                            <div class="w-px h-6 bg-gray-300"></div>
                            <div class="flex items-center space-x-3">
                                <span class="text-sm text-gray-700">{{ auth()->user()->name }}</span>
                                <img class="h-8 w-8 rounded-full"
                                    src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('images/admin-avatar.png') }}"
                                    alt="Profile">
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>

</html>
