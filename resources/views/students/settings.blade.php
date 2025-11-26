@extends('layouts.app')

@section('title', 'Settings')

@section('content')
<div class="min-h-screen bg-gray-50 flex">
    <x-student-sidebar />

    <div class="flex-1 overflow-auto">
        <div class="container mx-auto p-6">
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900">Settings</h1>
                <p class="text-gray-600 mt-2">Manage your account preferences and settings</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Navigation -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-sm p-4">
                        <nav class="space-y-1">
                            <button class="w-full flex items-center space-x-3 p-3 rounded-lg bg-blue-50 text-blue-700 border border-blue-100">
                                <span class="material-icons-sharp text-blue-600">person</span>
                                <span class="font-medium">Profile</span>
                            </button>
                            <button class="w-full flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                                <span class="material-icons-sharp">notifications</span>
                                <span class="font-medium">Notifications</span>
                            </button>
                            <button class="w-full flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                                <span class="material-icons-sharp">lock</span>
                                <span class="font-medium">Security</span>
                            </button>
                            <button class="w-full flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                                <span class="material-icons-sharp">palette</span>
                                <span class="font-medium">Appearance</span>
                            </button>
                            <button class="w-full flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                                <span class="material-icons-sharp">help</span>
                                <span class="font-medium">Help & Support</span>
                            </button>
                        </nav>
                    </div>
                </div>

                <!-- Settings Content -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Profile Settings</h2>

                        <!-- Profile Information -->
                        <div class="space-y-6">
                            <!-- Personal Info -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Personal Information</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                                        <input type="text" value="{{ Auth::user()->name }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                        <input type="email" value="{{ Auth::user()->email }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                                        <input type="tel" value="{{ Auth::user()->phone ?? '' }}" placeholder="Enter phone number" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Date of Birth</label>
                                        <input type="date" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                </div>
                            </div>

                            <!-- Academic Info -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Academic Information</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Grade/Class</label>
                                        <select class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option>Grade 10</option>
                                            <option>Grade 9</option>
                                            <option>Grade 8</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Roll Number</label>
                                        <input type="text" value="1025" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                </div>
                            </div>

                            <!-- Address -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Address</h3>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Street Address</label>
                                        <input type="text" value="{{ Auth::user()->address ?? '' }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">City</label>
                                            <input type="text" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">State</label>
                                            <input type="text" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">ZIP Code</label>
                                            <input type="text" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                                <button class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                    Cancel
                                </button>
                                <button class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                    Save Changes
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
