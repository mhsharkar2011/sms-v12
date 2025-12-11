@extends('layouts.app')

@section('title', 'Create New Class')

@section('content')
    <div class="min-h-screen bg-gray-50 flex">
        <!-- Admin Sidebar Component -->
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
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            <span>Back to Classes</span>
                        </a>
                    </div>
                </div>

                <!-- Breadcrumb -->
                <nav class="mb-6">
                    <ol class="flex items-center space-x-2 text-sm text-gray-600">
                        <li><a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600">Dashboard</a></li>
                        <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg></li>
                        <li><a href="{{ route('admin.classes.index') }}" class="hover:text-blue-600">Classes</a></li>
                        <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg></li>
                        <li class="text-gray-900">Create New Class</li>
                    </ol>
                </nav>

                <div class="max-w-4xl mx-auto">
                    <!-- Flash Messages -->
                    @if (session('success'))
                        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="font-medium">{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="font-medium">{{ session('error') }}</span>
                            </div>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd" />
                                </svg>
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
                        <form action="{{ route('admin.classes.store') }}" method="POST" id="classForm">
                            @csrf

                            <div class="p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Class Name -->
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                            Class Name *
                                        </label>
                                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
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
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('code') border-red-500 @enderror"
                                            placeholder="e.g., MATH-101-A" required>
                                        <p class="mt-1 text-xs text-gray-500">Must be unique across all classes</p>
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
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('grade_level') border-red-500 @enderror"
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
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('section') border-red-500 @enderror"
                                            placeholder="e.g., A, B, C" required>
                                        @error('section')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Subject -->
                                    <div>
                                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                                            Subject
                                        </label>
                                        <input type="text" name="subject" id="subject"
                                            value="{{ old('subject') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('subject') border-red-500 @enderror"
                                            placeholder="e.g., Mathematics">
                                        @error('subject')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Teacher -->
                                    <div>
                                        <label for="teacher_id" class="block text-sm font-medium text-gray-700 mb-2">
                                            Class Teacher
                                        </label>
                                        <select name="teacher_id" id="teacher_id"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('teacher_id') border-red-500 @enderror">
                                            <option value="">No Teacher Assigned</option>
                                            @isset($teachers)
                                                @foreach ($teachers as $teacher)
                                                    @php
                                                        $teacherId = $teacher->id ?? $teacher->user_id;
                                                        $teacherName =
                                                            $teacher->name ??
                                                            $teacher->first_name . ' ' . $teacher->last_name;
                                                        $teacherEmail =
                                                            $teacher->email ?? ($teacher->user->email ?? '');
                                                    @endphp
                                                    <option value="{{ $teacherId }}"
                                                        {{ old('teacher_id') == $teacherId ? 'selected' : '' }}>
                                                        {{ $teacherName }}
                                                        @if ($teacherEmail)
                                                            ({{ $teacherEmail }})
                                                        @endif
                                                    </option>
                                                @endforeach
                                            @endisset
                                        </select>
                                        @error('teacher_id')
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
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('academic_year') border-red-500 @enderror"
                                            placeholder="e.g., 2024-2025" required>
                                        <p class="mt-1 text-xs text-gray-500">Format: YYYY-YYYY</p>
                                        @error('academic_year')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Status -->
                                    <div>
                                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                            Status *
                                        </label>
                                        <select name="status" id="status"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('status') border-red-500 @enderror"
                                            required>
                                            <option value="">Select Status</option>
                                            <option value="active"
                                                {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                                Inactive</option>
                                            <option value="completed"
                                                {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                        </select>
                                        @error('status')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Schedule Days -->
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Schedule Days *
                                        </label>
                                        <div class="flex flex-wrap gap-3 p-3 border border-gray-300 rounded-lg">
                                            @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                                <label class="inline-flex items-center">
                                                    <input type="checkbox" name="schedule_days[]"
                                                        value="{{ strtolower($day) }}"
                                                        {{ is_array(old('schedule_days')) && in_array(strtolower($day), old('schedule_days')) ? 'checked' : '' }}
                                                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                                    <span class="ml-2 text-sm text-gray-700">{{ $day }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                        <p class="mt-1 text-xs text-gray-500">Select at least one day</p>
                                        @error('schedule_days')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Schedule Times -->
                                    <div>
                                        <label for="start_time" class="block text-sm font-medium text-gray-700 mb-2">
                                            Start Time
                                        </label>
                                        <input type="time" name="start_time" id="start_time"
                                            value="{{ old('start_time') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('start_time') border-red-500 @enderror">
                                        @error('start_time')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="end_time" class="block text-sm font-medium text-gray-700 mb-2">
                                            End Time
                                        </label>
                                        <input type="time" name="end_time" id="end_time"
                                            value="{{ old('end_time') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('end_time') border-red-500 @enderror">
                                        @error('end_time')
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
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('room_number') border-red-500 @enderror"
                                            placeholder="e.g., Room 101">
                                        @error('room_number')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Capacity -->
                                    <div>
                                        <label for="capacity" class="block text-sm font-medium text-gray-700 mb-2">
                                            Capacity *
                                        </label>
                                        <input type="number" name="capacity" id="capacity"
                                            value="{{ old('capacity', 30) }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('capacity') border-red-500 @enderror"
                                            min="1" max="100" placeholder="Maximum students" required>
                                        <p class="mt-1 text-xs text-gray-500">1-100 students</p>
                                        @error('capacity')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="mt-6">
                                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                        Description
                                    </label>
                                    <textarea name="description" id="description" rows="3"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror"
                                        placeholder="Optional class description...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
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
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
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
                            <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd" />
                            </svg>
                            <div>
                                <h3 class="text-sm font-medium text-blue-900">Creating a New Class</h3>
                                <ul class="mt-2 text-sm text-blue-800 list-disc list-inside space-y-1">
                                    <li>Fields marked with * are required</li>
                                    <li>Class Code must be unique across all classes</li>
                                    <li>Academic Year should follow the format: YYYY-YYYY</li>
                                    <li>You can assign a teacher now or later through the class management page</li>
                                    <li>Class capacity determines the maximum number of students that can be enrolled</li>
                                    <li>Select at least one schedule day for the class</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function resetForm() {
            if (confirm('Are you sure you want to reset the form? All entered data will be lost.')) {
                document.getElementById('classForm').reset();
                // Reset specific fields to default values
                document.getElementById('academic_year').value = '{{ date('Y') . '-' . (date('Y') + 1) }}';
                document.getElementById('capacity').value = '30';
                document.getElementById('status').value = 'active';

                // Uncheck all schedule days
                document.querySelectorAll('input[name="schedule_days[]"]').forEach(checkbox => {
                    checkbox.checked = false;
                });
            }
        }

        // Auto-generate class code based on name
        document.getElementById('name').addEventListener('blur', function() {
            const nameInput = this.value.trim();
            const codeInput = document.getElementById('code');
            const sectionInput = document.getElementById('section').value.trim();

            // Only auto-generate if code is empty and name is provided
            if (nameInput && !codeInput.value) {
                // Generate a simple code from the name
                let code = nameInput
                    .toUpperCase()
                    .replace(/[^A-Z0-9]/g, ' ')
                    .trim()
                    .replace(/\s+/g, '-')
                    .substring(0, 10);

                // Add section if available
                if (sectionInput) {
                    code += '-' + sectionInput.toUpperCase();
                }

                codeInput.value = code;
            }
        });

        // Validate academic year format
        document.getElementById('academic_year').addEventListener('blur', function() {
            const pattern = /^\d{4}-\d{4}$/;
            if (!pattern.test(this.value)) {
                alert('Academic year must be in the format: YYYY-YYYY (e.g., 2024-2025)');
                this.focus();
                return false;
            }

            // Validate years are sequential
            const years = this.value.split('-');
            if (parseInt(years[1]) - parseInt(years[0]) !== 1) {
                alert('Second year should be exactly one year after the first year (e.g., 2024-2025)');
                this.focus();
                return false;
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
        document.getElementById('classForm').addEventListener('submit', function(e) {
            // Basic required field validation
            const requiredFields = ['name', 'code', 'grade_level', 'section', 'academic_year', 'capacity',
            'status'];
            let isValid = true;
            let firstInvalidField = null;

            requiredFields.forEach(field => {
                const element = document.getElementById(field);
                if (!element.value.trim()) {
                    isValid = false;
                    element.classList.add('border-red-500');
                    if (!firstInvalidField) {
                        firstInvalidField = element;
                    }
                } else {
                    element.classList.remove('border-red-500');
                }
            });

            // Validate at least one schedule day is selected
            const scheduleDays = document.querySelectorAll('input[name="schedule_days[]"]:checked');
            if (scheduleDays.length === 0) {
                isValid = false;
                alert('Please select at least one schedule day');
            }

            // Validate academic year format if provided
            const academicYear = document.getElementById('academic_year').value;
            const pattern = /^\d{4}-\d{4}$/;
            if (academicYear && !pattern.test(academicYear)) {
                isValid = false;
                alert('Academic year must be in the format: YYYY-YYYY');
            }

            // Validate end time is after start time if both are provided
            const startTime = document.getElementById('start_time').value;
            const endTime = document.getElementById('end_time').value;
            if (startTime && endTime && startTime >= endTime) {
                isValid = false;
                alert('End time must be after start time');
            }

            if (!isValid) {
                e.preventDefault();
                if (firstInvalidField) {
                    firstInvalidField.focus();
                }
                return false;
            }
        });
    </script>
@endpush

@push('styles')
    <style>
        .border-red-500 {
            border-color: #ef4444 !important;
        }

        .border-red-500:focus {
            border-color: #ef4444 !important;
            ring-color: #fecaca !important;
        }
    </style>
@endpush
