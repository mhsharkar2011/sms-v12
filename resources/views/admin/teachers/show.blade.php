@extends('layouts.app')

@section('title', $teacher->name)

@section('content')
    <div class="min-h-screen bg-gray-50 flex">
        <x-admin-sidebar active-route="admin.teachers.index" />

        <div class="flex-1 overflow-auto">
            <div class="container mx-auto p-6">
                <!-- Breadcrumb -->
                <nav class="mb-6" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2 text-sm">
                        <li>
                            <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-home mr-1"></i> Dashboard
                            </a>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                            <a href="{{ route('admin.teachers.index') }}" class="ml-2 text-blue-600 hover:text-blue-800">
                                Teachers
                            </a>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                            <span class="ml-2 text-gray-500">{{ $teacher->name }}</span>
                        </li>
                    </ol>
                </nav>

                <!-- Success Message -->
                @if (session('success'))
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-lg">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                            <p class="text-green-800 font-semibold">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                <div class="max-w-6xl mx-auto">
                    <!-- Header Card -->
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
                        <div class="bg-gradient-to-r from-blue-600 to-blue-800 p-6">
                            <div class="flex flex-col md:flex-row md:items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    @if($teacher->avatar)
                                        <img src="{{ asset('storage/' . $teacher->avatar) }}"
                                             alt="{{ $teacher->name }}"
                                             class="w-20 h-20 rounded-full border-4 border-white/50 shadow-lg">
                                    @else
                                        <div class="w-20 h-20 rounded-full bg-white/20 flex items-center justify-center border-4 border-white/50 shadow-lg">
                                            <i class="fas fa-user text-white text-3xl"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <h1 class="text-2xl font-bold text-white">{{ $teacher->name }}</h1>
                                        <div class="flex flex-wrap items-center gap-3 mt-2">
                                            <span class="px-3 py-1 bg-white/20 text-white rounded-full text-sm">
                                                <i class="fas fa-id-badge mr-1"></i> {{ $teacher->teacher_id }}
                                            </span>
                                            <span class="px-3 py-1 bg-white/20 text-white rounded-full text-sm">
                                                <i class="fas fa-building mr-1"></i> {{ $teacher->department->name ?? 'No Department' }}
                                            </span>
                                            <span class="px-3 py-1 {{ $teacher->status === 'active' ? 'bg-green-500' : ($teacher->status === 'on_leave' ? 'bg-yellow-500' : 'bg-red-500') }} text-white rounded-full text-sm">
                                                {{ ucfirst(str_replace('_', ' ', $teacher->status)) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3 mt-4 md:mt-0">
                                    <a href="{{ route('admin.teachers.edit', $teacher) }}"
                                       class="px-4 py-2 bg-white text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                        <i class="fas fa-edit mr-2"></i> Edit
                                    </a>
                                    <a href="{{ route('admin.teachers.index') }}"
                                       class="px-4 py-2 border border-white text-white hover:bg-white/10 rounded-lg transition-colors">
                                        <i class="fas fa-arrow-left mr-2"></i> Back
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Left Column - Teacher Details -->
                        <div class="lg:col-span-2 space-y-6">
                            <!-- Personal Information Card -->
                            <div class="bg-white rounded-xl shadow-sm p-6">
                                <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <i class="fas fa-user-circle text-blue-500 mr-2"></i> Personal Information
                                </h2>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Full Name</label>
                                        <p class="mt-1 text-gray-900">{{ $teacher->name }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Email</label>
                                        <p class="mt-1 text-gray-900">{{ $teacher->email }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Phone</label>
                                        <p class="mt-1 text-gray-900">{{ $teacher->phone ?? 'Not provided' }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Gender</label>
                                        <p class="mt-1 text-gray-900">{{ ucfirst($teacher->gender ?? 'Not specified') }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Date of Birth</label>
                                        <p class="mt-1 text-gray-900">
                                            {{ $teacher->date_of_birth ? $teacher->date_of_birth->format('F d, Y') : 'Not provided' }}
                                        </p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Address</label>
                                        <p class="mt-1 text-gray-900">{{ $teacher->address ?? 'Not provided' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Professional Information Card -->
                            <div class="bg-white rounded-xl shadow-sm p-6">
                                <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <i class="fas fa-briefcase text-green-500 mr-2"></i> Professional Information
                                </h2>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Teacher ID</label>
                                        <p class="mt-1 text-gray-900 font-medium">{{ $teacher->teacher_id }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Department</label>
                                        <p class="mt-1 text-gray-900">{{ $teacher->department->name ?? 'Not assigned' }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Primary Subject</label>
                                        <p class="mt-1 text-gray-900">{{ $teacher->subject ?? 'Not specified' }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Qualification</label>
                                        <p class="mt-1 text-gray-900">{{ $teacher->qualification ?? 'Not specified' }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Date of Joining</label>
                                        <p class="mt-1 text-gray-900">
                                            {{ $teacher->date_of_joining ? $teacher->date_of_joining->format('F d, Y') : 'Not provided' }}
                                        </p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Salary</label>
                                        <p class="mt-1 text-gray-900">
                                            {{ $teacher->salary ? '$' . number_format($teacher->salary, 2) : 'Not specified' }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Bio Card -->
                            @if($teacher->bio)
                                <div class="bg-white rounded-xl shadow-sm p-6">
                                    <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                        <i class="fas fa-info-circle text-purple-500 mr-2"></i> Bio
                                    </h2>
                                    <p class="text-gray-700 whitespace-pre-line">{{ $teacher->bio }}</p>
                                </div>
                            @endif
                        </div>

                        <!-- Right Column - Stats & Actions -->
                        <div class="space-y-6">
                            <!-- Stats Card -->
                            <div class="bg-white rounded-xl shadow-sm p-6">
                                <h2 class="text-lg font-semibold text-gray-900 mb-4">Statistics</h2>
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                                <i class="fas fa-chalkboard-teacher text-blue-600"></i>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-500">Classes Assigned</p>
                                                <p class="text-xl font-bold text-gray-900">{{ $teacher->classes_count ?? 0 }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-3">
                                                <i class="fas fa-graduation-cap text-green-600"></i>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-500">Students</p>
                                                <p class="text-xl font-bold text-gray-900">{{ $teacher->students_count ?? 0 }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between p-3 bg-purple-50 rounded-lg">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center mr-3">
                                                <i class="fas fa-calendar-alt text-purple-600"></i>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-500">Years of Service</p>
                                                <p class="text-xl font-bold text-gray-900">
                                                    @if($teacher->date_of_joining)
                                                        {{ now()->diffInYears($teacher->date_of_joining) }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Actions Card -->
                            <div class="bg-white rounded-xl shadow-sm p-6">
                                <h2 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h2>
                                <div class="space-y-3">
                                    <a href="{{ route('admin.teachers.edit', $teacher) }}"
                                       class="flex items-center justify-between p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors group">
                                        <div class="flex items-center">
                                            <i class="fas fa-edit text-blue-600 mr-3"></i>
                                            <span class="text-gray-700 group-hover:text-blue-600">Edit Teacher</span>
                                        </div>
                                        <i class="fas fa-chevron-right text-gray-400 group-hover:text-blue-600"></i>
                                    </a>
                                    @if($teacher->email)
                                        <a href="mailto:{{ $teacher->email }}"
                                           class="flex items-center justify-between p-3 bg-green-50 hover:bg-green-100 rounded-lg transition-colors group">
                                            <div class="flex items-center">
                                                <i class="fas fa-envelope text-green-600 mr-3"></i>
                                                <span class="text-gray-700 group-hover:text-green-600">Send Email</span>
                                            </div>
                                            <i class="fas fa-chevron-right text-gray-400 group-hover:text-green-600"></i>
                                        </a>
                                    @endif
                                    @if($teacher->phone)
                                        <a href="tel:{{ $teacher->phone }}"
                                           class="flex items-center justify-between p-3 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors group">
                                            <div class="flex items-center">
                                                <i class="fas fa-phone text-purple-600 mr-3"></i>
                                                <span class="text-gray-700 group-hover:text-purple-600">Call Teacher</span>
                                            </div>
                                            <i class="fas fa-chevron-right text-gray-400 group-hover:text-purple-600"></i>
                                        </a>
                                    @endif
                                    <a href="#"
                                       class="flex items-center justify-between p-3 bg-yellow-50 hover:bg-yellow-100 rounded-lg transition-colors group">
                                        <div class="flex items-center">
                                            <i class="fas fa-print text-yellow-600 mr-3"></i>
                                            <span class="text-gray-700 group-hover:text-yellow-600">Print Profile</span>
                                        </div>
                                        <i class="fas fa-chevron-right text-gray-400 group-hover:text-yellow-600"></i>
                                    </a>
                                </div>
                            </div>

                            <!-- Status Card -->
                            <div class="bg-white rounded-xl shadow-sm p-6">
                                <h2 class="text-lg font-semibold text-gray-900 mb-4">Account Status</h2>
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-600">Status</span>
                                        <span class="px-3 py-1 rounded-full text-sm font-medium {{ $teacher->status === 'active' ? 'bg-green-100 text-green-800' : ($teacher->status === 'on_leave' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                            {{ ucfirst(str_replace('_', ' ', $teacher->status)) }}
                                        </span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-600">Account Created</span>
                                        <span class="text-gray-900">{{ $teacher->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-600">Last Updated</span>
                                        <span class="text-gray-900">{{ $teacher->updated_at->format('M d, Y') }}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-600">Email Verified</span>
                                        <span class="{{ $teacher->email_verified_at ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $teacher->email_verified_at ? 'Verified' : 'Not Verified' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Danger Zone Card -->
                            <div class="bg-white rounded-xl shadow-sm p-6 border border-red-200">
                                <h2 class="text-lg font-semibold text-red-700 mb-4">Danger Zone</h2>
                                <p class="text-sm text-gray-600 mb-4">Once you delete a teacher's account, there is no going back. Please be certain.</p>
                                <form action="{{ route('admin.teachers.destroy', $teacher) }}" method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this teacher? This action cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors flex items-center justify-center">
                                        <i class="fas fa-trash mr-2"></i> Delete Teacher
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity / Notes Section -->
                    <div class="mt-6 bg-white rounded-xl shadow-sm p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Recent Activity</h2>
                        <div class="border-l-2 border-blue-500 pl-4">
                            <div class="mb-4">
                                <p class="text-gray-700">Teacher account was created</p>
                                <p class="text-sm text-gray-500">{{ $teacher->created_at->diffForHumans() }}</p>
                            </div>
                            @if($teacher->date_of_joining)
                                <div class="mb-4">
                                    <p class="text-gray-700">Joined the school</p>
                                    <p class="text-sm text-gray-500">{{ $teacher->date_of_joining->diffForHumans() }}</p>
                                </div>
                            @endif
                            @if($teacher->updated_at != $teacher->created_at)
                                <div class="mb-4">
                                    <p class="text-gray-700">Profile was last updated</p>
                                    <p class="text-sm text-gray-500">{{ $teacher->updated_at->diffForHumans() }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    /* Custom styles for better UX */
    .status-active { background-color: #d1fae5; color: #065f46; }
    .status-on_leave { background-color: #fef3c7; color: #92400e; }
    .status-inactive { background-color: #fee2e2; color: #991b1b; }

    .stat-card:hover {
        transform: translateY(-2px);
        transition: transform 0.2s ease-in-out;
    }
</style>
@endpush
