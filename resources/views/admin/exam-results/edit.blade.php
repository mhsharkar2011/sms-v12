@extends('layouts.app')

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <div class="flex items-center">
                        <a href="{{ route('admin.exams.results.show', ['exam' => $exam->id, 'result' => $result->id]) }}"
                            class="text-indigo-600 hover:text-indigo-900 mr-2">
                            ← Back to Result
                        </a>
                        <h1 class="text-2xl font-bold text-gray-900">Edit Exam Result</h1>
                    </div>
                    <p class="mt-1 text-sm text-gray-600">
                        Exam: {{ $exam->name }} |
                        Student: {{ $result->student->name ?? 'N/A' }}
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
                            <span class="text-sm font-medium text-gray-500">Current Status</span>
                            <p class="mt-1">
                                <span
                                    class="px-2 py-1 text-xs font-semibold rounded-full
                                @if ($result->is_passed) bg-green-100 text-green-800
                                @else bg-red-100 text-red-800 @endif">
                                    {{ $result->is_passed ? 'Passed' : 'Failed' }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Form -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Update Result Details</h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.exams.results.update', ['exam' => $exam->id, 'result' => $result->id]) }}"
                        method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <!-- Student Information (Read-only) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Student Information
                                </label>
                                <div class="bg-gray-50 p-4 rounded-md">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <span class="text-sm text-gray-600">Name:</span>
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ $result->student->name ?? 'N/A' }}
                                            </p>
                                        </div>
                                        <div>
                                            <span class="text-sm text-gray-600">Roll Number:</span>
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ $result->student->roll_number ?? 'N/A' }}
                                            </p>
                                        </div>
                                        <div>
                                            <span class="text-sm text-gray-600">Class:</span>
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ $exam->schoolClass->name ?? 'N/A' }}
                                            </p>
                                        </div>
                                        <div>
                                            <span class="text-sm text-gray-600">Section:</span>
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ $exam->section->name ?? 'N/A' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="student_id" value="{{ $result->student_id }}">
                            </div>

                            <!-- Marks Section -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="marks_obtained" class="block text-sm font-medium text-gray-700">
                                        Marks Obtained *
                                    </label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input type="number" name="marks_obtained" id="marks_obtained"
                                            value="{{ old('marks_obtained', $result->marks_obtained) }}" required
                                            min="0" max="{{ $exam->total_marks }}" step="0.01"
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
                                            value="{{ old('percentage', number_format($result->percentage, 2)) }}"
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
                                        <option value="A+"
                                            {{ old('grade', $result->grade) == 'A+' ? 'selected' : '' }}>A+ (90-100%)
                                        </option>
                                        <option value="A" {{ old('grade', $result->grade) == 'A' ? 'selected' : '' }}>
                                            A (80-89%)</option>
                                        <option value="B+"
                                            {{ old('grade', $result->grade) == 'B+' ? 'selected' : '' }}>B+ (70-79%)
                                        </option>
                                        <option value="B" {{ old('grade', $result->grade) == 'B' ? 'selected' : '' }}>
                                            B (60-69%)</option>
                                        <option value="C" {{ old('grade', $result->grade) == 'C' ? 'selected' : '' }}>
                                            C (50-59%)</option>
                                        <option value="D" {{ old('grade', $result->grade) == 'D' ? 'selected' : '' }}>
                                            D (40-49%)</option>
                                        <option value="F" {{ old('grade', $result->grade) == 'F' ? 'selected' : '' }}>
                                            F (Below 40%)</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Result Status Preview -->
                            <div id="statusPreview"
                                class="p-4 rounded-lg border
                            @if ($result->is_passed) border-green-200 bg-green-50 @else border-red-200 bg-red-50 @endif">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <span class="text-sm font-medium text-gray-700">Result Status:</span>
                                        <span id="statusText"
                                            class="ml-2 text-sm font-semibold
                                        @if ($result->is_passed) text-green-700 @else text-red-700 @endif">
                                            {{ $result->is_passed ? 'Pass' : 'Fail' }}
                                        </span>
                                    </div>
                                    <div id="statusIcon">
                                        @if ($result->is_passed)
                                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        @endif
                                    </div>
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
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('remarks') border-red-300 @enderror">{{ old('remarks', $result->remarks) }}</textarea>
                                @error('remarks')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-2 text-sm text-gray-500">
                                    Optional comments or feedback for the student.
                                </p>
                            </div>

                            <!-- Current Result Info -->
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <h4 class="text-sm font-medium text-blue-900 mb-2">Current Result Information</h4>
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <span class="text-blue-700">Added On:</span>
                                        <p class="text-blue-900">{{ $result->created_at->format('M d, Y h:i A') }}</p>
                                    </div>
                                    <div>
                                        <span class="text-blue-700">Last Updated:</span>
                                        <p class="text-blue-900">{{ $result->updated_at->format('M d, Y h:i A') }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="pt-6 border-t border-gray-200 flex justify-end space-x-3">
                                <a href="{{ route('admin.exams.results.show', ['exam' => $exam->id, 'result' => $result->id]) }}"
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Cancel
                                </a>
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Update Result
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
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

                // Update status preview
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
