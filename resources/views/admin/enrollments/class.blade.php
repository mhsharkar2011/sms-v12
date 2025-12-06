@extends('layouts.app')

@section('title', 'Enrollments for ' . $class->name)

@section('content')
    <div class="min-h-screen bg-gray-50 flex">
        <x-admin-sidebar />

        <div class="flex-1 overflow-auto">
            <div class="container mx-auto p-6">
                <!-- Header -->
                <div class="mb-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Class Enrollments</h1>
                            <p class="text-gray-600 mt-2">{{ $class->name }} ({{ $class->code }})</p>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('admin.enrollments.create', ['class_id' => $class->id]) }}"
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2">
                                <span class="material-icons-sharp text-sm">person_add</span>
                                <span>Enroll New Student</span>
                            </a>
                            <a href="{{ route('admin.classes.show', $class) }}"
                                class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors flex items-center space-x-2">
                                <span class="material-icons-sharp text-sm">arrow_back</span>
                                <span>Back to Class</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Class Stats -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-white rounded-xl shadow-sm p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Total Capacity</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $class->capacity }}</p>
                            </div>
                            <span class="material-icons-sharp text-blue-600">people</span>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Enrolled Students</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $class->students_count }}</p>
                            </div>
                            <span class="material-icons-sharp text-green-600">school</span>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Available Seats</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $class->available_seats }}</p>
                            </div>
                            <span class="material-icons-sharp text-purple-600">event_seat</span>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Class Status</p>
                                <p class="text-lg font-medium text-gray-900">{{ ucfirst($class->status) }}</p>
                            </div>
                            <span
                                class="material-icons-sharp {{ $class->status == 'active' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $class->status == 'active' ? 'check_circle' : 'cancel' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Enrollments Table -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Student
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Enrollment Date
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Attendance
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Grade
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($enrollments as $enrollment)
                                    <tr class="hover:bg-gray-50">
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
                                                        {{ $enrollment->student->user->name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        {{ $enrollment->student->student_id }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {!! $enrollment->status_badge !!}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $enrollment->enrollment_date->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $enrollment->classes_attended }}/{{ $enrollment->total_classes }}
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-2">
                                                <div class="bg-green-600 h-2 rounded-full"
                                                    style="width: {{ $enrollment->attendance_percentage }}%"></div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if ($enrollment->final_grade)
                                                <span class="font-medium">{{ $enrollment->final_grade }}%</span>
                                                <span class="text-gray-500">({{ $enrollment->grade_letter }})</span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('admin.enrollments.show', $enrollment) }}"
                                                class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                            <a href="{{ route('admin.enrollments.edit', $enrollment) }}"
                                                class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                            No students enrolled in this class yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if ($enrollments->hasPages())
                        <div class="px-6 py-4 border-t border-gray-200">
                            {{ $enrollments->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <style>
        .material-icons-sharp {
            font-size: inherit;
        }
    </style>
@endpush
