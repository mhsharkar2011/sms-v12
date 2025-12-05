@extends('layouts.app')

@section('title', 'Guardian Details')


@section('content')
    <div class="min-h-screen bg-gray-50 flex">
        <x-admin-sidebar active-route="admin.guardians.index" />

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Guardian Details</h1>
                        <p class="mt-1 text-sm text-gray-600">Complete information for {{ $guardian->full_name }}</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('guardians.edit', $guardian) }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit
                        </a>
                        <a href="{{ route('guardians.index') }}"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Back to List
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column: Personal Info -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Personal Information Card -->
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-6 py-5 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Personal Information</h3>
                        </div>
                        <div class="px-6 py-5">
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="h-16 w-16 rounded-full bg-indigo-100 flex items-center justify-center">
                                        <span class="text-indigo-800 text-2xl font-bold">
                                            {{ substr($guardian->full_name, 0, 1) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-sm font-medium text-gray-500">Full Name</p>
                                            <p class="mt-1 text-sm text-gray-900">{{ $guardian->full_name }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-500">Guardian ID</p>
                                            <p class="mt-1 text-sm text-gray-900">{{ $guardian->guardian_id }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-500">Email</p>
                                            <p class="mt-1 text-sm text-gray-900">{{ $guardian->email }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-500">Phone</p>
                                            <p class="mt-1 text-sm text-gray-900">{{ $guardian->phone ?? 'N/A' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-500">Relationship</p>
                                            <p class="mt-1 text-sm text-gray-900">{{ $guardian->relationship ?? 'N/A' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-500">Status</p>
                                            <p class="mt-1">
                                                @if ($guardian->is_active)
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        Active
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        Inactive
                                                    </span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Employment Information Card -->
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-6 py-5 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Employment Information</h3>
                        </div>
                        <div class="px-6 py-5">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Occupation</p>
                                    <p class="mt-1 text-sm text-gray-900">{{ $guardian->occupation ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Employer</p>
                                    <p class="mt-1 text-sm text-gray-900">{{ $guardian->employer ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Work Phone</p>
                                    <p class="mt-1 text-sm text-gray-900">{{ $guardian->work_phone ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Work Email</p>
                                    <p class="mt-1 text-sm text-gray-900">{{ $guardian->work_email ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Emergency Contact Card -->
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-6 py-5 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Emergency Contact</h3>
                        </div>
                        <div class="px-6 py-5">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Contact Name</p>
                                    <p class="mt-1 text-sm text-gray-900">{{ $guardian->emergency_contact_name ?? 'N/A' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Contact Phone</p>
                                    <p class="mt-1 text-sm text-gray-900">{{ $guardian->emergency_contact_phone ?? 'N/A' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Relationship</p>
                                    <p class="mt-1 text-sm text-gray-900">
                                        {{ $guardian->emergency_contact_relationship ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Associated Students Card -->
                    @if ($guardian->students->count() > 0)
                        <div class="bg-white shadow rounded-lg">
                            <div class="px-6 py-5 border-b border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900">Associated Students
                                    ({{ $guardian->students_count }})</h3>
                            </div>
                            <div class="px-6 py-5">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach ($guardian->students as $student)
                                        <div class="bg-gray-50 rounded-lg p-4">
                                            <div class="flex items-center justify-between mb-2">
                                                <h4 class="font-medium text-gray-900">{{ $student->full_name }}</h4>
                                                <span
                                                    class="text-xs px-2 py-1 rounded-full {{ $guardian->pivot->is_primary_contact ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                    {{ $guardian->pivot->is_primary_contact ? 'Primary' : 'Secondary' }}
                                                </span>
                                            </div>
                                            <div class="text-sm text-gray-600 space-y-1">
                                                <p>Relationship: {{ $guardian->pivot->relationship_type ?? 'N/A' }}</p>
                                                <p>Can Pickup: {{ $guardian->pivot->can_pickup ? 'Yes' : 'No' }}</p>
                                                @if ($guardian->pivot->emergency_contact_priority)
                                                    <p class="text-red-600 font-medium">Emergency Contact (Priority:
                                                        {{ $guardian->pivot->emergency_contact_priority }})</p>
                                                @endif
                                                @if ($guardian->pivot->special_instructions)
                                                    <p class="mt-2 text-xs">Instructions:
                                                        {{ $guardian->pivot->special_instructions }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Column: Status & Permissions -->
                <div class="space-y-6">
                    <!-- Status & Permissions Card -->
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-6 py-5 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Status & Permissions</h3>
                        </div>
                        <div class="px-6 py-5 space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-900">Primary Contact</span>
                                @if ($guardian->is_primary)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Yes
                                    </span>
                                @else
                                    <span class="text-sm text-gray-500">No</span>
                                @endif
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-900">Can Pickup</span>
                                @if ($guardian->can_pickup)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Yes
                                    </span>
                                @else
                                    <span class="text-sm text-gray-500">No</span>
                                @endif
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-900">SMS Alerts</span>
                                @if ($guardian->receive_sms_alerts)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Enabled
                                    </span>
                                @else
                                    <span class="text-sm text-gray-500">Disabled</span>
                                @endif
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-900">Email Alerts</span>
                                @if ($guardian->receive_email_alerts)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Enabled
                                    </span>
                                @else
                                    <span class="text-sm text-gray-500">Disabled</span>
                                @endif
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-900">Emergency Contact</span>
                                @if ($guardian->isEmergencyContact())
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Yes
                                    </span>
                                @else
                                    <span class="text-sm text-gray-500">No</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Medical Notes Card -->
                    @if ($guardian->medical_notes)
                        <div class="bg-white shadow rounded-lg">
                            <div class="px-6 py-5 border-b border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900">Medical Notes</h3>
                            </div>
                            <div class="px-6 py-5">
                                <p class="text-sm text-gray-900 whitespace-pre-line">{{ $guardian->medical_notes }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Additional Notes Card -->
                    @if ($guardian->notes)
                        <div class="bg-white shadow rounded-lg">
                            <div class="px-6 py-5 border-b border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900">Additional Notes</h3>
                            </div>
                            <div class="px-6 py-5">
                                <p class="text-sm text-gray-900 whitespace-pre-line">{{ $guardian->notes }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- System Information Card -->
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-6 py-5 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">System Information</h3>
                        </div>
                        <div class="px-6 py-5 space-y-3">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Created At</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $guardian->created_at->format('M d, Y h:i A') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Last Updated</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $guardian->updated_at->format('M d, Y h:i A') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
