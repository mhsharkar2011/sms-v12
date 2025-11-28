@extends('layouts.app')

@section('title', 'User Management')

@section('content')
    <div class="min-h-screen bg-gray-50 flex">
        <x-admin-sidebar active-route="admin.users.index" />

        <div class="flex-1 overflow-auto">
            <!-- Flash Messages -->
            <div class="notification-container">
                @if (session('success'))
                    <div class="notification notification-success">
                        <div
                            class="bg-green-50 border border-green-200 rounded-xl p-4 shadow-lg transform transition-all duration-300 ease-in-out">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-check-circle text-green-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                                    </div>
                                </div>
                                <button type="button" onclick="this.parentElement.parentElement.parentElement.remove()"
                                    class="text-green-400 hover:text-green-600 transition-colors flex-shrink-0">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="notification notification-error">
                        <div
                            class="bg-red-50 border border-red-200 rounded-xl p-4 shadow-lg transform transition-all duration-300 ease-in-out">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-exclamation-circle text-red-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                                    </div>
                                </div>
                                <button type="button" onclick="this.parentElement.parentElement.parentElement.remove()"
                                    class="text-red-400 hover:text-red-600 transition-colors flex-shrink-0">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                @if (session('warning'))
                    <div class="notification notification-warning">
                        <div
                            class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 shadow-lg transform transition-all duration-300 ease-in-out">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-exclamation-triangle text-yellow-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-yellow-800">{{ session('warning') }}</p>
                                    </div>
                                </div>
                                <button type="button" onclick="this.parentElement.parentElement.parentElement.remove()"
                                    class="text-yellow-400 hover:text-yellow-600 transition-colors flex-shrink-0">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                @if (session('info'))
                    <div class="notification notification-info">
                        <div
                            class="bg-blue-50 border border-blue-200 rounded-xl p-4 shadow-lg transform transition-all duration-300 ease-in-out">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-info-circle text-blue-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-blue-800">{{ session('info') }}</p>
                                    </div>
                                </div>
                                <button type="button" onclick="this.parentElement.parentElement.parentElement.remove()"
                                    class="text-blue-400 hover:text-blue-600 transition-colors flex-shrink-0">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="notification notification-error">
                        <div
                            class="bg-red-50 border border-red-200 rounded-xl p-4 shadow-lg transform transition-all duration-300 ease-in-out">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-exclamation-triangle text-red-600 text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-red-800 mb-2">Please fix the following errors:</p>
                                    <ul class="text-sm text-red-700 list-disc list-inside space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                <button type="button" onclick="this.parentElement.parentElement.parentElement.remove()"
                                    class="text-red-400 hover:text-red-600 transition-colors flex-shrink-0 ml-4">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="flex-1 overflow-auto">
                <!-- Header -->
                <div class="bg-white shadow-sm border-b border-gray-200">
                    <div class="px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">User Management</h1>
                                <p class="text-gray-600 mt-1">Manage all system users and permissions</p>
                            </div>
                            <div class="flex items-center space-x-4">
                                <div class="relative">
                                    <input type="text" placeholder="Search users..."
                                        class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent w-64">
                                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                        <i class="fas fa-search"></i>
                                    </span>
                                </div>
                                <a href="{{ route('admin.users.create') }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors shadow-sm">
                                    <i class="fas fa-plus"></i>
                                    Add User
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container mx-auto p-6">
                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <!-- ... (your existing stats cards remain the same) ... -->
                        <div
                            class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Total Users</p>
                                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['totalUsers'] }}</p>
                                    <div class="flex items-center mt-2">
                                        <span
                                            class="text-xs text-green-600 bg-green-50 px-2 py-1 rounded-full flex items-center">
                                            <i class="fas fa-arrow-up text-xs mr-1"></i>
                                            12% growth
                                        </span>
                                    </div>
                                </div>
                                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-users text-blue-600 text-lg"></i>
                                </div>
                            </div>
                        </div>

                        <div
                            class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Active Users</p>
                                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['activeUsers'] }}</p>
                                    <div class="flex items-center mt-2">
                                        <span class="text-xs text-green-600 bg-green-50 px-2 py-1 rounded-full">
                                            {{ number_format(($stats['activeUsers'] / $stats['totalUsers']) * 100, 1) }}%
                                            active
                                        </span>
                                    </div>
                                </div>
                                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-user-check text-green-600 text-lg"></i>
                                </div>
                            </div>
                        </div>

                        <div
                            class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-500 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Administrators</p>
                                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['adminUsers'] }}</p>
                                    <div class="flex items-center mt-2">
                                        <span class="text-xs text-purple-600 bg-purple-50 px-2 py-1 rounded-full">
                                            {{ number_format(($stats['adminUsers'] / $stats['totalUsers']) * 100, 1) }}% of
                                            total
                                        </span>
                                    </div>
                                </div>
                                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-shield-alt text-purple-600 text-lg"></i>
                                </div>
                            </div>
                        </div>

                        <div
                            class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-yellow-500 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Pending Users</p>
                                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['pendingUsers'] }}</p>
                                    <div class="flex items-center mt-2">
                                        <span class="text-xs text-yellow-600 bg-yellow-50 px-2 py-1 rounded-full">
                                            Needs attention
                                        </span>
                                    </div>
                                </div>
                                <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-clock text-yellow-600 text-lg"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filters Card -->
                    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold text-gray-900">Filters & Search</h2>
                            <div class="text-sm text-gray-500">
                                {{ $users->total() }} users found
                            </div>
                        </div>

                        <form method="GET" action="{{ route('admin.users.index') }}"
                            class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                                <div class="relative">
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        placeholder="Name or email..."
                                        class="w-full border border-gray-300 rounded-lg pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                        <i class="fas fa-search"></i>
                                    </span>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                                <select name="role"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">All Roles</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}"
                                            {{ request('role') == $role->name ? 'selected' : '' }}>
                                            {{ ucfirst($role->name) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                <select name="status"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">All Status</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>
                                        Inactive</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                </select>
                            </div>

                            <div class="flex items-end space-x-2">
                                <button type="submit"
                                    class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center gap-2">
                                    <i class="fas fa-filter"></i>
                                    Apply
                                </button>
                                <a href="{{ route('admin.users.index') }}"
                                    class="flex-1 bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors flex items-center justify-center gap-2">
                                    <i class="fas fa-refresh"></i>
                                    Reset
                                </a>
                            </div>
                        </form>
                    </div>

                    <!-- Users Table Card -->
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-gray-900">User Accounts</h2>
                            <div class="text-sm text-gray-500">
                                Showing {{ $users->firstItem() ?? 0 }}-{{ $users->lastItem() ?? 0 }} of
                                {{ $users->total() }} users
                            </div>
                        </div>

                        @if ($users->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead>
                                        <tr class="bg-gray-50 border-b border-gray-100">
                                            <th
                                                class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                User
                                            </th>
                                            <th
                                                class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Role
                                            </th>
                                            <th
                                                class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Status
                                            </th>
                                            <th
                                                class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Last Active
                                            </th>
                                            <th
                                                class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Actions
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @foreach ($users as $user)
                                            <tr class="hover:bg-gray-50 transition-colors group">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center space-x-4">
                                                        <div class="relative">
                                                            <img class="h-12 w-12 rounded-xl object-cover border-2 border-white shadow-sm"
                                                                src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/default-avatar.png') }}"
                                                                alt="{{ $user->name }}">
                                                            <div
                                                                class="absolute -bottom-1 -right-1 w-3 h-3 rounded-full border-2 border-white
                                                                {{ $user->status === 'active' ? 'bg-green-400' : ($user->status === 'inactive' ? 'bg-red-400' : 'bg-yellow-400') }}">
                                                            </div>
                                                        </div>
                                                        <div class="flex-1 min-w-0">
                                                            <div class="flex items-center space-x-2">
                                                                <p class="text-sm font-semibold text-gray-900 truncate">
                                                                    {{ $user->name }}</p>
                                                                @if ($user->hasRole('admin'))
                                                                    <span
                                                                        class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs bg-purple-100 text-purple-800">
                                                                        <i class="fas fa-crown mr-1 text-xs"></i>
                                                                        Admin
                                                                    </span>
                                                                @endif
                                                            </div>
                                                            <p class="text-sm text-gray-500 truncate">{{ $user->email }}
                                                            </p>
                                                            <p class="text-xs text-gray-400 mt-1">
                                                                Joined {{ $user->created_at->format('M d, Y') }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex flex-wrap gap-1">
                                                        @foreach ($user->roles as $role)
                                                            <span
                                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                                {{ $role->name === 'admin'
                                                                    ? 'bg-purple-100 text-purple-800'
                                                                    : ($role->name === 'teacher'
                                                                        ? 'bg-blue-100 text-blue-800'
                                                                        : ($role->name === 'student'
                                                                            ? 'bg-green-100 text-green-800'
                                                                            : 'bg-gray-100 text-gray-800')) }}">
                                                                <i
                                                                    class="fas
                                                                    {{ $role->name === 'admin'
                                                                        ? 'fa-shield-alt'
                                                                        : ($role->name === 'teacher'
                                                                            ? 'fa-chalkboard-teacher'
                                                                            : ($role->name === 'student'
                                                                                ? 'fa-user-graduate'
                                                                                : 'fa-user')) }}
                                                                    mr-1 text-xs">
                                                                </i>
                                                                {{ ucfirst($role->name) }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                        {{ $user->status === 'active'
                                                            ? 'bg-green-100 text-green-800'
                                                            : ($user->status === 'inactive'
                                                                ? 'bg-red-100 text-red-800'
                                                                : 'bg-yellow-100 text-yellow-800') }}">
                                                        <i
                                                            class="fas
                                                            {{ $user->status === 'active'
                                                                ? 'fa-check-circle'
                                                                : ($user->status === 'inactive'
                                                                    ? 'fa-times-circle'
                                                                    : 'fa-clock') }}
                                                            mr-1 text-xs">
                                                        </i>
                                                        {{ ucfirst($user->status) }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">
                                                        {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}
                                                    </div>
                                                    @if ($user->last_login_at)
                                                        <div class="text-xs text-gray-500">
                                                            {{ $user->last_login_at->format('M d, Y g:i A') }}
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div
                                                        class="flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                                        <a href="{{ route('admin.users.edit', $user) }}"
                                                            class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors"
                                                            title="Edit User">
                                                            <i class="fas fa-edit mr-1 text-xs"></i>
                                                            Edit
                                                        </a>
                                                        <form action="{{ route('admin.users.destroy', $user) }}"
                                                            method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                onclick="return confirmDelete('{{ $user->name }}')"
                                                                class="inline-flex items-center px-3 py-1.5 border border-red-300 rounded-lg text-sm font-medium text-red-700 bg-white hover:bg-red-50 transition-colors"
                                                                title="Delete User">
                                                                <i class="fas fa-trash mr-1 text-xs"></i>
                                                                Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                                {{ $users->links() }}
                            </div>
                        @else
                            <div class="px-6 py-12 text-center">
                                <div
                                    class="w-24 h-24 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-users text-gray-400 text-2xl"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No users found</h3>
                                <p class="text-gray-500 mb-4">
                                    @if (request()->anyFilled(['search', 'role', 'status']))
                                        Try adjusting your search filters or
                                    @endif
                                    Create your first user to get started.
                                </p>
                                @if (request()->anyFilled(['search', 'role', 'status']))
                                    <a href="{{ route('admin.users.index') }}"
                                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors mr-2">
                                        <i class="fas fa-refresh mr-2"></i>
                                        Clear filters
                                    </a>
                                @endif
                                <a href="{{ route('admin.users.create') }}"
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                                    <i class="fas fa-plus mr-2"></i>
                                    Add New User
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .notification-container {
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: 1000;
            max-width: 24rem;
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .notification {
            animation: slideInRight 0.3s ease-out;
        }

        .notification.hiding {
            animation: slideOutRight 0.3s ease-in forwards;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }

            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Auto-hide notifications after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const notifications = document.querySelectorAll('.notification');

            notifications.forEach(notification => {
                // Start auto-hide timer
                const timer = setTimeout(() => {
                    hideNotification(notification);
                }, 5000);

                // Add hover pause functionality
                notification.addEventListener('mouseenter', () => {
                    clearTimeout(timer);
                });

                notification.addEventListener('mouseleave', () => {
                    setTimeout(() => {
                        hideNotification(notification);
                    }, 2000);
                });
            });
        });

        function hideNotification(notification) {
            if (notification.parentElement) {
                notification.classList.add('hiding');
                setTimeout(() => {
                    if (notification.parentElement) {
                        notification.remove();
                    }
                }, 300);
            }
        }

        function confirmDelete(userName) {
            return confirm(`Are you sure you want to delete "${userName}"? This action cannot be undone.`);
        }

        // Enhanced notification function for dynamic notifications
        function showNotification(message, type = 'success') {
            const container = document.querySelector('.notification-container');
            const notification = document.createElement('div');

            const styles = {
                success: 'notification-success bg-green-50 border-green-200',
                error: 'notification-error bg-red-50 border-red-200',
                warning: 'notification-warning bg-yellow-50 border-yellow-200',
                info: 'notification-info bg-blue-50 border-blue-200'
            };

            const icons = {
                success: 'fa-check-circle text-green-600',
                error: 'fa-exclamation-circle text-red-600',
                warning: 'fa-exclamation-triangle text-yellow-600',
                info: 'fa-info-circle text-blue-600'
            };

            notification.className = `notification ${styles[type]}`;
            notification.innerHTML = `
                <div class="border rounded-xl p-4 shadow-lg transform transition-all duration-300 ease-in-out">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 ${type === 'success' ? 'bg-green-100' : type === 'error' ? 'bg-red-100' : type === 'warning' ? 'bg-yellow-100' : 'bg-blue-100'}">
                                <i class="fas ${icons[type]} text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium ${type === 'success' ? 'text-green-800' : type === 'error' ? 'text-red-800' : type === 'warning' ? 'text-yellow-800' : 'text-blue-800'}">${message}</p>
                            </div>
                        </div>
                        <button type="button" onclick="hideNotification(this.closest('.notification'))"
                                class="${type === 'success' ? 'text-green-400 hover:text-green-600' : type === 'error' ? 'text-red-400 hover:text-red-600' : type === 'warning' ? 'text-yellow-400 hover:text-yellow-600' : 'text-blue-400 hover:text-blue-600'} transition-colors flex-shrink-0">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            `;

            container.appendChild(notification);

            // Auto-hide after 5 seconds
            const timer = setTimeout(() => {
                hideNotification(notification);
            }, 5000);

            // Pause on hover
            notification.addEventListener('mouseenter', () => {
                clearTimeout(timer);
            });

            notification.addEventListener('mouseleave', () => {
                setTimeout(() => {
                    hideNotification(notification);
                }, 2000);
            });
        }
    </script>
@endpush
