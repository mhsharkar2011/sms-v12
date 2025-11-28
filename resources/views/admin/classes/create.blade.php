@extends('layouts.app')

@section('title', 'Create New Class')

@section('content')
    <div class="min-h-screen bg-gray-50 flex">
        <x-admin-sidebar />

        <div class="flex-1 overflow-auto">
            <div class="container mx-auto p-6">
                <!-- Header -->
                <div class="mb-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Create New Class</h1>
                            <p class="text-gray-600 mt-2">Add a new class to the system</p>
                        </div>
                        <a href="{{ route('admin.classes.index') }}"
                            class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors flex items-center space-x-2">
                            <span class="material-icons-sharp text-sm">arrow_back</span>
                            <span>Back to Classes</span>
                        </a>
                    </div>
                </div>

                <!-- Breadcrumb -->
                <nav class="mb-6">
                    <ol class="flex items-center space-x-2 text-sm text-gray-600">
                        <li><a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600">Dashboard</a></li>
                        <li><span class="material-icons-sharp text-xs">chevron_right</span></li>
                        <li><a href="{{ route('admin.classes.index') }}" class="hover:text-blue-600">Classes</a></li>
                        <li><span class="material-icons-sharp text-xs">chevron_right</span></li>
                        <li class="text-gray-900">Create New Class</li>
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

                    <!-- Form Card -->
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <form action="{{ route('admin.classes.store') }}" method="POST">
                            @csrf

                            <!-- Basic Information Section -->
                            <div class="p-6 border-b border-gray-200">
                                <h2 class="text-xl font-semibold text-gray-900 mb-4">Basic Information</h2>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Class Name -->
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                            Class Name *
                                        </label>
                                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                                            placeholder="e.g., Mathematics 101" required>
                                        @error('name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Class Code -->
                                    <div>
                                        <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
                                            Class Code *
                                        </label>
                                        <input type="text" name="code" id="code" value="{{ old('code') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('code') border-red-500 @enderror"
                                            placeholder="e.g., MATH-101" required>
                                        @error('code')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Grade Level -->
                                    <div>
                                        <label for="grade_level" class="block text-sm font-medium text-gray-700 mb-2">
                                            Grade Level *
                                        </label>
                                        <select name="grade_level" id="grade_level"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('grade_level') border-red-500 @enderror"
                                            required>
                                            <option value="">Select Grade Level</option>
                                            @foreach (['Kindergarten', 'Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6', 'Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Grade 11', 'Grade 12'] as $level)
                                                <option value="{{ $level }}"
                                                    {{ old('grade_level') == $level ? 'selected' : '' }}>
                                                    {{ $level }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('grade_level')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Section -->
                                    <div>
                                        <label for="section" class="block text-sm font-medium text-gray-700 mb-2">
                                            Section *
                                        </label>
                                        <input type="text" name="section" id="section" value="{{ old('section') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('section') border-red-500 @enderror"
                                            placeholder="e.g., A, B, C" required>
                                        @error('section')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Class Details Section -->
                            <div class="p-6 border-b border-gray-200">
                                <h2 class="text-xl font-semibold text-gray-900 mb-4">Class Details</h2>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Subject -->
                                    <div>
                                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                                            Subject
                                        </label>
                                        <input type="text" name="subject" id="subject" value="{{ old('subject') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('subject') border-red-500 @enderror"
                                            placeholder="e.g., Mathematics">
                                        @error('subject')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Room Number -->
                                    <div>
                                        <label for="room_number" class="block text-sm font-medium text-gray-700 mb-2">
                                            Room Number
                                        </label>
                                        <input type="text" name="room_number" id="room_number"
                                            value="{{ old('room_number') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('room_number') border-red-500 @enderror"
                                            placeholder="e.g., Room 101">
                                        @error('room_number')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Academic Year -->
                                    <div>
                                        <label for="academic_year" class="block text-sm font-medium text-gray-700 mb-2">
                                            Academic Year *
                                        </label>
                                        <input type="text" name="academic_year" id="academic_year"
                                            value="{{ old('academic_year', date('Y') . '-' . (date('Y') + 1)) }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('academic_year') border-red-500 @enderror"
                                            placeholder="e.g., 2024-2025" required>
                                        @error('academic_year')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Capacity -->
                                    <div>
                                        <label for="capacity" class="block text-sm font-medium text-gray-700 mb-2">
                                            Maximum Capacity *
                                        </label>
                                        <input type="number" name="capacity" id="capacity"
                                            value="{{ old('capacity', 30) }}" min="1" max="100"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('capacity') border-red-500 @enderror"
                                            required>
                                        @error('capacity')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Schedule & Additional Information -->
                            <div class="p-6 border-b border-gray-200">
                                <h2 class="text-xl font-semibold text-gray-900 mb-4">Schedule & Additional Information</h2>

                                <div class="grid grid-cols-1 gap-6">
                                    <!-- Description -->
                                    <div>
                                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                            Class Description
                                        </label>
                                        <textarea name="description" id="description" rows="4"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror"
                                            placeholder="Enter class description...">{{ old('description') }}</textarea>
                                        @error('description')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Schedule Information -->
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                        <!-- Start Time -->
                                        <div>
                                            <label for="start_time" class="block text-sm font-medium text-gray-700 mb-2">
                                                Start Time
                                            </label>
                                            <input type="time" name="start_time" id="start_time"
                                                value="{{ old('start_time') }}"
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        </div>

                                        <!-- End Time -->
                                        <div>
                                            <label for="end_time" class="block text-sm font-medium text-gray-700 mb-2">
                                                End Time
                                            </label>
                                            <input type="time" name="end_time" id="end_time"
                                                value="{{ old('end_time') }}"
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        </div>

                                        <!-- Days of Week -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Meeting Days
                                            </label>
                                            <div class="flex flex-wrap gap-2">
                                                @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                                    <label class="inline-flex items-center">
                                                        <input type="checkbox" name="meeting_days[]"
                                                            value="{{ $day }}"
                                                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                                            {{ in_array($day, old('meeting_days', [])) ? 'checked' : '' }}>
                                                        <span
                                                            class="ml-1 text-sm text-gray-700">{{ substr($day, 0, 3) }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Status & Teacher Assignment -->
                            <div class="p-6">
                                <h2 class="text-xl font-semibold text-gray-900 mb-4">Status & Teacher Assignment</h2>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Status -->
                                    <div>
                                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                            Status *
                                        </label>
                                        <select name="status" id="status"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            required>
                                            <option value="active"
                                                {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                                Inactive</option>
                                            <option value="planned" {{ old('status') == 'planned' ? 'selected' : '' }}>
                                                Planned</option>
                                        </select>
                                    </div>

                                    <!-- Teacher Assignment -->
                                    <div>
                                        <label for="teacher_id" class="block text-sm font-medium text-gray-700 mb-2">
                                            Assign Teacher
                                        </label>
                                        <select name="teacher_id" id="teacher_id"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            <option value="">Select a Teacher</option>
                                            @if (isset($teachers) && $teachers->count())
                                                @foreach ($teachers as $teacher)
                                                    <option value="{{ $teacher->id }}"
                                                        {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                                        {{ $teacher->name }} - {{ $teacher->email }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <p class="mt-1 text-sm text-gray-500">You can assign a teacher later if needed</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                                <div class="flex items-center justify-between">
                                    <a href="{{ route('admin.classes.index') }}"
                                        class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                                        Cancel
                                    </a>
                                    <div class="flex space-x-3">
                                        <button type="button" onclick="resetForm()"
                                            class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                                            Reset Form
                                        </button>
                                        <button type="submit"
                                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2">
                                            <span class="material-icons-sharp text-sm">add</span>
                                            <span>Create Class</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Help Text -->
                    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-xl p-4">
                        <div class="flex items-start space-x-3">
                            <span class="material-icons-sharp text-blue-600 text-sm mt-0.5">info</span>
                            <div>
                                <h3 class="text-sm font-medium text-blue-900">Creating a New Class</h3>
                                <ul class="mt-2 text-sm text-blue-800 list-disc list-inside space-y-1">
                                    <li>Class Code must be unique across all classes</li>
                                    <li>Academic Year should follow the format: YYYY-YYYY</li>
                                    <li>You can assign a teacher now or later through the class management page</li>
                                    <li>Class capacity determines the maximum number of students that can be enrolled</li>
                                </ul>
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
            font-size: inherit;
        }
    </style>
@endpush

@push('scripts')
    <script>
        function resetForm() {
            if (confirm('Are you sure you want to reset the form? All entered data will be lost.')) {
                document.querySelector('form').reset();

                // Reset specific fields to default values
                document.getElementById('academic_year').value = '{{ date('Y') . '-' . (date('Y') + 1) }}';
                document.getElementById('capacity').value = '30';
                document.getElementById('status').value = 'active';

                // Uncheck all meeting days
                document.querySelectorAll('input[name="meeting_days[]"]').forEach(checkbox => {
                    checkbox.checked = false;
                });
            }
        }

        // Auto-generate class code based on name
        document.getElementById('name').addEventListener('blur', function() {
            const nameInput = this.value.trim();
            const codeInput = document.getElementById('code');

            // Only auto-generate if code is empty and name is provided
            if (nameInput && !codeInput.value) {
                // Generate a simple code from the name
                const code = nameInput
                    .toUpperCase()
                    .replace(/[^A-Z0-9]/g, ' ')
                    .trim()
                    .replace(/\s+/g, '-')
                    .substring(0, 20);

                codeInput.value = code;
            }
        });

        // Validate end time is after start time
        document.getElementById('end_time').addEventListener('change', function() {
            const startTime = document.getElementById('start_time').value;
            const endTime = this.value;

            if (startTime && endTime && startTime >= endTime) {
                alert('End time must be after start time');
                this.value = '';
                this.focus();
            }
        });

        // Capacity validation
        document.getElementById('capacity').addEventListener('input', function() {
            if (this.value < 1) {
                this.value = 1;
            }
            if (this.value > 100) {
                this.value = 100;
            }
        });

        // Form submission validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const requiredFields = ['name', 'code', 'grade_level', 'section', 'academic_year', 'capacity'];
            let isValid = true;

            requiredFields.forEach(field => {
                const element = document.getElementById(field);
                if (!element.value.trim()) {
                    isValid = false;
                    element.classList.add('border-red-500');
                } else {
                    element.classList.remove('border-red-500');
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields marked with *');
            }
        });
    </script>
@endpush
