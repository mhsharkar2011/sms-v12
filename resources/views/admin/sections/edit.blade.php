{{-- resources/views/sections/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Section')

@section('content')
    <div class="min-h-screen bg-gray-50 flex">
        <x-admin-sidebar />
        <div class="flex-1 overflow-auto">
            <div class="container mx-auto px-4 py-8">
                <!-- Header Card -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h2 class="text-2xl font-bold">Edit Section</h2>
                                    <p class="text-blue-100 text-sm mt-1">Update section details in the student management
                                        system</p>
                                </div>
                            </div>
                            <div class="bg-blue-800 text-white px-4 py-2 rounded-lg">
                                <span class="text-sm font-medium">{{ $section->code }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Breadcrumb -->
                    <div class="px-6 py-3 bg-gray-50 border-b border-gray-200">
                        <nav class="flex" aria-label="Breadcrumb">
                            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                                <li class="inline-flex items-center">
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                            </path>
                                        </svg>
                                        Dashboard
                                    </a>
                                </li>
                                <li>
                                    <div class="flex items-center">
                                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <a href="{{ route('admin.sections.index') }}"
                                            class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">Sections</a>
                                    </div>
                                </li>
                                <li>
                                    <div class="flex items-center">
                                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <a href="{{ route('admin.sections.show', $section) }}"
                                            class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">{{ $section->name }}</a>
                                    </div>
                                </li>
                                <li aria-current="page">
                                    <div class="flex items-center">
                                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Edit</span>
                                    </div>
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <!-- Form Card -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <form action="{{ route('admin.sections.update', $section) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Edit Section Information</h3>
                                    <p class="text-sm text-gray-600 mt-1">Update the details for this section</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span
                                        class="text-sm font-medium px-3 py-1 rounded-full {{ $section->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $section->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                    <span class="text-sm font-medium px-3 py-1 rounded-full bg-blue-100 text-blue-800">
                                        {{ $section->students->count() }} students
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="p-6 space-y-6">
                            <!-- Basic Information Section -->
                            <div class="space-y-4">
                                <h4 class="text-md font-semibold text-gray-800 border-l-4 border-blue-500 pl-3">Basic
                                    Information</h4>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Section Name -->
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                            Section Name <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="name" name="name"
                                            value="{{ old('name', $section->name) }}"
                                            class="w-full px-4 py-2.5 border @error('name') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                            placeholder="e.g., Morning Shift" required>
                                        @error('name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        <p class="mt-1 text-xs text-gray-500">Enter a descriptive name for the section</p>
                                    </div>

                                    <!-- Section Code -->
                                    <div>
                                        <label for="code" class="block text-sm font-medium text-gray-700 mb-1">
                                            Section Code <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="code" name="code"
                                            value="{{ old('code', $section->code) }}"
                                            class="w-full px-4 py-2.5 border @error('code') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                            placeholder="e.g., SEC-A" required>
                                        @error('code')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        <p class="mt-1 text-xs text-gray-500">Unique code for the section (uppercase)</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Assignment Section -->
                            <div class="space-y-4">
                                <h4 class="text-md font-semibold text-gray-800 border-l-4 border-blue-500 pl-3">Assignment &
                                    Capacity</h4>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Class Selection -->
                                    <div>
                                        <label for="class_id" class="block text-sm font-medium text-gray-700 mb-1">
                                            Class <span class="text-red-500">*</span>
                                        </label>
                                        <select id="class_id" name="class_id"
                                            class="w-full px-4 py-2.5 border @error('class_id') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                            required>
                                            <option value="">Select a class</option>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}"
                                                    {{ (old('class_id') ?? $section->class_id) == $class->id ? 'selected' : '' }}>
                                                    {{ $class->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('class_id')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        <p class="mt-1 text-xs text-gray-500">Select the class for this section</p>
                                    </div>

                                    <!-- Teacher Assignment -->
                                    <div>
                                        <label for="teacher_id" class="block text-sm font-medium text-gray-700 mb-1">
                                            Class Teacher
                                        </label>
                                        <select id="teacher_id" name="teacher_id"
                                            class="w-full px-4 py-2.5 border @error('teacher_id') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                            <option value="">Not Assigned</option>
                                            @foreach ($teachers as $teacher)
                                                <option value="{{ $teacher->id }}"
                                                    {{ (old('teacher_id') ?? $section->teacher_id) == $teacher->id ? 'selected' : '' }}>
                                                    {{ $teacher->full_name }}
                                                    @if ($teacher->subject)
                                                        ({{ $teacher->subject }})
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('teacher_id')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        <p class="mt-1 text-xs text-gray-500">Assign a teacher to this section</p>
                                    </div>

                                    <!-- Capacity -->
                                    <div>
                                        <label for="capacity" class="block text-sm font-medium text-gray-700 mb-1">
                                            Capacity <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <input type="number" id="capacity" name="capacity"
                                                value="{{ old('capacity', $section->capacity) }}"
                                                min="{{ $section->students->count() }}" max="100"
                                                class="w-full px-4 py-2.5 border @error('capacity') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                                required>
                                            <div
                                                class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500">students</span>
                                            </div>
                                        </div>
                                        @error('capacity')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        <div class="mt-2 space-y-1">
                                            <p class="text-xs text-gray-500">Maximum number of students
                                                ({{ $section->students->count() }}-100)</p>
                                            <div class="w-full bg-gray-200 rounded-full h-2">
                                                <div class="bg-blue-600 h-2 rounded-full"
                                                    style="width: {{ min(100, ($section->students->count() / $section->capacity) * 100) }}%">
                                                </div>
                                            </div>
                                            <p class="text-xs text-gray-600">
                                                Current: {{ $section->students->count() }} of {{ $section->capacity }}
                                                ({{ number_format(($section->students->count() / $section->capacity) * 100, 1) }}%)
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Status -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Section Status
                                        </label>
                                        <div class="mt-2">
                                            <label class="inline-flex items-center cursor-pointer">
                                                <div class="relative">
                                                    <input type="checkbox" id="is_active" name="is_active"
                                                        value="1"
                                                        {{ old('is_active') ?? $section->is_active ? 'checked' : '' }}
                                                        class="sr-only peer">
                                                    <div
                                                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500">
                                                    </div>
                                                </div>
                                                <div class="ml-3">
                                                    <span class="text-sm font-medium text-gray-900">Active Section</span>
                                                    <p class="text-xs text-gray-500">Inactive sections won't be available
                                                        for enrollment</p>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Description Section -->
                            <div class="space-y-4">
                                <h4 class="text-md font-semibold text-gray-800 border-l-4 border-blue-500 pl-3">Additional
                                    Details</h4>

                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                                        Description
                                    </label>
                                    <textarea id="description" name="description" rows="4"
                                        class="w-full px-4 py-3 border @error('description') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 resize-none"
                                        placeholder="Optional: Add any additional notes or description about this section...">{{ old('description', $section->description) }}</textarea>
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <div class="mt-2 flex justify-between text-xs text-gray-500">
                                        <span>Optional section description</span>
                                        <span id="charCount">{{ strlen(old('description', $section->description)) }}
                                            characters</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Information (Read-only) -->
                            <div class="space-y-4 bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <h4 class="text-md font-semibold text-gray-800">Section Information</h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <span class="text-xs text-gray-500">Created At</span>
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $section->created_at->format('M d, Y') }}</p>
                                    </div>
                                    <div>
                                        <span class="text-xs text-gray-500">Last Updated</span>
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $section->updated_at->format('M d, Y') }}</p>
                                    </div>
                                    <div>
                                        <span class="text-xs text-gray-500">Current Students</span>
                                        <p class="text-sm font-medium text-gray-900">{{ $section->students->count() }}
                                            students</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 rounded-b-xl">
                            <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
                                <div class="flex space-x-3">
                                    <a href="{{ route('admin.sections.show', $section) }}"
                                        class="inline-flex items-center px-5 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                        View Details
                                    </a>
                                    <a href="{{ route('admin.sections.index') }}"
                                        class="inline-flex items-center px-5 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                        </svg>
                                        Back to Sections
                                    </a>
                                </div>

                                <div class="flex space-x-3">
                                    <button type="reset"
                                        class="inline-flex items-center px-5 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Reset Changes
                                    </button>

                                    <button type="submit"
                                        class="inline-flex items-center px-5 py-2.5 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200 shadow-md">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Update Section
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Character count for description
        const descriptionTextarea = document.getElementById('description');
        const charCount = document.getElementById('charCount');

        descriptionTextarea.addEventListener('input', function() {
            charCount.textContent = this.value.length + ' characters';
        });

        // Auto-uppercase for section code
        document.getElementById('code').addEventListener('input', function(e) {
            this.value = this.value.toUpperCase();
        });

        // Form validation before submit
        document.querySelector('form').addEventListener('submit', function(e) {
            const requiredFields = this.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('border-red-500');
                    isValid = false;
                } else {
                    field.classList.remove('border-red-500');
                }
            });

            // Check capacity is not less than current students
            const capacityInput = document.getElementById('capacity');
            const currentStudents = {{ $section->students->count() }};
            if (parseInt(capacityInput.value) < currentStudents) {
                capacityInput.classList.add('border-red-500');
                isValid = false;
                alert('Capacity cannot be less than current number of students (' + currentStudents + ')');
            }

            if (!isValid) {
                e.preventDefault();
            }
        });

        // Update capacity progress bar
        function updateCapacityProgress() {
            const capacity = parseInt(document.getElementById('capacity').value) || 1;
            const currentStudents = {{ $section->students->count() }};
            const percentage = Math.min(100, (currentStudents / capacity) * 100);

            const progressBar = document.querySelector('.bg-blue-600');
            if (progressBar) {
                progressBar.style.width = percentage + '%';
            }
        }

        document.getElementById('capacity').addEventListener('input', updateCapacityProgress);

        // Initialize progress bar on load
        updateCapacityProgress();
    </script>
@endsection
