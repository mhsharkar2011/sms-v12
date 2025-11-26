@extends('layouts.app')

@section('title', 'Student Management')

@section('content')
    <div class="min-h-screen bg-gray-50 flex">
        <x-admin-sidebar active-route="admin.students" />

        <div class="flex-1 overflow-auto">
            <!-- Header -->
            <div class="bg-white shadow-sm border-b border-gray-200">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Student Management</h1>
                            <p class="text-gray-600 mt-1">Manage all student records and information</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="relative">
                                <input type="text" placeholder="Search students..."
                                    class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent w-64">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                    <i class="fas fa-search"></i>
                                </span>
                            </div>
                            <button onclick="openImportModal()"
                                class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors flex items-center gap-2">
                                <i class="fas fa-file-import"></i>
                                Import
                            </button>
                            <a href="{{ route('admin.students.create') }}"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors shadow-sm">
                                <i class="fas fa-plus"></i>
                                Add Student
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container mx-auto p-6">
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div
                        class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500 hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total Students</p>
                                <p class="text-2xl font-bold text-gray-900 mt-1">1,247</p>
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
                                <p class="text-sm font-medium text-gray-600">Active Students</p>
                                <p class="text-2xl font-bold text-gray-900 mt-1">1,189</p>
                                <div class="flex items-center mt-2">
                                    <span class="text-xs text-green-600 bg-green-50 px-2 py-1 rounded-full">
                                        95.3% active
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
                                <p class="text-sm font-medium text-gray-600">New This Month</p>
                                <p class="text-2xl font-bold text-gray-900 mt-1">42</p>
                                <div class="flex items-center mt-2">
                                    <span class="text-xs text-purple-600 bg-purple-50 px-2 py-1 rounded-full">
                                        3.4% increase
                                    </span>
                                </div>
                            </div>
                            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-user-plus text-purple-600 text-lg"></i>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-orange-500 hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Average Attendance</p>
                                <p class="text-2xl font-bold text-gray-900 mt-1">94.2%</p>
                                <div class="flex items-center mt-2">
                                    <span
                                        class="text-xs text-green-600 bg-green-50 px-2 py-1 rounded-full flex items-center">
                                        <i class="fas fa-arrow-up text-xs mr-1"></i>
                                        2.1% improvement
                                    </span>
                                </div>
                            </div>
                            <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-chart-line text-orange-600 text-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filters Card -->
                <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">Filters & Search</h2>
                        <div class="text-sm text-gray-500">
                            Showing 1,247 students
                        </div>
                    </div>

                    <form class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                            <div class="relative">
                                <input type="text" placeholder="Name or ID..."
                                    class="w-full border border-gray-300 rounded-lg pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                    <i class="fas fa-search"></i>
                                </span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Grade</label>
                            <select
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">All Grades</option>
                                <option value="1">Grade 1</option>
                                <option value="2">Grade 2</option>
                                <option value="3">Grade 3</option>
                                <option value="4">Grade 4</option>
                                <option value="5">Grade 5</option>
                                <option value="6">Grade 6</option>
                                <option value="7">Grade 7</option>
                                <option value="8">Grade 8</option>
                                <option value="9">Grade 9</option>
                                <option value="10">Grade 10</option>
                                <option value="11">Grade 11</option>
                                <option value="12">Grade 12</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Section</label>
                            <select
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">All Sections</option>
                                <option value="A">Section A</option>
                                <option value="B">Section B</option>
                                <option value="C">Section C</option>
                                <option value="D">Section D</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">All Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="graduated">Graduated</option>
                                <option value="transferred">Transferred</option>
                            </select>
                        </div>

                        <div class="flex items-end space-x-2">
                            <button type="submit"
                                class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center gap-2">
                                <i class="fas fa-filter"></i>
                                Apply
                            </button>
                            <button type="reset"
                                class="flex-1 bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors flex items-center justify-center gap-2">
                                <i class="fas fa-refresh"></i>
                                Reset
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Students Table Card -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-gray-900">Student Records</h2>
                        <div class="flex items-center space-x-3">
                            <button
                                class="px-3 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors flex items-center gap-2">
                                <i class="fas fa-download"></i>
                                Export
                            </button>
                            <div class="text-sm text-gray-500">
                                Showing 1-25 of 1,247 students
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-100">
                                    <th
                                        class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Student
                                    </th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Grade & Section
                                    </th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Contact Info
                                    </th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Attendance
                                    </th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <!-- Sample Student 1 -->
                                <tr class="hover:bg-gray-50 transition-colors group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-4">
                                            <div class="relative">
                                                <img class="h-12 w-12 rounded-xl object-cover border-2 border-white shadow-sm"
                                                    src="{{ asset('images/default-avatar.png') }}" alt="Emma Wilson">
                                                <div
                                                    class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-400 rounded-full border-2 border-white">
                                                </div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center space-x-2">
                                                    <p class="text-sm font-semibold text-gray-900 truncate">Emma Wilson</p>
                                                    <span
                                                        class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs bg-blue-100 text-blue-800">
                                                        <i class="fas fa-award mr-1 text-xs"></i>
                                                        Top
                                                    </span>
                                                </div>
                                                <p class="text-sm text-gray-500 truncate">STU-2024-001</p>
                                                <p class="text-xs text-gray-400 mt-1">Age: 15</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">Grade 10-A</div>
                                        <div class="text-xs text-gray-500">Roll No: 15</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">emma.wilson@example.com</div>
                                        <div class="text-xs text-gray-500">+1 (555) 123-4567</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1 text-xs"></i>
                                            Active
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-16 bg-gray-200 rounded-full h-2">
                                                <div class="bg-green-600 h-2 rounded-full" style="width: 96%"></div>
                                            </div>
                                            <span class="text-sm font-medium text-gray-900">96%</span>
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1">This month</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div
                                            class="flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <a href="#"
                                                class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors"
                                                title="View Profile">
                                                <i class="fas fa-eye mr-1 text-xs"></i>
                                                View
                                            </a>
                                            <a href="#"
                                                class="inline-flex items-center px-3 py-1.5 border border-blue-300 rounded-lg text-sm font-medium text-blue-700 bg-white hover:bg-blue-50 transition-colors"
                                                title="Edit Student">
                                                <i class="fas fa-edit mr-1 text-xs"></i>
                                                Edit
                                            </a>
                                            <button
                                                class="inline-flex items-center px-3 py-1.5 border border-red-300 rounded-lg text-sm font-medium text-red-700 bg-white hover:bg-red-50 transition-colors"
                                                title="Delete Student">
                                                <i class="fas fa-trash mr-1 text-xs"></i>
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Sample Student 2 -->
                                <tr class="hover:bg-gray-50 transition-colors group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-4">
                                            <div class="relative">
                                                <img class="h-12 w-12 rounded-xl object-cover border-2 border-white shadow-sm"
                                                    src="{{ asset('images/default-avatar.png') }}" alt="James Brown">
                                                <div
                                                    class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-400 rounded-full border-2 border-white">
                                                </div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-semibold text-gray-900 truncate">James Brown</p>
                                                <p class="text-sm text-gray-500 truncate">STU-2024-002</p>
                                                <p class="text-xs text-gray-400 mt-1">Age: 14</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">Grade 9-B</div>
                                        <div class="text-xs text-gray-500">Roll No: 08</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">james.brown@example.com</div>
                                        <div class="text-xs text-gray-500">+1 (555) 234-5678</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1 text-xs"></i>
                                            Active
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-16 bg-gray-200 rounded-full h-2">
                                                <div class="bg-green-600 h-2 rounded-full" style="width: 88%"></div>
                                            </div>
                                            <span class="text-sm font-medium text-gray-900">88%</span>
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1">This month</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div
                                            class="flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <a href="#"
                                                class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                                                <i class="fas fa-eye mr-1 text-xs"></i>
                                                View
                                            </a>
                                            <a href="#"
                                                class="inline-flex items-center px-3 py-1.5 border border-blue-300 rounded-lg text-sm font-medium text-blue-700 bg-white hover:bg-blue-50 transition-colors">
                                                <i class="fas fa-edit mr-1 text-xs"></i>
                                                Edit
                                            </a>
                                            <button
                                                class="inline-flex items-center px-3 py-1.5 border border-red-300 rounded-lg text-sm font-medium text-red-700 bg-white hover:bg-red-50 transition-colors">
                                                <i class="fas fa-trash mr-1 text-xs"></i>
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Sample Student 3 (Pending) -->
                                <tr class="hover:bg-gray-50 transition-colors group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-4">
                                            <div class="relative">
                                                <img class="h-12 w-12 rounded-xl object-cover border-2 border-white shadow-sm"
                                                    src="{{ asset('images/default-avatar.png') }}" alt="Sophia Garcia">
                                                <div
                                                    class="absolute -bottom-1 -right-1 w-3 h-3 bg-yellow-400 rounded-full border-2 border-white">
                                                </div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-semibold text-gray-900 truncate">Sophia Garcia</p>
                                                <p class="text-sm text-gray-500 truncate">STU-2024-003</p>
                                                <p class="text-xs text-gray-400 mt-1">Age: 16</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">Grade 11-C</div>
                                        <div class="text-xs text-gray-500">Roll No: 22</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">sophia.garcia@example.com</div>
                                        <div class="text-xs text-gray-500">+1 (555) 345-6789</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-clock mr-1 text-xs"></i>
                                            Pending
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-16 bg-gray-200 rounded-full h-2">
                                                <div class="bg-gray-400 h-2 rounded-full" style="width: 0%"></div>
                                            </div>
                                            <span class="text-sm font-medium text-gray-900">N/A</span>
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1">Not started</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div
                                            class="flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <button
                                                class="inline-flex items-center px-3 py-1.5 border border-green-300 rounded-lg text-sm font-medium text-green-700 bg-white hover:bg-green-50 transition-colors">
                                                <i class="fas fa-check mr-1 text-xs"></i>
                                                Approve
                                            </button>
                                            <a href="#"
                                                class="inline-flex items-center px-3 py-1.5 border border-blue-300 rounded-lg text-sm font-medium text-blue-700 bg-white hover:bg-blue-50 transition-colors">
                                                <i class="fas fa-edit mr-1 text-xs"></i>
                                                Edit
                                            </a>
                                            <button
                                                class="inline-flex items-center px-3 py-1.5 border border-red-300 rounded-lg text-sm font-medium text-red-700 bg-white hover:bg-red-50 transition-colors">
                                                <i class="fas fa-times mr-1 text-xs"></i>
                                                Reject
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex items-center justify-between">
                        <div class="text-sm text-gray-500">
                            Showing 1 to 25 of 1,247 entries
                        </div>
                        <div class="flex items-center space-x-2">
                            <button
                                class="px-3 py-1 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                                Previous
                            </button>
                            <button class="px-3 py-1 bg-blue-600 text-white rounded-lg">1</button>
                            <button
                                class="px-3 py-1 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">2</button>
                            <button
                                class="px-3 py-1 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">3</button>
                            <span class="px-2 text-gray-500">...</span>
                            <button
                                class="px-3 py-1 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">50</button>
                            <button
                                class="px-3 py-1 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                                Next
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Import Modal -->
    <div id="importModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Import Students</h3>
            </div>
            <div class="p-6">
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center">
                    <i class="fas fa-file-excel text-green-500 text-3xl mb-4"></i>
                    <p class="text-sm text-gray-600 mb-4">Upload Excel file with student data</p>
                    <input type="file" accept=".xlsx,.xls,.csv" class="hidden" id="fileInput">
                    <button onclick="document.getElementById('fileInput').click()"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        Choose File
                    </button>
                </div>
                <div class="mt-4 text-xs text-gray-500">
                    <p>Download <a href="#" class="text-blue-600 hover:underline">template file</a> for reference
                    </p>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 flex justify-end gap-3">
                <button onclick="closeImportModal()"
                    class="px-4 py-2 text-gray-600 hover:text-gray-800 transition-colors">
                    Cancel
                </button>
                <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    Import Students
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function openImportModal() {
            document.getElementById('importModal').classList.remove('hidden');
        }

        function closeImportModal() {
            document.getElementById('importModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.addEventListener('click', function(e) {
            if (e.target.id === 'importModal') {
                closeImportModal();
            }
        });
    </script>
@endpush

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
@endpush
