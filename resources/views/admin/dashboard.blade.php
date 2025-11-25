@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="min-h-screen bg-gray-50 flex">
    <!-- Sidebar Navigation -->
    <aside class="w-64 bg-white shadow-lg">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                    <h2 class="font-semibold text-gray-900 text-sm">{{ Auth::user()->name }}</h2>
                    <p class="text-xs text-gray-500">Administrator</p>
                </div>
            </div>
        </div>

        <x-admin-sidebar />

        <!-- Quick Actions -->
        <div class="p-4 border-t border-gray-200">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-4 text-white">
                <h3 class="font-semibold text-sm mb-3">Quick Actions</h3>
                <div class="space-y-2">
                    <a href="{{ route('admin.students') }}" class="flex items-center space-x-2 text-sm hover:text-blue-200 transition-colors">
                        <span class="material-icons-sharp text-sm">person_add</span>
                        <span>Add New Student</span>
                    </a>
                    <a href="{{ route('admin.teachers') }}" class="flex items-center space-x-2 text-sm hover:text-blue-200 transition-colors">
                        <span class="material-icons-sharp text-sm">person_add</span>
                        <span>Add New Teacher</span>
                    </a>
                    <a href="{{ route('admin.reports') }}" class="flex items-center space-x-2 text-sm hover:text-blue-200 transition-colors">
                        <span class="material-icons-sharp text-sm">summarize</span>
                        <span>Generate Report</span>
                    </a>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 overflow-auto">
        <div class="container mx-auto p-6">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
                <p class="text-gray-600 mt-2">Welcome back, {{ Auth::user()->name }}! Here's your system overview.</p>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Students -->
                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Total Students</p>
                            <p class="text-2xl font-bold text-gray-900">1,247</p>
                            <p class="text-xs text-green-600 mt-1">↑ 12% from last month</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <span class="material-icons-sharp text-blue-600">school</span>
                        </div>
                    </div>
                </div>

                <!-- Total Teachers -->
                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Total Teachers</p>
                            <p class="text-2xl font-bold text-gray-900">68</p>
                            <p class="text-xs text-green-600 mt-1">↑ 5% from last month</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <span class="material-icons-sharp text-green-600">person</span>
                        </div>
                    </div>
                </div>

                <!-- Total Classes -->
                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Total Classes</p>
                            <p class="text-2xl font-bold text-gray-900">42</p>
                            <p class="text-xs text-gray-600 mt-1">No change</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <span class="material-icons-sharp text-purple-600">class</span>
                        </div>
                    </div>
                </div>

                <!-- Attendance Rate -->
                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-orange-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Attendance Rate</p>
                            <p class="text-2xl font-bold text-gray-900">94.2%</p>
                            <p class="text-xs text-green-600 mt-1">↑ 2.1% from last week</p>
                        </div>
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                            <span class="material-icons-sharp text-orange-600">trending_up</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Recent Activity -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-900">Recent Activity</h2>
                        <a href="#" class="text-sm text-blue-600 hover:text-blue-800">View All</a>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center space-x-4 p-3 bg-blue-50 rounded-lg">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="material-icons-sharp text-blue-600 text-sm">person_add</span>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">New student registered</p>
                                <p class="text-xs text-gray-600">Sarah Johnson joined Grade 10-A</p>
                            </div>
                            <span class="text-xs text-gray-500">2 min ago</span>
                        </div>

                        <div class="flex items-center space-x-4 p-3 bg-green-50 rounded-lg">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <span class="material-icons-sharp text-green-600 text-sm">assignment_turned_in</span>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">Exam results published</p>
                                <p class="text-xs text-gray-600">Mathematics mid-term results</p>
                            </div>
                            <span class="text-xs text-gray-500">1 hour ago</span>
                        </div>

                        <div class="flex items-center space-x-4 p-3 bg-purple-50 rounded-lg">
                            <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                <span class="material-icons-sharp text-purple-600 text-sm">event</span>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">New event scheduled</p>
                                <p class="text-xs text-gray-600">Annual Science Fair on March 15</p>
                            </div>
                            <span class="text-xs text-gray-500">3 hours ago</span>
                        </div>
                    </div>
                </div>

                <!-- System Status -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">System Status</h2>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                    <span class="material-icons-sharp text-green-600">check_circle</span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Database</p>
                                    <p class="text-sm text-gray-600">All systems operational</p>
                                </div>
                            </div>
                            <span class="text-sm text-green-600 font-medium">Online</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                    <span class="material-icons-sharp text-green-600">check_circle</span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">File Storage</p>
                                    <p class="text-sm text-gray-600">2.3 GB of 10 GB used</p>
                                </div>
                            </div>
                            <span class="text-sm text-green-600 font-medium">Normal</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                                    <span class="material-icons-sharp text-yellow-600">warning</span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Backup</p>
                                    <p class="text-sm text-gray-600">Last backup: 2 days ago</p>
                                </div>
                            </div>
                            <span class="text-sm text-yellow-600 font-medium">Pending</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Overview Tables -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Students -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-900">Recent Students</h2>
                        <a href="{{ route('admin.students') }}" class="text-sm text-blue-600 hover:text-blue-800">View All</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="text-left py-3 px-4 text-sm font-medium text-gray-700">Name</th>
                                    <th class="text-left py-3 px-4 text-sm font-medium text-gray-700">Grade</th>
                                    <th class="text-left py-3 px-4 text-sm font-medium text-gray-700">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="py-3 px-4 text-sm text-gray-900">Emma Wilson</td>
                                    <td class="py-3 px-4 text-sm text-gray-900">10-A</td>
                                    <td class="py-3 px-4">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="py-3 px-4 text-sm text-gray-900">James Brown</td>
                                    <td class="py-3 px-4 text-sm text-gray-900">9-B</td>
                                    <td class="py-3 px-4">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="py-3 px-4 text-sm text-gray-900">Sophia Garcia</td>
                                    <td class="py-3 px-4 text-sm text-gray-900">11-C</td>
                                    <td class="py-3 px-4">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
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
                        <h2 class="text-xl font-bold text-gray-900">Upcoming Events</h2>
                        <a href="#" class="text-sm text-blue-600 hover:text-blue-800">View Calendar</a>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                            <div>
                                <h3 class="font-semibold text-gray-900 text-sm">Parent-Teacher Meeting</h3>
                                <p class="text-xs text-gray-600">March 20, 2024 • 2:00 PM</p>
                            </div>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                This Week
                            </span>
                        </div>

                        <div class="flex items-center justify-between p-3 border border-gray-100 rounded-lg">
                            <div>
                                <h3 class="font-semibold text-gray-900 text-sm">Science Fair</h3>
                                <p class="text-xs text-gray-600">March 25, 2024 • 10:00 AM</p>
                            </div>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Next Week
                            </span>
                        </div>

                        <div class="flex items-center justify-between p-3 border border-gray-100 rounded-lg">
                            <div>
                                <h3 class="font-semibold text-gray-900 text-sm">Sports Day</h3>
                                <p class="text-xs text-gray-600">April 5, 2024 • 9:00 AM</p>
                            </div>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
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
