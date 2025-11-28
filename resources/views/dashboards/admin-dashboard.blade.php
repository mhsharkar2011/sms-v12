@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="min-h-screen bg-gray-50 flex">
    <!-- Main Content -->
    <div class="flex-1 overflow-auto">
        <!-- Header -->
        <div class="bg-white shadow-sm border-b border-gray-200">
            <div class="px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Dashboard Overview</h1>
                        <p class="text-gray-600 mt-1">Welcome back, {{ Auth::user()->name }}! Here's what's happening today.</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <input type="text" placeholder="Search..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent w-64">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                <i class="fas fa-search"></i>
                            </span>
                        </div>
                        <button class="p-2 text-gray-400 hover:text-gray-600 relative">
                            <i class="fas fa-bell"></i>
                            <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">3</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mx-auto p-6">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Students -->
                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>

                            <p class="text-sm font-medium text-gray-600">Total Students</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalStudent }}</p>
                            <div class="flex items-center mt-2">
                                <span class="text-xs text-green-600 bg-green-50 px-2 py-1 rounded-full flex items-center">
                                    <i class="fas fa-arrow-up text-xs mr-1"></i>
                                    12% increase
                                </span>
                            </div>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-users text-blue-600 text-lg"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Teachers -->
                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Teachers</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">68</p>
                            <div class="flex items-center mt-2">
                                <span class="text-xs text-green-600 bg-green-50 px-2 py-1 rounded-full flex items-center">
                                    <i class="fas fa-arrow-up text-xs mr-1"></i>
                                    5% increase
                                </span>
                            </div>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-chalkboard-teacher text-green-600 text-lg"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Classes -->
                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-500 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Classes</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">42</p>
                            <div class="flex items-center mt-2">
                                <span class="text-xs text-gray-600 bg-gray-50 px-2 py-1 rounded-full">
                                    No change
                                </span>
                            </div>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-door-open text-purple-600 text-lg"></i>
                        </div>
                    </div>
                </div>

                <!-- Attendance Rate -->
                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-orange-500 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Attendance Rate</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">94.2%</p>
                            <div class="flex items-center mt-2">
                                <span class="text-xs text-green-600 bg-green-50 px-2 py-1 rounded-full flex items-center">
                                    <i class="fas fa-arrow-up text-xs mr-1"></i>
                                    2.1% increase
                                </span>
                            </div>
                        </div>
                        <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-chart-line text-orange-600 text-lg"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts and Activity Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Recent Activity -->
                <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-bold text-gray-900">Recent Activity</h2>
                        <a href="#" class="text-sm text-blue-600 hover:text-blue-800 font-medium flex items-center">
                            View All
                            <i class="fas fa-chevron-right ml-1 text-xs"></i>
                        </a>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-start space-x-4 p-4 bg-blue-50 rounded-lg border border-blue-100">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-user-plus text-blue-600 text-sm"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900">New student registered</p>
                                <p class="text-xs text-gray-600 mt-1">Sarah Johnson joined Grade 10-A</p>
                                <p class="text-xs text-gray-500 mt-2">2 minutes ago</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4 p-4 bg-green-50 rounded-lg border border-green-100">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-file-alt text-green-600 text-sm"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900">Exam results published</p>
                                <p class="text-xs text-gray-600 mt-1">Mathematics mid-term results are now available</p>
                                <p class="text-xs text-gray-500 mt-2">1 hour ago</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4 p-4 bg-purple-50 rounded-lg border border-purple-100">
                            <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-calendar-plus text-purple-600 text-sm"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900">New event scheduled</p>
                                <p class="text-xs text-gray-600 mt-1">Annual Science Fair scheduled for March 15</p>
                                <p class="text-xs text-gray-500 mt-2">3 hours ago</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4 p-4 bg-yellow-50 rounded-lg border border-yellow-100">
                            <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-yellow-600 text-sm"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900">System maintenance</p>
                                <p class="text-xs text-gray-600 mt-1">Scheduled maintenance this weekend</p>
                                <p class="text-xs text-gray-500 mt-2">5 hours ago</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions & System Status -->
                <div class="space-y-6">
                    <!-- Quick Actions -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Quick Actions</h2>
                        <div class="space-y-3">
                            <a href="{{ route('admin.users.create') }}" class="flex items-center space-x-3 p-3 rounded-lg border border-gray-200 hover:border-blue-300 hover:bg-blue-50 transition-colors group">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                                    <i class="fas fa-user-plus text-blue-600 text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Add New User</p>
                                    <p class="text-xs text-gray-600">Create staff or student account</p>
                                </div>
                            </a>

                            <a href="{{ route('admin.reports') }}" class="flex items-center space-x-3 p-3 rounded-lg border border-gray-200 hover:border-green-300 hover:bg-green-50 transition-colors group">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-200 transition-colors">
                                    <i class="fas fa-chart-bar text-green-600 text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Generate Report</p>
                                    <p class="text-xs text-gray-600">Create analytics report</p>
                                </div>
                            </a>

                            <a href="{{ route('admin.settings') }}" class="flex items-center space-x-3 p-3 rounded-lg border border-gray-200 hover:border-purple-300 hover:bg-purple-50 transition-colors group">
                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                                    <i class="fas fa-cog text-purple-600 text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">System Settings</p>
                                    <p class="text-xs text-gray-600">Manage platform configuration</p>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- System Status -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">System Status</h2>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-check text-green-600 text-xs"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">Database</span>
                                </div>
                                <span class="text-xs text-green-600 bg-green-50 px-2 py-1 rounded-full font-medium">Online</span>
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-check text-green-600 text-xs"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">File Storage</span>
                                </div>
                                <span class="text-xs text-green-600 bg-green-50 px-2 py-1 rounded-full font-medium">Normal</span>
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-exclamation text-yellow-600 text-xs"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">Backup</span>
                                </div>
                                <span class="text-xs text-yellow-600 bg-yellow-50 px-2 py-1 rounded-full font-medium">Pending</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Data Tables -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Students -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-bold text-gray-900">Recent Students</h2>
                        <a href="{{ route('admin.students.dashboard') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium flex items-center">
                            View All
                            <i class="fas fa-chevron-right ml-1 text-xs"></i>
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="text-left py-3 px-4 text-sm font-medium text-gray-700">Student</th>
                                    <th class="text-left py-3 px-4 text-sm font-medium text-gray-700">Grade</th>
                                    <th class="text-left py-3 px-4 text-sm font-medium text-gray-700">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-4">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                                <span class="text-sm font-medium text-blue-600">E</span>
                                            </div>
                                            <span class="text-sm font-medium text-gray-900">Emma Wilson</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-sm text-gray-900">10-A</td>
                                    <td class="py-3 px-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-4">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                                <span class="text-sm font-medium text-green-600">J</span>
                                            </div>
                                            <span class="text-sm font-medium text-gray-900">James Brown</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-sm text-gray-900">9-B</td>
                                    <td class="py-3 px-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-4">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                                <span class="text-sm font-medium text-purple-600">S</span>
                                            </div>
                                            <span class="text-sm font-medium text-gray-900">Sophia Garcia</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-sm text-gray-900">11-C</td>
                                    <td class="py-3 px-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Pending
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Upcoming Events -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-bold text-gray-900">Upcoming Events</h2>
                        <a href="#" class="text-sm text-blue-600 hover:text-blue-800 font-medium flex items-center">
                            View Calendar
                            <i class="fas fa-chevron-right ml-1 text-xs"></i>
                        </a>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 bg-blue-50 rounded-lg border border-blue-100">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-users text-blue-600 text-sm"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 text-sm">Parent-Teacher Meeting</h3>
                                    <p class="text-xs text-gray-600">March 20, 2024 • 2:00 PM</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                This Week
                            </span>
                        </div>

                        <div class="flex items-center justify-between p-4 border border-gray-100 rounded-lg hover:border-green-200 hover:bg-green-50 transition-colors">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-flask text-green-600 text-sm"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 text-sm">Science Fair</h3>
                                    <p class="text-xs text-gray-600">March 25, 2024 • 10:00 AM</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Next Week
                            </span>
                        </div>

                        <div class="flex items-center justify-between p-4 border border-gray-100 rounded-lg hover:border-gray-200 hover:bg-gray-50 transition-colors">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-running text-gray-600 text-sm"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 text-sm">Sports Day</h3>
                                    <p class="text-xs text-gray-600">April 5, 2024 • 9:00 AM</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                Later
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
@endpush
