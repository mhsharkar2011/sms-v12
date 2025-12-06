@extends('layouts.app')

@section('title', 'Guardian Details')

@section('content')
    <div class="min-h-screen bg-gray-50 flex">
        <x-admin-sidebar active-route="admin.guardians.index" />

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="mb-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <!-- Guardian Avatar -->
                        <div class="relative">
                            <div class="w-16 h-16 rounded-full overflow-hidden border-4 border-white shadow-lg">
                                @if ($guardian->avatar_url)
                                    <img src="{{ $guardian->avatar_url }}" alt="{{ $guardian->full_name }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <div
                                        class="w-full h-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-xl">
                                        {{ substr($guardian->full_name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Guardian Details</h1>
                            <p class="mt-1 text-sm text-gray-600">Complete information for <span
                                    class="font-semibold">{{ $guardian->full_name }}</span></p>
                            <div class="flex items-center space-x-3 mt-2">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <i class="fas fa-id-card mr-1"></i>
                                    {{ $guardian->guardian_id ?? 'N/A' }}
                                </span>
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $guardian->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    <i class="fas fa-circle mr-1" style="font-size: 6px;"></i>
                                    {{ $guardian->is_active ? 'Active' : 'Inactive' }}
                                </span>
                                @if ($guardian->is_primary)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-star mr-1"></i>
                                        Primary Contact
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('admin.guardians.edit', $guardian) }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <i class="fas fa-edit mr-2"></i>
                            Edit Guardian
                        </a>
                        <a href="{{ route('admin.guardians.index') }}"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <i class="fas fa-arrow-left mr-2"></i>
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
                        <div class="px-6 py-5 border-b border-gray-200 flex items-center justify-between">
                            <h3 class="text-lg font-medium text-gray-900">
                                <i class="fas fa-user-circle mr-2 text-indigo-600"></i>
                                Personal Information
                            </h3>
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-gray-500">
                                    <i class="fas fa-user-tag mr-1"></i>
                                    {{ $guardian->relationship ?? 'Not specified' }}
                                </span>
                            </div>
                        </div>
                        <div class="px-6 py-5">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-4">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 flex items-center">
                                            <i class="fas fa-user mr-2 text-gray-400"></i>
                                            Full Name
                                        </p>
                                        <p class="mt-1 text-lg font-semibold text-gray-900">{{ $guardian->full_name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 flex items-center">
                                            <i class="fas fa-id-badge mr-2 text-gray-400"></i>
                                            Guardian ID
                                        </p>
                                        <p class="mt-1 text-lg font-semibold text-gray-900">{{ $guardian->guardian_id }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 flex items-center">
                                            <i class="fas fa-envelope mr-2 text-gray-400"></i>
                                            Email
                                        </p>
                                        <p class="mt-1 text-sm text-gray-900 flex items-center">
                                            {{ $guardian->email }}
                                            @if ($guardian->user && $guardian->user->email_verified_at)
                                                <span
                                                    class="ml-2 inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <i class="fas fa-check-circle mr-1"></i>
                                                    Verified
                                                </span>
                                            @endif
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 flex items-center">
                                            <i class="fas fa-phone mr-2 text-gray-400"></i>
                                            Phone
                                        </p>
                                        <p class="mt-1 text-sm text-gray-900">
                                            {{ $guardian->phone ?? 'Not provided' }}
                                            @if ($guardian->phone)
                                                <a href="tel:{{ $guardian->phone }}"
                                                    class="ml-2 text-indigo-600 hover:text-indigo-900"
                                                    title="Call {{ $guardian->phone }}">
                                                    <i class="fas fa-phone-alt"></i>
                                                </a>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 flex items-center">
                                            <i class="fas fa-venus-mars mr-2 text-gray-400"></i>
                                            Relationship
                                        </p>
                                        <p class="mt-1 text-sm text-gray-900">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                {{ $guardian->relationship ?? 'Not specified' }}
                                            </span>
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 flex items-center">
                                            <i class="fas fa-calendar-alt mr-2 text-gray-400"></i>
                                            Created
                                        </p>
                                        <p class="mt-1 text-sm text-gray-900">
                                            {{ $guardian->created_at->format('M d, Y') }}
                                            <span
                                                class="text-gray-500">({{ $guardian->created_at->diffForHumans() }})</span>
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 flex items-center">
                                            <i class="fas fa-sync-alt mr-2 text-gray-400"></i>
                                            Last Updated
                                        </p>
                                        <p class="mt-1 text-sm text-gray-900">
                                            {{ $guardian->updated_at->format('M d, Y') }}
                                            <span
                                                class="text-gray-500">({{ $guardian->updated_at->diffForHumans() }})</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Employment Information Card -->
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-6 py-5 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">
                                <i class="fas fa-briefcase mr-2 text-blue-600"></i>
                                Employment Information
                            </h3>
                        </div>
                        <div class="px-6 py-5">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-4">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Occupation</p>
                                        <p class="mt-1 text-sm text-gray-900">
                                            {{ $guardian->occupation ?? 'Not specified' }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Employer</p>
                                        <p class="mt-1 text-sm text-gray-900">
                                            {{ $guardian->employer ?? 'Not specified' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Work Phone</p>
                                        <p class="mt-1 text-sm text-gray-900">
                                            {{ $guardian->work_phone ?? 'Not specified' }}
                                            @if ($guardian->work_phone)
                                                <a href="tel:{{ $guardian->work_phone }}"
                                                    class="ml-2 text-blue-600 hover:text-blue-900"
                                                    title="Call {{ $guardian->work_phone }}">
                                                    <i class="fas fa-phone-alt"></i>
                                                </a>
                                            @endif
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Work Email</p>
                                        <p class="mt-1 text-sm text-gray-900">
                                            {{ $guardian->work_email ?? 'Not specified' }}
                                            @if ($guardian->work_email)
                                                <a href="mailto:{{ $guardian->work_email }}"
                                                    class="ml-2 text-blue-600 hover:text-blue-900"
                                                    title="Email {{ $guardian->work_email }}">
                                                    <i class="fas fa-envelope"></i>
                                                </a>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Emergency Contact Card -->
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-6 py-5 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">
                                <i class="fas fa-first-aid mr-2 text-red-600"></i>
                                Emergency Contact Information
                            </h3>
                        </div>
                        <div class="px-6 py-5">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-4">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Contact Name</p>
                                        <p class="mt-1 text-sm text-gray-900">
                                            {{ $guardian->emergency_contact_name ?? 'Not specified' }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Contact Phone</p>
                                        <p class="mt-1 text-sm text-gray-900">
                                            {{ $guardian->emergency_contact_phone ?? 'Not specified' }}
                                            @if ($guardian->emergency_contact_phone)
                                                <a href="tel:{{ $guardian->emergency_contact_phone }}"
                                                    class="ml-2 text-red-600 hover:text-red-900"
                                                    title="Call {{ $guardian->emergency_contact_phone }}">
                                                    <i class="fas fa-phone-alt"></i>
                                                </a>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Relationship</p>
                                        <p class="mt-1 text-sm text-gray-900">
                                            {{ $guardian->emergency_contact_relationship ?? 'Not specified' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Associated Students Card -->
                    @if ($guardian->students && $guardian->students->count() > 0)
                        <div class="bg-white shadow rounded-lg">
                            <div class="px-6 py-5 border-b border-gray-200 flex items-center justify-between">
                                <h3 class="text-lg font-medium text-gray-900">
                                    <i class="fas fa-user-graduate mr-2 text-purple-600"></i>
                                    Associated Students
                                    <span
                                        class="ml-2 inline-flex items-center justify-center w-6 h-6 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                        {{ $guardian->students->count() }}
                                    </span>
                                </h3>
                                <button type="button"
                                    onclick="window.location.href='{{ route('admin.students.index') }}'"
                                    class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <i class="fas fa-eye mr-1"></i>
                                    View All Students
                                </button>
                            </div>
                            <div class="px-6 py-5">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach ($guardian->students as $student)
                                        <div
                                            class="bg-gradient-to-r from-gray-50 to-white rounded-lg border border-gray-200 p-4 hover:shadow-md transition-shadow duration-200">
                                            <div class="flex items-start justify-between">
                                                <div class="flex items-center space-x-3">
                                                    <div class="flex-shrink-0">
                                                        <div
                                                            class="h-10 w-10 rounded-full overflow-hidden border-2 border-white shadow-sm">
                                                            @if ($student->avatar_url)
                                                                <img src="{{ $student->avatar_url }}"
                                                                    alt="{{ $student->full_name }}"
                                                                    class="w-full h-full object-cover">
                                                            @else
                                                                <div
                                                                    class="w-full h-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold">
                                                                    {{ substr($student->full_name, 0, 1) }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <h4 class="font-medium text-gray-900">
                                                            <a href="{{ route('admin.students.show', $student) }}"
                                                                class="hover:text-indigo-600 hover:underline">
                                                                {{ $student->full_name }}
                                                            </a>
                                                        </h4>
                                                        <p class="text-xs text-gray-500 mt-1">
                                                            <i class="fas fa-id-card mr-1"></i>
                                                            {{ $student->student_id ?? 'No ID' }}
                                                            •
                                                            <i class="fas fa-graduation-cap ml-2 mr-1"></i>
                                                            {{ $student->grade_level ?? 'No grade' }}
                                                        </p>
                                                    </div>
                                                </div>
                                                @if ($guardian->pivot && $guardian->pivot->is_primary_contact)
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        <i class="fas fa-star mr-1"></i>
                                                        Primary
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="mt-4 pt-3 border-t border-gray-100">
                                                <div class="flex flex-wrap gap-2">
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                                        <i class="fas fa-users mr-1"></i>
                                                        {{ $guardian->pivot->relationship_type ?? 'Guardian' }}
                                                    </span>
                                                    @if ($guardian->pivot && $guardian->pivot->can_pickup)
                                                        <span
                                                            class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-50 text-green-700 border border-green-100">
                                                            <i class="fas fa-car mr-1"></i>
                                                            Can Pickup
                                                        </span>
                                                    @endif
                                                    @if ($guardian->pivot && $guardian->pivot->emergency_contact_priority)
                                                        <span
                                                            class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-red-50 text-red-700 border border-red-100">
                                                            <i class="fas fa-first-aid mr-1"></i>
                                                            Emergency #{{ $guardian->pivot->emergency_contact_priority }}
                                                        </span>
                                                    @endif
                                                </div>
                                                @if ($guardian->pivot && $guardian->pivot->special_instructions)
                                                    <p
                                                        class="mt-3 text-xs text-gray-600 bg-gray-50 p-2 rounded border border-gray-100">
                                                        <i class="fas fa-info-circle mr-1"></i>
                                                        {{ $guardian->pivot->special_instructions }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="bg-white shadow rounded-lg">
                            <div class="px-6 py-8 text-center">
                                <div class="mx-auto h-12 w-12 text-gray-400">
                                    <i class="fas fa-user-graduate text-3xl"></i>
                                </div>
                                <h3 class="mt-4 text-sm font-medium text-gray-900">No associated students</h3>
                                <p class="mt-1 text-sm text-gray-500">This guardian is not associated with any students
                                    yet.</p>
                                <div class="mt-6">
                                    <a href="{{ route('admin.guardians.edit', $guardian) }}"
                                        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <i class="fas fa-link mr-2"></i>
                                        Associate Students
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Column: Status & Permissions -->
                <div class="space-y-6">
                    <!-- Permissions Card -->
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-6 py-5 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">
                                <i class="fas fa-shield-alt mr-2 text-green-600"></i>
                                Permissions & Settings
                            </h3>
                        </div>
                        <div class="px-6 py-5 space-y-4">
                            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                <div class="flex items-center">
                                    <i class="fas fa-star mr-3 text-yellow-500"></i>
                                    <div>
                                        <span class="text-sm font-medium text-gray-900">Primary Contact</span>
                                        <p class="text-xs text-gray-500">Main point of contact</p>
                                    </div>
                                </div>
                                @if ($guardian->is_primary)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-check mr-1"></i>
                                        Yes
                                    </span>
                                @else
                                    <span class="text-sm text-gray-500">No</span>
                                @endif
                            </div>

                            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                <div class="flex items-center">
                                    <i class="fas fa-car mr-3 text-blue-500"></i>
                                    <div>
                                        <span class="text-sm font-medium text-gray-900">Can Pickup</span>
                                        <p class="text-xs text-gray-500">Authorized for student pickup</p>
                                    </div>
                                </div>
                                @if ($guardian->can_pickup)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check mr-1"></i>
                                        Authorized
                                    </span>
                                @else
                                    <span class="text-sm text-gray-500">Not authorized</span>
                                @endif
                            </div>

                            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                <div class="flex items-center">
                                    <i class="fas fa-sms mr-3 text-purple-500"></i>
                                    <div>
                                        <span class="text-sm font-medium text-gray-900">SMS Alerts</span>
                                        <p class="text-xs text-gray-500">Receive text notifications</p>
                                    </div>
                                </div>
                                @if ($guardian->receive_sms_alerts)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-bell mr-1"></i>
                                        Enabled
                                    </span>
                                @else
                                    <span class="text-sm text-gray-500">Disabled</span>
                                @endif
                            </div>

                            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                <div class="flex items-center">
                                    <i class="fas fa-envelope mr-3 text-indigo-500"></i>
                                    <div>
                                        <span class="text-sm font-medium text-gray-900">Email Alerts</span>
                                        <p class="text-xs text-gray-500">Receive email notifications</p>
                                    </div>
                                </div>
                                @if ($guardian->receive_email_alerts)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-envelope-open mr-1"></i>
                                        Enabled
                                    </span>
                                @else
                                    <span class="text-sm text-gray-500">Disabled</span>
                                @endif
                            </div>

                            <div class="flex items-center justify-between py-2">
                                <div class="flex items-center">
                                    <i class="fas fa-user-shield mr-3 text-red-500"></i>
                                    <div>
                                        <span class="text-sm font-medium text-gray-900">Account Status</span>
                                        <p class="text-xs text-gray-500">Guardian account access</p>
                                    </div>
                                </div>
                                @if ($guardian->is_active)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Active
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle mr-1"></i>
                                        Inactive
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Medical Notes Card -->
                    @if ($guardian->medical_notes)
                        <div class="bg-white shadow rounded-lg">
                            <div class="px-6 py-5 border-b border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900">
                                    <i class="fas fa-heartbeat mr-2 text-red-600"></i>
                                    Medical Notes
                                </h3>
                            </div>
                            <div class="px-6 py-5">
                                <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-exclamation-triangle text-red-400"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-red-700 whitespace-pre-line">
                                                {{ $guardian->medical_notes }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Additional Notes Card -->
                    @if ($guardian->notes)
                        <div class="bg-white shadow rounded-lg">
                            <div class="px-6 py-5 border-b border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900">
                                    <i class="fas fa-sticky-note mr-2 text-yellow-600"></i>
                                    Additional Notes
                                </h3>
                            </div>
                            <div class="px-6 py-5">
                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                    <p class="text-sm text-yellow-800 whitespace-pre-line">{{ $guardian->notes }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Quick Actions Card -->
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-6 py-5 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">
                                <i class="fas fa-bolt mr-2 text-indigo-600"></i>
                                Quick Actions
                            </h3>
                        </div>
                        <div class="px-6 py-5 space-y-3">
                            <a href="mailto:{{ $guardian->email }}"
                                class="w-full flex items-center justify-between px-4 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                <div class="flex items-center">
                                    <i class="fas fa-envelope text-indigo-600 mr-3"></i>
                                    <span class="text-sm font-medium text-gray-900">Send Email</span>
                                </div>
                                <i class="fas fa-chevron-right text-gray-400"></i>
                            </a>
                            @if ($guardian->phone)
                                <a href="tel:{{ $guardian->phone }}"
                                    class="w-full flex items-center justify-between px-4 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                    <div class="flex items-center">
                                        <i class="fas fa-phone text-green-600 mr-3"></i>
                                        <span class="text-sm font-medium text-gray-900">Make Call</span>
                                    </div>
                                    <i class="fas fa-chevron-right text-gray-400"></i>
                                </a>
                            @endif
                            <a href="{{ route('admin.guardians.edit', $guardian) }}"
                                class="w-full flex items-center justify-between px-4 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                <div class="flex items-center">
                                    <i class="fas fa-edit text-blue-600 mr-3"></i>
                                    <span class="text-sm font-medium text-gray-900">Edit Profile</span>
                                </div>
                                <i class="fas fa-chevron-right text-gray-400"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
@endpush
