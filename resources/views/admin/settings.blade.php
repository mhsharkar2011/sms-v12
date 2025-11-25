@extends('layouts.app')

@section('title', 'System Settings')

@section('content')
    <div class="min-h-screen bg-gray-50 flex">
        <x-admin-sidebar />

        <div class="flex-1 overflow-auto">
            <div class="container mx-auto p-6">
                <!-- Header -->
                <div class="mb-6">
                    <h1 class="text-3xl font-bold text-gray-900">System Settings</h1>
                    <p class="text-gray-600 mt-2">Manage system configuration and preferences</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Settings Navigation -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-xl shadow-sm p-4">
                            <nav class="space-y-1">
                                <button
                                    class="w-full flex items-center space-x-3 p-3 rounded-lg bg-blue-50 text-blue-700 border border-blue-100">
                                    <span class="material-icons-sharp text-blue-600">school</span>
                                    <span class="font-medium">School Information</span>
                                </button>
                                <button
                                    class="w-full flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                                    <span class="material-icons-sharp">academic_cap</span>
                                    <span class="font-medium">Academic Settings</span>
                                </button>
                                <button
                                    class="w-full flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                                    <span class="material-icons-sharp">notifications</span>
                                    <span class="font-medium">Notification Settings</span>
                                </button>
                                <button
                                    class="w-full flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                                    <span class="material-icons-sharp">security</span>
                                    <span class="font-medium">Security & Privacy</span>
                                </button>
                                <button
                                    class="w-full flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                                    <span class="material-icons-sharp">backup</span>
                                    <span class="font-medium">Backup & Restore</span>
                                </button>
                                <button
                                    class="w-full flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                                    <span class="material-icons-sharp">api</span>
                                    <span class="font-medium">Integration</span>
                                </button>
                                <button
                                    class="w-full flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                                    <span class="material-icons-sharp">palette</span>
                                    <span class="font-medium">Appearance</span>
                                </button>
                            </nav>
                        </div>
                    </div>

                    <!-- Settings Content -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-6">School Information</h2>

                            <div class="space-y-6">
                                <!-- Basic Information -->
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">School Name</label>
                                            <input type="text" value="Greenwood High School"
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">School Code</label>
                                            <input type="text" value="GHS2024"
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Established
                                                Year</label>
                                            <input type="number" value="1995"
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">School Type</label>
                                            <select
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                                <option>Private</option>
                                                <option>Public</option>
                                                <option>International</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Contact Information -->
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact Information</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Email
                                                Address</label>
                                            <input type="email" value="info@greenwood.edu"
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                            <input type="tel" value="+1 (555) 123-4567"
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                                            <textarea rows="3"
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">123 Education Street, Greenwood City, GC 12345</textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- Academic Settings -->
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Academic Settings</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Academic
                                                Year</label>
                                            <input type="text" value="2023-2024"
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Grading
                                                System</label>
                                            <select
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                                <option>Percentage</option>
                                                <option>GPA</option>
                                                <option>Letter Grades</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- System Preferences -->
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">System Preferences</h3>
                                    <div class="space-y-4">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="font-medium text-gray-900">Automatic Backup</p>
                                                <p class="text-sm text-gray-600">Daily automatic system backup</p>
                                            </div>
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" class="sr-only peer" checked>
                                                <div
                                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                                </div>
                                            </label>
                                        </div>

                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="font-medium text-gray-900">Email Notifications</p>
                                                <p class="text-sm text-gray-600">Send email alerts to parents</p>
                                            </div>
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" class="sr-only peer" checked>
                                                <div
                                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                                </div>
                                            </label>
                                        </div>

                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="font-medium text-gray-900">Maintenance Mode</p>
                                                <p class="text-sm text-gray-600">Take system offline for maintenance</p>
                                            </div>
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" class="sr-only peer">
                                                <div
                                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                                    <button
                                        class="px-6 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                        Reset to Default
                                    </button>
                                    <div class="flex items-center space-x-3">
                                        <button
                                            class="px-6 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                            Cancel
                                        </button>
                                        <button
                                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
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
    </div>
@endsection
