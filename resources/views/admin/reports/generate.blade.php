{{-- resources/views/admin/reports/generate.blade.php --}}
@extends('layouts.app')

@section('title', 'Generate Academic Report')

@section('content')
    <div class="min-h-screen bg-gray-50 flex">
        <x-admin-sidebar />

        <div class="flex-1 overflow-auto">
            <div class="container mx-auto p-6">
                <div class="max-w-4xl mx-auto">
                    <!-- Breadcrumb -->
                    <nav class="mb-6" aria-label="Breadcrumb">
                        <ol class="flex items-center space-x-2 text-sm">
                            <li>
                                <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-home mr-1"></i> Dashboard
                                </a>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                                <a href="{{ route('admin.reports.index') }}" class="ml-2 text-blue-600 hover:text-blue-800">
                                    Reports
                                </a>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                                <span class="ml-2 text-gray-500">Generate Academic Report</span>
                            </li>
                        </ol>
                    </nav>

                    <!-- Header -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">Generate Academic Report</h1>
                                <p class="mt-1 text-sm text-gray-600">Generate comprehensive academic reports for students,
                                    classes, or sections</p>
                            </div>
                            <a href="{{ route('admin.reports.index') }}"
                                class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                                <i class="fas fa-arrow-left mr-2"></i> Back to Reports
                            </a>
                        </div>
                    </div>

                    <!-- Flash Messages -->
                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-triangle text-red-500 text-xl mr-3"></i>
                                <h3 class="text-red-800 font-semibold">Please fix the following errors:</h3>
                            </div>
                            <ul class="mt-2 list-disc list-inside text-red-700">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Form Card -->
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <form action="{{ route('admin.academic..reports.generate') }}" method="POST">
                            @csrf

                            <div class="p-6 border-b border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                                    <i class="fas fa-file-alt text-blue-600"></i>
                                    Report Configuration
                                </h3>

                                <div class="space-y-6">
                                    <!-- Report Type -->
                                    <div>
                                        <label for="report_type" class="block text-sm font-medium text-gray-700 mb-2">
                                            Report Type *
                                        </label>
                                        <select name="report_type" id="report_type"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('report_type') border-red-500 @enderror"
                                            required>
                                            <option value="">Select Report Type</option>
                                            <option value="academic"
                                                {{ old('report_type') == 'academic' ? 'selected' : '' }}>
                                                Academic Performance Report
                                            </option>
                                            <option value="attendance"
                                                {{ old('report_type') == 'attendance' ? 'selected' : '' }}>
                                                Attendance Report
                                            </option>
                                            <option value="progress"
                                                {{ old('report_type') == 'progress' ? 'selected' : '' }}>
                                                Progress Report
                                            </option>
                                            <option value="transcript"
                                                {{ old('report_type') == 'transcript' ? 'selected' : '' }}>
                                                Transcript
                                            </option>
                                        </select>
                                        @error('report_type')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Class Selection -->
                                    <div>
                                        <label for="class_id" class="block text-sm font-medium text-gray-700 mb-2">
                                            Class *
                                        </label>
                                        <select name="class_id" id="class_id"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('class_id') border-red-500 @enderror"
                                            required>
                                            <option value="">Select Class</option>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}"
                                                    {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                                    {{ $class->name }} (Grade: {{ $class->grade_level ?? 'N/A' }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('class_id')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Section Selection -->
                                    <div>
                                        <label for="section_id" class="block text-sm font-medium text-gray-700 mb-2">
                                            Section (Optional)
                                        </label>
                                        <select name="section_id" id="section_id"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('section_id') border-red-500 @enderror">
                                            <option value="">All Sections</option>
                                            @foreach ($sections as $section)
                                                <option value="{{ $section->id }}"
                                                    data-class-id="{{ $section->class_id }}"
                                                    {{ old('section_id') == $section->id ? 'selected' : '' }}>
                                                    {{ $section->name }} ({{ $section->code }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('section_id')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Student Selection (Optional) -->
                                    <div>
                                        <label for="student_id" class="block text-sm font-medium text-gray-700 mb-2">
                                            Student (Optional - Leave blank for all students)
                                        </label>
                                        <select name="student_id" id="student_id"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('student_id') border-red-500 @enderror">
                                            <option value="">All Students</option>
                                            @foreach ($students as $student)
                                                <option value="{{ $student->id }}"
                                                    data-class-id="{{ $student->class_id }}"
                                                    data-section-id="{{ $student->section_id }}"
                                                    {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                                    {{ $student->first_name }} {{ $student->last_name }}
                                                    ({{ $student->student_id }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('student_id')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Date Range -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="date_from" class="block text-sm font-medium text-gray-700 mb-2">
                                                From Date (Optional)
                                            </label>
                                            <input type="date" name="date_from" id="date_from"
                                                value="{{ old('date_from') }}"
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('date_from') border-red-500 @enderror">
                                            @error('date_from')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="date_to" class="block text-sm font-medium text-gray-700 mb-2">
                                                To Date (Optional)
                                            </label>
                                            <input type="date" name="date_to" id="date_to"
                                                value="{{ old('date_to') }}"
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('date_to') border-red-500 @enderror">
                                            @error('date_to')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Output Format -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Output Format *
                                        </label>
                                        <div class="flex space-x-4">
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="format" value="view"
                                                    {{ old('format', 'view') == 'view' ? 'checked' : '' }}
                                                    class="form-radio text-blue-600">
                                                <span class="ml-2">View in Browser</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="format" value="pdf"
                                                    {{ old('format') == 'pdf' ? 'checked' : '' }}
                                                    class="form-radio text-blue-600">
                                                <span class="ml-2">Download PDF</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="format" value="excel"
                                                    {{ old('format') == 'excel' ? 'checked' : '' }}
                                                    class="form-radio text-blue-600">
                                                <span class="ml-2">Download Excel</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                                <div class="flex items-center justify-between">
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors flex items-center gap-2">
                                        <i class="fas fa-times"></i>
                                        Cancel
                                    </a>
                                    <div class="flex space-x-3">
                                        <button type="button" onclick="resetForm()"
                                            class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors flex items-center gap-2">
                                            <i class="fas fa-redo"></i>
                                            Reset Form
                                        </button>
                                        <button type="submit"
                                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
                                            <i class="fas fa-file-download"></i>
                                            Generate Report
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
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
                document.querySelector('form').reset();
            }
        }

        // Filter sections based on selected class
        document.getElementById('class_id').addEventListener('change', function() {
            const selectedClassId = this.value;
            const sectionSelect = document.getElementById('section_id');
            const studentSelect = document.getElementById('student_id');

            // Filter sections
            Array.from(sectionSelect.options).forEach(option => {
                if (option.value === '') return; // Keep "All Sections" option
                if (option.dataset.classId === selectedClassId) {
                    option.style.display = '';
                } else {
                    option.style.display = 'none';
                    if (option.selected) option.selected = false;
                }
            });

            // Filter students
            Array.from(studentSelect.options).forEach(option => {
                if (option.value === '') return; // Keep "All Students" option
                if (option.dataset.classId === selectedClassId) {
                    option.style.display = '';
                } else {
                    option.style.display = 'none';
                    if (option.selected) option.selected = false;
                }
            });
        });

        // Filter students based on selected section
        document.getElementById('section_id').addEventListener('change', function() {
            const selectedSectionId = this.value;
            const studentSelect = document.getElementById('student_id');

            // If no section selected, show all students from selected class
            if (!selectedSectionId) {
                const classId = document.getElementById('class_id').value;
                Array.from(studentSelect.options).forEach(option => {
                    if (option.value === '') return;
                    if (option.dataset.classId === classId) {
                        option.style.display = '';
                    }
                });
                return;
            }

            // Filter students by section
            Array.from(studentSelect.options).forEach(option => {
                if (option.value === '') return;
                if (option.dataset.sectionId === selectedSectionId) {
                    option.style.display = '';
                } else {
                    option.style.display = 'none';
                    if (option.selected) option.selected = false;
                }
            });
        });

        // Initialize date range to current academic year
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date();
            const currentYear = today.getFullYear();

            // Set default date range to current academic year
            document.getElementById('date_from').value = `${currentYear}-04-01`; // April 1st
            document.getElementById('date_to').value = `${currentYear + 1}-03-31`; // March 31st next year
        });
    </script>
@endpush
