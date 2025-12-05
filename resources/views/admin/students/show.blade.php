@extends('layouts.app')

@section('title', $student->first_name . ' ' . $student->last_name . ' - Student Details')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50/30 flex">
        <x-admin-sidebar active-route="admin.students.index" />

        <div class="flex-1 overflow-auto">
            <!-- Header -->
            <div class="bg-white/80 backdrop-blur-sm shadow-sm border-b border-gray-200/60">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div>
                                <nav class="flex space-x-2 text-sm text-gray-500 mb-2">
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="hover:text-blue-600 transition-colors">Dashboard</a>
                                    <span class="text-gray-300">/</span>
                                    <a href="{{ route('admin.students.index') }}"
                                        class="hover:text-blue-600 transition-colors">Students</a>
                                    <span class="text-gray-300">/</span>
                                    <span class="text-gray-900 font-medium">Details</span>
                                </nav>
                                <h1 class="text-2xl font-bold text-gray-900">Student Profile</h1>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('admin.students.index') }}"
                                class="px-4 py-2.5 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 transition-all duration-200 flex items-center space-x-2 shadow-sm hover:shadow">
                                <i class="fas fa-arrow-left text-sm"></i>
                                <span>Back to List</span>
                            </a>
                            <a href="{{ route('admin.students.edit', $student) }}"
                                class="px-4 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 flex items-center space-x-2 shadow-lg hover:shadow-xl">
                                <i class="fas fa-edit text-sm"></i>
                                <span>Edit Profile</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container mx-auto p-6">
                <div class="max-w-6xl mx-auto">
                    <!-- Profile Header Card -->
                    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 mb-6">
                        <div class="relative">
                            <!-- Background Pattern -->
                            <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-purple-500/5"></div>

                            <div class="relative px-8 py-8">
                                <div
                                    class="flex flex-col lg:flex-row items-start lg:items-center space-y-6 lg:space-y-0 lg:space-x-8">
                                    <!-- Avatar Section -->
                                    <div class="flex-shrink-0">
                                        <div class="relative">
                                            <div
                                                class="w-32 h-32 rounded-2xl bg-gradient-to-br from-blue-100 to-purple-100 p-1.5 shadow-lg">
                                                <img class="w-full h-full rounded-2xl object-cover border-4 border-white"
                                                    src="{{ $student->avatar_url ? asset('storage/' . $student->avatar_url) : asset('images/default-avatar.png') }}"
                                                    alt="{{ $student->full_name }}">
                                            </div>
                                            <div
                                                class="absolute -bottom-2 -right-2 w-7 h-7 rounded-full border-3 border-white shadow-lg
                                                {{ $student->status === 'active'
                                                    ? 'bg-emerald-500'
                                                    : ($student->status === 'inactive'
                                                        ? 'bg-red-500'
                                                        : 'bg-amber-500') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Profile Info -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                                            <div class="flex-1">
                                                <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">
                                                    {{ $student->first_name }} {{ $student->last_name }}
                                                </h1>
                                                <p class="text-lg text-gray-600 mb-4 flex items-center space-x-2">
                                                    <i class="fas fa-envelope text-blue-500"></i>
                                                    <span>{{ $student->email }}</span>
                                                </p>

                                                <!-- Quick Stats -->
                                                <div class="flex flex-wrap gap-3 mb-4">
                                                    <div class="bg-blue-50 rounded-xl px-4 py-2.5 border border-blue-100">
                                                        <div class="text-sm text-blue-600 font-medium">Student ID</div>
                                                        <div class="text-lg font-bold text-blue-900">
                                                            {{ $student->student_id ?? 'N/A' }}</div>
                                                    </div>
                                                    <div
                                                        class="bg-emerald-50 rounded-xl px-4 py-2.5 border border-emerald-100">
                                                        <div class="text-sm text-emerald-600 font-medium">Grade Level</div>
                                                        <div class="text-lg font-bold text-emerald-900">
                                                            {{ $student->grade_level ?? 'N/A' }}</div>
                                                    </div>
                                                    <div
                                                        class="bg-purple-50 rounded-xl px-4 py-2.5 border border-purple-100">
                                                        <div class="text-sm text-purple-600 font-medium">Admission No.</div>
                                                        <div class="text-lg font-bold text-purple-900">
                                                            {{ $student->admission_number ?? 'N/A' }}</div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Status Badges -->
                                            <div class="flex flex-wrap gap-3">
                                                <span
                                                    class="inline-flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold shadow-sm
                                                    {{ $student->status === 'active'
                                                        ? 'bg-emerald-500/10 text-emerald-700 border border-emerald-200'
                                                        : ($student->status === 'inactive'
                                                            ? 'bg-red-500/10 text-red-700 border border-red-200'
                                                            : 'bg-amber-500/10 text-amber-700 border border-amber-200') }}">
                                                    <i
                                                        class="fas
                                                        {{ $student->status === 'active'
                                                            ? 'fa-check-circle'
                                                            : ($student->status === 'inactive'
                                                                ? 'fa-times-circle'
                                                                : 'fa-clock') }}
                                                        mr-2 text-sm">
                                                    </i>
                                                    {{ ucfirst($student->status) }}
                                                </span>
                                                <span
                                                    class="inline-flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold bg-blue-500/10 text-blue-700 border border-blue-200 shadow-sm">
                                                    <i class="fas fa-user-graduate mr-2 text-sm"></i>
                                                    Student
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content Grid -->
                    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                        <!-- Left Column - Personal & Contact Info -->
                        <div class="xl:col-span-2 space-y-6">
                            <!-- Personal Information Card -->
                            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                                <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-gray-50/50">
                                    <div class="flex items-center justify-between">
                                        <h2 class="text-xl font-bold text-gray-900 flex items-center space-x-3">
                                            <div class="w-2 h-8 bg-gradient-to-b from-blue-500 to-purple-500 rounded-full">
                                            </div>
                                            <span>Personal Information</span>
                                        </h2>
                                        <i class="fas fa-user text-blue-500 text-lg"></i>
                                    </div>
                                </div>
                                <div class="p-6">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="space-y-5">
                                            <div class="flex items-start space-x-3">
                                                <div
                                                    class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">
                                                    <i class="fas fa-id-card text-blue-600"></i>
                                                </div>
                                                <div>
                                                    <label class="text-sm font-medium text-gray-500">Full Name</label>
                                                    <p class="text-gray-900 font-semibold">{{ $student->full_name }}
                                                       </p>
                                                </div>
                                            </div>
                                            <div class="flex items-start space-x-3">
                                                <div
                                                    class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center flex-shrink-0">
                                                    <i class="fas fa-venus-mars text-emerald-600"></i>
                                                </div>
                                                <div>
                                                    <label class="text-sm font-medium text-gray-500">Gender</label>
                                                    <p class="text-gray-900 font-semibold capitalize">
                                                        {{ $student->gender ?? 'Not specified' }}</p>
                                                </div>
                                            </div>
                                            <div class="flex items-start space-x-3">
                                                <div
                                                    class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center flex-shrink-0">
                                                    <i class="fas fa-birthday-cake text-amber-600"></i>
                                                </div>
                                                <div>
                                                    <label class="text-sm font-medium text-gray-500">Date of Birth</label>
                                                    <p class="text-gray-900 font-semibold">
                                                        {{ $student->date_of_birth ? $student->date_of_birth->format('F d, Y') : 'Not specified' }}
                                                    </p>
                                                    @if ($student->date_of_birth)
                                                        <p class="text-sm text-gray-500">Age:
                                                            {{ $student->date_of_birth->age }} years</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="space-y-5">
                                            <div class="flex items-start space-x-3">
                                                <div
                                                    class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center flex-shrink-0">
                                                    <i class="fas fa-tint text-purple-600"></i>
                                                </div>
                                                <div>
                                                    <label class="text-sm font-medium text-gray-500">Blood Group</label>
                                                    <p class="text-gray-900 font-semibold">
                                                        {{ $student->blood_group ?? 'Not specified' }}</p>
                                                </div>
                                            </div>
                                            <div class="flex items-start space-x-3">
                                                <div
                                                    class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center flex-shrink-0">
                                                    <i class="fas fa-globe text-red-600"></i>
                                                </div>
                                                <div>
                                                    <label class="text-sm font-medium text-gray-500">Nationality</label>
                                                    <p class="text-gray-900 font-semibold">
                                                        {{ $student->nationality ?? 'Not specified' }}</p>
                                                </div>
                                            </div>
                                            <div class="flex items-start space-x-3">
                                                <div
                                                    class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center flex-shrink-0">
                                                    <i class="fas fa-praying-hands text-indigo-600"></i>
                                                </div>
                                                <div>
                                                    <label class="text-sm font-medium text-gray-500">Religion &
                                                        Caste</label>
                                                    <p class="text-gray-900 font-semibold">
                                                        {{ $student->religion ?? 'Not specified' }}
                                                        @if ($student->caste)
                                                            <span class="text-gray-500">({{ $student->caste }})</span>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact & Academic Information -->
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <!-- Contact Information -->
                                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                                    <div
                                        class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-gray-50/50">
                                        <h2 class="text-xl font-bold text-gray-900 flex items-center space-x-3">
                                            <div
                                                class="w-2 h-8 bg-gradient-to-b from-green-500 to-emerald-500 rounded-full">
                                            </div>
                                            <span>Contact Information</span>
                                        </h2>
                                    </div>
                                    <div class="p-6 space-y-5">
                                        <div class="flex items-start space-x-3">
                                            <div
                                                class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center flex-shrink-0">
                                                <i class="fas fa-phone text-green-600"></i>
                                            </div>
                                            <div>
                                                <label class="text-sm font-medium text-gray-500">Phone Number</label>
                                                <p class="text-gray-900 font-semibold">
                                                    {{ $student->phone ?? 'Not provided' }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-start space-x-3">
                                            <div
                                                class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">
                                                <i class="fas fa-envelope text-blue-600"></i>
                                            </div>
                                            <div>
                                                <label class="text-sm font-medium text-gray-500">Email Address</label>
                                                <p class="text-gray-900 font-semibold">{{ $student->email }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-start space-x-3">
                                            <div
                                                class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center flex-shrink-0">
                                                <i class="fas fa-home text-purple-600"></i>
                                            </div>
                                            <div>
                                                <label class="text-sm font-medium text-gray-500">Address</label>
                                                <p class="text-gray-900 font-semibold">
                                                    {{ $student->address ?? 'Not provided' }}
                                                    @if ($student->city || $student->state)
                                                        <br>
                                                        <span class="text-sm text-gray-600">
                                                            {{ $student->city }}{{ $student->city && $student->state ? ', ' : '' }}{{ $student->state }}
                                                        </span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Academic Information -->
                                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                                    <div
                                        class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-gray-50/50">
                                        <h2 class="text-xl font-bold text-gray-900 flex items-center space-x-3">
                                            <div
                                                class="w-2 h-8 bg-gradient-to-b from-purple-500 to-indigo-500 rounded-full">
                                            </div>
                                            <span>Academic Information</span>
                                        </h2>
                                    </div>
                                    <div class="p-6 space-y-5">
                                        <div class="flex items-start space-x-3">
                                            <div
                                                class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center flex-shrink-0">
                                                <i class="fas fa-graduation-cap text-purple-600"></i>
                                            </div>
                                            <div>
                                                <label class="text-sm font-medium text-gray-500">Grade Level</label>
                                                <p class="text-gray-900 font-semibold">
                                                    {{ $student->grade_level ?? 'Not assigned' }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-start space-x-3">
                                            <div
                                                class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center flex-shrink-0">
                                                <i class="fas fa-calendar-alt text-indigo-600"></i>
                                            </div>
                                            <div>
                                                <label class="text-sm font-medium text-gray-500">Academic Year</label>
                                                <p class="text-gray-900 font-semibold">
                                                    {{ $student->academic_year ?? 'Not specified' }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-start space-x-3">
                                            <div
                                                class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center flex-shrink-0">
                                                <i class="fas fa-layer-group text-amber-600"></i>
                                            </div>
                                            <div>
                                                <label class="text-sm font-medium text-gray-500">Class & Section</label>
                                                <p class="text-gray-900 font-semibold">
                                                    @if ($student->schoolClass)
                                                        {{ $student->schoolClass->name }}
                                                    @else
                                                        Not assigned
                                                    @endif
                                                    @if ($student->section)
                                                        <span class="text-gray-600">(Section
                                                            {{ $student->section }})</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex items-start space-x-3">
                                            <div
                                                class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">
                                                <i class="fas fa-sort-numeric-up text-blue-600"></i>
                                            </div>
                                            <div>
                                                <label class="text-sm font-medium text-gray-500">Roll Number</label>
                                                <p class="text-gray-900 font-semibold">
                                                    {{ $student->roll_number ?? 'Not assigned' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column - Additional Info -->
                        <div class="space-y-6">
                            <!-- Emergency Contact -->
                            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                                <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-red-50 to-red-50/50">
                                    <h2 class="text-xl font-bold text-gray-900 flex items-center space-x-3">
                                        <div class="w-2 h-8 bg-gradient-to-b from-red-500 to-pink-500 rounded-full"></div>
                                        <span>Emergency Contact</span>
                                    </h2>
                                </div>
                                <div class="p-6 space-y-5">
                                    @if ($student->emergency_contact_name)
                                        <div class="text-center">
                                            <div
                                                class="w-16 h-16 rounded-2xl bg-red-100 flex items-center justify-center mx-auto mb-3">
                                                <i class="fas fa-phone-alt text-red-600 text-xl"></i>
                                            </div>
                                            <h3 class="font-bold text-gray-900 text-lg">
                                                {{ $student->emergency_contact_name }}</h3>
                                            <p class="text-gray-600">
                                                {{ $student->emergency_contact_relation ?? 'Emergency Contact' }}</p>
                                            <p class="text-gray-900 font-semibold text-lg mt-2">
                                                {{ $student->emergency_contact_phone }}</p>
                                        </div>
                                    @else
                                        <div class="text-center py-4">
                                            <i class="fas fa-exclamation-triangle text-gray-400 text-3xl mb-3"></i>
                                            <p class="text-gray-500">No emergency contact provided</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Medical Information -->
                            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                                <div
                                    class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-emerald-50 to-emerald-50/50">
                                    <h2 class="text-xl font-bold text-gray-900 flex items-center space-x-3">
                                        <div class="w-2 h-8 bg-gradient-to-b from-emerald-500 to-green-500 rounded-full">
                                        </div>
                                        <span>Medical Information</span>
                                    </h2>
                                </div>
                                <div class="p-6 space-y-4">
                                    @if ($student->allergies && count($student->allergies) > 0)
                                        <div>
                                            <label class="text-sm font-medium text-gray-500 mb-2 block">Allergies</label>
                                            <div class="flex flex-wrap gap-2">
                                                @foreach ($student->allergies as $allergy)
                                                    <span
                                                        class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm font-medium">
                                                        {{ $allergy }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    @if ($student->medical_notes)
                                        <div>
                                            <label class="text-sm font-medium text-gray-500 mb-2 block">Medical
                                                Notes</label>
                                            <p class="text-gray-700 bg-gray-50 rounded-xl p-3 text-sm">
                                                {{ $student->medical_notes }}</p>
                                        </div>
                                    @endif

                                    @if (!$student->allergies && !$student->medical_notes)
                                        <div class="text-center py-4">
                                            <i class="fas fa-heartbeat text-gray-400 text-2xl mb-2"></i>
                                            <p class="text-gray-500 text-sm">No medical information provided</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Quick Actions -->
                            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                                <div
                                    class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-gray-50/50">
                                    <h2 class="text-xl font-bold text-gray-900 flex items-center space-x-3">
                                        <div class="w-2 h-8 bg-gradient-to-b from-gray-500 to-gray-600 rounded-full"></div>
                                        <span>Quick Actions</span>
                                    </h2>
                                </div>
                                <div class="p-6 space-y-3">
                                    <a href="{{ route('admin.students.edit', $student) }}"
                                        class="w-full flex items-center justify-between p-4 rounded-xl border border-gray-200 hover:border-blue-300 hover:bg-blue-50 transition-all duration-200 group">
                                        <div class="flex items-center space-x-3">
                                            <div
                                                class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                                                <i class="fas fa-edit text-blue-600"></i>
                                            </div>
                                            <span class="font-medium text-gray-700">Edit Profile</span>
                                        </div>
                                        <i class="fas fa-chevron-right text-gray-400 group-hover:text-blue-600"></i>
                                    </a>

                                    <a href="#"
                                        class="w-full flex items-center justify-between p-4 rounded-xl border border-gray-200 hover:border-green-300 hover:bg-green-50 transition-all duration-200 group">
                                        <div class="flex items-center space-x-3">
                                            <div
                                                class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center group-hover:bg-green-200 transition-colors">
                                                <i class="fas fa-chart-line text-green-600"></i>
                                            </div>
                                            <span class="font-medium text-gray-700">View Performance</span>
                                        </div>
                                        <i class="fas fa-chevron-right text-gray-400 group-hover:text-green-600"></i>
                                    </a>

                                    <a href="#"
                                        class="w-full flex items-center justify-between p-4 rounded-xl border border-gray-200 hover:border-purple-300 hover:bg-purple-50 transition-all duration-200 group">
                                        <div class="flex items-center space-x-3">
                                            <div
                                                class="w-10 h-10 rounded-xl bg-purple-100 flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                                                <i class="fas fa-calendar-check text-purple-600"></i>
                                            </div>
                                            <span class="font-medium text-gray-700">Attendance</span>
                                        </div>
                                        <i class="fas fa-chevron-right text-gray-400 group-hover:text-purple-600"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .border-3 {
            border-width: 3px;
        }
    </style>
@endpush
