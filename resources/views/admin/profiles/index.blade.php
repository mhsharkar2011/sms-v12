@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="min-h-screen bg-gray-50 flex">
        <x-admin-sidebar :activeRoute="admin.students.index" />

        <div class="flex-1 overflow-auto">
            <!-- Header -->
            <div class="bg-white shadow-sm border-b border-gray-200">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
                            <p class="text-gray-600 mt-1">
                                Welcome back, {{ $currentUser->name ?? auth()->user()->name }}!
                                Here's what's happening today.
                            </p>
                        </div>
                        <div class="text-sm text-gray-500">
                            {{ now()->format('l, F j, Y') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="container mx-auto p-6">
                <!-- Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total Students</p>
                                <p class="text-2xl font-bold text-gray-900 mt-1">
                                    {{ $dashboardStats['total_students'] ?? 0 }}
                                </p>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-users text-blue-600 text-lg"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total Teachers</p>
                                <p class="text-2xl font-bold text-gray-900 mt-1">
                                    {{ $dashboardStats['total_teachers'] ?? 0 }}
                                </p>
                            </div>
                            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-chalkboard-teacher text-green-600 text-lg"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Active Users</p>
                                <p class="text-2xl font-bold text-gray-900 mt-1">
                                    {{ $dashboardStats['active_users'] ?? 0 }}
                                </p>
                            </div>
                            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-user-check text-purple-600 text-lg"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-orange-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Pending</p>
                                <p class="text-2xl font-bold text-gray-900 mt-1">
                                    {{ $dashboardStats['pending_users'] ?? 0 }}
                                </p>
                            </div>
                            <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-clock text-orange-600 text-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Activity</h3>
                        <div class="space-y-4">
                            @forelse($recentActivity ?? [] as $activity)
                                <div class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user-plus text-blue-600 text-xs"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $activity['name'] ?? ($activity->name ?? 'New User') }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            {{ $activity['email'] ?? ($activity->email ?? 'No email') }}
                                            • {{ $activity['time'] ?? $activity->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ $activity['role'] ?? ($activity->roles->first()->name ?? 'User') }}
                                    </span>
                                </div>
                            @empty
                                <p class="text-gray-500 text-center py-4">No recent activity</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                        <div class="space-y-3">
                            <a href="{{ route('admin.users.create') }}"
                                class="flex items-center space-x-3 p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors group">
                                <div
                                    class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                                    <i class="fas fa-user-plus text-blue-600"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">Add New User</p>
                                    <p class="text-xs text-gray-500">Create a new user account</p>
                                </div>
                                <i class="fas fa-chevron-right text-gray-400 group-hover:text-gray-600"></i>
                            </a>

                            <a href="{{ route('admin.students.index') }}"
                                class="flex items-center space-x-3 p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors group">
                                <div
                                    class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-200 transition-colors">
                                    <i class="fas fa-users text-green-600"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">Manage Students</p>
                                    <p class="text-xs text-gray-500">View and manage student records</p>
                                </div>
                                <i class="fas fa-chevron-right text-gray-400 group-hover:text-gray-600"></i>
                            </a>
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
