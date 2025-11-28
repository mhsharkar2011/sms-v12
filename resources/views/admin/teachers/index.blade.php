@extends('layouts.app')

@section('title', 'Teachers Management')

@section('content')
<div class="min-h-screen bg-gray-50 flex">
    <x-admin-sidebar />

    <div class="flex-1 overflow-auto">
        <div class="container mx-auto p-6">
            <!-- Header -->
            <div class="mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Teachers Management</h1>
                        <p class="text-gray-600 mt-2">Manage teacher records, assignments, and information</p>
                    </div>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2">
                        <span class="material-icons-sharp text-sm">person_add</span>
                        <span>Add New Teacher</span>
                    </button>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Total Teachers</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_teachers']  ?? 2 }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <span class="material-icons-sharp text-blue-600">groups</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Active Today</p>
                            <p class="text-2xl font-bold text-gray-900">54</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <span class="material-icons-sharp text-green-600">check_circle</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">On Leave</p>
                            <p class="text-2xl font-bold text-gray-900">3</p>
                        </div>
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <span class="material-icons-sharp text-yellow-600">beach_access</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Subjects Covered</p>
                            <p class="text-2xl font-bold text-gray-900">15</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <span class="material-icons-sharp text-purple-600">menu_book</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Teachers Table -->
            <div class="bg-white rounded-xl shadow-sm">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-bold text-gray-900">All Teachers</h2>
                        <div class="flex items-center space-x-4">
                            <div class="relative">
                                <input type="text" placeholder="Search teachers..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <span class="material-icons-sharp absolute left-3 top-2.5 text-gray-400 text-lg">search</span>
                            </div>
                            <button class="w-10 h-10 border border-gray-300 rounded-lg flex items-center justify-center hover:bg-gray-50 transition-colors">
                                <span class="material-icons-sharp text-gray-600">filter_list</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200 bg-gray-50">
                                <th class="text-left py-4 px-6 text-sm font-medium text-gray-700">Teacher</th>
                                <th class="text-left py-4 px-6 text-sm font-medium text-gray-700">Subject</th>
                                <th class="text-left py-4 px-6 text-sm font-medium text-gray-700">Classes</th>
                                <th class="text-left py-4 px-6 text-sm font-medium text-gray-700">Contact</th>
                                <th class="text-left py-4 px-6 text-sm font-medium text-gray-700">Status</th>
                                <th class="text-left py-4 px-6 text-sm font-medium text-gray-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="py-4 px-6">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                            <span class="material-icons-sharp text-blue-600">person</span>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">Mr. David Wilson</p>
                                            <p class="text-sm text-gray-600">ID: T001</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-sm text-gray-900">Mathematics</td>
                                <td class="py-4 px-6 text-sm text-gray-900">10-A, 10-B, 11-A</td>
                                <td class="py-4 px-6 text-sm text-gray-900">david.w@school.edu</td>
                                <td class="py-4 px-6">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        Active
                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center space-x-2">
                                        <button class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center hover:bg-blue-200 transition-colors">
                                            <span class="material-icons-sharp text-sm">edit</span>
                                        </button>
                                        <button class="w-8 h-8 bg-green-100 text-green-600 rounded-lg flex items-center justify-center hover:bg-green-200 transition-colors">
                                            <span class="material-icons-sharp text-sm">visibility</span>
                                        </button>
                                        <button class="w-8 h-8 bg-red-100 text-red-600 rounded-lg flex items-center justify-center hover:bg-red-200 transition-colors">
                                            <span class="material-icons-sharp text-sm">delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="py-4 px-6">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                            <span class="material-icons-sharp text-green-600">person</span>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">Ms. Sarah Johnson</p>
                                            <p class="text-sm text-gray-600">ID: T002</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-sm text-gray-900">Science</td>
                                <td class="py-4 px-6 text-sm text-gray-900">9-A, 9-B, 10-C</td>
                                <td class="py-4 px-6 text-sm text-gray-900">sarah.j@school.edu</td>
                                <td class="py-4 px-6">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        Active
                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center space-x-2">
                                        <button class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center hover:bg-blue-200 transition-colors">
                                            <span class="material-icons-sharp text-sm">edit</span>
                                        </button>
                                        <button class="w-8 h-8 bg-green-100 text-green-600 rounded-lg flex items-center justify-center hover:bg-green-200 transition-colors">
                                            <span class="material-icons-sharp text-sm">visibility</span>
                                        </button>
                                        <button class="w-8 h-8 bg-red-100 text-red-600 rounded-lg flex items-center justify-center hover:bg-red-200 transition-colors">
                                            <span class="material-icons-sharp text-sm">delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="py-4 px-6">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                                            <span class="material-icons-sharp text-yellow-600">person</span>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">Mr. Robert Brown</p>
                                            <p class="text-sm text-gray-600">ID: T003</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-sm text-gray-900">English</td>
                                <td class="py-4 px-6 text-sm text-gray-900">11-A, 11-B, 12-A</td>
                                <td class="py-4 px-6 text-sm text-gray-900">robert.b@school.edu</td>
                                <td class="py-4 px-6">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                        On Leave
                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center space-x-2">
                                        <button class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center hover:bg-blue-200 transition-colors">
                                            <span class="material-icons-sharp text-sm">edit</span>
                                        </button>
                                        <button class="w-8 h-8 bg-green-100 text-green-600 rounded-lg flex items-center justify-center hover:bg-green-200 transition-colors">
                                            <span class="material-icons-sharp text-sm">visibility</span>
                                        </button>
                                        <button class="w-8 h-8 bg-red-100 text-red-600 rounded-lg flex items-center justify-center hover:bg-red-200 transition-colors">
                                            <span class="material-icons-sharp text-sm">delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="p-6 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-gray-700">Showing 1 to 10 of 68 teachers</p>
                        <div class="flex items-center space-x-2">
                            <button class="w-10 h-10 border border-gray-300 rounded-lg flex items-center justify-center hover:bg-gray-50 transition-colors">
                                <span class="material-icons-sharp text-gray-600">chevron_left</span>
                            </button>
                            <button class="w-10 h-10 bg-blue-600 text-white rounded-lg flex items-center justify-center">1</button>
                            <button class="w-10 h-10 border border-gray-300 rounded-lg flex items-center justify-center hover:bg-gray-50 transition-colors">2</button>
                            <button class="w-10 h-10 border border-gray-300 rounded-lg flex items-center justify-center hover:bg-gray-50 transition-colors">3</button>
                            <button class="w-10 h-10 border border-gray-300 rounded-lg flex items-center justify-center hover:bg-gray-50 transition-colors">
                                <span class="material-icons-sharp text-gray-600">chevron_right</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
