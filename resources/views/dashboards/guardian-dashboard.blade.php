@extends('layouts.app')

@section('title', 'Parent Dashboard')

@section('content')
    <div class="min-h-screen bg-gray-50 flex">
        <!-- Parent Sidebar -->
        <x-guardian-sidebar />

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Welcome back, {{ Auth::user()->name }}! 👨‍👩‍👧‍👦
                            </h1>
                            <p class="text-gray-600 mt-1">Here's your family overview for {{ now()->format('l, F j, Y') }}
                            </p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="text-right">
                                <p class="text-sm text-gray-500">Current Time</p>
                                <p class="text-lg font-semibold text-gray-900">{{ now()->format('h:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto">
                <div class="container mx-auto p-6">
                    <!-- Quick Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <!-- Children in School -->
                        <div
                            class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500 hover:shadow-md transition-all duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Children in School</p>
                                    <p class="text-2xl font-bold text-gray-900 mt-1">2</p>
                                    <div class="flex items-center mt-2">
                                        <span class="text-xs text-green-600 bg-green-50 px-2 py-1 rounded-full">
                                            <i class="fas fa-check text-xs mr-1"></i>
                                            All present
                                        </span>
                                    </div>
                                </div>
                                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-users text-blue-600 text-lg"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Avg. Attendance -->
                        <div
                            class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500 hover:shadow-md transition-all duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Avg. Attendance</p>
                                    <p class="text-2xl font-bold text-gray-900 mt-1">96%</p>
                                    <div class="flex items-center mt-2">
                                        <span class="text-xs text-green-600 bg-green-50 px-2 py-1 rounded-full">
                                            <i class="fas fa-trending-up text-xs mr-1"></i>
                                            Excellent
                                        </span>
                                    </div>
                                </div>
                                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-calendar-check text-green-600 text-lg"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Homework -->
                        <div
                            class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-500 hover:shadow-md transition-all duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Pending Homework</p>
                                    <p class="text-2xl font-bold text-gray-900 mt-1">3</p>
                                    <div class="flex items-center mt-2">
                                        <span class="text-xs text-orange-600 bg-orange-50 px-2 py-1 rounded-full">
                                            <i class="fas fa-clock text-xs mr-1"></i>
                                            1 due tomorrow
                                        </span>
                                    </div>
                                </div>
                                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-tasks text-purple-600 text-lg"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Unread Messages -->
                        <div
                            class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-orange-500 hover:shadow-md transition-all duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Unread Messages</p>
                                    <p class="text-2xl font-bold text-gray-900 mt-1">5</p>
                                    <div class="flex items-center mt-2">
                                        <span class="text-xs text-blue-600 bg-blue-50 px-2 py-1 rounded-full">
                                            <i class="fas fa-bell text-xs mr-1"></i>
                                            New updates
                                        </span>
                                    </div>
                                </div>
                                <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-envelope text-orange-600 text-lg"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Main Content Area -->
                        <div class="lg:col-span-2 space-y-6">
                            <!-- Children Performance -->
                            <div class="bg-white rounded-xl shadow-sm p-6">
                                <h2 class="text-xl font-bold text-gray-900 mb-6">Children's Performance</h2>
                                <div class="space-y-6">
                                    <!-- Child 1 -->
                                    <div
                                        class="p-4 border border-gray-100 rounded-lg hover:shadow-md transition-all duration-200">
                                        <div class="flex items-center justify-between mb-4">
                                            <div class="flex items-center space-x-3">
                                                <div
                                                    class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold">
                                                    E
                                                </div>
                                                <div>
                                                    <h3 class="font-semibold text-gray-900">Emma Wilson</h3>
                                                    <p class="text-sm text-gray-600">Grade 5A • Age: 10</p>
                                                </div>
                                            </div>
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-star mr-1 text-xs"></i>
                                                Excellent
                                            </span>
                                        </div>

                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                                            <div>
                                                <p class="text-sm text-gray-600">Mathematics</p>
                                                <p class="text-lg font-bold text-gray-900">A</p>
                                                <div class="w-full bg-gray-200 rounded-full h-1 mt-1">
                                                    <div class="bg-green-600 h-1 rounded-full performance-bar"
                                                        data-width="95"></div>
                                                </div>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-600">Science</p>
                                                <p class="text-lg font-bold text-gray-900">A-</p>
                                                <div class="w-full bg-gray-200 rounded-full h-1 mt-1">
                                                    <div class="bg-green-600 h-1 rounded-full performance-bar"
                                                        data-width="90"></div>
                                                </div>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-600">English</p>
                                                <p class="text-lg font-bold text-gray-900">B+</p>
                                                <div class="w-full bg-gray-200 rounded-full h-1 mt-1">
                                                    <div class="bg-yellow-600 h-1 rounded-full performance-bar"
                                                        data-width="85"></div>
                                                </div>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-600">Attendance</p>
                                                <p class="text-lg font-bold text-gray-900">98%</p>
                                                <div class="w-full bg-gray-200 rounded-full h-1 mt-1">
                                                    <div class="bg-green-600 h-1 rounded-full performance-bar"
                                                        data-width="98"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Child 2 -->
                                    <div
                                        class="p-4 border border-gray-100 rounded-lg hover:shadow-md transition-all duration-200">
                                        <div class="flex items-center justify-between mb-4">
                                            <div class="flex items-center space-x-3">
                                                <div
                                                    class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600 font-bold">
                                                    N
                                                </div>
                                                <div>
                                                    <h3 class="font-semibold text-gray-900">Noah Wilson</h3>
                                                    <p class="text-sm text-gray-600">Grade 3B • Age: 8</p>
                                                </div>
                                            </div>
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                                <i class="fas fa-thumbs-up mr-1 text-xs"></i>
                                                Good
                                            </span>
                                        </div>

                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                                            <div>
                                                <p class="text-sm text-gray-600">Mathematics</p>
                                                <p class="text-lg font-bold text-gray-900">B+</p>
                                                <div class="w-full bg-gray-200 rounded-full h-1 mt-1">
                                                    <div class="bg-blue-600 h-1 rounded-full performance-bar"
                                                        data-width="85"></div>
                                                </div>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-600">Science</p>
                                                <p class="text-lg font-bold text-gray-900">A-</p>
                                                <div class="w-full bg-gray-200 rounded-full h-1 mt-1">
                                                    <div class="bg-green-600 h-1 rounded-full performance-bar"
                                                        data-width="90"></div>
                                                </div>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-600">English</p>
                                                <p class="text-lg font-bold text-gray-900">B</p>
                                                <div class="w-full bg-gray-200 rounded-full h-1 mt-1">
                                                    <div class="bg-yellow-600 h-1 rounded-full performance-bar"
                                                        data-width="80"></div>
                                                </div>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-600">Attendance</p>
                                                <p class="text-lg font-bold text-gray-900">94%</p>
                                                <div class="w-full bg-gray-200 rounded-full h-1 mt-1">
                                                    <div class="bg-green-600 h-1 rounded-full performance-bar"
                                                        data-width="94"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Upcoming Events -->
                            <div class="bg-white rounded-xl shadow-sm p-6">
                                <h2 class="text-xl font-bold text-gray-900 mb-6">Upcoming School Events</h2>
                                <div class="space-y-4">
                                    <div
                                        class="flex items-center space-x-4 p-4 bg-blue-50 rounded-lg border border-blue-100 hover:shadow-md transition-all duration-200">
                                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-running text-blue-600"></i>
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="font-semibold text-gray-900">Annual Sports Day</h3>
                                            <p class="text-sm text-gray-600">All students participate in various sports
                                                activities</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-semibold text-gray-900">March 15, 2024</p>
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-calendar-check mr-1 text-xs"></i>
                                                Confirmed
                                            </span>
                                        </div>
                                    </div>

                                    <div
                                        class="flex items-center space-x-4 p-4 bg-green-50 rounded-lg border border-green-100 hover:shadow-md transition-all duration-200">
                                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-user-graduate text-green-600"></i>
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="font-semibold text-gray-900">Parent-Teacher Meeting</h3>
                                            <p class="text-sm text-gray-600">Discuss student progress with teachers</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-semibold text-gray-900">March 22, 2024</p>
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                <i class="fas fa-clock mr-1 text-xs"></i>
                                                Scheduled
                                            </span>
                                        </div>
                                    </div>

                                    <div
                                        class="flex items-center space-x-4 p-4 bg-purple-50 rounded-lg border border-purple-100 hover:shadow-md transition-all duration-200">
                                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-music text-purple-600"></i>
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="font-semibold text-gray-900">Spring Concert</h3>
                                            <p class="text-sm text-gray-600">Music and arts performance by students</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-semibold text-gray-900">April 5, 2024</p>
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <i class="fas fa-exclamation mr-1 text-xs"></i>
                                                Preparation
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Sidebar -->
                        <div class="space-y-6">
                            <!-- Quick Actions -->
                            <div class="bg-white rounded-xl shadow-sm p-6">
                                <h2 class="text-xl font-bold text-gray-900 mb-4">Quick Actions</h2>
                                <div class="space-y-3">
                                    <a href="#"
                                        class="flex items-center space-x-3 p-3 border border-gray-100 rounded-lg hover:bg-green-50 hover:border-green-200 transition-all duration-200 group">
                                        <div
                                            class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-200 transition-colors">
                                            <i class="fas fa-eye text-green-600"></i>
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-gray-900 text-sm">View Report Cards</h3>
                                            <p class="text-xs text-gray-600">Latest academic reports</p>
                                        </div>
                                    </a>

                                    <a href="#"
                                        class="flex items-center space-x-3 p-3 border border-gray-100 rounded-lg hover:bg-blue-50 hover:border-blue-200 transition-all duration-200 group">
                                        <div
                                            class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                                            <i class="fas fa-calendar text-blue-600"></i>
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-gray-900 text-sm">Check Attendance</h3>
                                            <p class="text-xs text-gray-600">View attendance records</p>
                                        </div>
                                    </a>

                                    <a href="#"
                                        class="flex items-center space-x-3 p-3 border border-gray-100 rounded-lg hover:bg-purple-50 hover:border-purple-200 transition-all duration-200 group">
                                        <div
                                            class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                                            <i class="fas fa-tasks text-purple-600"></i>
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-gray-900 text-sm">Homework Status</h3>
                                            <p class="text-xs text-gray-600">3 pending assignments</p>
                                        </div>
                                    </a>

                                    <a href="#"
                                        class="flex items-center space-x-3 p-3 border border-gray-100 rounded-lg hover:bg-orange-50 hover:border-orange-200 transition-all duration-200 group">
                                        <div
                                            class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center group-hover:bg-orange-200 transition-colors">
                                            <i class="fas fa-comments text-orange-600"></i>
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-gray-900 text-sm">Message Teachers</h3>
                                            <p class="text-xs text-gray-600">5 unread messages</p>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <!-- Pending Homework -->
                            <div class="bg-white rounded-xl shadow-sm p-6">
                                <h2 class="text-xl font-bold text-gray-900 mb-4">Pending Homework</h2>
                                <div class="space-y-3">
                                    <div
                                        class="p-3 border border-red-100 rounded-lg bg-red-50 hover:shadow-md transition-all duration-200">
                                        <div class="flex justify-between items-start mb-2">
                                            <h3 class="font-semibold text-gray-900 text-sm">Math Worksheet</h3>
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <i class="fas fa-exclamation-circle mr-1 text-xs"></i>
                                                Due Tomorrow
                                            </span>
                                        </div>
                                        <p class="text-xs text-gray-600 mb-2">Emma • Algebra problems</p>
                                        <div class="flex items-center text-xs text-gray-500">
                                            <i class="fas fa-clock text-xs mr-1"></i>
                                            <span>Not started</span>
                                        </div>
                                    </div>

                                    <div
                                        class="p-3 border border-yellow-100 rounded-lg bg-yellow-50 hover:shadow-md transition-all duration-200">
                                        <div class="flex justify-between items-start mb-2">
                                            <h3 class="font-semibold text-gray-900 text-sm">Science Project</h3>
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <i class="fas fa-clock mr-1 text-xs"></i>
                                                Due in 3 days
                                            </span>
                                        </div>
                                        <p class="text-xs text-gray-600 mb-2">Noah • Solar system model</p>
                                        <div class="flex items-center text-xs text-gray-500">
                                            <i class="fas fa-chart-bar text-xs mr-1"></i>
                                            <span>In progress (60%)</span>
                                        </div>
                                    </div>

                                    <div
                                        class="p-3 border border-gray-100 rounded-lg hover:shadow-md transition-all duration-200">
                                        <div class="flex justify-between items-start mb-2">
                                            <h3 class="font-semibold text-gray-900 text-sm">English Essay</h3>
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                <i class="fas fa-calendar mr-1 text-xs"></i>
                                                Next Week
                                            </span>
                                        </div>
                                        <p class="text-xs text-gray-600">Emma • My favorite book</p>
                                    </div>
                                </div>
                            </div>

                            <!-- School Announcements -->
                            <div class="bg-gradient-to-r from-teal-500 to-green-600 rounded-xl shadow-sm p-6 text-white">
                                <h2 class="text-xl font-bold mb-4">School Announcements</h2>
                                <div class="space-y-3">
                                    <div class="p-2 rounded-lg hover:bg-white/10 transition-colors cursor-pointer">
                                        <p class="text-sm font-semibold">Fee Payment Reminder</p>
                                        <p class="text-xs opacity-90">Quarter 3 fees due by March 30th</p>
                                    </div>
                                    <div class="p-2 rounded-lg hover:bg-white/10 transition-colors cursor-pointer">
                                        <p class="text-sm font-semibold">Uniform Update</p>
                                        <p class="text-xs opacity-90">Summer uniform starts April 1st</p>
                                    </div>
                                    <div class="p-2 rounded-lg hover:bg-white/10 transition-colors cursor-pointer">
                                        <p class="text-sm font-semibold">Library Week</p>
                                        <p class="text-xs opacity-90">Special activities March 18-22</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .overflow-auto::-webkit-scrollbar {
            width: 6px;
        }

        .overflow-auto::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .overflow-auto::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        .overflow-auto::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .transition-shadow {
            transition: box-shadow 0.2s ease-in-out;
        }

        .performance-bar {
            transition: width 1s ease-in-out;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Parent Dashboard loaded successfully');

            // Animate performance bars
            const performanceBars = document.querySelectorAll('.performance-bar');
            performanceBars.forEach(bar => {
                const width = bar.getAttribute('data-width') + '%';
                bar.style.width = '0%';
                setTimeout(() => {
                    bar.style.width = width;
                }, 500);
            });

            // Add hover effects to all cards
            const cards = document.querySelectorAll(
                '.bg-white, .bg-red-50, .bg-yellow-50, .bg-blue-50, .bg-green-50, .bg-purple-50');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                });
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });
    </script>
@endpush
