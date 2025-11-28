@extends('layouts.app')

@section('title', $admin->name . ' - Admin Profile')

@section('content')
    <div class="min-h-screen bg-gray-50 flex">
        <x-admin-sidebar active-route="admin.users.index" />

        <div class="flex-1 overflow-auto">
            <!-- Header -->
            <div class="bg-white shadow-sm border-b border-gray-200">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('admin.admins.index') }}"
                               class="text-gray-400 hover:text-gray-600 transition-colors">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">{{ $admin->name }}</h1>
                                <p class="text-gray-600 mt-1">Administrator Profile</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('admin.admins.edit', $admin) }}"
                               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
                                <i class="fas fa-edit"></i>
                                Edit Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container mx-auto p-6">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Left Column - Profile Info -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Profile Summary Card -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                            <div class="p-6">
                                <div class="flex items-start space-x-6">
                                    <div class="relative">
                                        <img class="h-24 w-24 rounded-2xl object-cover border-2 border-white shadow-lg"
                                             src="{{ $admin->avatar ? asset('storage/' . $admin->avatar) : asset('images/default-avatar.png') }}"
                                             alt="{{ $admin->name }}">
                                        <div class="absolute -bottom-2 -right-2 w-6 h-6
                                            {{ $admin->status == 'active' ? 'bg-green-400' :
                                               ($admin->status == 'pending' ? 'bg-yellow-400' : 'bg-red-400') }}
                                            border-2 border-white rounded-full"></div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-3 mb-4">
                                            <h2 class="text-2xl font-bold text-gray-900">{{ $admin->name }}</h2>
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                                {{ $admin->status == 'active' ? 'bg-green-100 text-green-800' :
                                                   ($admin->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                <i class="fas
                                                    {{ $admin->status == 'active' ? 'fa-check-circle' :
                                                       ($admin->status == 'pending' ? 'fa-clock' : 'fa-times-circle') }}
                                                    mr-1"></i>
                                                {{ ucfirst($admin->status) }}
                                            </span>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                            <div>
                                                <span class="text-gray-500">Email:</span>
                                                <span class="font-medium text-gray-900 ml-2">{{ $admin->email }}</span>
                                            </div>
                                            <div>
                                                <span class="text-gray-500">Phone:</span>
                                                <span class="font-medium text-gray-900 ml-2">{{ $admin->phone ?? 'Not provided' }}</span>
                                            </div>
                                            <div>
                                                <span class="text-gray-500">Role:</span>
                                                <span class="font-medium text-gray-900 ml-2">{{ $admin->getRoleNames()->first() ?? 'No Role' }}</span>
                                            </div>
                                            <div>
                                                <span class="text-gray-500">Member since:</span>
                                                <span class="font-medium text-gray-900 ml-2">{{ $admin->created_at->format('M d, Y') }}</span>
                                            </div>
                                        </div>

                                        @if($admin->bio)
                                        <div class="mt-4">
                                            <h4 class="text-sm font-medium text-gray-700 mb-2">Bio</h4>
                                            <p class="text-sm text-gray-600">{{ $admin->bio }}</p>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Activity & Permissions -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Recent Activity -->
                            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                                <div class="px-6 py-4 border-b border-gray-200">
                                    <h3 class="text-lg font-semibold text-gray-900">Recent Activity</h3>
                                </div>
                                <div class="p-6">
                                    <div class="space-y-4">
                                        <div class="flex items-start space-x-3">
                                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                                <i class="fas fa-user-plus text-blue-600 text-xs"></i>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">Account Created</p>
                                                <p class="text-xs text-gray-500">{{ $admin->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>

                                        @if($admin->last_login_at)
                                        <div class="flex items-start space-x-3">
                                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                                <i class="fas fa-sign-in-alt text-green-600 text-xs"></i>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">Last Login</p>
                                                <p class="text-xs text-gray-500">{{ $admin->last_login_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Permissions -->
                            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                                <div class="px-6 py-4 border-b border-gray-200">
                                    <h3 class="text-lg font-semibold text-gray-900">Permissions</h3>
                                </div>
                                <div class="p-6">
                                    <div class="space-y-2">
                                        @foreach($admin->getAllPermissions() as $permission)
                                            <div class="flex items-center space-x-2">
                                                <i class="fas fa-check text-green-500 text-sm"></i>
                                                <span class="text-sm text-gray-700">{{ $permission->name }}</span>
                                            </div>
                                        @endforeach

                                        @if($admin->getAllPermissions()->isEmpty())
                                            <p class="text-sm text-gray-500">No specific permissions assigned</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Actions & Info -->
                    <div class="space-y-6">
                        <!-- Quick Actions -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900">Quick Actions</h3>
                            </div>
                            <div class="p-4 space-y-2">
                                <a href="mailto:{{ $admin->email }}"
                                   class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 transition-colors group">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                                        <i class="fas fa-envelope text-blue-600"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">Send Email</p>
                                        <p class="text-xs text-gray-500">{{ $admin->email }}</p>
                                    </div>
                                </a>

                                @if($admin->phone)
                                <a href="tel:{{ $admin->phone }}"
                                   class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 transition-colors group">
                                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-200 transition-colors">
                                        <i class="fas fa-phone text-green-600"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">Call</p>
                                        <p class="text-xs text-gray-500">{{ $admin->phone }}</p>
                                    </div>
                                </a>
                                @endif

                                @if($admin->id !== auth()->id())
                                <form action="{{ route('admin.admins.impersonate', $admin) }}" method="POST" class="w-full">
                                    @csrf
                                    <button type="submit"
                                            class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 transition-colors group w-full text-left">
                                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                                            <i class="fas fa-user-secret text-purple-600"></i>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900">Impersonate</p>
                                            <p class="text-xs text-gray-500">Login as this user</p>
                                        </div>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>

                        <!-- Account Information -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900">Account Info</h3>
                            </div>
                            <div class="p-6 space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-500">Account Status</span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $admin->status == 'active' ? 'bg-green-100 text-green-800' :
                                           ($admin->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($admin->status) }}
                                    </span>
                                </div>

                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-500">Email Verified</span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $admin->email_verified_at ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        <i class="fas {{ $admin->email_verified_at ? 'fa-check' : 'fa-clock' }} mr-1"></i>
                                        {{ $admin->email_verified_at ? 'Verified' : 'Pending' }}
                                    </span>
                                </div>

                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-500">Last Updated</span>
                                    <span class="text-sm font-medium text-gray-900">{{ $admin->updated_at->diffForHumans() }}</span>
                                </div>
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
