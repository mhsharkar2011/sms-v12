@extends('layouts.app')

@section('title', 'Enrollment: ' . $enrollment->enrollment_id)

@section('content')
    <div class="min-h-screen bg-gray-50 flex">
        <x-admin-sidebar />

        <div class="flex-1 overflow-auto">
            <div class="container mx-auto p-6">
                <!-- Header -->
                <div class="mb-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Enrollment Details</h1>
                            <p class="text-gray-600 mt-2">Enrollment ID: {{ $enrollment->enrollment_id }}</p>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('admin.enrollments.edit', $enrollment) }}"
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2">
                                <span class="material-icons-sharp text-sm">edit</span>
                                <span>Edit</span>
                            </a>
                            <a href="{{ route('admin.enrollments.index') }}"
                                class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors flex items-center space-x-2">
                                <span class="material-icons-sharp text-sm">arrow_back</span>
                                <span>Back to Enrollments</span>
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
                        <li class="text-gray-900">{{ $enrollment->enrollment_id }}</li>
                    </ol>
                </nav>

                <div class="max-w-6xl mx-auto">
                    <!-- Flash Messages -->
                    @if (session('success'))
                        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                            <div class="flex items-center space-x-2">
                                <span class="material-icons-sharp text-sm">check_circle</span>
                                <span class="font-medium">{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    <!-- Enrollment Header -->
                    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="p-3 bg-blue-100 rounded-lg">
                                    <span class="material-icons-sharp text-blue-600 text-2xl">assignment_ind</span>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold text-gray-900">{{ $enrollment->enrollment_id }}</h2>
                                    <div class="flex items-center space-x-4 mt-2">
                                        <span
                                            class="px-3 py-1 text-sm font-medium rounded-full
                                        @if ($enrollment->status == 'enrolled') bg-green-100 text-green-800
                                        @elseif($enrollment->status == 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($enrollment->status == 'completed') bg-blue-100 text-blue-800
                                        @elseif($enrollment->status == 'withdrawn') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst($enrollment->status) }}
                                        </span>
                                        <span class="text-sm text-gray-500">
                                            Enrolled on {{ $enrollment->enrollment_date->format('F d, Y') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Left Column: Student & Class Info -->
                        <div class="lg:col-span-2 space-y-6">
                            <!-- Student Information Card -->
                            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                                    <h3 class="text-lg font-semibold text-gray-900 flex items-center space-x-2">
                                        <span class="material-icons-sharp text-blue-600">person</span>
                                        <span>Student Information</span>
                                    </h3>
                                </div>
                                <div class="p-6">
                                    <div class="flex items-start space-x-4">
                                        <div class="flex-shrink-0">
                                            <div
                                                class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                                                <span class="material-icons-sharp text-blue-600 text-2xl">person</span>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <p class="text-sm text-gray-600">Full Name</p>
                                                    <p class="font-medium text-gray-900">
                                                        {{ $enrollment->student->user->name ?? 'N/A' }}
                                                    </p>
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-600">Student ID</p>
                                                    <p class="font-medium text-gray-900">
                                                        {{ $enrollment->student->student_id ?? 'N/A' }}
                                                    </p>
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-600">Email</p>
                                                    <p class="font-medium text-gray-900">
                                                        {{ $enrollment->student->user->email ?? 'N/A' }}
                                                    </p>
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-600">Phone</p>
                                                    <p class="font-medium text-gray-900">
                                                        {{ $enrollment->student->user->phone ?? 'N/A' }}
                                                    </p>
                                                </div>
                                                <div class="md:col-span-2">
                                                    <a href="{{ route('admin.students.show', $enrollment->student) }}"
                                                        class="inline-flex items-center text-blue-600 hover:text-blue-800">
                                                        <span class="material-icons-sharp text-sm">visibility</span>
                                                        <span class="ml-1">View Student Profile</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Class Information Card -->
                            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                                    <h3 class="text-lg font-semibold text-gray-900 flex items-center space-x-2">
                                        <span class="material-icons-sharp text-green-600">class</span>
                                        <span>Class Information</span>
                                    </h3>
                                </div>
                                <div class="p-6">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <p class="text-sm text-gray-600">Class Name</p>
                                            <p class="font-medium text-gray-900">{{ $enrollment->class->name }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600">Class Code</p>
                                            <p class="font-medium text-gray-900">{{ $enrollment->class->code }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600">Grade Level</p>
                                            <p class="font-medium text-gray-900">{{ $enrollment->class->grade_level }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600">Section</p>
                                            <p class="font-medium text-gray-900">{{ $enrollment->class->section }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600">Subject</p>
                                            <p class="font-medium text-gray-900">{{ $enrollment->class->subject ?? 'N/A' }}
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600">Academic Year</p>
                                            <p class="font-medium text-gray-900">{{ $enrollment->class->academic_year }}
                                            </p>
                                        </div>
                                        <div class="md:col-span-2">
                                            <a href="{{ route('admin.classes.show', $enrollment->class) }}"
                                                class="inline-flex items-center text-green-600 hover:text-green-800">
                                                <span class="material-icons-sharp text-sm">visibility</span>
                                                <span class="ml-1">View Class Details</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Actions & Timeline -->
                        <div class="space-y-6">
                            <!-- Actions Card -->
                            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                                    <h3 class="text-lg font-semibold text-gray-900">Quick Actions</h3>
                                </div>
                                <div class="p-4 space-y-3">
                                    @if ($enrollment->isActive())
                                        <!-- Withdraw Button -->
                                        <button type="button" onclick="openWithdrawModal()"
                                            class="w-full flex items-center justify-center space-x-2 px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors">
                                            <span class="material-icons-sharp text-sm">logout</span>
                                            <span>Withdraw Student</span>
                                        </button>

                                        <!-- Complete Button -->
                                        <button type="button" onclick="openCompleteModal()"
                                            class="w-full flex items-center justify-center space-x-2 px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors">
                                            <span class="material-icons-sharp text-sm">check_circle</span>
                                            <span>Complete Enrollment</span>
                                        </button>

                                        <!-- Transfer Button -->
                                        <button type="button" onclick="openTransferModal()"
                                            class="w-full flex items-center justify-center space-x-2 px-4 py-2 bg-purple-100 text-purple-700 rounded-lg hover:bg-purple-200 transition-colors">
                                            <span class="material-icons-sharp text-sm">swap_horiz</span>
                                            <span>Transfer to Another Class</span>
                                        </button>

                                        <!-- Record Payment -->
                                        <button type="button" onclick="openPaymentModal()"
                                            class="w-full flex items-center justify-center space-x-2 px-4 py-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors">
                                            <span class="material-icons-sharp text-sm">payments</span>
                                            <span>Record Payment</span>
                                        </button>
                                    @endif

                                    <!-- Update Attendance -->
                                    <button type="button" onclick="openAttendanceModal()"
                                        class="w-full flex items-center justify-center space-x-2 px-4 py-2 bg-yellow-100 text-yellow-700 rounded-lg hover:bg-yellow-200 transition-colors">
                                        <span class="material-icons-sharp text-sm">calendar_today</span>
                                        <span>Update Attendance</span>
                                    </button>

                                    <!-- Print Enrollment -->
                                    <button type="button" onclick="printEnrollment()"
                                        class="w-full flex items-center justify-center space-x-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                                        <span class="material-icons-sharp text-sm">print</span>
                                        <span>Print Enrollment</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Timeline Card -->
                            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                                    <h3 class="text-lg font-semibold text-gray-900">Enrollment Timeline</h3>
                                </div>
                                <div class="p-4">
                                    <div class="space-y-4">
                                        <div class="flex items-start">
                                            <div
                                                class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                                <span class="material-icons-sharp text-green-600 text-sm">event</span>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-sm font-medium text-gray-900">Enrollment Date</p>
                                                <p class="text-sm text-gray-500">
                                                    {{ $enrollment->enrollment_date->format('F d, Y') }}</p>
                                            </div>
                                        </div>

                                        <div class="flex items-start">
                                            <div
                                                class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                                <span class="material-icons-sharp text-blue-600 text-sm">play_arrow</span>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-sm font-medium text-gray-900">Start Date</p>
                                                <p class="text-sm text-gray-500">
                                                    {{ $enrollment->start_date->format('F d, Y') }}</p>
                                            </div>
                                        </div>

                                        @if ($enrollment->end_date)
                                            <div class="flex items-start">
                                                <div
                                                    class="flex-shrink-0 w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                                    <span class="material-icons-sharp text-red-600 text-sm">stop</span>
                                                </div>
                                                <div class="ml-4">
                                                    <p class="text-sm font-medium text-gray-900">
                                                        {{ $enrollment->status == 'completed' ? 'Completion Date' : 'End Date' }}
                                                    </p>
                                                    <p class="text-sm text-gray-500">
                                                        {{ $enrollment->end_date->format('F d, Y') }}</p>
                                                </div>
                                            </div>
                                        @endif

                                        @if ($enrollment->approved_at)
                                            <div class="flex items-start">
                                                <div
                                                    class="flex-shrink-0 w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                                    <span
                                                        class="material-icons-sharp text-purple-600 text-sm">verified</span>
                                                </div>
                                                <div class="ml-4">
                                                    <p class="text-sm font-medium text-gray-900">Approved On</p>
                                                    <p class="text-sm text-gray-500">
                                                        {{ $enrollment->approved_at->format('F d, Y') }}</p>
                                                    <p class="text-xs text-gray-400">By
                                                        {{ $enrollment->approvedBy->name ?? 'N/A' }}</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Performance & Details Cards -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
                        <!-- Academic Performance -->
                        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center space-x-2">
                                    <span class="material-icons-sharp text-purple-600">school</span>
                                    <span>Academic Performance</span>
                                </h3>
                            </div>
                            <div class="p-6">
                                @if ($enrollment->status == 'completed')
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="text-center">
                                            <p class="text-sm text-gray-600">Final Grade</p>
                                            <p class="text-2xl font-bold text-gray-900">
                                                {{ $enrollment->final_grade ?? 'N/A' }}</p>
                                        </div>
                                        <div class="text-center">
                                            <p class="text-sm text-gray-600">Grade Letter</p>
                                            <p class="text-2xl font-bold text-gray-900">
                                                {{ $enrollment->grade_letter ?? 'N/A' }}</p>
                                        </div>
                                        <div class="col-span-2 text-center">
                                            <p class="text-sm text-gray-600">GPA</p>
                                            <p class="text-2xl font-bold text-gray-900">{{ $enrollment->gpa ?? 'N/A' }}
                                            </p>
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center py-8">
                                        <span class="material-icons-sharp text-gray-400 text-4xl">pending</span>
                                        <p class="mt-2 text-gray-500">Grades will be available after completion</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Attendance -->
                        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center space-x-2">
                                    <span class="material-icons-sharp text-yellow-600">calendar_today</span>
                                    <span>Attendance</span>
                                </h3>
                            </div>
                            <div class="p-6">
                                <div class="text-center">
                                    <div class="inline-block relative">
                                        <svg class="w-32 h-32" viewBox="0 0 36 36">
                                            <path d="M18 2.0845
                                                    a 15.9155 15.9155 0 0 1 0 31.831
                                                    a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#e5e7eb"
                                                stroke-width="3" stroke-dasharray="100, 100" />
                                            @if ($enrollment->total_classes > 0)
                                                <path d="M18 2.0845
                                                        a 15.9155 15.9155 0 0 1 0 31.831
                                                        a 15.9155 15.9155 0 0 1 0 -31.831" fill="none"
                                                    stroke="#10b981" stroke-width="3"
                                                    stroke-dasharray="{{ $enrollment->attendance_percentage }}, 100" />
                                            @endif
                                        </svg>
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <div class="text-center">
                                                <p class="text-2xl font-bold text-gray-900">
                                                    {{ $enrollment->attendance_percentage }}%
                                                </p>
                                                <p class="text-xs text-gray-500">Attendance</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4 grid grid-cols-3 gap-4">
                                        <div class="text-center">
                                            <p class="text-sm text-gray-600">Attended</p>
                                            <p class="font-medium text-gray-900">{{ $enrollment->classes_attended }}</p>
                                        </div>
                                        <div class="text-center">
                                            <p class="text-sm text-gray-600">Absent</p>
                                            <p class="font-medium text-gray-900">{{ $enrollment->classes_absent }}</p>
                                        </div>
                                        <div class="text-center">
                                            <p class="text-sm text-gray-600">Total</p>
                                            <p class="font-medium text-gray-900">{{ $enrollment->total_classes }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Financial Information -->
                        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center space-x-2">
                                    <span class="material-icons-sharp text-green-600">payments</span>
                                    <span>Financial Information</span>
                                </h3>
                            </div>
                            <div class="p-6">
                                <div class="space-y-4">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Tuition Fee:</span>
                                        <span
                                            class="font-medium">${{ number_format($enrollment->tuition_fee ?? 0, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Amount Paid:</span>
                                        <span
                                            class="font-medium text-green-600">${{ number_format($enrollment->amount_paid, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between border-t border-gray-200 pt-2">
                                        <span class="text-gray-600 font-medium">Balance:</span>
                                        <span
                                            class="font-medium {{ $enrollment->balance > 0 ? 'text-red-600' : 'text-green-600' }}">
                                            ${{ number_format($enrollment->balance ?? 0, 2) }}
                                        </span>
                                    </div>
                                    @if ($enrollment->hasBalance())
                                        <div class="mt-4">
                                            <p class="text-sm text-red-600">Outstanding balance of
                                                ${{ number_format($enrollment->balance, 2) }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notes Card -->
                    @if ($enrollment->notes)
                        <div class="mt-6 bg-white rounded-xl shadow-sm overflow-hidden">
                            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center space-x-2">
                                    <span class="material-icons-sharp text-gray-600">notes</span>
                                    <span>Notes</span>
                                </h3>
                            </div>
                            <div class="p-6">
                                <p class="text-gray-700 whitespace-pre-line">{{ $enrollment->notes }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
    @include('admin.enrollments.modals.withdraw')
    @include('admin.enrollments.modals.complete')
    @include('admin.enrollments.modals.transfer')
    @include('admin.enrollments.modals.payment')
    @include('admin.enrollments.modals.attendance')

    @push('scripts')
        <script>
            function printEnrollment() {
                window.open('{{ route('admin.enrollments.print', $enrollment) }}', '_blank');
            }

            function openWithdrawModal() {
                document.getElementById('withdrawModal').classList.remove('hidden');
            }

            function openCompleteModal() {
                document.getElementById('completeModal').classList.remove('hidden');
            }

            function openTransferModal() {
                document.getElementById('transferModal').classList.remove('hidden');
            }

            function openPaymentModal() {
                document.getElementById('paymentModal').classList.remove('hidden');
            }

            function openAttendanceModal() {
                document.getElementById('attendanceModal').classList.remove('hidden');
            }

            function closeModal(modalId) {
                document.getElementById(modalId).classList.add('hidden');
            }

            // Close modals on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    document.querySelectorAll('.modal').forEach(modal => {
                        modal.classList.add('hidden');
                    });
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

            .modal {
                background-color: rgba(0, 0, 0, 0.5);
            }
        </style>
    @endpush
@endsection
