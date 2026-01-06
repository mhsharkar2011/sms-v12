@extends('layouts.app')

@section('title', 'School Management System')

@section('content')
    @php
        // Get statistics from database
        $studentCount = App\Models\Student::count();
        $teacherCount = App\Models\Teacher::count();
        $parentCount = App\Models\Guardian::count();
        $activeClassCount = App\Models\SchoolClass::where('status', 'active')->count();

        // Get current user if logged in
        $user = Auth::user();
    @endphp

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
        <div class="max-w-7xl mx-auto px-4 py-20">
            <div class="text-center">
                <h1 class="text-5xl font-bold mb-6">
                    @if ($user)
                        Welcome back, {{ $user->name }}!
                    @else
                        Welcome to {{ config('app.name', 'School Management System') }}
                    @endif
                </h1>
                <p class="text-xl mb-8 max-w-2xl mx-auto">
                    Streamline your educational institution with our comprehensive school management solution.
                    Manage students, teachers, and parents all in one platform.
                </p>
                <div class="space-x-4">
                    @auth
                        @if ($user->role == 'admin')
                            <a href="{{ route('admin.dashboard') }}"
                                class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
                                Admin Dashboard
                            </a>
                        @elseif($user->role == 'teacher')
                            <a href="{{ route('teacher.dashboard') }}"
                                class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
                                Teacher Dashboard
                            </a>
                        @elseif($user->role == 'student')
                            <a href="{{ route('student.dashboard') }}"
                                class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
                                Student Dashboard
                            </a>
                        @elseif($user->role == 'parent')
                            <a href="{{ route('parent.dashboard') }}"
                                class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
                                Parent Dashboard
                            </a>
                        @endif
                    @else
                        <a href="{{ route('register') }}"
                            class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
                            Get Started
                        </a>
                        <a href="#features"
                            class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-indigo-600 transition duration-300">
                            Learn More
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-4xl font-bold text-center text-gray-900 mb-12">Features</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Student Feature -->
                <div class="bg-white rounded-lg shadow-lg p-8 text-center hover:shadow-xl transition duration-300">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-user-graduate text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-4">Student Portal</h3>
                    <p class="text-gray-600 mb-4">
                        Access courses, assignments, grades, and track your academic progress in one place.
                    </p>
                    @if ($studentCount > 0)
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <span class="text-sm text-blue-600 font-semibold">
                                {{ $studentCount }} Active Students
                            </span>
                        </div>
                    @endif
                </div>

                <!-- Teacher Feature -->
                <div class="bg-white rounded-lg shadow-lg p-8 text-center hover:shadow-xl transition duration-300">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-chalkboard-teacher text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-4">Teacher Dashboard</h3>
                    <p class="text-gray-600 mb-4">
                        Manage classes, assignments, grading, and communicate with students and parents.
                    </p>
                    @if ($teacherCount > 0)
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <span class="text-sm text-green-600 font-semibold">
                                {{ $teacherCount }} Qualified Teachers
                            </span>
                        </div>
                    @endif
                </div>

                <!-- Parent Feature -->
                <div class="bg-white rounded-lg shadow-lg p-8 text-center hover:shadow-xl transition duration-300">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-users text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-4">Parent Monitoring</h3>
                    <p class="text-gray-600 mb-4">
                        Monitor your child's progress, attendance, and communicate with teachers easily.
                    </p>
                    @if ($parentCount > 0)
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <span class="text-sm text-purple-600 font-semibold">
                                {{ $parentCount }} Engaged Parents
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-4xl font-bold text-indigo-600 mb-2">{{ $studentCount }}</div>
                    <div class="text-gray-600">Active Students</div>
                    <div class="text-sm text-gray-400 mt-1">
                        {{ App\Models\Student::where('status', 'active')->count() }} currently active
                    </div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-indigo-600 mb-2">{{ $teacherCount }}</div>
                    <div class="text-gray-600">Qualified Teachers</div>
                    <div class="text-sm text-gray-400 mt-1">
                        {{ App\Models\Teacher::where('status', 'active')->count() }} active
                    </div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-indigo-600 mb-2">{{ $parentCount }}</div>
                    <div class="text-gray-600">Engaged Parents</div>
                    <div class="text-sm text-gray-400 mt-1">
                        {{ App\Models\Guardian::where('is_active', 'active')->count() }} active
                    </div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-indigo-600 mb-2">{{ $activeClassCount }}</div>
                    <div class="text-gray-600">Active Classes</div>
                    <div class="text-sm text-gray-400 mt-1">
                        {{ App\Models\SchoolClass::where('status', 'active')->count() }} running classes
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Recent Activities Section -->
    @php
        $recentActivities = App\Models\ActivityLog::latest()->take(5)->get();
        $upcomingEvents = App\Models\Event::where('event_date', '>=', now())->orderBy('event_date')->take(3)->get();
    @endphp
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-4xl font-bold text-center text-gray-900 mb-12">Recent Activities</h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Recent Activities -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Latest Updates</h3>
                    @if ($recentActivities->count() > 0)
                        <div class="space-y-4">
                            @foreach ($recentActivities as $activity)
                                <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="w-8 h-8 rounded-full {{ $activity->type == 'info' ? 'bg-blue-100' : ($activity->type == 'success' ? 'bg-green-100' : 'bg-gray-100') }} flex items-center justify-center">
                                            <i
                                                class="fas {{ $activity->icon ?? 'fa-bell' }} text-sm {{ $activity->type == 'info' ? 'text-blue-600' : ($activity->type == 'success' ? 'text-green-600' : 'text-gray-600') }}"></i>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm text-gray-800">{{ $activity->description }}</p>
                                        <p class="text-xs text-gray-500 mt-1">{{ $activity->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500">No recent activities to display</p>
                        </div>
                    @endif
                </div>

                <!-- Upcoming Events -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Upcoming Events</h3>
                    @if ($upcomingEvents->count() > 0)
                        <div class="space-y-4">
                            @foreach ($upcomingEvents as $event)
                                <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="w-12 h-12 bg-indigo-100 rounded-lg flex flex-col items-center justify-center">
                                            <span
                                                class="text-xs text-indigo-600 font-bold">{{ $event->event_date->format('M') }}</span>
                                            <span
                                                class="text-lg font-bold text-indigo-600">{{ $event->event_date->format('d') }}</span>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900">{{ $event->title }}</h4>
                                        <p class="text-sm text-gray-600 mt-1">{{ $event->description }}</p>
                                        <div class="flex items-center text-xs text-gray-500 mt-2">
                                            <i class="fas fa-clock mr-1"></i>
                                            {{ $event->event_date->format('h:i A') }}
                                            @if ($event->location)
                                                <i class="fas fa-map-marker-alt ml-3 mr-1"></i>
                                                {{ $event->location }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500">No upcoming events</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-4xl font-bold text-center text-gray-900 mb-12">How It Works</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-indigo-600 font-bold text-2xl">1</span>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Register</h3>
                    <p class="text-gray-600">Create your account as a student, teacher, or parent</p>
                </div>
                <div class="text-center">
                    <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-indigo-600 font-bold text-2xl">2</span>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Setup</h3>
                    <p class="text-gray-600">Complete your profile and get familiar with the dashboard</p>
                </div>
                <div class="text-center">
                    <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-indigo-600 font-bold text-2xl">3</span>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Engage</h3>
                    <p class="text-gray-600">Start managing your educational activities efficiently</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    @php
        $testimonials = [
            [
                'name' => 'Principal Sharma',
                'role' => 'School Principal',
                'content' =>
                    'This system has revolutionized how we manage our school. Everything is now at our fingertips.',
                'rating' => 5,
            ],
            [
                'name' => 'Teacher Priya',
                'role' => 'Mathematics Teacher',
                'content' => 'Grading and communication with students has become so much easier. Highly recommended!',
                'rating' => 5,
            ],
            [
                'name' => 'Parent Raj',
                'role' => 'Student Parent',
                'content' => 'I can monitor my child\'s progress in real-time. The parent portal is amazing!',
                'rating' => 4,
            ],
        ];
    @endphp
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-4xl font-bold text-center text-gray-900 mb-12">What Our Users Say</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach ($testimonials as $testimonial)
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <div class="flex items-center mb-4">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="w-5 h-5 {{ $i <= $testimonial['rating'] ? 'text-yellow-400' : 'text-gray-300' }}"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            @endfor
                        </div>
                        <p class="text-gray-600 mb-4 italic">"{{ $testimonial['content'] }}"</p>
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                                <span class="text-indigo-600 font-bold">{{ substr($testimonial['name'], 0, 1) }}</span>
                            </div>
                            <div class="ml-3">
                                <h4 class="font-semibold text-gray-900">{{ $testimonial['name'] }}</h4>
                                <p class="text-sm text-gray-600">{{ $testimonial['role'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-indigo-600 text-white">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-4">Ready to Get Started?</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">
                Join thousands of educational institutions using our platform to streamline their operations.
            </p>
            @auth
                <a href="{{ route('dashboard') }}"
                    class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
                    Go to Dashboard
                </a>
            @else
                <div class="space-x-4">
                    <a href="{{ route('register') }}"
                        class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
                        Create Your Account
                    </a>
                    <a href="{{ route('login') }}"
                        class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-indigo-600 transition duration-300">
                        Login
                    </a>
                </div>
            @endauth
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h4 class="text-lg font-semibold mb-4">{{ config('app.name', 'SchoolSystem') }}</h4>
                    <p class="text-gray-400">
                        Comprehensive school management solution for modern educational institutions.
                    </p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="{{ url('/') }}" class="hover:text-white">Home</a></li>
                        <li><a href="#features" class="hover:text-white">Features</a></li>
                        @if ($activeClassCount > 0)
                            <li><a href="#" class="hover:text-white">Classes</a></li>
                        @endif
                        @if ($teacherCount > 0)
                            <li><a href="#" class="hover:text-white">Teachers</a></li>
                        @endif
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Contact</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li>Email: {{ config('mail.from.address', 'info@schoolsystem.com') }}</li>
                        <li>Phone: {{ config('app.phone', '+1 (555) 123-4567') }}</li>
                        <li>Address: {{ config('app.address', '123 Education St, City') }}</li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Follow Us</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} {{ config('app.name', 'School Management System') }}. All rights reserved.
                </p>
                <p class="text-sm mt-2">Version: {{ config('app.version', '1.0.0') }}</p>
            </div>
        </div>
    </footer>

    <!-- Smooth scroll for anchor links -->
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
@endsection
