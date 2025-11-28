@extends('layouts.app')

@section('title', 'Academic Reports')

@section('content')
    <div class="min-h-screen bg-gray-50 flex">
        <x-admin-sidebar />

        <div class="flex-1 overflow-auto">
            <div class="container mx-auto p-6">
                <!-- Header -->
                <div class="mb-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Academic Performance Reports</h1>
                            <p class="text-gray-600 mt-2">Detailed analysis of student academic performance</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <select
                                class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option>All Grades</option>
                                <option>Grade 10</option>
                                <option>Grade 9</option>
                                <option>Grade 8</option>
                            </select>
                            <select
                                class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option>All Subjects</option>
                                <option>Mathematics</option>
                                <option>Science</option>
                                <option>English</option>
                            </select>
                            <button
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2">
                                <span class="material-icons-sharp text-sm">download</span>
                                <span>Export PDF</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Academic Performance Overview -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <!-- Overall Performance -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Overall Academic Performance</h2>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-700">Average GPA</span>
                                <span class="font-bold text-gray-900">3.75</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-700">Pass Rate</span>
                                <span class="font-bold text-green-600">94.2%</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-700">Honor Students</span>
                                <span class="font-bold text-blue-600">187</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-700">Students Needing Support</span>
                                <span class="font-bold text-orange-600">23</span>
                            </div>
                        </div>
                    </div>

                    <!-- Subject-wise Performance -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Subject-wise Performance</h2>
                        <div class="space-y-3">
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span>Mathematics</span>
                                    <span class="font-bold">92%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-600 h-2 rounded-full" style="width: 92%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span>Science</span>
                                    <span class="font-bold">88%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: 88%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span>English</span>
                                    <span class="font-bold">85%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-purple-600 h-2 rounded-full" style="width: 85%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detailed Performance Table -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Class-wise Performance Analysis</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-200 bg-gray-50">
                                    <th class="text-left py-4 px-6 text-sm font-medium text-gray-700">Class</th>
                                    <th class="text-left py-4 px-6 text-sm font-medium text-gray-700">Students</th>
                                    <th class="text-left py-4 px-6 text-sm font-medium text-gray-700">Avg. GPA</th>
                                    <th class="text-left py-4 px-6 text-sm font-medium text-gray-700">Pass Rate</th>
                                    <th class="text-left py-4 px-6 text-sm font-medium text-gray-700">Top Performer</th>
                                    <th class="text-left py-4 px-6 text-sm font-medium text-gray-700">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-4 px-6 font-medium text-gray-900">Grade 10-A</td>
                                    <td class="py-4 px-6 text-sm text-gray-900">32</td>
                                    <td class="py-4 px-6 text-sm font-bold text-green-600">3.92</td>
                                    <td class="py-4 px-6 text-sm font-bold text-green-600">98.4%</td>
                                    <td class="py-4 px-6 text-sm text-gray-900">Emma Wilson (4.0)</td>
                                    <td class="py-4 px-6">
                                        <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            View Details
                                        </button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-4 px-6 font-medium text-gray-900">Grade 9-B</td>
                                    <td class="py-4 px-6 text-sm text-gray-900">28</td>
                                    <td class="py-4 px-6 text-sm font-bold text-blue-600">3.65</td>
                                    <td class="py-4 px-6 text-sm font-bold text-blue-600">92.8%</td>
                                    <td class="py-4 px-6 text-sm text-gray-900">James Brown (3.95)</td>
                                    <td class="py-4 px-6">
                                        <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            View Details
                                        </button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-4 px-6 font-medium text-gray-900">Grade 8-C</td>
                                    <td class="py-4 px-6 text-sm text-gray-900">30</td>
                                    <td class="py-4 px-6 text-sm font-bold text-orange-600">3.42</td>
                                    <td class="py-4 px-6 text-sm font-bold text-orange-600">87.5%</td>
                                    <td class="py-4 px-6 text-sm text-gray-900">Sophia Garcia (3.88)</td>
                                    <td class="py-4 px-6">
                                        <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            View Details
                                        </button>
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
