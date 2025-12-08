@extends('layouts.app')

@section('title', 'Mark Staff Attendance')

@section('content')
    <div class="min-h-screen bg-gray-50 flex">
        <x-admin-sidebar />

        <div class="flex-1 overflow-auto">
            <div class="container mx-auto p-6">
                <div class="mb-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Mark Staff Attendance</h1>
                            <p class="text-gray-600 mt-2">Select date to mark staff attendance</p>
                        </div>
                        <a href="{{ route('staff-attendance.index') }}"
                            class="text-gray-600 hover:text-gray-900 flex items-center space-x-1">
                            <span class="material-icons-sharp">arrow_back</span>
                            <span>Back to List</span>
                        </a>
                    </div>
                </div>

                <form action="{{ route('staff-attendance.store') }}" method="POST" id="attendanceForm">
                    @csrf

                    <!-- Selection Section -->
                    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Date *</label>
                                <input type="date" name="attendance_date" id="attendance_date"
                                    value="{{ date('Y-m-d') }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div class="flex items-end">
                                <button type="button" id="loadStaff"
                                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                    Load Staff Members
                                </button>
                                <button type="button" id="loadPreviousAttendance"
                                    class="ml-2 bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                                    Load Previous Attendance
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Staff List -->
                    <div class="bg-white rounded-xl shadow-sm p-6 mb-6 hidden" id="staffSection">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Mark Attendance</h2>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Staff ID
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Staff Name
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Type
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Check In
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Check Out
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Remark
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200" id="staffList">
                                    <!-- Staff will be loaded here -->
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-6">
                            <button type="submit"
                                class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors font-medium">
                                Save Attendance
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loadBtn = document.getElementById('loadStaff');
            const loadPreviousBtn = document.getElementById('loadPreviousAttendance');
            const staffSection = document.getElementById('staffSection');
            const staffList = document.getElementById('staffList');

            loadBtn.addEventListener('click', async function() {
                const date = document.getElementById('attendance_date').value;

                if (!date) {
                    alert('Please select date');
                    return;
                }

                try {
                    // In a real application, you would fetch staff from API
                    // For now, we'll use the staff data passed from controller
                    staffList.innerHTML = '';

                    @foreach ($staffMembers as $staff)
                        const row = document.createElement('tr');
                        row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ $staff->staff_id ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $staff->user->name }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ ucfirst($staff->staff_type) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <select name="attendances[{{ $staff->id }}][status]"
                            class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
                            <option value="present">Present</option>
                            <option value="absent">Absent</option>
                            <option value="late">Late</option>
                            <option value="half_day">Half Day</option>
                            <option value="leave">Leave</option>
                        </select>
                        <input type="hidden" name="attendances[{{ $staff->id }}][staff_id]" value="{{ $staff->id }}">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <input type="time" name="attendances[{{ $staff->id }}][check_in_time]"
                            class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <input type="time" name="attendances[{{ $staff->id }}][check_out_time]"
                            class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <input type="text" name="attendances[{{ $staff->id }}][remark]"
                            class="border border-gray-300 rounded-lg px-3 py-2 text-sm w-full"
                            placeholder="Optional remark">
                    </td>
                `;
                        staffList.appendChild(row);
                    @endforeach

                    staffSection.classList.remove('hidden');
                } catch (error) {
                    console.error('Error loading staff:', error);
                    alert('Error loading staff members');
                }
            });

            loadPreviousBtn.addEventListener('click', async function() {
                const date = document.getElementById('attendance_date').value;

                if (!date) {
                    alert('Please select date');
                    return;
                }

                try {
                    // Load previous attendance data
                    const response = await fetch(`/attendance/staff-attendance-by-date?date=${date}`);
                    const previousAttendance = await response.json();

                    // Update statuses based on previous attendance
                    Object.keys(previousAttendance).forEach(staffId => {
                        const attendance = previousAttendance[staffId];
                        const statusSelect = document.querySelector(
                            `select[name="attendances[${staffId}][status]"]`);
                        const checkInInput = document.querySelector(
                            `input[name="attendances[${staffId}][check_in_time]"]`);
                        const checkOutInput = document.querySelector(
                            `input[name="attendances[${staffId}][check_out_time]"]`);
                        const remarkInput = document.querySelector(
                            `input[name="attendances[${staffId}][remark]"]`);

                        if (statusSelect) {
                            statusSelect.value = attendance.status;
                        }
                        if (checkInInput && attendance.check_in_time) {
                            checkInInput.value = attendance.check_in_time.substring(0, 5);
                        }
                        if (checkOutInput && attendance.check_out_time) {
                            checkOutInput.value = attendance.check_out_time.substring(0, 5);
                        }
                        if (remarkInput) {
                            remarkInput.value = attendance.remark || '';
                        }
                    });
                } catch (error) {
                    console.error('Error loading previous attendance:', error);
                }
            });
        });
    </script>
@endsection
