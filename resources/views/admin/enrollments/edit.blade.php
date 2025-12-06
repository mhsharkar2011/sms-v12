@extends('layouts.app')

@section('title', 'Edit Enrollment: ' . $enrollment->enrollment_id)

@section('content')
    <div class="min-h-screen bg-gray-50 flex">
        <x-admin-sidebar />

        <div class="flex-1 overflow-auto">
            <div class="container mx-auto p-6">
                <!-- Header -->
                <div class="mb-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Edit Enrollment</h1>
                            <p class="text-gray-600 mt-2">Enrollment ID: {{ $enrollment->enrollment_id }}</p>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('admin.enrollments.show', $enrollment) }}"
                                class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors flex items-center space-x-2">
                                <span class="material-icons-sharp text-sm">arrow_back</span>
                                <span>Back to Details</span>
                            </a>
                            <a href="{{ route('admin.enrollments.index') }}"
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2">
                                <span class="material-icons-sharp text-sm">list</span>
                                <span>All Enrollments</span>
                            </a>
                        </div>
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
                        <li><a href="{{ route('admin.enrollments.show', $enrollment) }}"
                                class="hover:text-blue-600">{{ $enrollment->enrollment_id }}</a></li>
                        <li><span class="material-icons-sharp text-xs">chevron_right</span></li>
                        <li class="text-gray-900">Edit</li>
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

                    <!-- Enrollment Summary -->
                    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Student</p>
                                <p class="font-medium text-gray-900">{{ $enrollment->student->user->name ?? 'N/A' }}</p>
                                <p class="text-sm text-gray-500">{{ $enrollment->student->student_id ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Class</p>
                                <p class="font-medium text-gray-900">{{ $enrollment->class->name }}
                                    ({{ $enrollment->class->code }})</p>
                                <p class="text-sm text-gray-500">{{ $enrollment->class->grade_level }} -
                                    {{ $enrollment->class->section }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Current Status</p>
                                <span
                                    class="px-2 py-1 text-xs font-medium rounded-full
                                @if ($enrollment->status == 'enrolled') bg-green-100 text-green-800
                                @elseif($enrollment->status == 'pending') bg-yellow-100 text-yellow-800
                                @elseif($enrollment->status == 'completed') bg-blue-100 text-blue-800
                                @elseif($enrollment->status == 'withdrawn') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($enrollment->status) }}
                                </span>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Enrollment Date</p>
                                <p class="font-medium text-gray-900">{{ $enrollment->enrollment_date->format('M d, Y') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Form Card -->
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <form action="{{ route('admin.enrollments.update', $enrollment) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Basic Information -->
                            <div class="p-6 border-b border-gray-200">
                                <h2 class="text-xl font-semibold text-gray-900 mb-4">Basic Information</h2>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Student -->
                                    <div>
                                        <label for="student_id" class="block text-sm font-medium text-gray-700 mb-2">
                                            Student *
                                        </label>
                                        <select name="student_id" id="student_id"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            required>
                                            <option value="">Select Student</option>
                                            @foreach ($students as $student)
                                                <option value="{{ $student->id }}"
                                                    {{ old('student_id', $enrollment->student_id) == $student->id ? 'selected' : '' }}>
                                                    {{ $student->user->name }} - {{ $student->student_id }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('student_id')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Class -->
                                    <div>
                                        <label for="class_id" class="block text-sm font-medium text-gray-700 mb-2">
                                            Class *
                                        </label>
                                        <select name="class_id" id="class_id"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            required>
                                            <option value="">Select Class</option>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}"
                                                    {{ old('class_id', $enrollment->class_id) == $class->id ? 'selected' : '' }}>
                                                    {{ $class->name }} ({{ $class->code }}) - {{ $class->grade_level }}
                                                    {{ $class->section }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('class_id')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Enrollment Date -->
                                    <div>
                                        <label for="enrollment_date" class="block text-sm font-medium text-gray-700 mb-2">
                                            Enrollment Date *
                                        </label>
                                        <input type="date" name="enrollment_date" id="enrollment_date"
                                            value="{{ old('enrollment_date', $enrollment->enrollment_date->format('Y-m-d')) }}"
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
                                            value="{{ old('start_date', $enrollment->start_date->format('Y-m-d')) }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            required>
                                        @error('start_date')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Status & Dates -->
                            <div class="p-6 border-b border-gray-200">
                                <h2 class="text-xl font-semibold text-gray-900 mb-4">Status & Dates</h2>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Status -->
                                    <div>
                                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                            Status *
                                        </label>
                                        <select name="status" id="status"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            required>
                                            <option value="pending"
                                                {{ old('status', $enrollment->status) == 'pending' ? 'selected' : '' }}>
                                                Pending</option>
                                            <option value="enrolled"
                                                {{ old('status', $enrollment->status) == 'enrolled' ? 'selected' : '' }}>
                                                Enrolled</option>
                                            <option value="completed"
                                                {{ old('status', $enrollment->status) == 'completed' ? 'selected' : '' }}>
                                                Completed</option>
                                            <option value="withdrawn"
                                                {{ old('status', $enrollment->status) == 'withdrawn' ? 'selected' : '' }}>
                                                Withdrawn</option>
                                            <option value="transferred"
                                                {{ old('status', $enrollment->status) == 'transferred' ? 'selected' : '' }}>
                                                Transferred</option>
                                        </select>
                                        @error('status')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- End Date -->
                                    <div>
                                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">
                                            End Date
                                        </label>
                                        <input type="date" name="end_date" id="end_date"
                                            value="{{ old('end_date', $enrollment->end_date ? $enrollment->end_date->format('Y-m-d') : '') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        @error('end_date')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Academic Information -->
                            <div class="p-6 border-b border-gray-200">
                                <h2 class="text-xl font-semibold text-gray-900 mb-4">Academic Information</h2>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <!-- Final Grade -->
                                    <div>
                                        <label for="final_grade" class="block text-sm font-medium text-gray-700 mb-2">
                                            Final Grade (0-100)
                                        </label>
                                        <input type="number" name="final_grade" id="final_grade" step="0.01"
                                            min="0" max="100"
                                            value="{{ old('final_grade', $enrollment->final_grade) }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        @error('final_grade')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Grade Letter -->
                                    <div>
                                        <label for="grade_letter" class="block text-sm font-medium text-gray-700 mb-2">
                                            Grade Letter
                                        </label>
                                        <select name="grade_letter" id="grade_letter"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="">Select Grade</option>
                                            <option value="A+"
                                                {{ old('grade_letter', $enrollment->grade_letter) == 'A+' ? 'selected' : '' }}>
                                                A+</option>
                                            <option value="A"
                                                {{ old('grade_letter', $enrollment->grade_letter) == 'A' ? 'selected' : '' }}>
                                                A</option>
                                            <option value="A-"
                                                {{ old('grade_letter', $enrollment->grade_letter) == 'A-' ? 'selected' : '' }}>
                                                A-</option>
                                            <option value="B+"
                                                {{ old('grade_letter', $enrollment->grade_letter) == 'B+' ? 'selected' : '' }}>
                                                B+</option>
                                            <option value="B"
                                                {{ old('grade_letter', $enrollment->grade_letter) == 'B' ? 'selected' : '' }}>
                                                B</option>
                                            <option value="B-"
                                                {{ old('grade_letter', $enrollment->grade_letter) == 'B-' ? 'selected' : '' }}>
                                                B-</option>
                                            <option value="C+"
                                                {{ old('grade_letter', $enrollment->grade_letter) == 'C+' ? 'selected' : '' }}>
                                                C+</option>
                                            <option value="C"
                                                {{ old('grade_letter', $enrollment->grade_letter) == 'C' ? 'selected' : '' }}>
                                                C</option>
                                            <option value="C-"
                                                {{ old('grade_letter', $enrollment->grade_letter) == 'C-' ? 'selected' : '' }}>
                                                C-</option>
                                            <option value="D+"
                                                {{ old('grade_letter', $enrollment->grade_letter) == 'D+' ? 'selected' : '' }}>
                                                D+</option>
                                            <option value="D"
                                                {{ old('grade_letter', $enrollment->grade_letter) == 'D' ? 'selected' : '' }}>
                                                D</option>
                                            <option value="F"
                                                {{ old('grade_letter', $enrollment->grade_letter) == 'F' ? 'selected' : '' }}>
                                                F</option>
                                        </select>
                                        @error('grade_letter')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- GPA -->
                                    <div>
                                        <label for="gpa" class="block text-sm font-medium text-gray-700 mb-2">
                                            GPA (0-4.0)
                                        </label>
                                        <input type="number" name="gpa" id="gpa" step="0.01"
                                            min="0" max="4" value="{{ old('gpa', $enrollment->gpa) }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        @error('gpa')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Financial Information -->
                            <div class="p-6 border-b border-gray-200">
                                <h2 class="text-xl font-semibold text-gray-900 mb-4">Financial Information</h2>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <!-- Tuition Fee -->
                                    <div>
                                        <label for="tuition_fee" class="block text-sm font-medium text-gray-700 mb-2">
                                            Tuition Fee
                                        </label>
                                        <div class="relative">
                                            <span class="absolute left-3 top-2 text-gray-500">$</span>
                                            <input type="number" name="tuition_fee" id="tuition_fee" step="0.01"
                                                min="0" value="{{ old('tuition_fee', $enrollment->tuition_fee) }}"
                                                class="w-full border border-gray-300 rounded-lg pl-8 pr-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        </div>
                                        @error('tuition_fee')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Amount Paid -->
                                    <div>
                                        <label for="amount_paid" class="block text-sm font-medium text-gray-700 mb-2">
                                            Amount Paid
                                        </label>
                                        <div class="relative">
                                            <span class="absolute left-3 top-2 text-gray-500">$</span>
                                            <input type="number" name="amount_paid" id="amount_paid" step="0.01"
                                                min="0" value="{{ old('amount_paid', $enrollment->amount_paid) }}"
                                                class="w-full border border-gray-300 rounded-lg pl-8 pr-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        </div>
                                        @error('amount_paid')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Balance (Readonly) -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Balance
                                        </label>
                                        <div class="relative">
                                            <span class="absolute left-3 top-2 text-gray-500">$</span>
                                            <input type="text" readonly
                                                value="{{ number_format($enrollment->calculateBalance(), 2) }}"
                                                class="w-full border border-gray-300 bg-gray-50 rounded-lg pl-8 pr-3 py-2">
                                        </div>
                                        <p class="mt-1 text-xs text-gray-500">Calculated automatically</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Withdrawal Information -->
                            <div class="p-6 border-b border-gray-200">
                                <h2 class="text-xl font-semibold text-gray-900 mb-4">Withdrawal Information</h2>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Withdrawal Date -->
                                    <div>
                                        <label for="withdrawal_date" class="block text-sm font-medium text-gray-700 mb-2">
                                            Withdrawal Date
                                        </label>
                                        <input type="date" name="withdrawal_date" id="withdrawal_date"
                                            value="{{ old('withdrawal_date', $enrollment->withdrawal_date ? $enrollment->withdrawal_date->format('Y-m-d') : '') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        @error('withdrawal_date')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Withdrawal Reason -->
                                    <div>
                                        <label for="withdrawal_reason"
                                            class="block text-sm font-medium text-gray-700 mb-2">
                                            Withdrawal Reason
                                        </label>
                                        <input type="text" name="withdrawal_reason" id="withdrawal_reason"
                                            value="{{ old('withdrawal_reason', $enrollment->withdrawal_reason) }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        @error('withdrawal_reason')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Information -->
                            <div class="p-6">
                                <h2 class="text-xl font-semibold text-gray-900 mb-4">Additional Information</h2>

                                <!-- Notes -->
                                <div>
                                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                        Notes
                                    </label>
                                    <textarea name="notes" id="notes" rows="4"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('notes', $enrollment->notes) }}</textarea>
                                    @error('notes')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                                <div class="flex items-center justify-between">
                                    <a href="{{ route('admin.enrollments.show', $enrollment) }}"
                                        class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                                        Cancel
                                    </a>
                                    <div class="flex space-x-3">
                                        <button type="button" onclick="resetForm()"
                                            class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                                            Reset Changes
                                        </button>
                                        <button type="submit"
                                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2">
                                            <span class="material-icons-sharp text-sm">save</span>
                                            <span>Update Enrollment</span>
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

    @push('scripts')
        <script>
            function resetForm() {
                if (confirm('Are you sure you want to reset all changes?')) {
                    window.location.reload();
                }
            }

            // Auto-update balance when fee or payment changes
            document.getElementById('tuition_fee').addEventListener('input', updateBalance);
            document.getElementById('amount_paid').addEventListener('input', updateBalance);

            function updateBalance() {
                const tuitionFee = parseFloat(document.getElementById('tuition_fee').value) || 0;
                const amountPaid = parseFloat(document.getElementById('amount_paid').value) || 0;
                const balance = tuitionFee - amountPaid;

                // Update the display (though it's readonly)
                document.querySelector('input[readonly]').value = balance.toFixed(2);
            }

            // Form validation
            document.querySelector('form').addEventListener('submit', function(e) {
                const requiredFields = ['student_id', 'class_id', 'enrollment_date', 'start_date', 'status'];
                let isValid = true;

                requiredFields.forEach(field => {
                    const element = document.getElementById(field);
                    if (!element.value) {
                        isValid = false;
                        element.classList.add('border-red-500');
                    } else {
                        element.classList.remove('border-red-500');
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    alert('Please fill in all required fields.');
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
        </style>
    @endpush
@endsection
