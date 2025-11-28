@extends('layouts.app')

@section('title', 'Teacher Dashboard')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <!-- Sidebar Navigation -->
        <div class="flex">
            <aside class="w-64 bg-white shadow-lg">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div
                            class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div>
                            <h2 class="font-semibold text-gray-900">{{ Auth::user()->name }}</h2>
                            <p class="text-sm text-gray-500">Teacher</p>
                            <p class="text-xs text-gray-400 mt-1">ID: {{ Auth::user()->id }}</p>
                        </div>
                    </div>
                </div>

                <!-- Teacher Navigation Menu -->
                <nav class="flex-1 py-4 space-y-1">
                    @php
                        $currentRoute = request()->route()->getName();
                        $menuItems = [
                            [
                                'route' => 'teacher.dashboard',
                                'icon' => '📊',
                                'label' => 'Dashboard',
                                'description' => 'Teaching Overview',
                            ],
                            [
                                'route' => 'teacher.profile',
                                'icon' => '👤',
                                'label' => 'My Profile',
                                'description' => 'Personal information',
                            ],
                            [
                                'route' => 'teacher.classes',
                                'icon' => '🏫',
                                'label' => 'My Classes',
                                'description' => 'Manage classes',
                            ],
                            [
                                'route' => 'teacher.students',
                                'icon' => '🎓',
                                'label' => 'Students',
                                'description' => 'Student management',
                            ],
                            [
                                'route' => 'teacher.attendance',
                                'icon' => '📅',
                                'label' => 'Attendance',
                                'description' => 'Track attendance',
                            ],
                            [
                                'route' => 'teacher.grades',
                                'icon' => '📝',
                                'label' => 'Grades & Assessment',
                                'description' => 'Grade management',
                            ],
                            [
                                'route' => 'teacher.assignments',
                                'icon' => '📚',
                                'label' => 'Assignments',
                                'description' => 'Create & grade work',
                            ],
                            [
                                'route' => 'teacher.schedule',
                                'icon' => '⏰',
                                'label' => 'Schedule',
                                'description' => 'Teaching schedule',
                            ],
                        ];
                    @endphp

                    @foreach ($menuItems as $item)
                        @php
                            $isActive =
                                $currentRoute === $item['route'] ||
                                str_starts_with($currentRoute, $item['route'] . '.');
                            $classes = $isActive
                                ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-600'
                                : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900';
                        @endphp

                        <a href="{{ Route::has($item['route']) ? route($item['route']) : '#' }}"
                            class="flex items-center px-6 py-3 text-sm font-medium transition-colors duration-200 {{ $classes }}">
                            <span class="text-lg mr-3">{{ $item['icon'] }}</span>
                            <div class="flex-1">
                                <span class="block">{{ $item['label'] }}</span>
                                <span class="text-xs text-gray-500 mt-0.5 block">{{ $item['description'] }}</span>
                            </div>
                        </a>
                    @endforeach
                </nav>

                <!-- Quick Stats in Sidebar -->
                <div class="p-4 border-t border-gray-200">
                    <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg p-4 text-white">
                        <h3 class="font-semibold text-sm mb-2">This Week</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span>Classes Taught</span>
                                <span class="font-bold">12/15</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Assignments Graded</span>
                                <span class="font-bold">45/60</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Avg. Attendance</span>
                                <span class="font-bold">94%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Main Content -->
            <div class="flex-1 overflow-auto">
                <!-- Header -->
                <div class="bg-white shadow-sm border-b border-gray-200">
                    <div class="px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">Welcome back, {{ Auth::user()->name }}! 👨‍🏫
                                </h1>
                                <p class="text-gray-600 mt-1">Here's your teaching overview for
                                    {{ now()->format('l, F j, Y') }}</p>
                            </div>
                            <div class="flex items-center space-x-4">
                                <div class="text-right">
                                    <p class="text-sm text-gray-500">Current Time</p>
                                    <div id="live-clock" class="text-lg font-semibold text-gray-900">
                                        {{ now()->format('h:i:s A') }}
                                    </div>
                                    <div id="live-date" class="text-sm text-gray-600">
                                        {{ now()->format('l, F j, Y') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container mx-auto p-6">
                    <!-- Quick Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <div
                            class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Total Students</p>
                                    <p class="text-2xl font-bold text-gray-900 mt-1">142</p>
                                    <div class="flex items-center mt-2">
                                        <span class="text-xs text-green-600 bg-green-50 px-2 py-1 rounded-full">
                                            <i class="fas fa-arrow-up text-xs mr-1"></i>
                                            8% growth
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
                                    <p class="text-sm font-medium text-gray-600">Classes Today</p>
                                    <p class="text-2xl font-bold text-gray-900 mt-1">4</p>
                                    <div class="flex items-center mt-2">
                                        <span class="text-xs text-blue-600 bg-blue-50 px-2 py-1 rounded-full">
                                            <i class="fas fa-clock text-xs mr-1"></i>
                                            2 completed
                                        </span>
                                    </div>
                                </div>
                                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-chalkboard-teacher text-green-600 text-lg"></i>
                                </div>
                            </div>
                        </div>

                        <div
                            class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-500 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Pending Grading</p>
                                    <p class="text-2xl font-bold text-gray-900 mt-1">15</p>
                                    <div class="flex items-center mt-2">
                                        <span class="text-xs text-orange-600 bg-orange-50 px-2 py-1 rounded-full">
                                            <i class="fas fa-exclamation-circle text-xs mr-1"></i>
                                            3 urgent
                                        </span>
                                    </div>
                                </div>
                                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-tasks text-purple-600 text-lg"></i>
                                </div>
                            </div>
                        </div>

                        <div
                            class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-orange-500 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Avg. Class Score</p>
                                    <p class="text-2xl font-bold text-gray-900 mt-1">86%</p>
                                    <div class="flex items-center mt-2">
                                        <span class="text-xs text-green-600 bg-green-50 px-2 py-1 rounded-full">
                                            <i class="fas fa-trending-up text-xs mr-1"></i>
                                            5% improvement
                                        </span>
                                    </div>
                                </div>
                                <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-chart-line text-orange-600 text-lg"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Main Content Area -->
                        <div class="lg:col-span-2 space-y-6">
                            <!-- Today's Schedule -->
                            <div class="bg-white rounded-xl shadow-sm p-6">
                                <div class="flex items-center justify-between mb-6">
                                    <h2 class="text-xl font-bold text-gray-900">Today's Teaching Schedule</h2>
                                    <span class="text-sm text-gray-500">{{ now()->format('l, F j') }}</span>
                                </div>

                                <div class="space-y-4">
                                    <div
                                        class="flex items-center space-x-4 p-4 bg-blue-50 rounded-lg border border-blue-100">
                                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-calculator text-blue-600"></i>
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="font-semibold text-gray-900">Mathematics - Grade 10A</h3>
                                            <p class="text-sm text-gray-600">Algebra & Calculus • Room 201</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-semibold text-gray-900">08:00 - 09:30</p>
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-check mr-1 text-xs"></i>
                                                Completed
                                            </span>
                                        </div>
                                    </div>

                                    <div
                                        class="flex items-center space-x-4 p-4 bg-green-50 rounded-lg border border-green-100">
                                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-calculator text-green-600"></i>
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="font-semibold text-gray-900">Mathematics - Grade 9B</h3>
                                            <p class="text-sm text-gray-600">Geometry • Room 105</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-semibold text-gray-900">10:00 - 11:30</p>
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                <i class="fas fa-play mr-1 text-xs"></i>
                                                In Progress
                                            </span>
                                        </div>
                                    </div>

                                    <div
                                        class="flex items-center space-x-4 p-4 border border-gray-100 rounded-lg hover:bg-gray-50 transition-colors">
                                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-calculator text-purple-600"></i>
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="font-semibold text-gray-900">Advanced Math - Grade 11</h3>
                                            <p class="text-sm text-gray-600">Trigonometry • Room 302</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-semibold text-gray-900">13:00 - 14:30</p>
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                <i class="fas fa-clock mr-1 text-xs"></i>
                                                Upcoming
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Recent Student Performance -->
                            <div class="bg-white rounded-xl shadow-sm p-6">
                                <h2 class="text-xl font-bold text-gray-900 mb-6">Recent Student Performance</h2>
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between p-4 border border-gray-100 rounded-lg">
                                        <div class="flex items-center space-x-3">
                                            <div
                                                class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                <span class="text-blue-600 font-semibold">A</span>
                                            </div>
                                            <div>
                                                <h3 class="font-semibold text-gray-900">Grade 10A - Algebra Test</h3>
                                                <p class="text-sm text-gray-600">Average Score: 84%</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="w-16 bg-gray-200 rounded-full h-2">
                                                <div class="bg-green-600 h-2 rounded-full" style="width: 84%"></div>
                                            </div>
                                            <p class="text-xs text-gray-600 mt-1">42/50 students passed</p>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between p-4 border border-gray-100 rounded-lg">
                                        <div class="flex items-center space-x-3">
                                            <div
                                                class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
                                                <span class="text-orange-600 font-semibold">B</span>
                                            </div>
                                            <div>
                                                <h3 class="font-semibold text-gray-900">Grade 9B - Geometry Quiz</h3>
                                                <p class="text-sm text-gray-600">Average Score: 76%</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="w-16 bg-gray-200 rounded-full h-2">
                                                <div class="bg-yellow-600 h-2 rounded-full" style="width: 76%"></div>
                                            </div>
                                            <p class="text-xs text-gray-600 mt-1">35/48 students passed</p>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between p-4 border border-gray-100 rounded-lg">
                                        <div class="flex items-center space-x-3">
                                            <div
                                                class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                                <span class="text-red-600 font-semibold">C</span>
                                            </div>
                                            <div>
                                                <h3 class="font-semibold text-gray-900">Grade 11 - Calculus Assignment</h3>
                                                <p class="text-sm text-gray-600">Average Score: 68%</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="w-16 bg-gray-200 rounded-full h-2">
                                                <div class="bg-red-600 h-2 rounded-full" style="width: 68%"></div>
                                            </div>
                                            <p class="text-xs text-gray-600 mt-1">28/45 students passed</p>
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
                                        class="flex items-center space-x-3 p-3 border border-gray-100 rounded-lg hover:bg-blue-50 hover:border-blue-200 transition-colors group">
                                        <div
                                            class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                                            <i class="fas fa-plus text-blue-600"></i>
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-gray-900 text-sm">Create Assignment</h3>
                                            <p class="text-xs text-gray-600">New homework or test</p>
                                        </div>
                                    </a>

                                    <a href="#"
                                        class="flex items-center space-x-3 p-3 border border-gray-100 rounded-lg hover:bg-green-50 hover:border-green-200 transition-colors group">
                                        <div
                                            class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-200 transition-colors">
                                            <i class="fas fa-attendance text-green-600"></i>
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-gray-900 text-sm">Take Attendance</h3>
                                            <p class="text-xs text-gray-600">Mark today's presence</p>
                                        </div>
                                    </a>

                                    <a href="#"
                                        class="flex items-center space-x-3 p-3 border border-gray-100 rounded-lg hover:bg-purple-50 hover:border-purple-200 transition-colors group">
                                        <div
                                            class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                                            <i class="fas fa-grade text-purple-600"></i>
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-gray-900 text-sm">Grade Assignments</h3>
                                            <p class="text-xs text-gray-600">15 pending to grade</p>
                                        </div>
                                    </a>

                                    <a href="#"
                                        class="flex items-center space-x-3 p-3 border border-gray-100 rounded-lg hover:bg-orange-50 hover:border-orange-200 transition-colors group">
                                        <div
                                            class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center group-hover:bg-orange-200 transition-colors">
                                            <i class="fas fa-analytics text-orange-600"></i>
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-gray-900 text-sm">View Reports</h3>
                                            <p class="text-xs text-gray-600">Class performance analytics</p>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <!-- Upcoming Deadlines -->
                            <div class="bg-white rounded-xl shadow-sm p-6">
                                <h2 class="text-xl font-bold text-gray-900 mb-4">Upcoming Deadlines</h2>
                                <div class="space-y-3">
                                    <div class="p-3 border border-red-100 rounded-lg bg-red-50">
                                        <div class="flex justify-between items-start mb-2">
                                            <h3 class="font-semibold text-gray-900 text-sm">Grade 10 Algebra Test</h3>
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <i class="fas fa-exclamation-circle mr-1 text-xs"></i>
                                                Tomorrow
                                            </span>
                                        </div>
                                        <p class="text-xs text-gray-600 mb-2">50 students • 2 hours duration</p>
                                        <div class="flex items-center text-xs text-gray-500">
                                            <i class="fas fa-clock text-xs mr-1"></i>
                                            <span>Preparation: 80% complete</span>
                                        </div>
                                    </div>

                                    <div class="p-3 border border-yellow-100 rounded-lg bg-yellow-50">
                                        <div class="flex justify-between items-start mb-2">
                                            <h3 class="font-semibold text-gray-900 text-sm">Grade 9 Project Submission</h3>
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <i class="fas fa-clock mr-1 text-xs"></i>
                                                In 3 days
                                            </span>
                                        </div>
                                        <p class="text-xs text-gray-600 mb-2">48 projects to review</p>
                                        <div class="flex items-center text-xs text-gray-500">
                                            <i class="fas fa-check-circle text-xs mr-1"></i>
                                            <span>12 projects submitted early</span>
                                        </div>
                                    </div>

                                    <div class="p-3 border border-gray-100 rounded-lg">
                                        <div class="flex justify-between items-start mb-2">
                                            <h3 class="font-semibold text-gray-900 text-sm">Monthly Progress Report</h3>
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                <i class="fas fa-calendar mr-1 text-xs"></i>
                                                Next Week
                                            </span>
                                        </div>
                                        <p class="text-xs text-gray-600">Submit to department head</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Teaching Resources -->
                            <div
                                class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl shadow-sm p-6 text-white">
                                <h2 class="text-xl font-bold mb-4">Teaching Resources</h2>
                                <div class="space-y-3">
                                    <a href="#"
                                        class="flex items-center space-x-3 p-2 rounded-lg hover:bg-white/10 transition-colors">
                                        <i class="fas fa-book-open w-5 text-center"></i>
                                        <span class="text-sm">Lesson Plans</span>
                                    </a>
                                    <a href="#"
                                        class="flex items-center space-x-3 p-2 rounded-lg hover:bg-white/10 transition-colors">
                                        <i class="fas fa-file-pdf w-5 text-center"></i>
                                        <span class="text-sm">Worksheets & Templates</span>
                                    </a>
                                    <a href="#"
                                        class="flex items-center space-x-3 p-2 rounded-lg hover:bg-white/10 transition-colors">
                                        <i class="fas fa-video w-5 text-center"></i>
                                        <span class="text-sm">Teaching Videos</span>
                                    </a>
                                    <a href="#"
                                        class="flex items-center space-x-3 p-2 rounded-lg hover:bg-white/10 transition-colors">
                                        <i class="fas fa-chart-bar w-5 text-center"></i>
                                        <span class="text-sm">Assessment Tools</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Teacher Dashboard loaded successfully');

            // Add active class to current page in sidebar
            const currentPath = window.location.pathname;
            const sidebarLinks = document.querySelectorAll('aside nav a');

            sidebarLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('bg-blue-50', 'text-blue-700', 'border-r-2', 'border-blue-600');
                }
            });

            // Add hover effects to cards
            const cards = document.querySelectorAll('.bg-white');
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
