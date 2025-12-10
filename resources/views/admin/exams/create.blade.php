@extends('layouts.app')

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Header -->
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Create New Exam</h2>
                        <p class="text-gray-600 mt-1">Fill in the details to create a new exam</p>
                    </div>

                    <!-- Form -->
                    <form action="{{ route('admin.exams.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Basic Information -->
                            <div class="space-y-6">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>

                                    <div class="space-y-4">
                                        <div>
                                            <label for="name" class="block text-sm font-medium text-gray-700">Exam Name
                                                *</label>
                                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                                required
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('name') border-red-300 @enderror">
                                            @error('name')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="type" class="block text-sm font-medium text-gray-700">Exam Type
                                                *</label>
                                            <select name="type" id="type" required
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('type') border-red-300 @enderror">
                                                <option value="">Select Type</option>
                                                <option value="weekly" {{ old('type') == 'weekly' ? 'selected' : '' }}>
                                                    Weekly Test</option>
                                                <option value="monthly" {{ old('type') == 'monthly' ? 'selected' : '' }}>
                                                    Monthly Test</option>
                                                <option value="quarterly"
                                                    {{ old('type') == 'quarterly' ? 'selected' : '' }}>Quarterly Exam
                                                </option>
                                                <option value="half-yearly"
                                                    {{ old('type') == 'half-yearly' ? 'selected' : '' }}>Half Yearly
                                                </option>
                                                <option value="annual" {{ old('type') == 'annual' ? 'selected' : '' }}>
                                                    Annual Exam</option>
                                                <option value="final" {{ old('type') == 'final' ? 'selected' : '' }}>Final
                                                    Exam</option>
                                                <option value="quiz" {{ old('type') == 'quiz' ? 'selected' : '' }}>Quiz
                                                </option>
                                            </select>
                                            @error('type')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label for="academic_year"
                                                    class="block text-sm font-medium text-gray-700">Academic Year *</label>
                                                <select name="academic_year" id="academic_year" required
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                    @for ($year = date('Y') - 1; $year <= date('Y') + 1; $year++)
                                                        <option value="{{ $year }}-{{ $year + 1 }}"
                                                            {{ old('academic_year') == $year . '-' . ($year + 1) ? 'selected' : '' }}>
                                                            {{ $year }}-{{ $year + 1 }}
                                                        </option>
                                                    @endfor
                                                </select>
                                            </div>

                                            <div>
                                                <label for="term" class="block text-sm font-medium text-gray-700">Term
                                                    *</label>
                                                <select name="term" id="term" required
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                    <option value="1" {{ old('term') == '1' ? 'selected' : '' }}>Term
                                                        1</option>
                                                    <option value="2" {{ old('term') == '2' ? 'selected' : '' }}>Term
                                                        2</option>
                                                    <option value="3" {{ old('term') == '3' ? 'selected' : '' }}>Term
                                                        3</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Class & Subject -->
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Class & Subject</h3>

                                    <div class="space-y-4">
                                        <div>
                                            <label for="school_class_id"
                                                class="block text-sm font-medium text-gray-700">Class *</label>
                                            <select name="school_class_id" id="school_class_id" required
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('school_class_id') border-red-300 @enderror">
                                                <option value="">Select Class</option>
                                                @foreach ($classes as $class)
                                                    <option value="{{ $class->id }}"
                                                        {{ old('school_class_id') == $class->id ? 'selected' : '' }}>
                                                        {{ $class->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('school_class_id')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="section_id" class="block text-sm font-medium text-gray-700">Section
                                                *</label>
                                            <select name="section_id" id="section_id" required
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('section_id') border-red-300 @enderror">
                                                <option value="">Select Section</option>
                                                <!-- Sections will be loaded via AJAX based on class selection -->
                                                @foreach ($sections ?? [] as $section)
                                                    <option value="{{ $section->id }}"
                                                        {{ old('section_id') == $section->id ? 'selected' : '' }}>
                                                        {{ $section->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('section_id')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="subject_id" class="block text-sm font-medium text-gray-700">Subject
                                                *</label>
                                            <select name="subject_id" id="subject_id" required
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('subject_id') border-red-300 @enderror">
                                                <option value="">Select Subject</option>
                                                @foreach ($subjects as $subject)
                                                    <option value="{{ $subject->id }}"
                                                        {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                                        {{ $subject->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('subject_id')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Schedule & Details -->
                            <div class="space-y-6">
                                <!-- Schedule -->
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Schedule</h3>

                                    <div class="space-y-4">
                                        <div>
                                            <label for="exam_date" class="block text-sm font-medium text-gray-700">Exam Date
                                                *</label>
                                            <input type="date" name="exam_date" id="exam_date"
                                                value="{{ old('exam_date') }}" required
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        </div>

                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label for="start_time"
                                                    class="block text-sm font-medium text-gray-700">Start Time *</label>
                                                <input type="time" name="start_time" id="start_time"
                                                    value="{{ old('start_time') }}" required
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            </div>

                                            <div>
                                                <label for="end_time" class="block text-sm font-medium text-gray-700">End
                                                    Time *</label>
                                                <input type="time" name="end_time" id="end_time"
                                                    value="{{ old('end_time') }}" required
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Marks & Status -->
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Marks & Status</h3>

                                    <div class="space-y-4">
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label for="total_marks"
                                                    class="block text-sm font-medium text-gray-700">Total Marks *</label>
                                                <input type="number" name="total_marks" id="total_marks"
                                                    value="{{ old('total_marks', 100) }}" required min="1"
                                                    max="200"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            </div>

                                            <div>
                                                <label for="passing_percentage"
                                                    class="block text-sm font-medium text-gray-700">Passing %</label>
                                                <input type="number" name="passing_percentage" id="passing_percentage"
                                                    value="{{ old('passing_percentage', 40) }}" min="0"
                                                    max="100"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            </div>
                                        </div>

                                        <div>
                                            <label for="status" class="block text-sm font-medium text-gray-700">Status
                                                *</label>
                                            <select name="status" id="status" required
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                <option value="scheduled"
                                                    {{ old('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                                <option value="ongoing"
                                                    {{ old('status') == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                                                <option value="completed"
                                                    {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                                <option value="cancelled"
                                                    {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label for="description"
                                                class="block text-sm font-medium text-gray-700">Description</label>
                                            <textarea name="description" id="description" rows="3"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description') }}</textarea>
                                        </div>

                                        <div class="flex items-center">
                                            <input type="checkbox" name="is_published" id="is_published" value="1"
                                                {{ old('is_published') ? 'checked' : '' }}
                                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                            <label for="is_published" class="ml-2 block text-sm text-gray-900">
                                                Publish immediately
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end space-x-3">
                            <a href="{{ route('admin.exams.index') }}"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cancel
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                Create Exam
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- <!-- AJAX for Section Loading -->
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const classSelect = document.getElementById('school_class_id');
                const sectionSelect = document.getElementById('section_id');

                classSelect.addEventListener('change', function() {
                    const classId = this.value;
                    sectionSelect.innerHTML = '<option value="">Loading...</option>';

                    if (classId) {
                        fetch(`/api/sections-by-class/${classId}`)
                            .then(response => response.json())
                            .then(data => {
                                sectionSelect.innerHTML = '<option value="">Select Section</option>';
                                data.forEach(section => {
                                    sectionSelect.innerHTML +=
                                        `<option value="${section.id}">${section.name}</option>`;
                                });
                            })
                            .catch(error => {
                                sectionSelect.innerHTML =
                                '<option value="">Error loading sections</option>';
                                console.error('Error:', error);
                            });
                    } else {
                        sectionSelect.innerHTML = '<option value="">Select Section</option>';
                    }
                });
            });
        </script>
    @endpush --}}
@endsection
