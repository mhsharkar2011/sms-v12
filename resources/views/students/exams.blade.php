@extends('layouts.app')

@section('title', 'Exams')

@section('content')
<div class="min-h-screen bg-gray-50 flex">
    <x-student-sidebar />

    <div class="flex-1 overflow-auto">
        <div class="container mx-auto p-6">
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900">Exams & Results</h1>
                <p class="text-gray-600 mt-2">Your exam schedule and performance</p>
            </div>

            <!-- Exam Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Upcoming Exams</p>
                            <p class="text-2xl font-bold text-gray-900">3</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <span class="material-icons-sharp text-blue-600">quiz</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Average Score</p>
                            <p class="text-2xl font-bold text-gray-900">87%</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <span class="material-icons-sharp text-green-600">trending_up</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Exams Taken</p>
                            <p class="text-2xl font-bold text-gray-900">12</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <span class="material-icons-sharp text-purple-600">assignment_turned_in</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Rank in Class</p>
                            <p class="text-2xl font-bold text-gray-900">5th</p>
                        </div>
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                            <span class="material-icons-sharp text-orange-600">emoji_events</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upcoming Exams -->
            <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Upcoming Exams</h2>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-red-50 rounded-lg border border-red-100">
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 bg-red-100 rounded-lg flex flex-col items-center justify-center">
                                <span class="text-red-600 font-bold text-lg">18</span>
                                <span class="text-red-600 text-xs">MAR</span>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Mathematics - Final Term</h3>
                                <p class="text-sm text-gray-600">Chapters 1-10 • Duration: 3 hours</p>
                                <div class="flex items-center space-x-4 mt-1">
                                    <span class="flex items-center text-xs text-gray-500">
                                        <span class="material-icons-sharp text-sm mr-1">schedule</span>
                                        9:00 AM - 12:00 PM
                                    </span>
                                    <span class="flex items-center text-xs text-gray-500">
                                        <span class="material-icons-sharp text-sm mr-1">location_on</span>
                                        Room 201
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                In 3 days
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between p-4 border border-gray-100 rounded-lg">
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 bg-blue-100 rounded-lg flex flex-col items-center justify-center">
                                <span class="text-blue-600 font-bold text-lg">22</span>
                                <span class="text-blue-600 text-xs">MAR</span>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Science - Final Term</h3>
                                <p class="text-sm text-gray-600">Physics & Chemistry • Duration: 2.5 hours</p>
                                <div class="flex items-center space-x-4 mt-1">
                                    <span class="flex items-center text-xs text-gray-500">
                                        <span class="material-icons-sharp text-sm mr-1">schedule</span>
                                        10:30 AM - 1:00 PM
                                    </span>
                                    <span class="flex items-center text-xs text-gray-500">
                                        <span class="material-icons-sharp text-sm mr-1">location_on</span>
                                        Lab 105
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                In 7 days
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Results -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Recent Results</h2>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 px-4 text-sm font-medium text-gray-700">Subject</th>
                                <th class="text-left py-3 px-4 text-sm font-medium text-gray-700">Exam</th>
                                <th class="text-left py-3 px-4 text-sm font-medium text-gray-700">Date</th>
                                <th class="text-left py-3 px-4 text-sm font-medium text-gray-700">Score</th>
                                <th class="text-left py-3 px-4 text-sm font-medium text-gray-700">Grade</th>
                                <th class="text-left py-3 px-4 text-sm font-medium text-gray-700">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="py-3 px-4 text-sm text-gray-900">Mathematics</td>
                                <td class="py-3 px-4 text-sm text-gray-900">Mid Term</td>
                                <td class="py-3 px-4 text-sm text-gray-900">March 5, 2024</td>
                                <td class="py-3 px-4 text-sm font-semibold text-gray-900">92/100</td>
                                <td class="py-3 px-4 text-sm font-semibold text-green-600">A</td>
                                <td class="py-3 px-4">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Passed
                                    </span>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="py-3 px-4 text-sm text-gray-900">Science</td>
                                <td class="py-3 px-4 text-sm text-gray-900">Mid Term</td>
                                <td class="py-3 px-4 text-sm text-gray-900">March 3, 2024</td>
                                <td class="py-3 px-4 text-sm font-semibold text-gray-900">85/100</td>
                                <td class="py-3 px-4 text-sm font-semibold text-blue-600">B+</td>
                                <td class="py-3 px-4">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Passed
                                    </span>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="py-3 px-4 text-sm text-gray-900">English</td>
                                <td class="py-3 px-4 text-sm text-gray-900">Unit Test</td>
                                <td class="py-3 px-4 text-sm text-gray-900">Feb 28, 2024</td>
                                <td class="py-3 px-4 text-sm font-semibold text-gray-900">78/100</td>
                                <td class="py-3 px-4 text-sm font-semibold text-yellow-600">B</td>
                                <td class="py-3 px-4">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Passed
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
