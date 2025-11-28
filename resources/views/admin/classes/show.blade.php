@extends('layouts.app')

@section('title', $class->name . ' - Class Details')

@section('content')
<div class="min-h-screen bg-gray-50 flex">
    <x-admin-sidebar />

    <div class="flex-1 overflow-auto">
        <div class="container mx-auto p-6">
            <!-- Header -->
            <div class="mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                                <span class="material-icons-sharp text-white">class</span>
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900">{{ $class->name }}</h1>
                                <div class="flex items-center space-x-4 mt-2">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $class->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ ucfirst($class->status) }}
                                    </span>
                                    <span class="text-gray-600">•</span>
                                    <span class="text-gray-600">Academic Year: {{ $class->academic_year }}</span>
                                    <span class="text-gray-600">•</span>
                                    <span class="text-gray-600">Section: {{ $class->section }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('admin.classes.edit', $class->id) }}"
                           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2">
                            <span class="material-icons-sharp text-sm">edit</span>
                            <span>Edit Class</span>
                        </a>
                        <a href="{{ route('admin.classes.index') }}"
                           class="border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors flex items-center space-x-2">
                            <span class="material-icons-sharp text-sm">arrow_back</span>
                            <span>Back to Classes</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Total Students</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $class->current_strength }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <span class="material-icons-sharp text-blue-600">people</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Class Capacity</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $class->capacity }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <span class="material-icons-sharp text-green-600">event_seat</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Available Seats</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $class->capacity - $class->current_strength }}</p>
                        </div>
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                            <span class="material-icons-sharp text-orange-600">chair</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Occupancy Rate</p>
                            <p class="text-2xl font-bold text-gray-900">
                                {{ number_format(($class->current_strength / $class->capacity) * 100, 1) }}%
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <span class="material-icons-sharp text-purple-600">trending_up</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column - Class Information -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Class Details Card -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Class Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Class Code</label>
                                    <p class="text-gray-900 font-semibold">{{ $class->code }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Grade Level</label>
                                    <p class="text-gray-900 font-semibold">{{ $class->grade_level }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Section</label>
                                    <p class="text-gray-900 font-semibold">{{ $class->section }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Room Number</label>
                                    <p class="text-gray-900 font-semibold">{{ $class->room_number ?? 'Not assigned' }}</p>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Class Teacher</label>
                                    <p class="text-gray-900 font-semibold">
                                        {{ $class->classTeacher ? $class->classTeacher->name : 'Not assigned' }}
                                    </p>
                                    @if($class->classTeacher)
                                    <p class="text-sm text-gray-600">{{ $class->classTeacher->email ?? '' }}</p>
                                    @endif
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Academic Year</label>
                                    <p class="text-gray-900 font-semibold">{{ $class->academic_year }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Status</label>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $class->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ ucfirst($class->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        @if($class->description)
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <label class="text-sm font-medium text-gray-600">Description</label>
                            <p class="text-gray-700 mt-1">{{ $class->description }}</p>
                        </div>
                        @endif
                    </div>

                    <!-- Recent Students Card -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-xl font-bold text-gray-900">Students ({{ $class->students->count() }})</h3>
                            <button class="bg-blue-600 text-white px-3 py-2 rounded-lg text-sm hover:bg-blue-700 transition-colors flex items-center space-x-2">
                                <span class="material-icons-sharp text-sm">person_add</span>
                                <span>Add Student</span>
                            </button>
                        </div>

                        @if($class->students->count() > 0)
                        <div class="overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Roll No.</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($class->students as $student)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold text-sm mr-3">
                                                    {{ substr($student->first_name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $student->first_name }} {{ $student->last_name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">{{ $student->student_id }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $student->roll_number }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $student->email }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                {{ ucfirst($student->status) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm">
                                            <button class="text-blue-600 hover:text-blue-900 mr-3">View</button>
                                            <button class="text-red-600 hover:text-red-900">Remove</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="text-center py-8">
                            <div class="text-gray-400 mb-4">
                                <span class="material-icons-sharp text-6xl">person_outline</span>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No Students</h3>
                            <p class="text-gray-600 mb-4">No students are currently enrolled in this class.</p>
                            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                Add Students
                            </button>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Right Column - Actions & Management -->
                <div class="space-y-6">
                    <!-- Class Actions Card -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Class Actions</h3>
                        <div class="space-y-3">
                            <button class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center space-x-2">
                                <span class="material-icons-sharp text-sm">group_add</span>
                                <span>Manage Students</span>
                            </button>
                            <button class="w-full border border-blue-600 text-blue-600 py-3 rounded-lg hover:bg-blue-50 transition-colors flex items-center justify-center space-x-2">
                                <span class="material-icons-sharp text-sm">assignment</span>
                                <span>View Attendance</span>
                            </button>
                            <button class="w-full border border-green-600 text-green-600 py-3 rounded-lg hover:bg-green-50 transition-colors flex items-center justify-center space-x-2">
                                <span class="material-icons-sharp text-sm">grading</span>
                                <span>Grade Reports</span>
                            </button>
                            <button class="w-full border border-purple-600 text-purple-600 py-3 rounded-lg hover:bg-purple-50 transition-colors flex items-center justify-center space-x-2">
                                <span class="material-icons-sharp text-sm">schedule</span>
                                <span>Class Schedule</span>
                            </button>
                        </div>
                    </div>

                    <!-- Quick Stats Card -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Quick Stats</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Male Students</span>
                                <span class="font-semibold text-gray-900">
                                    {{ $class->students->where('gender', 'male')->count() }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Female Students</span>
                                <span class="font-semibold text-gray-900">
                                    {{ $class->students->where('gender', 'female')->count() }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Boarders</span>
                                <span class="font-semibold text-gray-900">
                                    {{ $class->students->where('is_boarder', true)->count() }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Transport Users</span>
                                <span class="font-semibold text-gray-900">
                                    {{ $class->students->where('uses_transport', true)->count() }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Danger Zone Card -->
                    <div class="bg-red-50 rounded-xl shadow-sm p-6 border border-red-200">
                        <h3 class="text-xl font-bold text-red-900 mb-4">Danger Zone</h3>
                        <p class="text-red-700 mb-4 text-sm">
                            Once you delete a class, there is no going back. Please be certain.
                        </p>
                        <form action="{{ route('admin.classes.destroy', $class->id) }}" method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this class? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="w-full bg-red-600 text-white py-3 rounded-lg hover:bg-red-700 transition-colors flex items-center justify-center space-x-2">
                                <span class="material-icons-sharp text-sm">delete</span>
                                <span>Delete Class</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add any interactive functionality here
        console.log('Class detail page loaded');
    });
</script>
@endpush
