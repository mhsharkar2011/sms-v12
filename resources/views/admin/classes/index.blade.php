@extends('layouts.app')

@section('title', 'Class Management')

@section('content')
    <div class="min-h-screen bg-gray-50 flex">
        <x-admin-sidebar active-route="admin.classes.index" />

        <div class="flex-1 overflow-auto">
            <div class="container mx-auto p-6">
                <!-- Header with Breadcrumb -->
                <div class="mb-6">
                    <nav class="flex mb-4" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            <li class="inline-flex items-center">
                                <a href="{{ route('admin.dashboard') }}"
                                    class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                                    <span class="material-icons-sharp text-sm mr-2">dashboard</span>
                                    Dashboard
                                </a>
                            </li>
                            <li aria-current="page">
                                <div class="flex items-center">
                                    <span class="material-icons-sharp text-gray-400 text-sm mx-2">chevron_right</span>
                                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Class Management</span>
                                </div>
                            </li>
                        </ol>
                    </nav>

                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Class Management</h1>
                            <div class="flex items-center space-x-4 mt-2">
                                <p class="text-gray-600">Manage classes, assign teachers, and organize students</p>
                                <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full">
                                    {{ now()->format('F Y') }} Academic Year
                                </span>
                            </div>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('admin.classes.export') }}"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                                <span class="material-icons-sharp text-sm mr-2">download</span>
                                Export
                            </a>
                            <a href="{{ route('admin.classes.create') }}"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                <span class="material-icons-sharp text-sm mr-2">add</span>
                                Create New Class
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Advanced Stats with Charts -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                    <!-- Main Stats -->
                    <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-600">Total Classes</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ $totalClasses }}</p>
                                    <div class="flex items-center mt-1">
                                        <span class="text-xs {{ $classGrowth >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                            <span
                                                class="material-icons-sharp text-xs">{{ $classGrowth >= 0 ? 'arrow_upward' : 'arrow_downward' }}</span>
                                            {{ abs($classGrowth) }}%
                                        </span>
                                        <span class="text-xs text-gray-500 ml-2">from last term</span>
                                    </div>
                                </div>
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <span class="material-icons-sharp text-blue-600">class</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-600">Active Classes</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ $activeClasses }}</p>
                                    @if ($activeClasses > 0 || $totalClasses > 0)
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ number_format(($activeClasses / $totalClasses) * 100, 1) ?? '0' }}% of total
                                        </p>
                                    @endif
                                </div>
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                    <span class="material-icons-sharp text-green-600">check_circle</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-500">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-600">Total Students</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ $totalStudents }}</p>
                                    <div class="flex items-center mt-1">
                                        <div class="w-full bg-gray-200 rounded-full h-1.5">
                                            <div class="bg-purple-600 h-1.5 rounded-full"
                                                style="width: {{ ($totalStudents / $maxCapacity) * 100 }}%">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <span class="material-icons-sharp text-purple-600">school</span>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Stats Row -->
                        <div class="md:col-span-3 grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                            <div class="bg-white rounded-lg shadow-sm p-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                                        <span class="material-icons-sharp text-orange-600 text-sm">people</span>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Avg. Class Size</p>
                                        <p class="text-lg font-semibold text-gray-900">
                                            {{ number_format($averageClassSize, 1) }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white rounded-lg shadow-sm p-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                                        <span class="material-icons-sharp text-red-600 text-sm">warning</span>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Overcrowded Classes</p>
                                        <p class="text-lg font-semibold text-gray-900">{{ $overcrowdedClasses }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white rounded-lg shadow-sm p-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                                        <span class="material-icons-sharp text-indigo-600 text-sm">person</span>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Teacher Ratio</p>
                                        <p class="text-lg font-semibold text-gray-900">
                                            {{ number_format($teacherStudentRatio, 1) }}:1</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions Panel -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                        <div class="space-y-3">
                            <a href="{{ route('admin.classes.create') }}"
                                class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-200 transition-colors group">
                                <div
                                    class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-blue-200 transition-colors">
                                    <span class="material-icons-sharp text-blue-600 text-sm">add</span>
                                </div>
                                <span class="text-sm font-medium text-gray-700">Create New Class</span>
                            </a>
                            <button onclick="openBulkAssignModal()"
                                class="w-full flex items-center p-3 border border-gray-200 rounded-lg hover:bg-green-50 hover:border-green-200 transition-colors group">
                                <div
                                    class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-green-200 transition-colors">
                                    <span class="material-icons-sharp text-green-600 text-sm">group_add</span>
                                </div>
                                <span class="text-sm font-medium text-gray-700">Bulk Student Assignment</span>
                            </button>
                            <a href="{{ route('admin.classes.schedule') }}"
                                class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-purple-50 hover:border-purple-200 transition-colors group">
                                <div
                                    class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-purple-200 transition-colors">
                                    <span class="material-icons-sharp text-purple-600 text-sm">schedule</span>
                                </div>
                                <span class="text-sm font-medium text-gray-700">Generate Schedule</span>
                            </a>
                            <a href="{{ route('admin.classes.reports') }}"
                                class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-orange-50 hover:border-orange-200 transition-colors group">
                                <div
                                    class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-orange-200 transition-colors">
                                    <span class="material-icons-sharp text-orange-600 text-sm">assessment</span>
                                </div>
                                <span class="text-sm font-medium text-gray-700">Generate Reports</span>
                            </a>
                        </div>

                        <!-- Class Distribution -->
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <h4 class="text-sm font-medium text-gray-700 mb-3">Class Distribution by Grade</h4>
                            <div class="space-y-2">
                                @foreach ($gradeDistribution as $grade => $count)
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">Grade {{ $grade }}</span>
                                        <div class="flex items-center space-x-3">
                                            <div class="w-24 bg-gray-200 rounded-full h-2">
                                                <div class="bg-blue-600 h-2 rounded-full"
                                                    style="width: {{ ($count / max($gradeDistribution)) * 100 }}%">
                                                </div>
                                            </div>
                                            <span
                                                class="text-sm font-medium text-gray-900 w-6 text-right">{{ $count }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity & Announcements -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                    <!-- Recent Activity -->
                    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-semibold text-gray-900">Recent Activity</h3>
                            <a href="{{ route('admin.classes.activity') }}"
                                class="text-sm text-blue-600 hover:text-blue-800">
                                View All
                            </a>
                        </div>
                        <div class="space-y-4">
                            @forelse($recentActivities as $activity)
                                <div class="flex items-start space-x-3 p-3 hover:bg-gray-50 rounded-lg transition-colors">
                                    <div
                                        class="w-8 h-8 rounded-full flex items-center justify-center {{ $activity['color'] }}">
                                        <span
                                            class="material-icons-sharp text-sm text-white">{{ $activity['icon'] }}</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm text-gray-900">{{ $activity['description'] }}</p>
                                        <div class="flex items-center mt-1">
                                            <span class="text-xs text-gray-500">{{ $activity['time'] }}</span>
                                            <span class="mx-2 text-gray-300">•</span>
                                            <span
                                                class="text-xs font-medium {{ $activity['type_color'] }}">{{ $activity['type'] }}</span>
                                        </div>
                                    </div>
                                    @if ($activity['class_id'])
                                        <a href="{{ route('admin.classes.show', $activity['class_id']) }}"
                                            class="text-xs text-blue-600 hover:text-blue-800 whitespace-nowrap">
                                            View Class
                                        </a>
                                    @endif
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <span class="material-icons-sharp text-gray-400 text-4xl mb-3">notifications</span>
                                    <p class="text-gray-500">No recent activity</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Upcoming Events -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-6">Upcoming Events</h3>
                        <div class="space-y-4">
                            @forelse($upcomingEvents as $event)
                                <div class="border-l-4 border-blue-500 pl-4 py-2">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900">{{ $event['title'] }}</h4>
                                            <p class="text-xs text-gray-600 mt-1">{{ $event['description'] }}</p>
                                        </div>
                                        <span class="text-xs font-medium px-2 py-1 rounded-full bg-blue-100 text-blue-800">
                                            {{ $event['date'] }}
                                        </span>
                                    </div>
                                    <div class="flex items-center mt-2">
                                        <span class="material-icons-sharp text-gray-400 text-xs mr-1">schedule</span>
                                        <span class="text-xs text-gray-500">{{ $event['time'] }}</span>
                                        <span class="mx-2 text-gray-300">•</span>
                                        <span class="text-xs text-gray-500">{{ $event['class_count'] }} classes</span>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <span class="material-icons-sharp text-gray-400 text-4xl mb-3">event</span>
                                    <p class="text-gray-500">No upcoming events</p>
                                </div>
                            @endforelse
                        </div>

                        <!-- Academic Calendar Quick View -->
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="text-sm font-medium text-gray-700">Academic Calendar</h4>
                                <span class="text-xs text-gray-500">{{ now()->format('M Y') }}</span>
                            </div>
                            <div class="grid grid-cols-7 gap-1">
                                @foreach (['M', 'T', 'W', 'T', 'F', 'S', 'S'] as $day)
                                    <div class="text-center text-xs font-medium text-gray-500 py-1">{{ $day }}
                                    </div>
                                @endforeach
                                @for ($i = 1; $i <= 31; $i++)
                                    <div
                                        class="text-center text-xs p-1 rounded {{ in_array($i, [15, 16, 17]) ? 'bg-blue-100 text-blue-800 font-medium' : 'text-gray-700' }}">
                                        {{ $i <= 30 ? $i : '' }}
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Flash Messages -->
                @if (session('success'))
                    <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg">
                        <div class="flex items-center">
                            <span class="material-icons-sharp text-green-500 mr-3">check_circle</span>
                            <div>
                                <p class="text-green-800 font-medium">{{ session('success') }}</p>
                                @if (session('success_details'))
                                    <p class="text-green-600 text-sm mt-1">{{ session('success_details') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                @if (session('warning'))
                    <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-6 rounded-r-lg">
                        <div class="flex items-center">
                            <span class="material-icons-sharp text-yellow-500 mr-3">warning</span>
                            <div>
                                <p class="text-yellow-800 font-medium">{{ session('warning') }}</p>
                                @if (session('warning_details'))
                                    <p class="text-yellow-600 text-sm mt-1">{{ session('warning_details') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg">
                        <div class="flex items-center">
                            <span class="material-icons-sharp text-red-500 mr-3">error</span>
                            <div>
                                <p class="text-red-800 font-medium">{{ session('error') }}</p>
                                @if (session('error_details'))
                                    <p class="text-red-600 text-sm mt-1">{{ session('error_details') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Advanced Filters & Search -->
                <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Class List</h3>
                            <p class="text-sm text-gray-600">Manage and organize all classes</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open"
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                                    <span class="material-icons-sharp text-sm mr-2">filter_list</span>
                                    Advanced Filters
                                    <span class="material-icons-sharp text-sm ml-2">expand_more</span>
                                </button>

                                <!-- Dropdown Filters -->
                                <div x-show="open" @click.away="open = false"
                                    class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-200 p-4 z-10">
                                    <h4 class="font-medium text-gray-900 mb-3">Advanced Filters</h4>
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Capacity
                                                Range</label>
                                            <div class="flex items-center space-x-2">
                                                <input type="number" name="min_capacity" placeholder="Min"
                                                    class="w-24 border border-gray-300 rounded px-3 py-1 text-sm">
                                                <span class="text-gray-400">-</span>
                                                <input type="number" name="max_capacity" placeholder="Max"
                                                    class="w-24 border border-gray-300 rounded px-3 py-1 text-sm">
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Created
                                                Date</label>
                                            <select name="created_date"
                                                class="w-full border border-gray-300 rounded px-3 py-1 text-sm">
                                                <option value="">Any time</option>
                                                <option value="today">Today</option>
                                                <option value="week">This week</option>
                                                <option value="month">This month</option>
                                                <option value="year">This year</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                                            <select name="sort_by"
                                                class="w-full border border-gray-300 rounded px-3 py-1 text-sm">
                                                <option value="name">Name A-Z</option>
                                                <option value="created_at">Newest First</option>
                                                <option value="strength">Class Size</option>
                                                <option value="capacity">Capacity</option>
                                            </select>
                                        </div>
                                        <button
                                            class="w-full bg-blue-600 text-white py-2 rounded text-sm hover:bg-blue-700">
                                            Apply Filters
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="relative" x-data="{ view: 'grid' }">
                                <button @click="view = view === 'grid' ? 'list' : 'grid'"
                                    class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                                    <span class="material-icons-sharp text-sm"
                                        x-text="view === 'grid' ? 'grid_view' : 'view_list'"></span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <form method="GET" action="{{ route('admin.classes.index') }}">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <!-- Search -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Search Classes</label>
                                <div class="relative">
                                    <input type="search" name="q" value="{{ request('q') }}"
                                        class="w-full border border-gray-300 rounded-lg pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="Search by name, code, teacher, room...">
                                    <span
                                        class="material-icons-sharp absolute left-3 top-2.5 text-gray-400 text-sm">search</span>
                                </div>
                            </div>

                            <!-- Grade Level Filter -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Grade Level</label>
                                <select name="grade_level"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">All Grades</option>
                                    @foreach ($gradeLevels as $level)
                                        <option value="{{ $level }}"
                                            {{ request('grade_level') == $level ? 'selected' : '' }}>
                                            Grade {{ $level }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Status Filter -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                <select name="status"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">All Status</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>
                                        Inactive</option>
                                    <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>
                                        Archived</option>
                                </select>
                            </div>

                            <!-- Academic Year Filter -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Academic Year</label>
                                <select name="academic_year"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">All Years</option>
                                    @foreach ($academicYears as $year)
                                        <option value="{{ $year }}"
                                            {{ request('academic_year') == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Subject Filter -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                                <select name="subject"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">All Subjects</option>
                                    @foreach ($subjects as $subject)
                                        <option value="{{ $subject }}"
                                            {{ request('subject') == $subject ? 'selected' : '' }}>
                                            {{ $subject }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Capacity Filter -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Capacity</label>
                                <select name="capacity"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Any Capacity</option>
                                    <option value="under" {{ request('capacity') == 'under' ? 'selected' : '' }}>Under
                                        50%</option>
                                    <option value="balanced" {{ request('capacity') == 'balanced' ? 'selected' : '' }}>
                                        50-80% Full</option>
                                    <option value="over" {{ request('capacity') == 'over' ? 'selected' : '' }}>Over 80%
                                        Full</option>
                                    <option value="full" {{ request('capacity') == 'full' ? 'selected' : '' }}>Full
                                    </option>
                                </select>
                            </div>

                            <!-- Teacher Filter -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Teacher</label>
                                <select name="teacher_id"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">All Teachers</option>
                                    @foreach ($teachers as $teacher)
                                        <option value="{{ $teacher->id }}"
                                            {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                            {{ $teacher->user->name ?? $teacher->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3 mt-6">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                <span class="material-icons-sharp text-sm mr-2">search</span>
                                Apply Filters
                            </button>
                            <a href="{{ route('admin.classes.index') }}"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                                <span class="material-icons-sharp text-sm mr-2">refresh</span>
                                Reset Filters
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Classes Table/Grid View -->
                @if ($classes->count())
                    <!-- View Toggle -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="text-sm text-gray-600">
                            Showing {{ $classes->firstItem() }} to {{ $classes->lastItem() }} of {{ $classes->total() }}
                            classes
                            @if (request()->hasAny(['q', 'grade_level', 'status', 'academic_year']))
                                <span class="text-blue-600 ml-2">(Filtered)</span>
                            @endif
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-600">View:</span>
                            <button id="listViewBtn" class="p-2 rounded-lg bg-blue-100 text-blue-600">
                                <span class="material-icons-sharp text-sm">view_list</span>
                            </button>
                            <button id="gridViewBtn" class="p-2 rounded-lg text-gray-400 hover:text-gray-600">
                                <span class="material-icons-sharp text-sm">grid_view</span>
                            </button>
                        </div>
                    </div>

                    <!-- List View (Default) -->
                    <div id="listView" class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <input type="checkbox"
                                                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Class Details
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Teacher & Schedule
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Students & Performance
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status & Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($classes as $class)
                                        @php
                                            $progress = ($class->current_strength / $class->capacity) * 100;
                                            $teacher = $class->teachers->first() ?? $class->teacher;
                                            $avgAttendance = $class->average_attendance ?? 0;
                                            $avgGrade = $class->average_grade ?? 0;
                                        @endphp

                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <input type="checkbox"
                                                    class="class-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                                    data-class-id="{{ $class->id }}">
                                            </td>

                                            <!-- Class Details -->
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <div
                                                        class="w-12 h-12 rounded-lg flex items-center justify-center mr-4
                                                        {{ $progress >= 90
                                                            ? 'bg-red-100 text-red-600'
                                                            : ($progress >= 70
                                                                ? 'bg-yellow-100 text-yellow-600'
                                                                : 'bg-blue-100 text-blue-600') }}">
                                                        <span class="material-icons-sharp">class</span>
                                                    </div>
                                                    <div>
                                                        <a href="{{ route('admin.classes.show', $class) }}"
                                                            class="text-lg font-semibold text-gray-900 hover:text-blue-600 transition-colors block">
                                                            {{ $class->name }}
                                                        </a>
                                                        <div class="flex items-center space-x-4 mt-1">
                                                            <span class="text-sm text-gray-600">{{ $class->code }}</span>
                                                            <span class="text-xs text-gray-400">•</span>
                                                            <span
                                                                class="text-sm text-gray-600">{{ $class->room_number ?? 'No Room' }}</span>
                                                            <span class="text-xs text-gray-400">•</span>
                                                            <span
                                                                class="text-sm font-medium {{ $class->status === 'active' ? 'text-green-600' : 'text-red-600' }}">
                                                                {{ ucfirst($class->status) }}
                                                            </span>
                                                        </div>
                                                        <div class="flex items-center mt-2">
                                                            <span
                                                                class="text-xs px-2 py-1 rounded-full bg-gray-100 text-gray-700 mr-2">
                                                                Grade {{ $class->grade_level }}
                                                            </span>
                                                            <span
                                                                class="text-xs px-2 py-1 rounded-full bg-gray-100 text-gray-700">
                                                                Section {{ $class->section }}
                                                            </span>
                                                            @if ($class->academic_year)
                                                                <span
                                                                    class="text-xs px-2 py-1 rounded-full bg-blue-100 text-blue-700 ml-2">
                                                                    {{ $class->academic_year }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- Teacher & Schedule -->
                                            <td class="px-6 py-4">
                                                @if ($teacher)
                                                    <div class="flex items-center mb-3">
                                                        <div
                                                            class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-bold text-sm mr-3">
                                                            {{ substr($teacher->user->name ?? $teacher->name, 0, 1) }}
                                                        </div>
                                                        <div>
                                                            <div class="text-sm font-medium text-gray-900">
                                                                {{ $teacher->user->name ?? $teacher->name }}
                                                            </div>
                                                            <div class="text-xs text-gray-500">
                                                                {{ $teacher->subjects_taught ?? 'No subject specified' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if ($class->schedule)
                                                        <div class="text-xs text-gray-600">
                                                            <span
                                                                class="material-icons-sharp text-xs align-text-bottom mr-1">schedule</span>
                                                            {{ $class->schedule }}
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="text-gray-400 text-sm italic">No teacher assigned</div>
                                                @endif
                                            </td>

                                            <!-- Students & Performance -->
                                            <td class="px-6 py-4">
                                                <div class="mb-3">
                                                    <div class="flex items-center justify-between mb-1">
                                                        <span class="text-sm font-medium text-gray-700">
                                                            {{ $class->current_strength }}/{{ $class->capacity }} students
                                                        </span>
                                                        <span
                                                            class="text-xs font-medium {{ $progress >= 90 ? 'text-red-600' : ($progress >= 70 ? 'text-yellow-600' : 'text-green-600') }}">
                                                            {{ number_format($progress, 0) }}%
                                                        </span>
                                                    </div>
                                                    <div class="w-full bg-gray-200 rounded-full h-1.5">
                                                        <div class="h-1.5 rounded-full {{ $progress >= 90 ? 'bg-red-600' : ($progress >= 70 ? 'bg-yellow-600' : 'bg-green-600') }}"
                                                            style="width: {{ $progress }}%"></div>
                                                    </div>
                                                </div>

                                                <div class="grid grid-cols-2 gap-2 text-xs">
                                                    <div class="flex items-center">
                                                        <span
                                                            class="material-icons-sharp text-green-500 text-xs mr-1">check_circle</span>
                                                        <span>Avg. Attendance: {{ $avgAttendance }}%</span>
                                                    </div>
                                                    <div class="flex items-center">
                                                        <span
                                                            class="material-icons-sharp text-blue-500 text-xs mr-1">grade</span>
                                                        <span>Avg. Grade: {{ $avgGrade }}/100</span>
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- Status & Actions -->
                                            <td class="px-6 py-4">
                                                <div class="flex flex-col space-y-3">
                                                    <div class="flex items-center space-x-2">
                                                        <span
                                                            class="text-xs px-2 py-1 rounded-full {{ $class->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                            {{ ucfirst($class->status) }}
                                                        </span>
                                                        @if ($class->is_featured)
                                                            <span
                                                                class="text-xs px-2 py-1 rounded-full bg-yellow-100 text-yellow-800">
                                                                Featured
                                                            </span>
                                                        @endif
                                                    </div>

                                                    <div class="flex items-center space-x-2">
                                                        <!-- Quick Assign Student -->
                                                        <button
                                                            onclick="openAssignStudentModal({{ $class->id }}, '{{ addslashes($class->name) }}')"
                                                            class="p-1.5 bg-green-100 text-green-600 rounded-lg hover:bg-green-200 transition-colors"
                                                            title="Assign Students">
                                                            <span class="material-icons-sharp text-sm">person_add</span>
                                                        </button>

                                                        <!-- Quick Assign Teacher -->
                                                        <button
                                                            onclick="openAssignTeacherModal({{ $class->id }}, '{{ addslashes($class->name) }}')"
                                                            class="p-1.5 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition-colors"
                                                            title="Assign Teacher">
                                                            <span class="material-icons-sharp text-sm">person</span>
                                                        </button>

                                                        <!-- View Button -->
                                                        <a href="{{ route('admin.classes.show', $class) }}"
                                                            class="p-1.5 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-100 transition-colors"
                                                            title="View Details">
                                                            <span class="material-icons-sharp text-sm">visibility</span>
                                                        </a>

                                                        <!-- Edit Button -->
                                                        <a href="{{ route('admin.classes.edit', $class) }}"
                                                            class="p-1.5 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-100 transition-colors"
                                                            title="Edit Class">
                                                            <span class="material-icons-sharp text-sm">edit</span>
                                                        </a>

                                                        <!-- More Actions Dropdown -->
                                                        <div class="relative inline-block">
                                                            <button
                                                                class="p-1.5 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-100 transition-colors dropdown-toggle">
                                                                <span class="material-icons-sharp text-sm">more_vert</span>
                                                            </button>
                                                            <div
                                                                class="dropdown-menu absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-10 hidden">
                                                                <a href="{{ route('admin.classes.schedule.edit', $class) }}"
                                                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                                                    <span
                                                                        class="material-icons-sharp text-sm mr-2">schedule</span>
                                                                    Schedule
                                                                </a>
                                                                <a href="{{ route('admin.classes.attendance', $class) }}"
                                                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                                                    <span
                                                                        class="material-icons-sharp text-sm mr-2">assignment</span>
                                                                    Attendance
                                                                </a>
                                                                <a href="{{ route('admin.classes.grades', $class) }}"
                                                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                                                    <span
                                                                        class="material-icons-sharp text-sm mr-2">grading</span>
                                                                    Grades
                                                                </a>
                                                                <div class="border-t border-gray-200 my-1"></div>
                                                                <form
                                                                    action="{{ route('admin.classes.destroy', $class) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        onclick="return confirm('Are you sure you want to delete this class? All associated data will be lost.')"
                                                                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100 flex items-center">
                                                                        <span
                                                                            class="material-icons-sharp text-sm mr-2">delete</span>
                                                                        Delete Class
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Grid View (Hidden by Default) -->
                    <div id="gridView" class="hidden grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                        @foreach ($classes as $class)
                            @php
                                $progress = ($class->current_strength / $class->capacity) * 100;
                                $teacher = $class->teachers->first() ?? $class->teacher;
                            @endphp

                            <div
                                class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200 hover:border-blue-300 transition-colors">
                                <!-- Class Header -->
                                <div class="p-6 border-b border-gray-200">
                                    <div class="flex items-center justify-between mb-4">
                                        <div
                                            class="w-12 h-12 rounded-lg flex items-center justify-center
                                            {{ $progress >= 90
                                                ? 'bg-red-100 text-red-600'
                                                : ($progress >= 70
                                                    ? 'bg-yellow-100 text-yellow-600'
                                                    : 'bg-blue-100 text-blue-600') }}">
                                            <span class="material-icons-sharp">class</span>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <span
                                                class="text-xs px-2 py-1 rounded-full {{ $class->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ ucfirst($class->status) }}
                                            </span>
                                            @if ($class->is_featured)
                                                <span class="text-xs px-2 py-1 rounded-full bg-yellow-100 text-yellow-800">
                                                    ★
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $class->name }}</h3>
                                    <div class="space-y-1">
                                        <div class="flex items-center text-sm text-gray-600">
                                            <span class="material-icons-sharp text-xs mr-2">tag</span>
                                            {{ $class->code }}
                                        </div>
                                        <div class="flex items-center text-sm text-gray-600">
                                            <span class="material-icons-sharp text-xs mr-2">location_on</span>
                                            {{ $class->room_number ?? 'No Room' }}
                                        </div>
                                        <div class="flex items-center text-sm text-gray-600">
                                            <span class="material-icons-sharp text-xs mr-2">school</span>
                                            Grade {{ $class->grade_level }}, Section {{ $class->section }}
                                        </div>
                                        @if ($class->academic_year)
                                            <div class="flex items-center text-sm text-blue-600">
                                                <span class="material-icons-sharp text-xs mr-2">calendar_today</span>
                                                {{ $class->academic_year }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Class Stats -->
                                <div class="p-6 border-b border-gray-200">
                                    <div class="mb-4">
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="text-sm font-medium text-gray-700">Class Capacity</span>
                                            <span
                                                class="text-sm font-medium {{ $progress >= 90 ? 'text-red-600' : ($progress >= 70 ? 'text-yellow-600' : 'text-green-600') }}">
                                                {{ number_format($progress, 0) }}%
                                            </span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="h-2 rounded-full {{ $progress >= 90 ? 'bg-red-600' : ($progress >= 70 ? 'bg-yellow-600' : 'bg-green-600') }}"
                                                style="width: {{ $progress }}%"></div>
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1 text-center">
                                            {{ $class->current_strength }} of {{ $class->capacity }} students
                                        </div>
                                    </div>

                                    @if ($teacher)
                                        <div class="flex items-center">
                                            <div
                                                class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-bold text-sm mr-3">
                                                {{ substr($teacher->user->name ?? $teacher->name, 0, 1) }}
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="text-sm font-medium text-gray-900 truncate">
                                                    {{ $teacher->user->name ?? $teacher->name }}
                                                </div>
                                                <div class="text-xs text-gray-500 truncate">
                                                    {{ $teacher->subjects_taught ?? 'Teacher' }}
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="text-center py-2">
                                            <span class="text-sm text-gray-400 italic">No teacher assigned</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Action Buttons -->
                                <div class="p-6">
                                    <div class="grid grid-cols-2 gap-3">
                                        <button
                                            onclick="openAssignStudentModal({{ $class->id }}, '{{ addslashes($class->name) }}')"
                                            class="flex items-center justify-center px-3 py-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors text-sm">
                                            <span class="material-icons-sharp text-sm mr-1">person_add</span>
                                            Students
                                        </button>
                                        <button
                                            onclick="openAssignTeacherModal({{ $class->id }}, '{{ addslashes($class->name) }}')"
                                            class="flex items-center justify-center px-3 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors text-sm">
                                            <span class="material-icons-sharp text-sm mr-1">person</span>
                                            Teacher
                                        </button>
                                        <a href="{{ route('admin.classes.show', $class) }}"
                                            class="flex items-center justify-center px-3 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors text-sm">
                                            <span class="material-icons-sharp text-sm mr-1">visibility</span>
                                            View
                                        </a>
                                        <a href="{{ route('admin.classes.edit', $class) }}"
                                            class="flex items-center justify-center px-3 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors text-sm">
                                            <span class="material-icons-sharp text-sm mr-1">edit</span>
                                            Edit
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Bulk Actions Bar -->
                    <div id="bulkActionsBar" class="hidden bg-white rounded-xl shadow-sm p-4 mb-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <span class="text-sm text-gray-700">
                                    <span id="selectedCount">0</span> classes selected
                                </span>
                                <div class="flex items-center space-x-2">
                                    <button onclick="bulkAssignStudents()"
                                        class="px-3 py-1.5 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition-colors">
                                        Assign Students
                                    </button>
                                    <button onclick="bulkAssignTeachers()"
                                        class="px-3 py-1.5 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors">
                                        Assign Teachers
                                    </button>
                                    <button onclick="bulkChangeStatus()"
                                        class="px-3 py-1.5 bg-yellow-600 text-white text-sm rounded-lg hover:bg-yellow-700 transition-colors">
                                        Change Status
                                    </button>
                                    <button onclick="bulkExport()"
                                        class="px-3 py-1.5 border border-gray-300 text-gray-700 text-sm rounded-lg hover:bg-gray-50 transition-colors">
                                        Export Selected
                                    </button>
                                </div>
                            </div>
                            <button onclick="clearSelection()" class="text-sm text-gray-600 hover:text-gray-800">
                                Clear Selection
                            </button>
                        </div>
                    </div>

                    <!-- Pagination with Results Summary -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0">
                            <div class="text-sm text-gray-700">
                                <div class="flex items-center space-x-2">
                                    <span>Showing {{ $classes->firstItem() }} to {{ $classes->lastItem() }} of
                                        {{ $classes->total() }} classes</span>
                                    <span class="text-gray-400">•</span>
                                    <span>{{ $classes->lastPage() }} pages</span>
                                </div>
                                <div class="text-xs text-gray-500 mt-1">
                                    Page {{ $classes->currentPage() }} of {{ $classes->lastPage() }}
                                </div>
                            </div>

                            <div class="flex items-center space-x-2">
                                <!-- Items per page -->
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm text-gray-600">Show:</span>
                                    <select onchange="window.location.href = this.value"
                                        class="border border-gray-300 rounded-lg px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        @foreach ([10, 25, 50, 100] as $perPage)
                                            <option value="{{ request()->fullUrlWithQuery(['per_page' => $perPage]) }}"
                                                {{ request('per_page', 10) == $perPage ? 'selected' : '' }}>
                                                {{ $perPage }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Pagination Links -->
                                <nav class="isolate inline-flex -space-x-px rounded-lg shadow-sm">
                                    @if ($classes->onFirstPage())
                                        <span
                                            class="relative inline-flex items-center rounded-l-lg px-2 py-2 text-gray-400 bg-white border border-gray-300 cursor-not-allowed">
                                            <span class="material-icons-sharp text-sm">chevron_left</span>
                                        </span>
                                    @else
                                        <a href="{{ $classes->previousPageUrl() }}"
                                            class="relative inline-flex items-center rounded-l-lg px-2 py-2 text-gray-700 bg-white border border-gray-300 hover:bg-gray-50">
                                            <span class="material-icons-sharp text-sm">chevron_left</span>
                                        </a>
                                    @endif

                                    @foreach ($classes->getUrlRange(1, $classes->lastPage()) as $page => $url)
                                        @if ($page == $classes->currentPage())
                                            <span
                                                class="relative inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold border border-blue-600">
                                                {{ $page }}
                                            </span>
                                        @else
                                            <a href="{{ $url }}"
                                                class="relative inline-flex items-center px-4 py-2 text-gray-700 bg-white border border-gray-300 hover:bg-gray-50">
                                                {{ $page }}
                                            </a>
                                        @endif
                                    @endforeach

                                    @if ($classes->hasMorePages())
                                        <a href="{{ $classes->nextPageUrl() }}"
                                            class="relative inline-flex items-center rounded-r-lg px-2 py-2 text-gray-700 bg-white border border-gray-300 hover:bg-gray-50">
                                            <span class="material-icons-sharp text-sm">chevron_right</span>
                                        </a>
                                    @else
                                        <span
                                            class="relative inline-flex items-center rounded-r-lg px-2 py-2 text-gray-400 bg-white border border-gray-300 cursor-not-allowed">
                                            <span class="material-icons-sharp text-sm">chevron_right</span>
                                        </span>
                                    @endif
                                </nav>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="bg-white rounded-xl shadow-sm p-12 text-center">
                        <div class="text-gray-400 mb-6">
                            <span class="material-icons-sharp text-6xl">class</span>
                        </div>
                        <h3 class="text-xl font-medium text-gray-900 mb-3">No Classes Found</h3>
                        <p class="text-gray-600 mb-8 max-w-md mx-auto">
                            @if (request()->hasAny(['q', 'grade_level', 'status']))
                                No classes match your current filters. Try adjusting your search criteria.
                            @else
                                Get started by creating your first class. You can assign teachers, add students, and manage
                                schedules.
                            @endif
                        </p>
                        <div
                            class="flex flex-col sm:flex-row items-center justify-center space-y-3 sm:space-y-0 sm:space-x-4">
                            <a href="{{ route('admin.classes.create') }}"
                                class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                                <span class="material-icons-sharp text-sm mr-2">add</span>
                                Create New Class
                            </a>
                            @if (request()->hasAny(['q', 'grade_level', 'status']))
                                <a href="{{ route('admin.classes.index') }}"
                                    class="border border-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-50 transition-colors flex items-center">
                                    <span class="material-icons-sharp text-sm mr-2">refresh</span>
                                    Clear Filters
                                </a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modals -->
    @include('admin.classes.modals.assign-students')
    @include('admin.classes.modals.assign-teacher')
    @include('admin.classes.modals.bulk-assign')
@endsection

@push('styles')
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <style>
        .dropdown-menu {
            display: none;
        }

        .dropdown-toggle:hover+.dropdown-menu,
        .dropdown-menu:hover {
            display: block;
        }

        /* Custom scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }

        /* Animation for notifications */
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .animate-slide-in {
            animation: slideIn 0.3s ease-out;
        }

        /* Progress bar animation */
        .progress-bar {
            transition: width 0.3s ease-in-out;
        }

        /* Hover effects */
        .hover-lift {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('js/class-management.js') }}"></script>
    <script>
        // View Toggle
        document.addEventListener('DOMContentLoaded', function() {
            const listViewBtn = document.getElementById('listViewBtn');
            const gridViewBtn = document.getElementById('gridViewBtn');
            const listView = document.getElementById('listView');
            const gridView = document.getElementById('gridView');

            if (listViewBtn && gridViewBtn) {
                listViewBtn.addEventListener('click', function() {
                    listView.classList.remove('hidden');
                    gridView.classList.add('hidden');
                    listViewBtn.classList.add('bg-blue-100', 'text-blue-600');
                    gridViewBtn.classList.remove('bg-blue-100', 'text-blue-600');
                    gridViewBtn.classList.add('text-gray-400', 'hover:text-gray-600');
                });

                gridViewBtn.addEventListener('click', function() {
                    listView.classList.add('hidden');
                    gridView.classList.remove('hidden');
                    gridViewBtn.classList.add('bg-blue-100', 'text-blue-600');
                    listViewBtn.classList.remove('bg-blue-100', 'text-blue-600');
                    listViewBtn.classList.add('text-gray-400', 'hover:text-gray-600');
                });
            }

            // Bulk selection
            const bulkActionsBar = document.getElementById('bulkActionsBar');
            const selectAllCheckbox = document.querySelector('thead input[type="checkbox"]');
            const classCheckboxes = document.querySelectorAll('.class-checkbox');

            if (selectAllCheckbox) {
                selectAllCheckbox.addEventListener('change', function() {
                    const isChecked = this.checked;
                    classCheckboxes.forEach(checkbox => {
                        checkbox.checked = isChecked;
                    });
                    updateBulkActions();
                });
            }

            classCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateBulkActions);
            });

            function updateBulkActions() {
                const selectedCount = document.querySelectorAll('.class-checkbox:checked').length;
                const selectedCountElement = document.getElementById('selectedCount');

                if (selectedCountElement) {
                    selectedCountElement.textContent = selectedCount;
                }

                if (selectedCount > 0) {
                    bulkActionsBar.classList.remove('hidden');
                } else {
                    bulkActionsBar.classList.add('hidden');
                }

                // Update select all checkbox
                if (selectAllCheckbox) {
                    const allChecked = selectedCount === classCheckboxes.length;
                    const someChecked = selectedCount > 0 && selectedCount < classCheckboxes.length;

                    selectAllCheckbox.checked = allChecked;
                    selectAllCheckbox.indeterminate = someChecked;
                }
            }

            // Initialize Alpine.js components
            if (typeof Alpine === 'undefined') {
                console.warn('Alpine.js is not loaded');
            }
        });

        // Bulk action functions
        function bulkAssignStudents() {
            const selectedClasses = Array.from(document.querySelectorAll('.class-checkbox:checked'))
                .map(checkbox => checkbox.getAttribute('data-class-id'));

            if (selectedClasses.length === 0) return;

            // Open bulk assign modal
            if (typeof window.openBulkAssignModal === 'function') {
                window.openBulkAssignModal(selectedClasses);
            }
        }

        function bulkAssignTeachers() {
            const selectedClasses = Array.from(document.querySelectorAll('.class-checkbox:checked'))
                .map(checkbox => checkbox.getAttribute('data-class-id'));

            if (selectedClasses.length === 0) return;

            alert(`Bulk assign teacher to ${selectedClasses.length} classes`);
            // Implement bulk teacher assignment
        }

        function bulkChangeStatus() {
            const selectedClasses = Array.from(document.querySelectorAll('.class-checkbox:checked'))
                .map(checkbox => checkbox.getAttribute('data-class-id'));

            if (selectedClasses.length === 0) return;

            const newStatus = prompt('Enter new status (active/inactive/archived):');
            if (newStatus) {
                // Implement bulk status change via AJAX
                console.log(`Changing status to ${newStatus} for classes:`, selectedClasses);
            }
        }

        function bulkExport() {
            const selectedClasses = Array.from(document.querySelectorAll('.class-checkbox:checked'))
                .map(checkbox => checkbox.getAttribute('data-class-id'));

            if (selectedClasses.length === 0) return;

            // Redirect to export endpoint with selected IDs
            const url = new URL('{{ route('admin.classes.export') }}');
            url.searchParams.set('class_ids', selectedClasses.join(','));
            window.location.href = url.toString();
        }

        function clearSelection() {
            document.querySelectorAll('.class-checkbox').forEach(checkbox => {
                checkbox.checked = false;
            });
            updateBulkActions();
        }

        // Advanced filter toggle
        document.addEventListener('DOMContentLoaded', function() {
            const advancedFilterBtn = document.querySelector('[x-data] button');
            if (advancedFilterBtn) {
                advancedFilterBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }

            // Close dropdowns when clicking outside
            document.addEventListener('click', function() {
                document.querySelectorAll('.dropdown-menu').forEach(dropdown => {
                    dropdown.classList.add('hidden');
                });
            });
        });
    </script>
@endpush
