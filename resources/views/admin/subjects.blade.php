@extends('layouts.app')

@section('title', 'Subjects Management')

@section('content')
<div class="min-h-screen bg-gray-50 flex">
    <x-admin-sidebar />

    <div class="flex-1 overflow-auto">
        <div class="container mx-auto p-6">
            <!-- Header -->
            <div class="mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Subjects Management</h1>
                        <p class="text-gray-600 mt-2">Manage curriculum subjects and teacher assignments</p>
                    </div>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2">
                        <span class="material-icons-sharp text-sm">add</span>
                        <span>Add New Subject</span>
                    </button>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Total Subjects</p>
                            <p class="text-2xl font-bold text-gray-900">15</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <span class="material-icons-sharp text-blue-600">menu_book</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Active Subjects</p>
                            <p class="text-2xl font-bold text-gray-900">12</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <span class="material-icons-sharp text-green-600">check_circle</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Teachers Assigned</p>
                            <p class="text-2xl font-bold text-gray-900">45</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <span class="material-icons-sharp text-purple-600">person</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Classes Covered</p>
                            <p class="text-2xl font-bold text-gray-900">38</p>
                        </div>
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                            <span class="material-icons-sharp text-orange-600">class</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Subjects Table -->
            <div class="bg-white rounded-xl shadow-sm">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-bold text-gray-900">All Subjects</h2>
                        <div class="flex items-center space-x-4">
                            <div class="relative">
                                <input type="text" placeholder="Search subjects..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <span class="material-icons-sharp absolute left-3 top-2.5 text-gray-400 text-lg">search</span>
                            </div>
                            <select class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option>All Categories</option>
                                <option>Science</option>
                                <option>Mathematics</option>
                                <option>Languages</option>
                                <option>Arts</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200 bg-gray-50">
                                <th class="text-left py-4 px-6 text-sm font-medium text-gray-700">Subject</th>
                                <th class="text-left py-4 px-6 text-sm font-medium text-gray-700">Category</th>
                                <th class="text-left py-4 px-6 text-sm font-medium text-gray-700">Assigned Teachers</th>
                                <th class="text-left py-4 px-6 text-sm font-medium text-gray-700">Classes</th>
                                <th class="text-left py-4 px-6 text-sm font-medium text-gray-700">Status</th>
                                <th class="text-left py-4 px-6 text-sm font-medium text-gray-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="py-4 px-6">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <span class="material-icons-sharp text-blue-600">calculate</span>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">Mathematics</p>
                                            <p class="text-sm text-gray-600">Code: MATH101</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-sm text-gray-900">Core</td>
                                <td class="py-4 px-6 text-sm text-gray-900">Mr. Wilson, Ms. Chen</td>
                                <td class="py-4 px-6 text-sm text-gray-900">15 classes</td>
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
                                    </div>
                                </td>
                            </tr>

                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="py-4 px-6">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                            <span class="material-icons-sharp text-green-600">science</span>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">Science</p>
                                            <p class="text-sm text-gray-600">Code: SCI201</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-sm text-gray-900">Core</td>
                                <td class="py-4 px-6 text-sm text-gray-900">Ms. Johnson, Mr. Kumar</td>
                                <td class="py-4 px-6 text-sm text-gray-900">12 classes</td>
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
                                    </div>
                                </td>
                            </tr>

                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="py-4 px-6">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                            <span class="material-icons-sharp text-purple-600">language</span>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">English</p>
                                            <p class="text-sm text-gray-600">Code: ENG301</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-sm text-gray-900">Language</td>
                                <td class="py-4 px-6 text-sm text-gray-900">Mr. Brown, Ms. Davis</td>
                                <td class="py-4 px-6 text-sm text-gray-900">18 classes</td>
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
                                    </div>
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
