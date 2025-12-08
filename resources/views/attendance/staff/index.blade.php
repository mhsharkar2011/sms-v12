@extends('layouts.app')

@section('title', 'Staff Attendance')

@section('content')
    <div class="min-h-screen bg-gray-50 flex">
        <x-admin-sidebar />

        <div class="flex-1 overflow-auto">
            <div class="container mx-auto p-6">
                <div class="mb-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Staff Attendance</h1>
                            <p class="text-gray-600 mt-2">View and manage staff attendance records</p>
                        </div>
                        <a href="{{ route('staff-attendance.create') }}"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2">
                            <span class="material-icons-sharp">add</span>
                            <span>Mark Attendance</span>
                        </a>
                    </div>
                </div>

                <!-- Filters -->
                <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
                    <form action="{{ route('staff-attendance.index') }}" method="GET"
                        class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                            <input type="date" name="date" value="{{ request('date') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Staff Type</label>
                            <select name="staff_type" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                <option value="">All Staff</option>
                                <option value="teacher" {{ request('staff_type') == 'teacher' ? 'selected' : '' }}>Teachers
                                </option>
                                <option value="admin" {{ request('staff_type') == 'admin' ? 'selected' : '' }}>
                                    Administrative</option>
                                <option value="support" {{ request('staff_type') == 'support' ? 'selected' : '' }}>Support
                                </option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                <option value="">All Status</option>
                                <option value="present" {{ request('status') == 'present' ? 'selected' : '' }}>Present
                                </option>
                                <option value="absent" {{ request('status') == 'absent' ? 'selected' : '' }}>Absent</option>
                                <option value="late" {{ request('status') == 'late' ? 'selected' : '' }}>Late</option>
                                <option value="half_day" {{ request('status') == 'half_day' ? 'selected' : '' }}>Half Day
                                </option>
                                <option value="leave" {{ request('status') == 'leave' ? 'selected' : '' }}>Leave</option>
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="submit"
                                class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                Filter
                            </button>
                            <a href="{{ route('staff-attendance.index') }}"
                                class="ml-2 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Attendance Table -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Staff Member
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Staff ID
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Working Hours
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Check In/Out
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($attendances as $attendance)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div
                                                        class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                        <span class="material-icons-sharp text-blue-600">person</span>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $attendance->staff->user->name ?? 'N/A' }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        {{ $attendance->staff->staff_type ?? '' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $attendance->staff->staff_id ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $attendance->attendance_date->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $statusColors = [
                                                    'present' => 'bg-green-100 text-green-800',
                                                    'absent' => 'bg-red-100 text-red-800',
                                                    'late' => 'bg-yellow-100 text-yellow-800',
                                                    'half_day' => 'bg-orange-100 text-orange-800',
                                                    'leave' => 'bg-blue-100 text-blue-800',
                                                ];
                                            @endphp
                                            <span
                                                class="px-3 py-1 text-xs font-semibold rounded-full {{ $statusColors[$attendance->status] }}">
                                                {{ ucfirst(str_replace('_', ' ', $attendance->status)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $attendance->working_hours ? number_format($attendance->working_hours, 1) . ' hrs' : 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @if ($attendance->check_in_time)
                                                {{ \Carbon\Carbon::parse($attendance->check_in_time)->format('h:i A') }}
                                                @if ($attendance->check_out_time)
                                                    <br>→
                                                    {{ \Carbon\Carbon::parse($attendance->check_out_time)->format('h:i A') }}
                                                @endif
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('staff-attendance.edit', $attendance) }}"
                                                class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                                            <form action="{{ route('staff-attendance.destroy', $attendance) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900"
                                                    onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                            No attendance records found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $attendances->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
