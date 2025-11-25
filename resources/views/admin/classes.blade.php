@extends('layouts.app')

@section('title', 'Classes Management')

@section('content')
<div class="min-h-screen bg-gray-50 flex">
    <x-admin-sidebar />

    <div class="flex-1 overflow-auto">
        <div class="container mx-auto p-6">
            <!-- Header -->
            <div class="mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Classes Management</h1>
                        <p class="text-gray-600 mt-2">Manage class sections, schedules, and student assignments</p>
                    </div>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2">
                        <span class="material-icons-sharp text-sm">add</span>
                        <span>Create New Class</span>
                    </button>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Total Classes</p>
                            <p class="text-2xl font-bold text-gray-900">42</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <span class="material-icons-sharp text-blue-600">class</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Active Classes</p>
                            <p class="text-2xl font-bold text-gray-900">38</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <span class="material-icons-sharp text-green-600">check_circle</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Total Students</p>
                            <p class="text-2xl font-bold text-gray-900">1,247</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <span class="material-icons-sharp text-purple-600">school</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Avg. Class Size</p>
                            <p class="text-2xl font-bold text-gray-900">29.7</p>
                        </div>
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                            <span class="material-icons-sharp text-orange-600">people</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Classes Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Class Card -->
                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Grade 10-A</h3>
                            <p class="text-sm text-gray-600">Science Stream</p>
                        </div>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Active
                        </span>
                    </div>

                    <div class="space-y-3 mb-4">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">Class Teacher:</span>
                            <span class="font-medium text-gray-900">Mr. David Wilson</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">Students:</span>
                            <span class="font-medium text-gray-900">32</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">Room:</span>
                            <span class="font-medium text-gray-900">201</span>
                        </div>
                    </div>

                    <div class="flex items-center space-x-2">
                        <button class="flex-1 bg-blue-600 text-white py-2 rounded-lg text-sm hover:bg-blue-700 transition-colors">
                            Manage
                        </button>
                        <button class="w-10 h-10 border border-gray-300 rounded-lg flex items-center justify-center hover:bg-gray-50 transition-colors">
                            <span class="material-icons-sharp text-gray-600 text-sm">more_vert</span>
                        </button>
                    </div>
                </div>

                <!-- Class Card -->
                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Grade 9-B</h3>
                            <p class="text-sm text-gray-600">General Stream</p>
                        </div>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Active
                        </span>
                    </div>

                    <div class="space-y-3 mb-4">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">Class Teacher:</span>
                            <span class="font-medium text-gray-900">Ms. Sarah Johnson</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">Students:</span>
                            <span class="font-medium text-gray-900">28</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">Room:</span>
                            <span class="font-medium text-gray-900">105</span>
                        </div>
                    </div>

                    <div class="flex items-center space-x-2">
                        <button class="flex-1 bg-blue-600 text-white py-2 rounded-lg text-sm hover:bg-blue-700 transition-colors">
                            Manage
                        </button>
                        <button class="w-10 h-10 border border-gray-300 rounded-lg flex items-center justify-center hover:bg-gray-50 transition-colors">
                            <span class="material-icons-sharp text-gray-600 text-sm">more_vert</span>
                        </button>
                    </div>
                </div>

                <!-- Class Card -->
                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-500">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Grade 11-C</h3>
                            <p class="text-sm text-gray-600">Commerce Stream</p>
                        </div>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            Inactive
                        </span>
                    </div>

                    <div class="space-y-3 mb-4">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">Class Teacher:</span>
                            <span class="font-medium text-gray-900">Mr. Robert Brown</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">Students:</span>
                            <span class="font-medium text-gray-900">0</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">Room:</span>
                            <span class="font-medium text-gray-900">302</span>
                        </div>
                    </div>

                    <div class="flex items-center space-x-2">
                        <button class="flex-1 bg-blue-600 text-white py-2 rounded-lg text-sm hover:bg-blue-700 transition-colors">
                            Manage
                        </button>
                        <button class="w-10 h-10 border border-gray-300 rounded-lg flex items-center justify-center hover:bg-gray-50 transition-colors">
                            <span class="material-icons-sharp text-gray-600 text-sm">more_vert</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
