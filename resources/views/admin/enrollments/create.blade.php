@extends('layouts.app')

@section('title', 'Enroll Student')

@section('content')
    <div class="min-h-screen bg-gray-50 flex">
        <x-admin-sidebar />

        <div class="flex-1 overflow-auto">
            <div class="container mx-auto p-6">
                <!-- Header -->
                <div class="mb-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Enroll Student</h1>
                            <p class="text-gray-600 mt-2">Add a new student to a class</p>
                        </div>
                        <a href="{{ route('admin.enrollments.index') }}"
                            class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors flex items-center space-x-2">
                            <span class="material-icons-sharp text-sm">arrow_back</span>
                            <span>Back to Enrollments</span>
                        </a>
                    </div>
                </div>

                <!-- Breadcrumb -->
                <nav class="mb-6">
                    <ol class="flex items-center space-x-2 text-sm text-gray-600">
                        <li><a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600">Dashboard</a></li>
                        <li><span class="material-icons-sharp text-xs">chevron_right</span></li>
                        <li><a href="{{ route('admin.enrollments.index') }}" class="hover:text-blue-600">Enrollments</a>
                        </li>
                        <li><span class="material-icons-sharp text-xs">chevron_right</span></li>
                        <li class="text-gray-900">Enroll Student</li>
                    </ol>
                </nav>

                <div class="max-w-4xl mx-auto">
                    <!-- Flash Messages -->
                    @if ($errors->any())
                        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                            <div class="flex items-center space-x-2">
                                <span class="material-icons-sharp text-sm">error</span>
                                <span class="font-medium">Please fix the following errors:</span>
                            </div>
                            <ul class="mt-2 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Quick Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        @if ($selectedClass)
                            <div class="bg-white rounded-xl shadow-sm p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-gray-600">Selected Class</p>
                                        <p class="font-medium text-gray-900">{{ $selectedClass->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $selectedClass->code }} •
                                            {{ $selectedClass->grade_level }}</p>
                                    </div>
                                    <span class="material-icons-sharp text-blue-600">class</span>
                                </div>
                            </div>
                        @endif

                        @if ($selectedStudent)
                            <div class="bg-white rounded-xl shadow-sm p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-gray-600">Selected Student</p>
                                        <p class="font-medium text-gray-900">{{ $selectedStudent->user->name ?? 'N/A' }}</p>
                                        <p class="text-sm text-gray-500">{{ $selectedStudent->student_id ?? 'N/A' }}</p>
                                    </div>
                                    <span class="material-icons-sharp text-green-600">person</span>
                                </div>
                            </div>
                        @endif

                        <div class="bg-white rounded-xl shadow-sm p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-600">Available Classes</p>
                                    <p class="font-medium text-gray-900">{{ $classes->count() }}</p>
                                    <p class="text-sm text-gray-500">With available seats</p>
                                </div>
                                <span class="material-icons-sharp text-purple-600">school</span>
                            </div>
                        </div>
                    </div>

                    <!-- Form Card -->
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <form action="{{ route('admin.enrollments.store') }}" method="POST">
                            @csrf

                            <!-- Student Selection -->
                            <div class="p-6 border-b border-gray-200">
                                <h2 class="text-xl font-semibold text-gray-900 mb-4">1. Select Student</h2>

                                <div class="mb-4">
                                    <label for="student_search" class="block text-sm font-medium text-gray-700 mb-2">
                                        Search Student
                                    </label>
                                    <input type="text" id="student_search"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 mb-2"
                                        placeholder="Type to search students..." onkeyup="filterStudents()">
                                </div>

                                <div
                                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 max-h-96 overflow-y-auto p-2">
                                    @foreach ($students as $student)
                                        <div class="student-card border border-gray-200 rounded-lg p-4 hover:bg-blue-50 transition-colors cursor-pointer"
                                            data-student-id="{{ $student->id }}"
                                            data-student-name="{{ $student->user->name }}"
                                            data-student-email="{{ $student->user->email }}" onclick="selectStudent(this)">
                                            <div class="flex items-center space-x-3">
                                                <div class="flex-shrink-0">
                                                    <div
                                                        class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                        <span class="material-icons-sharp text-blue-600">person</span>
                                                    </div>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-gray-900 truncate">
                                                        {{ $student->user->name }}
                                                    </p>
                                                    <p class="text-sm text-gray-500 truncate">
                                                        {{ $student->user->email }}
                                                    </p>
                                                    <p class="text-xs text-gray-400 mt-1">
                                                        ID: {{ $student->student_id }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Selected Student Display -->
                                <div id="selectedStudentDisplay" class="mt-4 hidden">
                                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-sm text-blue-700">Selected Student:</p>
                                                <p id="selectedStudentName" class="font-medium text-blue-900"></p>
                                                <p id="selectedStudentEmail" class="text-sm text-blue-700"></p>
                                            </div>
                                            <button type="button" onclick="clearStudentSelection()"
                                                class="text-blue-600 hover:text-blue-800">
                                                <span class="material-icons-sharp">close</span>
                                            </button>
                                        </div>
                                        <input type="hidden" name="student_id" id="student_id"
                                            value="{{ old('student_id', $selectedStudent->id ?? '') }}">
                                    </div>
                                </div>

                                @error('student_id')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Class Selection -->
                            <div class="p-6 border-b border-gray-200">
                                <h2 class="text-xl font-semibold text-gray-900 mb-4">2. Select Class</h2>

                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach ($classes as $class)
                                        <div class="class-card border border-gray-200 rounded-lg p-4 hover:bg-green-50 transition-colors cursor-pointer"
                                            data-class-id="{{ $class->id }}" data-class-name="{{ $class->name }}"
                                            data-class-code="{{ $class->code }}"
                                            data-available-seats="{{ $class->available_seats }}"
                                            onclick="selectClass(this)">
                                            <div class="flex justify-between items-start mb-2">
                                                <div>
                                                    <h3 class="font-medium text-gray-900">{{ $class->name }}</h3>
                                                    <p class="text-sm text-gray-500">{{ $class->code }}</p>
                                                </div>
                                                <span class="material-icons-sharp text-green-600">class</span>
                                            </div>

                                            <div class="space-y-2 text-sm">
                                                <div class="flex justify-between">
                                                    <span class="text-gray-600">Grade Level:</span>
                                                    <span class="font-medium">{{ $class->grade_level }}</span>
                                                </div>
                                                <div class="flex justify-between">
                                                    <span class="text-gray-600">Section:</span>
                                                    <span class="font-medium">{{ $class->section }}</span>
                                                </div>
                                                <div class="flex justify-between">
                                                    <span class="text-gray-600">Teacher:</span>
                                                    <span class="font-medium">
                                                        {{ $class->teachers->first()->name ?? 'Not Assigned' }}
                                                    </span>
                                                </div>
                                                <div class="flex justify-between">
                                                    <span class="text-gray-600">Available Seats:</span>
                                                    <span
                                                        class="font-medium {{ $class->available_seats > 0 ? 'text-green-600' : 'text-red-600' }}">
                                                        {{ $class->available_seats }} / {{ $class->capacity }}
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="mt-3 pt-3 border-t border-gray-100">
                                                <span class="text-xs text-gray-500">
                                                    {{ $class->academic_year }}
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Selected Class Display -->
                                <div id="selectedClassDisplay" class="mt-4 hidden">
                                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-sm text-green-700">Selected Class:</p>
                                                <p id="selectedClassName" class="font-medium text-green-900"></p>
                                                <p id="selectedClassDetails" class="text-sm text-green-700"></p>
                                                <p id="selectedClassSeats" class="text-sm text-green-700 mt-1"></p>
                                            </div>
                                            <button type="button" onclick="clearClassSelection()"
                                                class="text-green-600 hover:text-green-800">
                                                <span class="material-icons-sharp">close</span>
                                            </button>
                                        </div>
                                        <input type="hidden" name="class_id" id="class_id"
                                            value="{{ old('class_id', $selectedClass->id ?? '') }}">
                                    </div>
                                </div>

                                @error('class_id')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Enrollment Details -->
                            <div class="p-6 border-b border-gray-200">
                                <h2 class="text-xl font-semibold text-gray-900 mb-4">3. Enrollment Details</h2>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Enrollment Date -->
                                    <div>
                                        <label for="enrollment_date" class="block text-sm font-medium text-gray-700 mb-2">
                                            Enrollment Date *
                                        </label>
                                        <input type="date" name="enrollment_date" id="enrollment_date"
                                            value="{{ old('enrollment_date', date('Y-m-d')) }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            required>
                                        @error('enrollment_date')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Start Date -->
                                    <div>
                                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">
                                            Start Date *
                                        </label>
                                        <input type="date" name="start_date" id="start_date"
                                            value="{{ old('start_date', date('Y-m-d')) }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            required>
                                        @error('start_date')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Tuition Fee -->
                                    <div>
                                        <label for="tuition_fee" class="block text-sm font-medium text-gray-700 mb-2">
                                            Tuition Fee (Optional)
                                        </label>
                                        <div class="relative">
                                            <span class="absolute left-3 top-2 text-gray-500">$</span>
                                            <input type="number" name="tuition_fee" id="tuition_fee" step="0.01"
                                                min="0" value="{{ old('tuition_fee') }}"
                                                class="w-full border border-gray-300 rounded-lg pl-8 pr-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                placeholder="0.00">
                                        </div>
                                        @error('tuition_fee')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Notes -->
                                    <div class="md:col-span-2">
                                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                            Notes (Optional)
                                        </label>
                                        <textarea name="notes" id="notes" rows="3"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            placeholder="Any additional notes about this enrollment...">{{ old('notes') }}</textarea>
                                        @error('notes')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="px-6 py-4 bg-gray-50">
                                <div class="flex items-center justify-between">
                                    <a href="{{ route('admin.enrollments.index') }}"
                                        class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                                        Cancel
                                    </a>
                                    <button type="submit"
                                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2">
                                        <span class="material-icons-sharp text-sm">person_add</span>
                                        <span>Enroll Student</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Help Text -->
                    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-xl p-4">
                        <div class="flex items-start space-x-3">
                            <span class="material-icons-sharp text-blue-600 text-sm mt-0.5">info</span>
                            <div>
                                <h3 class="text-sm font-medium text-blue-900">Enrollment Process</h3>
                                <ul class="mt-2 text-sm text-blue-800 list-disc list-inside space-y-1">
                                    <li>Select a student who is not currently enrolled in any active class</li>
                                    <li>Choose a class with available seats</li>
                                    <li>Enrollment will be active immediately after submission</li>
                                    <li>You can update enrollment details later if needed</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Filter students based on search
            function filterStudents() {
                const search = document.getElementById('student_search').value.toLowerCase();
                const cards = document.querySelectorAll('.student-card');

                cards.forEach(card => {
                    const name = card.getAttribute('data-student-name').toLowerCase();
                    const email = card.getAttribute('data-student-email').toLowerCase();

                    if (name.includes(search) || email.includes(search)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            }

            // Select student
            function selectStudent(element) {
                const studentId = element.getAttribute('data-student-id');
                const studentName = element.getAttribute('data-student-name');
                const studentEmail = element.getAttribute('data-student-email');

                // Set hidden input
                document.getElementById('student_id').value = studentId;

                // Update display
                document.getElementById('selectedStudentName').textContent = studentName;
                document.getElementById('selectedStudentEmail').textContent = studentEmail;
                document.getElementById('selectedStudentDisplay').classList.remove('hidden');

                // Highlight selected card
                document.querySelectorAll('.student-card').forEach(card => {
                    card.classList.remove('bg-blue-100', 'border-blue-300');
                });
                element.classList.add('bg-blue-100', 'border-blue-300');
            }

            // Clear student selection
            function clearStudentSelection() {
                document.getElementById('student_id').value = '';
                document.getElementById('selectedStudentDisplay').classList.add('hidden');
                document.querySelectorAll('.student-card').forEach(card => {
                    card.classList.remove('bg-blue-100', 'border-blue-300');
                });
            }

            // Select class
            function selectClass(element) {
                const classId = element.getAttribute('data-class-id');
                const className = element.getAttribute('data-class-name');
                const classCode = element.getAttribute('data-class-code');
                const availableSeats = element.getAttribute('data-available-seats');

                // Set hidden input
                document.getElementById('class_id').value = classId;

                // Update display
                document.getElementById('selectedClassName').textContent = `${className} (${classCode})`;
                document.getElementById('selectedClassDetails').textContent =
                    `${element.querySelector('.text-sm:nth-child(2)').textContent}`;
                document.getElementById('selectedClassSeats').textContent = `Available seats: ${availableSeats}`;
                document.getElementById('selectedClassDisplay').classList.remove('hidden');

                // Highlight selected card
                document.querySelectorAll('.class-card').forEach(card => {
                    card.classList.remove('bg-green-100', 'border-green-300');
                });
                element.classList.add('bg-green-100', 'border-green-300');
            }

            // Clear class selection
            function clearClassSelection() {
                document.getElementById('class_id').value = '';
                document.getElementById('selectedClassDisplay').classList.add('hidden');
                document.querySelectorAll('.class-card').forEach(card => {
                    card.classList.remove('bg-green-100', 'border-green-300');
                });
            }

            // Initialize with pre-selected values
            document.addEventListener('DOMContentLoaded', function() {
                @if ($selectedStudent)
                    const studentCard = document.querySelector(
                        `.student-card[data-student-id="{{ $selectedStudent->id }}"]`);
                    if (studentCard) {
                        selectStudent(studentCard);
                    }
                @endif

                @if ($selectedClass)
                    const classCard = document.querySelector(`.class-card[data-class-id="{{ $selectedClass->id }}"]`);
                    if (classCard) {
                        selectClass(classCard);
                    }
                @endif
            });

            // Form validation
            document.querySelector('form').addEventListener('submit', function(e) {
                if (!document.getElementById('student_id').value || !document.getElementById('class_id').value) {
                    e.preventDefault();
                    alert('Please select both a student and a class.');
                }
            });
        </script>
    @endpush

    @push('styles')
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
        <style>
            .material-icons-sharp {
                font-size: inherit;
            }

            .student-card,
            .class-card {
                transition: all 0.2s ease;
            }

            .student-card:hover,
            .class-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            }
        </style>
    @endpush
@endsection
