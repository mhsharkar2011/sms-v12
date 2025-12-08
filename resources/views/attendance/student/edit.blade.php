@extends('layouts.app')

@section('title', 'Edit Student Attendance')

@section('content')
    <div class="min-h-screen bg-gray-50 flex">
        <x-admin-sidebar />

        <div class="flex-1 overflow-auto">
            <div class="container mx-auto p-6">
                <div class="mb-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Edit Student Attendance</h1>
                            <p class="text-gray-600 mt-2">
                                Editing attendance for {{ $studentAttendance->attendance_date->format('F d, Y') }}
                                - {{ $studentAttendance->class->name }} - Section {{ $studentAttendance->section->name }}
                            </p>
                        </div>
                        <a href="{{ route('student-attendance.index') }}"
                            class="text-gray-600 hover:text-gray-900 flex items-center space-x-1">
                            <span class="material-icons-sharp">arrow_back</span>
                            <span>Back to List</span>
                        </a>
                    </div>
                </div>

                <form action="{{ route('student-attendance.update', $studentAttendance) }}" method="POST"
                    id="attendanceForm">
                    @csrf
                    @method('PUT')

                    <!-- Attendance Details -->
                    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Attendance Details</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                                <input type="date" name="attendance_date" id="attendance_date"
                                    value="{{ $studentAttendance->attendance_date->format('Y-m-d') }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-50" readonly>
                                <p class="text-xs text-gray-500 mt-1">Date cannot be changed</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Student</label>
                                <div class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-50">
                                    <div class="text-sm text-gray-900">
                                        {{ $studentAttendance->student->user->name ?? 'N/A' }}</div>
                                    <div class="text-xs text-gray-500">Roll No:
                                        {{ $studentAttendance->student->roll_number ?? 'N/A' }}</div>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Class & Section</label>
                                <div class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-50">
                                    <div class="text-sm text-gray-900">{{ $studentAttendance->class->name }} - Section
                                        {{ $studentAttendance->section->name }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Attendance Status -->
                    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Attendance Status</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Status Selection -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Status *</label>
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="relative">
                                        <input type="radio" id="status_present" name="status" value="present"
                                            class="hidden peer"
                                            {{ $studentAttendance->status == 'present' ? 'checked' : '' }}>
                                        <label for="status_present"
                                            class="flex items-center justify-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer
                                                hover:border-green-500 peer-checked:border-green-500 peer-checked:bg-green-50">
                                            <div class="text-center">
                                                <span
                                                    class="material-icons-sharp text-green-600 text-2xl">check_circle</span>
                                                <p class="mt-2 font-medium">Present</p>
                                            </div>
                                        </label>
                                    </div>

                                    <div class="relative">
                                        <input type="radio" id="status_absent" name="status" value="absent"
                                            class="hidden peer"
                                            {{ $studentAttendance->status == 'absent' ? 'checked' : '' }}>
                                        <label for="status_absent"
                                            class="flex items-center justify-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer
                                                hover:border-red-500 peer-checked:border-red-500 peer-checked:bg-red-50">
                                            <div class="text-center">
                                                <span class="material-icons-sharp text-red-600 text-2xl">cancel</span>
                                                <p class="mt-2 font-medium">Absent</p>
                                            </div>
                                        </label>
                                    </div>

                                    <div class="relative">
                                        <input type="radio" id="status_late" name="status" value="late"
                                            class="hidden peer"
                                            {{ $studentAttendance->status == 'late' ? 'checked' : '' }}>
                                        <label for="status_late"
                                            class="flex items-center justify-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer
                                                hover:border-yellow-500 peer-checked:border-yellow-500 peer-checked:bg-yellow-50">
                                            <div class="text-center">
                                                <span class="material-icons-sharp text-yellow-600 text-2xl">schedule</span>
                                                <p class="mt-2 font-medium">Late</p>
                                            </div>
                                        </label>
                                    </div>

                                    <div class="relative">
                                        <input type="radio" id="status_excused" name="status" value="excused"
                                            class="hidden peer"
                                            {{ $studentAttendance->status == 'excused' ? 'checked' : '' }}>
                                        <label for="status_excused"
                                            class="flex items-center justify-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer
                                                hover:border-blue-500 peer-checked:border-blue-500 peer-checked:bg-blue-50">
                                            <div class="text-center">
                                                <span class="material-icons-sharp text-blue-600 text-2xl">verified</span>
                                                <p class="mt-2 font-medium">Excused</p>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Time Information -->
                            <div id="timeSection"
                                class="{{ in_array($studentAttendance->status, ['present', 'late']) ? '' : 'hidden' }}">
                                <div class="flex items-center justify-between mb-3">
                                    <label class="block text-sm font-medium text-gray-700">Time Tracking</label>
                                    <button type="button" id="setCurrentTimes"
                                        class="text-sm bg-blue-100 text-blue-700 px-3 py-1 rounded hover:bg-blue-200">
                                        Set Current Time
                                    </button>
                                </div>

                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Check-in Time</label>
                                        <div class="flex items-center space-x-3">
                                            <input type="time" name="check_in_time" id="check_in_time"
                                                value="{{ $studentAttendance->check_in_time ? \Carbon\Carbon::parse($studentAttendance->check_in_time)->format('H:i') : '' }}"
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <button type="button" id="setCurrentCheckIn"
                                                class="px-3 py-2 text-sm border border-gray-300 rounded-lg hover:bg-gray-50">
                                                Now
                                            </button>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Check-out Time</label>
                                        <div class="flex items-center space-x-3">
                                            <input type="time" name="check_out_time" id="check_out_time"
                                                value="{{ $studentAttendance->check_out_time ? \Carbon\Carbon::parse($studentAttendance->check_out_time)->format('H:i') : '' }}"
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <button type="button" id="setCurrentCheckOut"
                                                class="px-3 py-2 text-sm border border-gray-300 rounded-lg hover:bg-gray-50">
                                                Now
                                            </button>
                                        </div>
                                    </div>

                                    @if ($studentAttendance->check_in_time && $studentAttendance->check_out_time)
                                        <div class="p-3 bg-gray-50 rounded-lg">
                                            <div class="flex justify-between items-center">
                                                <span class="text-sm font-medium text-gray-700">Duration:</span>
                                                <span class="text-sm font-semibold text-blue-600">
                                                    @php
                                                        $checkIn = \Carbon\Carbon::parse(
                                                            $studentAttendance->check_in_time,
                                                        );
                                                        $checkOut = \Carbon\Carbon::parse(
                                                            $studentAttendance->check_out_time,
                                                        );
                                                        $duration = $checkOut->diff($checkIn);
                                                        echo $duration->format('%hh %im');
                                                    @endphp
                                                </span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Additional Information</h2>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Remark</label>
                            <textarea name="remark" id="remark" rows="3"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Enter any additional remarks or notes...">{{ $studentAttendance->remark }}</textarea>
                            <p class="text-xs text-gray-500 mt-1">Optional. Add notes about absence reason, late arrival,
                                etc.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Marked By</label>
                                <div class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-50">
                                    <div class="text-sm text-gray-900">{{ $studentAttendance->markedBy->name ?? 'N/A' }}
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Last Updated</label>
                                <div class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-50">
                                    <div class="text-sm text-gray-900">
                                        {{ $studentAttendance->updated_at->format('M d, Y h:i A') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex justify-between items-center">
                            <div>
                                <button type="button" onclick="window.history.back()"
                                    class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                                    Cancel
                                </button>
                            </div>
                            <div class="flex space-x-3">
                                <!-- Delete Form -->
                                <form action="{{ route('student-attendance.destroy', $studentAttendance) }}"
                                    method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this attendance record?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium">
                                        Delete
                                    </button>
                                </form>

                                <button type="submit"
                                    class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium">
                                    Update Attendance
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusRadios = document.querySelectorAll('input[name="status"]');
            const timeSection = document.getElementById('timeSection');
            const checkInInput = document.getElementById('check_in_time');
            const checkOutInput = document.getElementById('check_out_time');
            const setCurrentTimesBtn = document.getElementById('setCurrentTimes');
            const setCurrentCheckInBtn = document.getElementById('setCurrentCheckIn');
            const setCurrentCheckOutBtn = document.getElementById('setCurrentCheckOut');

            // Function to get current time in HH:MM format
            function getCurrentTime() {
                const now = new Date();
                const hours = now.getHours().toString().padStart(2, '0');
                const minutes = now.getMinutes().toString().padStart(2, '0');
                return `${hours}:${minutes}`;
            }

            // Toggle time section based on status
            function toggleTimeSection() {
                const selectedStatus = document.querySelector('input[name="status"]:checked').value;

                if (selectedStatus === 'present' || selectedStatus === 'late') {
                    timeSection.classList.remove('hidden');

                    // Auto-set current time if no time is set
                    if (!checkInInput.value) {
                        checkInInput.value = getCurrentTime();
                    }

                    // Auto-set check-out time 5 hours later if present and no check-out time
                    if (selectedStatus === 'present' && !checkOutInput.value) {
                        const currentTime = new Date();
                        currentTime.setHours(currentTime.getHours() + 5);
                        const checkOutHour = currentTime.getHours().toString().padStart(2, '0');
                        const checkOutMinute = currentTime.getMinutes().toString().padStart(2, '0');
                        checkOutInput.value = `${checkOutHour}:${checkOutMinute}`;
                    }
                } else {
                    timeSection.classList.add('hidden');
                }
            }

            // Set current time for both check-in and check-out
            setCurrentTimesBtn.addEventListener('click', function() {
                const currentTime = getCurrentTime();
                checkInInput.value = currentTime;

                // Set check-out time 5 hours later
                const now = new Date();
                now.setHours(now.getHours() + 5);
                const checkOutHour = now.getHours().toString().padStart(2, '0');
                const checkOutMinute = now.getMinutes().toString().padStart(2, '0');
                checkOutInput.value = `${checkOutHour}:${checkOutMinute}`;

                showNotification('Current time set for both check-in and check-out');
            });

            // Set current time for check-in only
            setCurrentCheckInBtn.addEventListener('click', function() {
                checkInInput.value = getCurrentTime();
                showNotification('Current time set for check-in');
            });

            // Set current time for check-out only
            setCurrentCheckOutBtn.addEventListener('click', function() {
                checkOutInput.value = getCurrentTime();
                showNotification('Current time set for check-out');
            });

            // Validate check-out time is after check-in time
            checkOutInput.addEventListener('change', function() {
                if (checkInInput.value && checkOutInput.value) {
                    if (checkOutInput.value <= checkInInput.value) {
                        alert('Check-out time must be after check-in time');
                        checkOutInput.value = '';
                        checkOutInput.focus();
                    }
                }
            });

            // Show notification
            function showNotification(message) {
                // Create notification element
                const notification = document.createElement('div');
                notification.className =
                    'fixed top-4 right-4 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg transform translate-x-full transition-transform duration-300';
                notification.textContent = message;
                notification.id = 'notification';

                document.body.appendChild(notification);

                // Show notification
                setTimeout(() => {
                    notification.style.transform = 'translateX(0)';
                }, 10);

                // Hide and remove after 3 seconds
                setTimeout(() => {
                    notification.style.transform = 'translateX(100%)';
                    setTimeout(() => {
                        notification.remove();
                    }, 300);
                }, 3000);
            }

            // Add event listeners to status radios
            statusRadios.forEach(radio => {
                radio.addEventListener('change', toggleTimeSection);
            });

            // Initialize time section on page load
            toggleTimeSection();

            // Form validation
            document.getElementById('attendanceForm').addEventListener('submit', function(e) {
                const selectedStatus = document.querySelector('input[name="status"]:checked');

                if (!selectedStatus) {
                    e.preventDefault();
                    alert('Please select an attendance status');
                    return;
                }

                // If status is present or late, check if check-in time is provided
                if (selectedStatus.value === 'present' || selectedStatus.value === 'late') {
                    if (!checkInInput.value) {
                        e.preventDefault();
                        alert('Please provide check-in time for present/late status');
                        checkInInput.focus();
                        return;
                    }

                    // Check-out time is optional but if provided, must be after check-in
                    if (checkOutInput.value && checkOutInput.value <= checkInInput.value) {
                        e.preventDefault();
                        alert('Check-out time must be after check-in time');
                        checkOutInput.focus();
                        return;
                    }
                }

                // Show loading state
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.textContent;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="animate-spin mr-2">⟳</span> Updating...';

                // Re-enable button after 5 seconds if form hasn't submitted
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                }, 5000);
            });

            // Add CSS for spinner if not already present
            if (!document.querySelector('#spinner-styles')) {
                const style = document.createElement('style');
                style.id = 'spinner-styles';
                style.textContent = `
                    @keyframes spin {
                        0% { transform: rotate(0deg); }
                        100% { transform: rotate(360deg); }
                    }
                    .animate-spin {
                        animation: spin 1s linear infinite;
                        display: inline-block;
                    }
                `;
                document.head.appendChild(style);
            }
        });
    </script>
    <style>
        /* Custom styles for attendance edit page */
        .hidden {
            display: none !important;
        }

        /* Radio button card styles */
        .peer:checked+label {
            border-width: 2px;
        }

        /* Status-specific colors */
        .peer:checked[value="present"]+label {
            border-color: #10b981;
            background-color: #f0fdf4;
        }

        .peer:checked[value="absent"]+label {
            border-color: #ef4444;
            background-color: #fef2f2;
        }

        .peer:checked[value="late"]+label {
            border-color: #f59e0b;
            background-color: #fffbeb;
        }

        .peer:checked[value="excused"]+label {
            border-color: #3b82f6;
            background-color: #eff6ff;
        }

        /* Time input styling */
        input[type="time"]::-webkit-calendar-picker-indicator {
            background: none;
            display: none;
        }

        /* Notification animation */
        @keyframes slideIn {
            from {
                transform: translateX(100%);
            }

            to {
                transform: translateX(0);
            }
        }

        @keyframes slideOut {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(100%);
            }
        }
    </style>
@endsection
