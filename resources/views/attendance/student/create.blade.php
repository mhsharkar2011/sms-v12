@extends('layouts.app')

@section('title', 'Mark Student Attendance')

@section('content')
    <div class="min-h-screen bg-gray-50 flex">
        <x-admin-sidebar />

        <div class="flex-1 overflow-auto">
            <div class="container mx-auto p-6">
                <div class="mb-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Mark Student Attendance</h1>
                            <p class="text-gray-600 mt-2">Select class and section to mark attendance</p>
                        </div>
                        <a href="{{ route('student-attendance.index') }}"
                            class="text-gray-600 hover:text-gray-900 flex items-center space-x-1">
                            <span class="material-icons-sharp">arrow_back</span>
                            <span>Back to List</span>
                        </a>
                    </div>
                </div>

                <form action="{{ route('student-attendance.store') }}" method="POST" id="attendanceForm">
                    @csrf

                    <!-- Selection Section -->
                    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Select Class & Section</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Date *</label>
                                <input type="date" name="attendance_date" id="attendance_date"
                                    value="{{ date('Y-m-d') }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Class *</label>
                                <select name="class_id" id="class_id"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Class</option>
                                    @foreach ($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Section *</label>
                                <select name="section_id" id="section_id"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Section</option>
                                    @foreach ($sections as $section)
                                        <option value="{{ $section->id }}">{{ $section->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="button" id="loadStudents"
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                Load Students
                            </button>
                            <button type="button" id="loadPreviousAttendance"
                                class="ml-2 bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                                Load Previous Attendance
                            </button>
                            <button type="button" id="setCurrentTimeForPresent"
                                class="ml-2 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                                Set Current Time for Present
                            </button>
                        </div>
                    </div>

                    <!-- Students List -->
                    <div class="bg-white rounded-xl shadow-sm p-6 mb-6 hidden" id="studentsSection">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-semibold text-gray-900">Mark Attendance</h2>
                            <div class="text-sm text-gray-600">
                                <span id="studentCount">0</span> students loaded
                            </div>
                        </div>

                        <div class="mb-4 flex items-center space-x-4">
                            <div class="flex items-center">
                                <input type="checkbox" id="enableCheckInOut" class="mr-2">
                                <label for="enableCheckInOut" class="text-sm text-gray-700">Enable
                                    Check-in/Check-out</label>
                            </div>
                            <div class="text-sm text-gray-500">
                                Current Time: <span id="currentTime">{{ now()->format('H:i') }}</span>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Roll No
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Student Name
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider check-time-column hidden">
                                            Check-in
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider check-time-column hidden">
                                            Check-out
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Remark
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200" id="studentsList">
                                    <!-- Students will be loaded here -->
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-6 flex justify-between items-center">
                            <div>
                                <button type="button" id="markAllPresent"
                                    class="bg-green-100 text-green-700 px-4 py-2 rounded-lg hover:bg-green-200 transition-colors font-medium mr-2">
                                    Mark All Present
                                </button>
                                <button type="button" id="markAllAbsent"
                                    class="bg-red-100 text-red-700 px-4 py-2 rounded-lg hover:bg-red-200 transition-colors font-medium">
                                    Mark All Absent
                                </button>
                            </div>
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
            const loadBtn = document.getElementById('loadStudents');
            const loadPreviousBtn = document.getElementById('loadPreviousAttendance');
            const setCurrentTimeBtn = document.getElementById('setCurrentTimeForPresent');
            const studentsSection = document.getElementById('studentsSection');
            const studentsList = document.getElementById('studentsList');
            const studentCount = document.getElementById('studentCount');
            const enableCheckInOut = document.getElementById('enableCheckInOut');
            const markAllPresentBtn = document.getElementById('markAllPresent');
            const markAllAbsentBtn = document.getElementById('markAllAbsent');
            const currentTimeSpan = document.getElementById('currentTime');

            // Update current time every minute
            function updateCurrentTime() {
                const now = new Date();
                const hours = now.getHours().toString().padStart(2, '0');
                const minutes = now.getMinutes().toString().padStart(2, '0');
                currentTimeSpan.textContent = `${hours}:${minutes}`;
            }

            updateCurrentTime();
            setInterval(updateCurrentTime, 60000);

            // Toggle check-in/check-out columns
            enableCheckInOut.addEventListener('change', function() {
                const checkTimeColumns = document.querySelectorAll('.check-time-column');
                const checkTimeInputs = document.querySelectorAll('.check-time-input');

                if (this.checked) {
                    checkTimeColumns.forEach(col => col.classList.remove('hidden'));
                    checkTimeInputs.forEach(input => input.classList.remove('hidden'));
                } else {
                    checkTimeColumns.forEach(col => col.classList.add('hidden'));
                    checkTimeInputs.forEach(input => input.classList.add('hidden'));
                }
            });

            loadBtn.addEventListener('click', async function() {
                const date = document.getElementById('attendance_date').value;
                const classId = document.getElementById('class_id').value;
                const sectionId = document.getElementById('section_id').value;

                if (!date || !classId || !sectionId) {
                    alert('Please select date, class and section');
                    return;
                }

                try {
                    // Show loading state
                    loadBtn.disabled = true;
                    loadBtn.innerHTML = '<span class="animate-spin mr-2">⟳</span> Loading...';

                    const response = await fetch(
                        `/attendance/students-by-class-section?class_id=${classId}&section_id=${sectionId}`
                    );

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const contentType = response.headers.get('content-type');
                    if (!contentType || !contentType.includes('application/json')) {
                        const text = await response.text();
                        console.error('Non-JSON response:', text.substring(0, 200));
                        throw new Error('Server returned non-JSON response');
                    }

                    const result = await response.json();

                    if (!result.success) {
                        throw new Error(result.message || 'Failed to load students');
                    }

                    const students = result.data || result;
                    renderStudentsTable(students);

                    studentsSection.classList.remove('hidden');

                } catch (error) {
                    console.error('Error loading students:', error);
                    alert(`Error: ${error.message}\nCheck console for details.`);
                } finally {
                    loadBtn.disabled = false;
                    loadBtn.innerHTML = 'Load Students';
                }
            });

            function renderStudentsTable(students) {
                studentsList.innerHTML = '';
                const currentTime = new Date();
                const currentHour = currentTime.getHours().toString().padStart(2, '0');
                const currentMinute = currentTime.getMinutes().toString().padStart(2, '0');
                const currentTimeString = `${currentHour}:${currentMinute}`;

                students.forEach(student => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            ${student.roll_number || 'N/A'}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                                ${student.user?.name || student.name || 'N/A'}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <select name="attendances[${student.id}][status]"
                                class="border border-gray-300 rounded-lg px-3 py-2 text-sm attendance-status">
                                <option value="present">Present</option>
                                <option value="absent">Absent</option>
                                <option value="late">Late</option>
                                <option value="excused">Excused</option>
                            </select>
                            <input type="hidden" name="attendances[${student.id}][student_id]" value="${student.id}">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap check-time-column hidden">
                            <input type="time" name="attendances[${student.id}][check_in_time]"
                                class="border border-gray-300 rounded-lg px-3 py-2 text-sm check-time-input hidden"
                                value="${currentTimeString}">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap check-time-column hidden">
                            <input type="time" name="attendances[${student.id}][check_out_time]"
                                class="border border-gray-300 rounded-lg px-3 py-2 text-sm check-time-input hidden">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="text" name="attendances[${student.id}][remark]"
                                class="border border-gray-300 rounded-lg px-3 py-2 text-sm w-full"
                                placeholder="Optional remark">
                        </td>
                    `;

                    // Add change event to status dropdown
                    const statusSelect = row.querySelector('.attendance-status');
                    const checkInInput = row.querySelector('input[name*="check_in_time"]');
                    const checkOutInput = row.querySelector('input[name*="check_out_time"]');

                    statusSelect.addEventListener('change', function() {
                        if (this.value === 'present' || this.value === 'late') {
                            checkInInput.value = currentTimeString;
                            // Set check-out time 5 hours later (school day)
                            const checkOutTime = new Date(currentTime.getTime() + 5 * 60 * 60 *
                                1000);
                            const checkOutHour = checkOutTime.getHours().toString().padStart(2,
                            '0');
                            const checkOutMinute = checkOutTime.getMinutes().toString().padStart(2,
                                '0');
                            checkOutInput.value = `${checkOutHour}:${checkOutMinute}`;
                        } else {
                            checkInInput.value = '';
                            checkOutInput.value = '';
                        }
                    });

                    studentsList.appendChild(row);
                });

                studentCount.textContent = students.length;
            }

            // Set current time for all present students
            setCurrentTimeBtn.addEventListener('click', function() {
                const currentTime = new Date();
                const currentHour = currentTime.getHours().toString().padStart(2, '0');
                const currentMinute = currentTime.getMinutes().toString().padStart(2, '0');
                const currentTimeString = `${currentHour}:${currentMinute}`;

                // Set check-in time for all "present" status students
                const statusSelects = document.querySelectorAll('.attendance-status');
                statusSelects.forEach(select => {
                    if (select.value === 'present' || select.value === 'late') {
                        const studentId = select.name.match(/\d+/)[0];
                        const checkInInput = document.querySelector(
                            `input[name="attendances[${studentId}][check_in_time]"]`);
                        const checkOutInput = document.querySelector(
                            `input[name="attendances[${studentId}][check_out_time]"]`);

                        if (checkInInput) {
                            checkInInput.value = currentTimeString;
                        }
                        if (checkOutInput) {
                            // Set check-out time 5 hours later
                            const checkOutTime = new Date(currentTime.getTime() + 5 * 60 * 60 *
                                1000);
                            const checkOutHour = checkOutTime.getHours().toString().padStart(2,
                            '0');
                            const checkOutMinute = checkOutTime.getMinutes().toString().padStart(2,
                                '0');
                            checkOutInput.value = `${checkOutHour}:${checkOutMinute}`;
                        }
                    }
                });

                alert('Current time set for all present students');
            });

            // Mark all as present
            markAllPresentBtn.addEventListener('click', function() {
                const statusSelects = document.querySelectorAll('.attendance-status');
                const currentTime = new Date();
                const currentHour = currentTime.getHours().toString().padStart(2, '0');
                const currentMinute = currentTime.getMinutes().toString().padStart(2, '0');
                const currentTimeString = `${currentHour}:${currentMinute}`;

                statusSelects.forEach(select => {
                    select.value = 'present';

                    // Trigger the change event to set times
                    const event = new Event('change');
                    select.dispatchEvent(event);
                });

                alert('All students marked as present');
            });

            // Mark all as absent
            markAllAbsentBtn.addEventListener('click', function() {
                const statusSelects = document.querySelectorAll('.attendance-status');

                statusSelects.forEach(select => {
                    select.value = 'absent';

                    // Trigger the change event to clear times
                    const event = new Event('change');
                    select.dispatchEvent(event);
                });

                alert('All students marked as absent');
            });

            loadPreviousBtn.addEventListener('click', async function() {
                const date = document.getElementById('attendance_date').value;
                const classId = document.getElementById('class_id').value;
                const sectionId = document.getElementById('section_id').value;

                if (!date || !classId || !sectionId) {
                    alert('Please select date, class and section');
                    return;
                }

                try {
                    // Load students first
                    await loadBtn.click();

                    // Wait a moment for table to render
                    await new Promise(resolve => setTimeout(resolve, 500));

                    // Load previous attendance
                    const response = await fetch(
                        `/attendance/attendance-by-date?date=${date}&class_id=${classId}&section_id=${sectionId}`
                    );

                    if (response.ok) {
                        const previousAttendance = await response.json();

                        // Update statuses and times based on previous attendance
                        if (previousAttendance.data) {
                            previousAttendance.data.forEach(attendance => {
                                const statusSelect = document.querySelector(
                                    `select[name="attendances[${attendance.student_id}][status]"]`
                                );
                                const checkInInput = document.querySelector(
                                    `input[name="attendances[${attendance.student_id}][check_in_time]"]`
                                );
                                const checkOutInput = document.querySelector(
                                    `input[name="attendances[${attendance.student_id}][check_out_time]"]`
                                );
                                const remarkInput = document.querySelector(
                                    `input[name="attendances[${attendance.student_id}][remark]"]`
                                );

                                if (statusSelect) {
                                    statusSelect.value = attendance.status;
                                }
                                if (checkInInput && attendance.check_in_time) {
                                    const checkInTime = new Date(attendance.check_in_time);
                                    const hours = checkInTime.getHours().toString().padStart(2,
                                        '0');
                                    const minutes = checkInTime.getMinutes().toString()
                                        .padStart(2, '0');
                                    checkInInput.value = `${hours}:${minutes}`;
                                }
                                if (checkOutInput && attendance.check_out_time) {
                                    const checkOutTime = new Date(attendance.check_out_time);
                                    const hours = checkOutTime.getHours().toString().padStart(2,
                                        '0');
                                    const minutes = checkOutTime.getMinutes().toString()
                                        .padStart(2, '0');
                                    checkOutInput.value = `${hours}:${minutes}`;
                                }
                                if (remarkInput) {
                                    remarkInput.value = attendance.remark || '';
                                }
                            });

                            alert('Previous attendance loaded successfully');
                        }
                    }
                } catch (error) {
                    console.error('Error loading previous attendance:', error);
                }
            });
        });
    </script>
@endsection
