@extends('layouts.app')

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <div class="flex items-center">
                        <a href="{{ route('admin.exams.results.index', ['exam' => $exam->id]) }}"
                            class="text-indigo-600 hover:text-indigo-900 mr-2">
                            ← Back to Results
                        </a>
                        <h1 class="text-2xl font-bold text-gray-900">Add Exam Result</h1>
                    </div>
                    <p class="mt-1 text-sm text-gray-600">
                        Exam: {{ $exam->name }} |
                        Class: {{ $exam->schoolClass->name ?? 'N/A' }} |
                        Section: {{ $exam->section->name ?? 'N/A' }} |
                        Subject: {{ $exam->subject->name ?? 'N/A' }}
                    </p>
                </div>
                <div>
                    <a href="{{ route('admin.exams.show', $exam) }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        View Exam Details
                    </a>
                </div>
            </div>

            <!-- Exam Info Card -->
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Exam Information</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <span class="text-sm font-medium text-gray-500">Total Marks</span>
                            <p class="mt-1 text-lg font-semibold text-gray-900">{{ $exam->total_marks }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500">Passing %</span>
                            <p class="mt-1 text-lg font-semibold text-gray-900">{{ $exam->passing_percentage }}%</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500">Passing Marks</span>
                            <p class="mt-1 text-lg font-semibold text-gray-900">
                                {{ number_format(($exam->total_marks * $exam->passing_percentage) / 100, 2) }}
                            </p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500">Status</span>
                            <p class="mt-1">
                                <span
                                    class="px-2 py-1 text-xs font-semibold rounded-full
                                @if ($exam->status == 'completed') bg-green-100 text-green-800
                                @elseif($exam->status == 'ongoing') bg-yellow-100 text-yellow-800
                                @elseif($exam->status == 'cancelled') bg-red-100 text-red-800
                                @else bg-blue-100 text-blue-800 @endif">
                                    {{ ucfirst($exam->status) }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Form -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Enter Result Details</h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.exams.results.store', ['exam' => $exam->id]) }}" method="POST">
                        @csrf

                        <div class="space-y-6">
                            <!-- Student Selection -->
                            <div>
                                <label for="student_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Select Student *
                                </label>
                                <select name="student_id" id="student_id" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('student_id') border-red-300 @enderror">
                                    <option value="">Select a student</option>
                                    @foreach ($students as $student)
                                        @php
                                            $hasResult = in_array($student->id, $existingResults ?? []);
                                        @endphp
                                        <option value="{{ $student->id }}"
                                            {{ old('student_id') == $student->id ? 'selected' : '' }}
                                            @if ($hasResult) disabled @endif
                                            class="@if ($hasResult) bg-gray-100 text-gray-400 @endif">
                                            {{ $student->name }}
                                            (Roll: {{ $student->roll_number ?? 'N/A' }})
                                            @if ($hasResult)
                                                - Already has result
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('student_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-2 text-sm text-gray-500">
                                    Students already having results are disabled.
                                    You can edit existing results instead.
                                </p>
                            </div>

                            <!-- Marks Section -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="marks_obtained" class="block text-sm font-medium text-gray-700">
                                        Marks Obtained *
                                    </label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input type="number" name="marks_obtained" id="marks_obtained"
                                            value="{{ old('marks_obtained') }}" required min="0"
                                            max="{{ $exam->total_marks }}" step="0.01"
                                            class="block w-full rounded-md border-gray-300 pl-3 pr-12 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('marks_obtained') border-red-300 @enderror"
                                            oninput="calculatePercentage()">
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                            <span class="text-gray-500 sm:text-sm">/ {{ $exam->total_marks }}</span>
                                        </div>
                                    </div>
                                    @error('marks_obtained')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="percentage" class="block text-sm font-medium text-gray-700">
                                        Percentage
                                    </label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input type="number" id="percentage" readonly
                                            class="block w-full rounded-md border-gray-300 bg-gray-50 pl-3 pr-12 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                            <span class="text-gray-500 sm:text-sm">%</span>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label for="grade" class="block text-sm font-medium text-gray-700">
                                        Grade
                                    </label>
                                    <select name="grade" id="grade"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="">Select Grade</option>
                                        <option value="A+" {{ old('grade') == 'A+' ? 'selected' : '' }}>A+ (90-100%)
                                        </option>
                                        <option value="A" {{ old('grade') == 'A' ? 'selected' : '' }}>A (80-89%)
                                        </option>
                                        <option value="B+" {{ old('grade') == 'B+' ? 'selected' : '' }}>B+ (70-79%)
                                        </option>
                                        <option value="B" {{ old('grade') == 'B' ? 'selected' : '' }}>B (60-69%)
                                        </option>
                                        <option value="C" {{ old('grade') == 'C' ? 'selected' : '' }}>C (50-59%)
                                        </option>
                                        <option value="D" {{ old('grade') == 'D' ? 'selected' : '' }}>D (40-49%)
                                        </option>
                                        <option value="F" {{ old('grade') == 'F' ? 'selected' : '' }}>F (Below 40%)
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <!-- Result Status Preview -->
                            <div id="statusPreview" class="hidden p-4 rounded-lg border">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <span class="text-sm font-medium text-gray-700">Result Status:</span>
                                        <span id="statusText" class="ml-2 text-sm font-semibold"></span>
                                    </div>
                                    <div id="statusIcon"></div>
                                </div>
                                <div class="mt-2 text-sm text-gray-600">
                                    Passing Marks: <span
                                        id="passingMarks">{{ number_format(($exam->total_marks * $exam->passing_percentage) / 100, 2) }}</span>
                                </div>
                            </div>

                            <!-- Remarks -->
                            <div>
                                <label for="remarks" class="block text-sm font-medium text-gray-700">
                                    Remarks
                                </label>
                                <textarea name="remarks" id="remarks" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('remarks') border-red-300 @enderror">{{ old('remarks') }}</textarea>
                                @error('remarks')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-2 text-sm text-gray-500">
                                    Optional comments or feedback for the student.
                                </p>
                            </div>

                            <!-- Form Actions -->
                            <div class="pt-6 border-t border-gray-200 flex justify-end space-x-3">
                                <a href="{{ route('admin.exams.results.index', ['exam' => $exam->id]) }}"
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Cancel
                                </a>
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Add Result
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Bulk Add Option (Optional) -->
            @if ($students->count() > 0)
                <div class="mt-6 bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Bulk Add Results</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-sm text-gray-600 mb-4">
                            Need to add results for multiple students at once? Use the bulk add feature.
                        </p>
                        <a href="{{ route('admin.exams.results.bulk-create', ['exam' => $exam->id]) }}"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                            </svg>
                            Bulk Add Results
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script>
            function calculatePercentage() {
                const marksInput = document.getElementById('marks_obtained');
                const percentageInput = document.getElementById('percentage');
                const statusPreview = document.getElementById('statusPreview');
                const statusText = document.getElementById('statusText');
                const statusIcon = document.getElementById('statusIcon');
                const passingMarks = {{ ($exam->total_marks * $exam->passing_percentage) / 100 }};
                const totalMarks = {{ $exam->total_marks }};

                const marks = parseFloat(marksInput.value) || 0;
                const percentage = (marks / totalMarks) * 100;

                // Update percentage field
                percentageInput.value = percentage.toFixed(2);

                // Show/hide status preview
                if (marks > 0) {
                    statusPreview.classList.remove('hidden');

                    // Determine pass/fail status
                    if (marks >= passingMarks) {
                        statusPreview.className = 'p-4 rounded-lg border border-green-200 bg-green-50';
                        statusText.className = 'text-green-700';
                        statusText.textContent = 'Pass';
                        statusIcon.innerHTML = `
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            `;
                    } else {
                        statusPreview.className = 'p-4 rounded-lg border border-red-200 bg-red-50';
                        statusText.className = 'text-red-700';
                        statusText.textContent = 'Fail';
                        statusIcon.innerHTML = `
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            `;
                    }
                } else {
                    statusPreview.classList.add('hidden');
                }

                // Auto-select grade based on percentage
                const gradeSelect = document.getElementById('grade');
                if (percentage >= 90) {
                    gradeSelect.value = 'A+';
                } else if (percentage >= 80) {
                    gradeSelect.value = 'A';
                } else if (percentage >= 70) {
                    gradeSelect.value = 'B+';
                } else if (percentage >= 60) {
                    gradeSelect.value = 'B';
                } else if (percentage >= 50) {
                    gradeSelect.value = 'C';
                } else if (percentage >= 40) {
                    gradeSelect.value = 'D';
                } else if (percentage > 0) {
                    gradeSelect.value = 'F';
                }
            }

            // Initialize calculation on page load
            document.addEventListener('DOMContentLoaded', function() {
                calculatePercentage();

                // Add event listener for marks input
                document.getElementById('marks_obtained').addEventListener('input', calculatePercentage);
            });
        </script>
    @endpush
@endsection
