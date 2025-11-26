@extends('layouts.app')

@section('title', 'School Events')

@section('content')
<div class="min-h-screen bg-gray-50 flex">
    <x-student-sidebar />

    <div class="flex-1 overflow-auto">
        <div class="container mx-auto p-6">
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900">School Events</h1>
                <p class="text-gray-600 mt-2">Upcoming school events and activities</p>
            </div>

            <!-- Events Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Upcoming Events</p>
                            <p class="text-2xl font-bold text-gray-900">5</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <span class="material-icons-sharp text-blue-600">event_upcoming</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">This Month</p>
                            <p class="text-2xl font-bold text-gray-900">8</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <span class="material-icons-sharp text-green-600">calendar_month</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Participating</p>
                            <p class="text-2xl font-bold text-gray-900">3</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <span class="material-icons-sharp text-purple-600">emoji_events</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upcoming Events -->
            <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Upcoming Events</h2>
                <div class="space-y-4">
                    <div class="flex items-center space-x-4 p-4 bg-blue-50 rounded-lg border border-blue-100">
                        <div class="w-16 h-16 bg-blue-100 rounded-lg flex flex-col items-center justify-center">
                            <span class="text-blue-600 font-bold text-lg">15</span>
                            <span class="text-blue-600 text-xs">MAR</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900">Annual Science Fair</h3>
                            <p class="text-sm text-gray-600">Showcase your science projects and innovations</p>
                            <div class="flex items-center space-x-4 mt-2">
                                <span class="flex items-center text-xs text-gray-500">
                                    <span class="material-icons-sharp text-sm mr-1">schedule</span>
                                    10:00 AM - 3:00 PM
                                </span>
                                <span class="flex items-center text-xs text-gray-500">
                                    <span class="material-icons-sharp text-sm mr-1">location_on</span>
                                    School Auditorium
                                </span>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                Registered
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4 p-4 border border-gray-100 rounded-lg">
                        <div class="w-16 h-16 bg-green-100 rounded-lg flex flex-col items-center justify-center">
                            <span class="text-green-600 font-bold text-lg">20</span>
                            <span class="text-green-600 text-xs">MAR</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900">Sports Day Competition</h3>
                            <p class="text-sm text-gray-600">Inter-class sports competition</p>
                            <div class="flex items-center space-x-4 mt-2">
                                <span class="flex items-center text-xs text-gray-500">
                                    <span class="material-icons-sharp text-sm mr-1">schedule</span>
                                    9:00 AM - 4:00 PM
                                </span>
                                <span class="flex items-center text-xs text-gray-500">
                                    <span class="material-icons-sharp text-sm mr-1">location_on</span>
                                    School Ground
                                </span>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                Not Registered
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4 p-4 border border-gray-100 rounded-lg">
                        <div class="w-16 h-16 bg-purple-100 rounded-lg flex flex-col items-center justify-center">
                            <span class="text-purple-600 font-bold text-lg">25</span>
                            <span class="text-purple-600 text-xs">MAR</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900">Parent-Teacher Meeting</h3>
                            <p class="text-sm text-gray-600">Discuss academic progress with teachers</p>
                            <div class="flex items-center space-x-4 mt-2">
                                <span class="flex items-center text-xs text-gray-500">
                                    <span class="material-icons-sharp text-sm mr-1">schedule</span>
                                    2:00 PM - 5:00 PM
                                </span>
                                <span class="flex items-center text-xs text-gray-500">
                                    <span class="material-icons-sharp text-sm mr-1">location_on</span>
                                    Classrooms
                                </span>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                Pending
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Past Events -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Recent Events</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="p-4 border border-gray-100 rounded-lg">
                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center mb-3">
                            <span class="material-icons-sharp text-gray-600">celebration</span>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Cultural Fest</h3>
                        <p class="text-sm text-gray-600 mb-2">March 5, 2024</p>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Attended
                        </span>
                    </div>

                    <div class="p-4 border border-gray-100 rounded-lg">
                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center mb-3">
                            <span class="material-icons-sharp text-gray-600">menu_book</span>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Book Fair</h3>
                        <p class="text-sm text-gray-600 mb-2">March 1, 2024</p>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Attended
                        </span>
                    </div>

                    <div class="p-4 border border-gray-100 rounded-lg">
                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center mb-3">
                            <span class="material-icons-sharp text-gray-600">science</span>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Science Workshop</h3>
                        <p class="text-sm text-gray-600 mb-2">February 28, 2024</p>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            Missed
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
