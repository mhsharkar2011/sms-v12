@extends('layouts.app')

@section('title', 'Attendance Management')

@section('content')
    <div class="min-h-screen bg-gray-50 flex">
        <x-admin-sidebar />

        <div class="flex-1 overflow-auto">
            <div class="container mx-auto p-6">
                <!-- Header -->
                <div class="mb-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Attendance Management</h1>
                            <p class="text-gray-600 mt-2">Track and manage student and teacher attendance</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <input type="date"
                                class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <button
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2">
                                <span class="material-icons-sharp text-sm">today</span>
                                <span>Mark Attendance</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Today's Attendance</p>
                                <p class="text-2xl font-bold text-gray-900">94.2%</p>
                                <p class="text-xs text-green-600 mt-1">↑ 2.1% from yesterday</p>
                            </div>
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <span class="material-icons-sharp text-green-600">trending_up</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Present Today</p>
                                <p class="text-2xl font-bold text-gray-900">1,175</p>
                                <p class="text-xs text-gray-600 mt-1">Students</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <span class="material-icons-sharp text-blue-600">check_circle</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Absent Today</p>
                                <p class="text-2xl font-bold text-gray-900">72</p>
                                <p class="text-xs text-gray-600 mt-1">Students</p>
                            </div>
                            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                                <span class="material-icons-sharp text-red-600">cancel</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Monthly Average</p>
                                <p class="text-2xl font-bold text-gray-900">92.8%</p>
                                <p class="text-xs text-green-600 mt-1">↑ 1.5% from last month</p>
                            </div>
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                <span class="material-icons-sharp text-purple-600">bar_chart</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Today's Overview -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Today's Attendance Overview</h2>
                        <div class="space-y-4">
                            <div
                                class="flex items-center justify-between p-4 bg-green-50 rounded-lg border border-green-100">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                        <span class="material-icons-sharp text-green-600">check_circle</span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">Present</p>
                                        <p class="text-sm text-gray-600">1,175 students</p>
                                    </div>
                                </div>
                                <span class="text-2xl font-bold text-green-600">94.2%</span>
                            </div>

                            <div class="flex items-center justify-between p-4 bg-red-50 rounded-lg border border-red-100">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                        <span class="material-icons-sharp text-red-600">cancel</span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">Absent</p>
                                        <p class="text-sm text-gray-600">72 students</p>
                                    </div>
                                </div>
                                <span class="text-2xl font-bold text-red-600">5.8%</span>
                            </div>

                            <div
                                class="flex items-center justify-between p-4 bg-yellow-50 rounded-lg border border-yellow-100">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                                        <span class="material-icons-sharp text-yellow-600">schedule</span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">Late</p>
                                        <p class="text-sm text-gray-600">23 students</p>
                                    </div>
                                </div>
                                <span class="text-2xl font-bold text-yellow-600">1.8%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Quick Actions</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <button
                                class="p-4 bg-blue-50 rounded-lg border border-blue-100 hover:bg-blue-100 transition-colors text-center">
                                <span class="material-icons-sharp text-blue-600 text-2xl mb-2">download</span>
                                <p class="font-medium text-gray-900 text-sm">Export Report</p>
                            </button>
                            <button
                                class="p-4 bg-green-50 rounded-lg border border-green-100 hover:bg-green-100 transition-colors text-center">
                                <span class="material-icons-sharp text-green-600 text-2xl mb-2">notifications</span>
                                <p class="font-medium text-gray-900 text-sm">Send Alerts</p>
                            </button>
                            <button
                                class="p-4 bg-purple-50 rounded-lg border border-purple-100 hover:bg-purple-100 transition-colors text-center">
                                <span class="material-icons-sharp text-purple-600 text-2xl mb-2">summarize</span>
                                <p class="font-medium text-gray-900 text-sm">Generate Report</p>
                            </button>
                            <button
                                class="p-4 bg-orange-50 rounded-lg border border-orange-100 hover:bg-orange-100 transition-colors text-center">
                                <span class="material-icons-sharp text-orange-600 text-2xl mb-2">settings</span>
                                <p class="font-medium text-gray-900 text-sm">Settings</p>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
