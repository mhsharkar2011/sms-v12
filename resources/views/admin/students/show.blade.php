@extends('layouts.app')

@section('title', 'User Details - ' . $user->name)

@section('content')
    <div class="min-h-screen bg-gray-50 flex">
        <x-admin-sidebar active-route="admin.users.index" />

        <div class="flex-1 overflow-auto">
            <!-- Header -->
            <div class="bg-white shadow-sm border-b border-gray-200">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">User Details</h1>
                            <p class="text-gray-600 mt-1">View user information and activity</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('admin.users.index') }}"
                                class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                                Back to Users
                            </a>
                            <a href="{{ route('admin.users.edit', $user) }}"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                Edit User
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container mx-auto p-6">
                <div class="max-w-4xl mx-auto">
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <!-- User Profile Header -->
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-8 border-b border-gray-200">
                            <div class="flex items-center space-x-6">
                                <div class="relative">
                                    <img class="h-24 w-24 rounded-2xl border-4 border-white shadow-lg object-cover"
                                        src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/default-avatar.png') }}"
                                        alt="{{ $user->name }}">
                                    <div
                                        class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full border-2 border-white
                                    {{ $user->status === 'active' ? 'bg-green-400' : ($user->status === 'inactive' ? 'bg-red-400' : 'bg-yellow-400') }}">
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <h2 class="text-3xl font-bold text-gray-900">{{ $user->name }}</h2>
                                    <p class="text-gray-600 mt-1">{{ $user->email }}</p>
                                    <div class="flex items-center space-x-4 mt-3">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
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
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                            <i class="fas fa-user-tag mr-1 text-xs"></i>
                                            {{ ucfirst($user->roles->first()->name ?? 'No Role') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- User Details -->
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Basic Information -->
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h3>
                                    <div class="space-y-4">
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">Full Name</label>
                                            <p class="text-gray-900">{{ $user->name }}</p>
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">Email Address</label>
                                            <p class="text-gray-900">{{ $user->email }}</p>
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">Phone Number</label>
                                            <p class="text-gray-900">{{ $user->phone ?? 'Not provided' }}</p>
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">Address</label>
                                            <p class="text-gray-900">{{ $user->address ?? 'Not provided' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Account Information -->
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Account Information</h3>
                                    <div class="space-y-4">
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">Role</label>
                                            <p class="text-gray-900">
                                                {{ ucfirst($user->roles->first()->name ?? 'No role assigned') }}</p>
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">Status</label>
                                            <p class="text-gray-900 capitalize">{{ $user->status }}</p>
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">Member Since</label>
                                            <p class="text-gray-900">{{ $user->created_at->format('F d, Y') }}</p>
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">Last Login</label>
                                            <p class="text-gray-900">
                                                {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}
                                            </p>
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">Last Updated</label>
                                            <p class="text-gray-900">{{ $user->updated_at->format('F d, Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
