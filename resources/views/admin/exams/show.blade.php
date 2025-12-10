@extends('layouts.app')

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $exam->name }}</h1>
                    <div class="flex items-center mt-2 space-x-4">
                        @php
                            $statusColors = [
                                'scheduled' => 'bg-blue-100 text-blue-800',
                                'ongoing' => 'bg-yellow-100 text-yellow-800',
                                'completed' => 'bg-green-100 text-green-800',
                                'cancelled' => 'bg-red-100 text-red-800',
                            ];
                            $color = $statusColors[$exam->status] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $color }}">
                            {{ ucfirst($exam->status) }}
                        </span>
                        @if ($exam->is_published)
                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                Published
                            </span>
                            <span class="text-sm text-gray-500">
                                Published on: {{ $exam->published_at->format('M d, Y h:i A') }}
                            </span>
                        @else
                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-gray-100 text-gray-800">
                                Draft
                            </span>
                        @endif
                    </div>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.exams.edit', $exam) }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                        Edit
                    </a>
                    @if (!$exam->is_published)
                        <form action="{{ route('admin.exams.publish', $exam) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                Publish
                            </button>
                        </form>
                    @endif
                    <a href="{{ route('admin.exams.index') }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Back to List
                    </a>
                </div>
            </div>

            <!-- Main Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Exam Details Card -->
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Exam Details</h3>
                        </div>
                        <div class="p-6">
                            <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Exam Type</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($exam->type) }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Academic Year</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $exam->academic_year }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Term</dt>
                                    <dd class="mt-1 text-sm text-gray-900">Term {{ $exam->term }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Total Marks</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $exam->total_marks }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Passing Percentage</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $exam->passing_percentage }}%</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Passing Marks</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ number_format(($exam->total_marks * $exam->passing_percentage) / 100, 2) }}</dd>
                                </div>
                            </dl>

                            @if ($exam->description)
                                <div class="mt-6">
                                    <dt class="text-sm font-medium text-gray-500">Description</dt>
                                    <dd class="mt-1 text-sm text-gray-900 whitespace-pre-line">{{ $exam->description }}
                                    </dd>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Class & Subject Card -->
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Class & Subject Information</h3>
                        </div>
                        <div class="p-6">
                            <dl class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Class</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $exam->schoolClass->name ?? 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Section</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $exam->section->name ?? 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Subject</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $exam->subject->name ?? 'N/A' }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Schedule Card -->
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Schedule</h3>
                        </div>
                        <div class="p-6">
                            <dl class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Exam Date</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $exam->exam_date->format('F d, Y') }}</dd>
                                    <dd class="text-sm text-gray-500">{{ $exam->exam_date->format('l') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Start Time</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $exam->start_time->format('h:i A') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">End Time</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $exam->end_time->format('h:i A') }}</dd>
                                </div>
                            </dl>
                            <div class="mt-4">
                                <dt class="text-sm font-medium text-gray-500">Duration</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    @php
                                        $duration = $exam->start_time->diff($exam->end_time);
                                        $hours = $duration->h;
                                        $minutes = $duration->i;
                                        $durationString = '';
                                        if ($hours > 0) {
                                            $durationString .= $hours . ' hour' . ($hours > 1 ? 's' : '');
                                        }
                                        if ($minutes > 0) {
                                            if ($hours > 0) {
                                                $durationString .= ' ';
                                            }
                                            $durationString .= $minutes . ' minute' . ($minutes > 1 ? 's' : '');
                                        }
                                    @endphp
                                    {{ $durationString }}
                                </dd>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- Actions Card -->
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <a href="{{ route('admin.exam-results.create', ['exam' => $exam->id]) }}"
                                class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Add Results
                            </a>
                            <a href="{{ route('admin.exam-results.index', ['exam' => $exam->id]) }}"
                                class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                    </path>
                                </svg>
                                View Results
                            </a>
                            @if ($exam->status == 'scheduled')
                                <form action="{{ route('admin.exams.update-status', $exam) }}" method="POST" class="w-full">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="ongoing">
                                    <button type="submit"
                                        class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Mark as Ongoing
                                    </button>
                                </form>
                            @endif
                            @if ($exam->status == 'ongoing')
                                <form action="{{ route('admin.exams.update-status', $exam) }}" method="POST" class="w-full">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="completed">
                                    <button type="submit"
                                        class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Mark as Completed
                                    </button>
                                </form>
                            @endif
                            @if (in_array($exam->status, ['scheduled', 'ongoing']))
                                <form action="{{ route('admin.exams.update-status', $exam) }}" method="POST" class="w-full">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="cancelled">
                                    <button type="submit"
                                        onclick="return confirm('Are you sure you want to cancel this exam?')"
                                        class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Cancel Exam
                                    </button>
                                </form>
                            @endif
                            <form action="{{ route('admin.exams.destroy', $exam) }}" method="POST" class="w-full">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Are you sure you want to delete this exam? This action cannot be undone.')"
                                    class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                    Delete Exam
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Results Summary Card -->
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Results Summary</h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-600">Total Students:</span>
                                    <span class="text-sm text-gray-900">{{ $exam->results->count() }}</span>
                                </div>
                                @if ($exam->results->count() > 0)
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm font-medium text-gray-600">Average Score:</span>
                                        <span class="text-sm text-gray-900">
                                            {{ number_format($exam->results->avg('marks_obtained'), 2) }}/{{ $exam->total_marks }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm font-medium text-gray-600">Passed:</span>
                                        <span class="text-sm text-green-600 font-medium">
                                            {{ $exam->results->where('marks_obtained', '>=', ($exam->total_marks * $exam->passing_percentage) / 100)->count() }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm font-medium text-gray-600">Failed:</span>
                                        <span class="text-sm text-red-600 font-medium">
                                            {{ $exam->results->where('marks_obtained', '<', ($exam->total_marks * $exam->passing_percentage) / 100)->count() }}
                                        </span>
                                    </div>
                                    <div class="pt-4 border-t border-gray-200">
                                        <a href="{{ route('admin.exam-results.index', ['exam_id' => $exam->id]) }}"
                                            class="text-sm text-indigo-600 hover:text-indigo-900 font-medium">
                                            View All Results →
                                        </a>
                                    </div>
                                @else
                                    <div class="text-center py-4">
                                        <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <p class="mt-2 text-sm text-gray-500">No results added yet</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Meta Information -->
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Meta Information</h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Created</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $exam->created_at->format('M d, Y h:i A') }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $exam->updated_at->format('M d, Y h:i A') }}
                                    </dd>
                                </div>
                                @if ($exam->deleted_at)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Deleted</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ $exam->deleted_at->format('M d, Y h:i A') }}
                                        </dd>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
