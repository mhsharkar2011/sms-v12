@extends('layouts.app')

@section('title', 'School Management System')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
    <div class="max-w-7xl mx-auto px-4 py-20">
        <div class="text-center">
            <h1 class="text-5xl font-bold mb-6">Welcome to School Management System</h1>
            <p class="text-xl mb-8 max-w-2xl mx-auto">
                Streamline your educational institution with our comprehensive school management solution.
                Manage students, teachers, and parents all in one platform.
            </p>
            <div class="space-x-4">
                <a href="{{ route('register') }}" class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
                    Get Started
                </a>
                <a href="#features" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-indigo-600 transition duration-300">
                    Learn More
                </a>
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
                <p class="text-gray-600">
                    Access courses, assignments, grades, and track your academic progress in one place.
                </p>
            </div>

            <!-- Teacher Feature -->
            <div class="bg-white rounded-lg shadow-lg p-8 text-center hover:shadow-xl transition duration-300">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-chalkboard-teacher text-green-600 text-2xl"></i>
                </div>
                <h3 class="text-2xl font-semibold text-gray-900 mb-4">Teacher Dashboard</h3>
                <p class="text-gray-600">
                    Manage classes, assignments, grading, and communicate with students and parents.
                </p>
            </div>

            <!-- Parent Feature -->
            <div class="bg-white rounded-lg shadow-lg p-8 text-center hover:shadow-xl transition duration-300">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-users text-purple-600 text-2xl"></i>
                </div>
                <h3 class="text-2xl font-semibold text-gray-900 mb-4">Parent Monitoring</h3>
                <p class="text-gray-600">
                    Monitor your child's progress, attendance, and communicate with teachers easily.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
            <div>
                <div class="text-4xl font-bold text-indigo-600 mb-2">500+</div>
                <div class="text-gray-600">Students</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-indigo-600 mb-2">50+</div>
                <div class="text-gray-600">Teachers</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-indigo-600 mb-2">1000+</div>
                <div class="text-gray-600">Parents</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-indigo-600 mb-2">98%</div>
                <div class="text-gray-600">Satisfaction</div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-4xl font-bold text-center text-gray-900 mb-12">How It Works</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="bg-indigo-100 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-indigo-600 font-bold">1</span>
                </div>
                <h3 class="text-xl font-semibold mb-2">Register</h3>
                <p class="text-gray-600">Create your account as a student, teacher, or parent</p>
            </div>
            <div class="text-center">
                <div class="bg-indigo-100 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-indigo-600 font-bold">2</span>
                </div>
                <h3 class="text-xl font-semibold mb-2">Setup</h3>
                <p class="text-gray-600">Complete your profile and get familiar with the dashboard</p>
            </div>
            <div class="text-center">
                <div class="bg-indigo-100 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-indigo-600 font-bold">3</span>
                </div>
                <h3 class="text-xl font-semibold mb-2">Engage</h3>
                <p class="text-gray-600">Start managing your educational activities efficiently</p>
            </div>
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
        <a href="{{ route('register') }}" class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
            Create Your Account
        </a>
    </div>
</section>

<!-- Footer -->
<footer class="bg-gray-800 text-white py-12">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <h4 class="text-lg font-semibold mb-4">SchoolSystem</h4>
                <p class="text-gray-400">
                    Comprehensive school management solution for modern educational institutions.
                </p>
            </div>
            <div>
                <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                <ul class="space-y-2 text-gray-400">
                    <li><a href="#" class="hover:text-white">Home</a></li>
                    <li><a href="#features" class="hover:text-white">Features</a></li>
                    <li><a href="#" class="hover:text-white">About</a></li>
                    <li><a href="#" class="hover:text-white">Contact</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-lg font-semibold mb-4">Contact</h4>
                <ul class="space-y-2 text-gray-400">
                    <li>Email: info@schoolsystem.com</li>
                    <li>Phone: +1 (555) 123-4567</li>
                    <li>Address: 123 Education St, City</li>
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
            <p>&copy; 2024 School Management System. All rights reserved.</p>
        </div>
    </div>
</footer>

<!-- Smooth scroll for anchor links -->
<script>
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
</script>
@endsection
