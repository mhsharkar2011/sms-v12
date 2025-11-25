@extends('layouts.app')

@section('title', 'Student Dashboard')

@section('content')
    <div class="min-h-screen bg-gray-50 flex">
        <!-- Sidebar Navigation -->
        <aside class="w-64 bg-white shadow-lg">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <div
                        class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div>
                        <h2 class="font-semibold text-gray-900 text-sm">{{ Auth::user()->name }}</h2>
                        <p class="text-xs text-gray-500">Grade 10</p>
                    </div>
                </div>
            </div>
            <x-student-sidebar />
            <!-- Quick Stats in Sidebar -->
            <div class="p-4 border-t border-gray-200">
                <div class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg p-4 text-white">
                    <h3 class="font-semibold text-sm mb-2">This Week</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span>Classes Attended</span>
                            <span class="font-bold">18/20</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Homework Done</span>
                            <span class="font-bold">5/6</span>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <div class="container mx-auto p-6">
                <!-- Welcome Header -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-900">Welcome back, {{ Auth::user()->name }}! 👋</h1>
                    <p class="text-gray-600 mt-2">Here's your academic overview for today</p>

                    <!-- Quick Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-6">
                        <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-600">Today's Classes</p>
                                    <p class="text-2xl font-bold text-gray-900">6</p>
                                </div>
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <span class="material-icons-sharp text-blue-600">school</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-600">Pending Homework</p>
                                    <p class="text-2xl font-bold text-gray-900">2</p>
                                </div>
                                <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                                    <span class="material-icons-sharp text-orange-600">assignment</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-600">Overall Attendance</p>
                                    <p class="text-2xl font-bold text-gray-900">92%</p>
                                </div>
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                    <span class="material-icons-sharp text-green-600">trending_up</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-600">Current GPA</p>
                                    <p class="text-2xl font-bold text-gray-900">8.7</p>
                                </div>
                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <span class="material-icons-sharp text-purple-600">star</span>
                                </div>
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
                                <h2 class="text-xl font-bold text-gray-900">Today's Schedule</h2>
                                <span class="text-sm text-gray-500">{{ now()->format('l, F j') }}</span>
                            </div>

                            <div class="space-y-4">
                                <div class="flex items-center space-x-4 p-4 bg-blue-50 rounded-lg border border-blue-100">
                                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <span class="material-icons-sharp text-blue-600">science</span>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-900">Science</h3>
                                        <p class="text-sm text-gray-600">Mr. Johnson • Room 201</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold text-gray-900">08:00 - 09:00</p>
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Ongoing
                                        </span>
                                    </div>
                                </div>

                                <div class="flex items-center space-x-4 p-4 border border-gray-100 rounded-lg">
                                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                        <span class="material-icons-sharp text-green-600">calculate</span>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-900">Mathematics</h3>
                                        <p class="text-sm text-gray-600">Ms. Davis • Room 105</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold text-gray-900">09:00 - 10:00</p>
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            Upcoming
                                        </span>
                                    </div>
                                </div>

                                <div class="flex items-center space-x-4 p-4 border border-gray-100 rounded-lg">
                                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                        <span class="material-icons-sharp text-purple-600">language</span>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-900">English</h3>
                                        <p class="text-sm text-gray-600">Mrs. Wilson • Room 302</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold text-gray-900">10:30 - 11:30</p>
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            Upcoming
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Subject Performance -->
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-6">Subject Performance</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Math -->
                                <div class="p-4 border border-gray-100 rounded-lg">
                                    <div class="flex items-center space-x-3 mb-3">
                                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <span class="material-icons-sharp text-blue-600">calculate</span>
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-gray-900">Mathematics</h3>
                                            <p class="text-sm text-gray-600">Current Grade: A</p>
                                        </div>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-blue-600 h-2 rounded-full" style="width: 92%"></div>
                                    </div>
                                    <div class="flex justify-between text-xs text-gray-600 mt-1">
                                        <span>Progress</span>
                                        <span>92%</span>
                                    </div>
                                </div>

                                <!-- Science -->
                                <div class="p-4 border border-gray-100 rounded-lg">
                                    <div class="flex items-center space-x-3 mb-3">
                                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                            <span class="material-icons-sharp text-green-600">science</span>
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-gray-900">Science</h3>
                                            <p class="text-sm text-gray-600">Current Grade: A-</p>
                                        </div>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-green-600 h-2 rounded-full" style="width: 88%"></div>
                                    </div>
                                    <div class="flex justify-between text-xs text-gray-600 mt-1">
                                        <span>Progress</span>
                                        <span>88%</span>
                                    </div>
                                </div>

                                <!-- English -->
                                <div class="p-4 border border-gray-100 rounded-lg">
                                    <div class="flex items-center space-x-3 mb-3">
                                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                            <span class="material-icons-sharp text-purple-600">language</span>
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-gray-900">English</h3>
                                            <p class="text-sm text-gray-600">Current Grade: B+</p>
                                        </div>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-purple-600 h-2 rounded-full" style="width: 85%"></div>
                                    </div>
                                    <div class="flex justify-between text-xs text-gray-600 mt-1">
                                        <span>Progress</span>
                                        <span>85%</span>
                                    </div>
                                </div>

                                <!-- History -->
                                <div class="p-4 border border-gray-100 rounded-lg">
                                    <div class="flex items-center space-x-3 mb-3">
                                        <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                                            <span class="material-icons-sharp text-orange-600">history_edu</span>
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-gray-900">History</h3>
                                            <p class="text-sm text-gray-600">Current Grade: A</p>
                                        </div>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-orange-600 h-2 rounded-full" style="width: 94%"></div>
                                    </div>
                                    <div class="flex justify-between text-xs text-gray-600 mt-1">
                                        <span>Progress</span>
                                        <span>94%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Sidebar -->
                    <div class="space-y-6">
                        <!-- Upcoming Events -->
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">Upcoming Events</h2>
                            <div class="space-y-4">
                                <div class="p-3 bg-blue-50 rounded-lg border border-blue-100">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <span class="material-icons-sharp text-blue-600 text-sm">sports_soccer</span>
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-gray-900 text-sm">Sports Day</h3>
                                            <p class="text-xs text-gray-600">Tomorrow • 9:00 AM</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-3 bg-green-50 rounded-lg border border-green-100">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                            <span class="material-icons-sharp text-green-600 text-sm">science</span>
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-gray-900 text-sm">Science Fair</h3>
                                            <p class="text-xs text-gray-600">March 15 • 10:00 AM</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-3 bg-purple-50 rounded-lg border border-purple-100">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                            <span class="material-icons-sharp text-purple-600 text-sm">menu_book</span>
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-gray-900 text-sm">Parent-Teacher Meeting</h3>
                                            <p class="text-xs text-gray-600">March 20 • 2:00 PM</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Homework -->
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">Pending Homework</h2>
                            <div class="space-y-3">
                                <div class="p-3 border border-gray-100 rounded-lg">
                                    <div class="flex justify-between items-start mb-2">
                                        <h3 class="font-semibold text-gray-900 text-sm">Math Worksheet</h3>
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Due Tomorrow
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-600 mb-2">Algebra problems chapter 5</p>
                                    <div class="flex items-center text-xs text-gray-500">
                                        <span class="material-icons-sharp text-sm mr-1">schedule</span>
                                        <span>Submitted: 0/10 problems</span>
                                    </div>
                                </div>

                                <div class="p-3 border border-gray-100 rounded-lg">
                                    <div class="flex justify-between items-start mb-2">
                                        <h3 class="font-semibold text-gray-900 text-sm">Science Project</h3>
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Due in 3 days
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-600 mb-2">Solar system model</p>
                                    <div class="flex items-center text-xs text-gray-500">
                                        <span class="material-icons-sharp text-sm mr-1">schedule</span>
                                        <span>Progress: 60% complete</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Links -->
                        <div class="bg-gradient-to-r from-blue-600 to-purple-700 rounded-xl shadow-sm p-6 text-white">
                            <h2 class="text-xl font-bold mb-4">Quick Links</h2>
                            <div class="space-y-3">
                                <a href="#"
                                    class="flex items-center space-x-3 p-2 rounded-lg hover:bg-white/10 transition-colors">
                                    <span class="material-icons-sharp">download</span>
                                    <span class="text-sm">Download Study Material</span>
                                </a>
                                <a href="#"
                                    class="flex items-center space-x-3 p-2 rounded-lg hover:bg-white/10 transition-colors">
                                    <span class="material-icons-sharp">video_library</span>
                                    <span class="text-sm">Online Classes</span>
                                </a>
                                <a href="#"
                                    class="flex items-center space-x-3 p-2 rounded-lg hover:bg-white/10 transition-colors">
                                    <span class="material-icons-sharp">assignment_turned_in</span>
                                    <span class="text-sm">Submit Assignment</span>
                                </a>
                                <a href="#"
                                    class="flex items-center space-x-3 p-2 rounded-lg hover:bg-white/10 transition-colors">
                                    <span class="material-icons-sharp">library_books</span>
                                    <span class="text-sm">Digital Library</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <style>
        .material-icons-sharp {
            font-family: 'Material Icons Sharp';
            font-weight: normal;
            font-style: normal;
            font-size: 24px;
            line-height: 1;
            letter-spacing: normal;
            text-transform: none;
            display: inline-block;
            white-space: nowrap;
            word-wrap: normal;
            direction: ltr;
            -webkit-font-feature-settings: 'liga';
            -webkit-font-smoothing: antialiased;
        }

        /* Custom scrollbar */
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
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('School Student Dashboard loaded successfully');

            // Add active class to current page in sidebar
            const currentPath = window.location.pathname;
            const sidebarLinks = document.querySelectorAll('aside nav a');

            sidebarLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('bg-blue-50', 'text-blue-700', 'border-blue-100');
                    link.classList.remove('text-gray-700', 'hover:bg-gray-50');
                }
            });
        });
    </script>
@endpush
