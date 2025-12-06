@extends('layouts.app')

@section('title', 'Edit Student - ' . $student->full_name)

@section('content')
    <div class="min-h-screen bg-gray-50 flex">
        <x-admin-sidebar active-route="admin.students" />

        <div class="flex-1 overflow-auto">
            <!-- Header -->
            <div class="bg-white shadow-sm border-b border-gray-200">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <!-- Student Avatar -->
                            <div class="relative">
                                <div class="w-16 h-16 rounded-full overflow-hidden border-4 border-white shadow-lg">
                                    @if ($student->avatar_url)
                                        <img src="{{ $student->avatar_url }}" alt="{{ $student->full_name }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        <div
                                            class="w-full h-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-xl">
                                            {{ substr($student->full_name, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                @if ($student->avatar_url)
                                    <button type="button" onclick="removeAvatar()"
                                        class="absolute -bottom-1 -right-1 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center hover:bg-red-600 transition-colors"
                                        title="Remove avatar">
                                        <i class="fas fa-times text-xs"></i>
                                    </button>
                                @endif
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">Edit Student</h1>
                                <p class="text-gray-600 mt-1">Update student information for <span
                                        class="text-2xl font-bold text-gray-600"> {{ $student->full_name }}</span></p>
                                <div class="flex items-center space-x-4 mt-2">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <i class="fas fa-id-card mr-1"></i>
                                        {{ $student->student_id ?? 'N/A' }}
                                    </span>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-calendar mr-1"></i>
                                        {{ $student->admission_number ?? 'N/A' }}
                                    </span>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        <i class="fas fa-user-tag mr-1"></i>
                                        {{ $user->roles->first()->name ?? 'No Role' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('admin.students.show', $student->id) }}"
                                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
                                <i class="fas fa-eye"></i>
                                View Profile
                            </a>
                            <a href="{{ route('admin.students.index') }}"
                                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
                                <i class="fas fa-arrow-left"></i>
                                Back to Students
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container mx-auto p-6">
                <div class="max-w-6xl mx-auto">
                    <!-- Flash Messages -->
                    @if ($errors->any())
                        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-exclamation-circle"></i>
                                <span class="font-medium">Please fix the following errors:</span>
                            </div>
                            <ul class="mt-2 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-check-circle"></i>
                                <span>{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    <!-- Form Card -->
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <form action="{{ route('admin.students.update', $student->id) }}" method="POST"
                            enctype="multipart/form-data" id="studentForm">
                            @csrf
                            @method('PUT')
                            <!-- Hidden input for avatar removal -->
                            <input type="hidden" name="remove_avatar" id="remove_avatar" value="0">

                            <!-- Student Basic Information Section -->
                            <div class="p-6 border-b border-gray-200">
                                <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center gap-2">
                                    <i class="fas fa-user-graduate text-blue-600"></i>
                                    Student Basic Information
                                </h2>

                                <!-- Avatar Upload -->
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-3">
                                        Profile Picture
                                    </label>
                                    <div class="flex items-center space-x-6">
                                        <div class="relative">
                                            <div
                                                class="w-24 h-24 rounded-full overflow-hidden border-4 border-white shadow-lg">
                                                <img id="avatarPreview"
                                                    src="{{ $student->avatar_url ?: 'https://ui-avatars.com/api/?name=' . urlencode($student->full_name) . '&color=FFFFFF&background=4F46E5&size=96' }}"
                                                    alt="Avatar Preview" class="w-full h-full object-cover">
                                            </div>
                                            <div id="avatarLoading"
                                                class="hidden absolute inset-0 bg-gray-800 bg-opacity-50 rounded-full flex items-center justify-center">
                                                <i class="fas fa-spinner fa-spin text-white text-xl"></i>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <div class="mb-3">
                                                <input type="file" name="avatar" id="avatar" accept="image/*"
                                                    class="hidden" onchange="previewAvatar(event)">
                                                <label for="avatar"
                                                    class="cursor-pointer bg-white border border-gray-300 text-gray-700 px-4 py-2.5 rounded-lg hover:bg-gray-50 transition-colors flex items-center gap-2 inline-flex">
                                                    <i class="fas fa-upload"></i>
                                                    Upload New Photo
                                                </label>
                                                @if ($student->avatar_url)
                                                    <button type="button" onclick="removeAvatar()"
                                                        class="ml-3 bg-red-500 hover:bg-red-600 text-white px-4 py-2.5 rounded-lg transition-colors flex items-center gap-2">
                                                        <i class="fas fa-trash"></i>
                                                        Remove Photo
                                                    </button>
                                                @endif
                                            </div>
                                            <p class="text-xs text-gray-500">
                                                Maximum file size: 2MB. Allowed formats: JPG, PNG, GIF.
                                            </p>
                                            <p class="text-xs text-gray-500 mt-1">
                                                For a better result, use a square image (e.g., 400x400 pixels).
                                            </p>
                                            @error('avatar')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <!-- First Name -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                                        <input type="text" name="name"
                                            value="{{ old('name', $student->user->name ?? 'Student') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                                            required>
                                        @error('name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <!-- Email -->
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                            Email Address *
                                        </label>
                                        <input type="email" name="email" id="email"
                                            value="{{ old('email', $student->user->email) }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
                                            placeholder="student@example.com" required>
                                        @error('email')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Phone -->
                                    <div>
                                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                            Phone Number
                                        </label>
                                        <input type="tel" name="phone" id="phone"
                                            value="{{ old('phone', $student->user->phone) }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('phone') border-red-500 @enderror"
                                            placeholder="+1 (555) 123-4567">
                                        @error('phone')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Date of Birth -->
                                    <div>
                                        <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">
                                            Date of Birth *
                                        </label>
                                        <input type="date" name="date_of_birth" id="date_of_birth"
                                            value="{{ old('date_of_birth', $student->date_of_birth ? $student->date_of_birth->format('Y-m-d') : '') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('date_of_birth') border-red-500 @enderror"
                                            required>
                                        @error('date_of_birth')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Gender -->
                                    <div>
                                        <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">
                                            Gender *
                                        </label>
                                        <select name="gender" id="gender"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('gender') border-red-500 @enderror"
                                            required>
                                            <option value="">Select Gender</option>
                                            <option value="male"
                                                {{ old('gender', $student->gender) == 'male' ? 'selected' : '' }}>Male
                                            </option>
                                            <option value="female"
                                                {{ old('gender', $student->gender) == 'female' ? 'selected' : '' }}>Female
                                            </option>
                                            <option value="other"
                                                {{ old('gender', $student->gender) == 'other' ? 'selected' : '' }}>Other
                                            </option>
                                        </select>
                                        @error('gender')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Account Information Section -->
                            <div class="p-6 border-b border-gray-200">
                                <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center gap-2">
                                    <i class="fas fa-lock text-green-600"></i>
                                    Account Information
                                </h2>

                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                                    <div class="flex items-start space-x-2">
                                        <i class="fas fa-info-circle text-yellow-600 mt-0.5"></i>
                                        <div>
                                            <p class="text-sm text-yellow-800">
                                                Leave password fields blank to keep current password. Only fill if you want
                                                to change the password.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Password -->
                                    <div>
                                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                            New Password
                                        </label>
                                        <input type="password" name="password" id="password"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror"
                                            placeholder="Leave blank to keep current password">
                                        @error('password')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        <div id="passwordStrength" class="mt-1 text-xs"></div>
                                    </div>

                                    <!-- Confirm Password -->
                                    <div>
                                        <label for="password_confirmation"
                                            class="block text-sm font-medium text-gray-700 mb-2">
                                            Confirm New Password
                                        </label>
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="Confirm new password">
                                    </div>
                                </div>

                                <!-- Role Assignment -->
                                <div class="mt-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        User Role
                                    </label>
                                    <div class="space-y-3">
                                        @if ($roles->count() > 0)
                                            @foreach ($roles as $role)
                                                <label
                                                    class="flex items-center justify-between p-4 border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer transition-all duration-200 group">
                                                    <div class="flex items-center space-x-4">
                                                        <input type="checkbox" name="roles[]"
                                                            value="{{ $role->name }}"
                                                            {{ in_array($role->name, old('roles', $assignedRoles)) ? 'checked' : '' }}
                                                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 h-5 w-5 transition-colors">

                                                        <div class="flex items-center space-x-3">
                                                            <div
                                                                class="w-8 h-8 rounded-lg flex items-center justify-center
                            {{ $role->name == 'admin'
                                ? 'bg-red-100 text-red-600'
                                : ($role->name == 'teacher'
                                    ? 'bg-green-100 text-green-600'
                                    : ($role->name == 'student'
                                        ? 'bg-blue-100 text-blue-600'
                                        : 'bg-gray-100 text-gray-600')) }}">
                                                                <i
                                                                    class="fas
                                {{ $role->name == 'admin'
                                    ? 'fa-crown'
                                    : ($role->name == 'teacher'
                                        ? 'fa-chalkboard-teacher'
                                        : ($role->name == 'student'
                                            ? 'fa-user-graduate'
                                            : 'fa-user')) }}
                                text-sm">
                                                                </i>
                                                            </div>

                                                            <div>
                                                                <span
                                                                    class="text-sm font-semibold text-gray-900 block capitalize">
                                                                    {{ $role->name }}
                                                                </span>
                                                                <span class="text-xs text-gray-500">
                                                                    @switch($role->name)
                                                                        @case('admin')
                                                                            Full system access
                                                                        @break

                                                                        @case('teacher')
                                                                            Teaching and class management
                                                                        @break

                                                                        @case('student')
                                                                            Student access and learning
                                                                        @break

                                                                        @default
                                                                            Basic user access
                                                                    @endswitch
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="flex items-center space-x-2">
                                                        @if ($role->name == 'student')
                                                            <span
                                                                class="px-2.5 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full border border-blue-200">
                                                                Default
                                                            </span>
                                                        @endif
                                                        <i
                                                            class="fas fa-check text-green-500 text-sm opacity-0 group-hover:opacity-100 transition-opacity
                        {{ in_array($role->name, old('roles', $assignedRoles)) ? 'opacity-100' : '' }}"></i>
                                                    </div>
                                                </label>
                                            @endforeach
                                        @else
                                            <div
                                                class="text-center py-6 border-2 border-dashed border-gray-300 rounded-xl">
                                                <i class="fas fa-exclamation-triangle text-gray-400 text-2xl mb-2"></i>
                                                <p class="text-gray-500 text-sm">No roles available in the system</p>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Validation Error Display -->
                                    @error('roles')
                                        <div class="mt-2 p-3 bg-red-50 border border-red-200 rounded-lg">
                                            <div class="flex items-center space-x-2 text-red-700">
                                                <i class="fas fa-exclamation-circle"></i>
                                                <span class="text-sm font-medium">{{ $message }}</span>
                                            </div>
                                        </div>
                                    @enderror

                                    <!-- Current Roles Summary -->
                                    @if (count($assignedRoles) > 0)
                                        <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-xl">
                                            <h4
                                                class="text-sm font-semibold text-blue-900 mb-2 flex items-center space-x-2">
                                                <i class="fas fa-info-circle"></i>
                                                <span>Current Roles Assigned</span>
                                            </h4>
                                            <div class="flex flex-wrap gap-2">
                                                @foreach ($assignedRoles as $assignedRole)
                                                    <span
                                                        class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium
                    {{ $assignedRole == 'admin'
                        ? 'bg-red-100 text-red-800 border border-red-200'
                        : ($assignedRole == 'teacher'
                            ? 'bg-green-100 text-green-800 border border-green-200'
                            : ($assignedRole == 'student'
                                ? 'bg-blue-100 text-blue-800 border border-blue-200'
                                : 'bg-gray-100 text-gray-800 border border-gray-200')) }}">
                                                        <i
                                                            class="fas
                        {{ $assignedRole == 'admin'
                            ? 'fa-crown'
                            : ($assignedRole == 'teacher'
                                ? 'fa-chalkboard-teacher'
                                : ($assignedRole == 'student'
                                    ? 'fa-user-graduate'
                                    : 'fa-user')) }}
                        mr-1.5 text-xs">
                                                        </i>
                                                        {{ ucfirst($assignedRole) }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-xl">
                                            <div class="flex items-center space-x-2 text-yellow-700">
                                                <i class="fas fa-exclamation-triangle"></i>
                                                <span class="text-sm font-medium">No roles currently assigned to this
                                                    user</span>
                                            </div>
                                        </div>
                                    @endif
                                    @error('roles')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Academic Information Section -->
                            <div class="p-6 border-b border-gray-200">
                                <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center gap-2">
                                    <i class="fas fa-graduation-cap text-purple-600"></i>
                                    Academic Information
                                </h2>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <!-- Admission Number -->
                                    <div>
                                        <label for="admission_number"
                                            class="block text-sm font-medium text-gray-700 mb-2">
                                            Admission Number
                                        </label>
                                        <input type="text" name="admission_number" id="admission_number"
                                            value="{{ old('admission_number', $student->admission_number) }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('admission_number') border-red-500 @enderror"
                                            readonly>
                                        @error('admission_number')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Student ID -->
                                    <div>
                                        <label for="student_id" class="block text-sm font-medium text-gray-700 mb-2">
                                            Student ID
                                        </label>
                                        <input type="text" name="student_id" id="student_id"
                                            value="{{ old('student_id', $student->student_id) }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('student_id') border-red-500 @enderror"
                                            readonly>
                                        @error('student_id')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Class -->
                                    <div>
                                        <label for="class_id" class="block text-sm font-medium text-gray-700 mb-2">
                                            Class
                                        </label>
                                        <select name="class_id" id="class_id"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('class_id') border-red-500 @enderror">
                                            <option value="">Select Class</option>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}"
                                                    {{ old('class_id', $student->class_id) == $class->id ? 'selected' : '' }}>
                                                    {{ $class->name }} - {{ $class->grade_level }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('class_id')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Grade Level -->
                                    <div>
                                        <label for="grade_level" class="block text-sm font-medium text-gray-700 mb-2">
                                            Grade Level *
                                        </label>
                                        <select name="grade_level" id="grade_level"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('grade_level') border-red-500 @enderror"
                                            required>
                                            <option value="">Select Grade Level</option>
                                            @foreach (['Kindergarten', 'Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6', 'Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Grade 11', 'Grade 12'] as $level)
                                                <option value="{{ $level }}"
                                                    {{ old('grade_level', $student->grade_level) == $level ? 'selected' : '' }}>
                                                    {{ $level }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('grade_level')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Roll Number -->
                                    <div>
                                        <label for="roll_number" class="block text-sm font-medium text-gray-700 mb-2">
                                            Roll Number
                                        </label>
                                        <input type="text" name="roll_number" id="roll_number"
                                            value="{{ old('roll_number', $student->roll_number) }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('roll_number') border-red-500 @enderror"
                                            placeholder="Roll number">
                                        @error('roll_number')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Section -->
                                    <div>
                                        <label for="section" class="block text-sm font-medium text-gray-700 mb-2">
                                            Section
                                        </label>
                                        <input type="text" name="section" id="section"
                                            value="{{ old('section', $student->section) }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('section') border-red-500 @enderror"
                                            placeholder="Section (e.g., A, B, C)">
                                        @error('section')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Academic Year -->
                                    <div>
                                        <label for="academic_year" class="block text-sm font-medium text-gray-700 mb-2">
                                            Academic Year *
                                        </label>
                                        <input type="text" name="academic_year" id="academic_year"
                                            value="{{ old('academic_year', $student->academic_year) }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('academic_year') border-red-500 @enderror"
                                            placeholder="e.g., 2024-2025" required>
                                        @error('academic_year')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Admission Date -->
                                    <div>
                                        <label for="admission_date" class="block text-sm font-medium text-gray-700 mb-2">
                                            Admission Date *
                                        </label>
                                        <input type="date" name="admission_date" id="admission_date"
                                            value="{{ old('admission_date', $student->admission_date ? $student->admission_date->format('Y-m-d') : '') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('admission_date') border-red-500 @enderror"
                                            required>
                                        @error('admission_date')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <a href="{{ route('admin.students.index') }}"
                                            class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors flex items-center gap-2">
                                            <i class="fas fa-times"></i>
                                            Cancel
                                        </a>
                                        <button type="button" onclick="resetForm()"
                                            class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors flex items-center gap-2">
                                            <i class="fas fa-redo"></i>
                                            Reset Changes
                                        </button>
                                    </div>
                                    <div class="flex space-x-3">
                                        <button type="submit"
                                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
                                            <i class="fas fa-save"></i>
                                            Update Student
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
@endpush

@push('scripts')
    <script>
        // Role selection enhancement
        document.addEventListener('DOMContentLoaded', function() {
            const roleCheckboxes = document.querySelectorAll('input[name="roles[]"]');

            roleCheckboxes.forEach(checkbox => {
                // Add click effect to the entire label
                checkbox.closest('label').addEventListener('click', function(e) {
                    if (e.target.type !== 'checkbox') {
                        checkbox.checked = !checkbox.checked;
                        checkbox.dispatchEvent(new Event('change'));
                    }
                });

                // Update visual state on change
                checkbox.addEventListener('change', function() {
                    const label = this.closest('label');
                    if (this.checked) {
                        label.classList.add('border-blue-300', 'bg-blue-50');
                        label.classList.remove('border-gray-200', 'hover:bg-gray-50');
                    } else {
                        label.classList.remove('border-blue-300', 'bg-blue-50');
                        label.classList.add('border-gray-200', 'hover:bg-gray-50');
                    }
                });

                // Initialize visual state
                if (checkbox.checked) {
                    const label = checkbox.closest('label');
                    label.classList.add('border-blue-300', 'bg-blue-50');
                    label.classList.remove('border-gray-200', 'hover:bg-gray-50');
                }
            });

            // Auto-check student role if no roles selected on form submit
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                const checkedRoles = document.querySelectorAll('input[name="roles[]"]:checked');
                if (checkedRoles.length === 0) {
                    e.preventDefault();
                    alert('Please assign at least one role to the user. Student role is recommended.');
                    document.querySelector('input[value="student"]').focus();
                }
            });
        });

        // Avatar preview functionality
        function previewAvatar(event) {
            const input = event.target;
            const preview = document.getElementById('avatarPreview');
            const loading = document.getElementById('avatarLoading');

            if (input.files && input.files[0]) {
                const file = input.files[0];
                const maxSize = 2 * 1024 * 1024; // 2MB

                // Check file size
                if (file.size > maxSize) {
                    alert('File size exceeds 2MB limit. Please choose a smaller file.');
                    input.value = '';
                    return;
                }

                // Check file type
                const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
                if (!validTypes.includes(file.type)) {
                    alert('Only JPG, PNG, and GIF files are allowed.');
                    input.value = '';
                    return;
                }

                // Show loading
                loading.classList.remove('hidden');

                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    loading.classList.add('hidden');

                    // Remove avatar removal flag if a new image is uploaded
                    document.getElementById('remove_avatar').value = '0';
                };
                reader.readAsDataURL(file);
            }
        }

        // Remove avatar functionality
        function removeAvatar() {
            if (confirm('Are you sure you want to remove the profile picture?')) {
                // Reset file input
                document.getElementById('avatar').value = '';

                // Set default avatar (initials)
                const initials = '{{ substr($student->full_name, 0, 1) }}';
                const defaultAvatar =
                    `https://ui-avatars.com/api/?name=${encodeURIComponent('{{ $student->full_name }}')}&color=FFFFFF&background=4F46E5&size=96`;

                document.getElementById('avatarPreview').src = defaultAvatar;

                // Set remove avatar flag
                document.getElementById('remove_avatar').value = '1';

                // Hide remove button if it exists
                const removeBtn = document.querySelector('button[onclick="removeAvatar()"]');
                if (removeBtn) {
                    removeBtn.style.display = 'none';
                }
            }
        }

        // Form reset functionality
        function resetForm() {
            if (confirm('Are you sure you want to reset all changes? This will restore the original values.')) {
                document.getElementById('studentForm').reset();

                // Reset avatar to original
                const originalAvatar =
                    '{{ $student->avatar_url ?: 'https://ui-avatars.com/api/?name=' . urlencode($student->full_name) . '&color=FFFFFF&background=4F46E5&size=96' }}';
                document.getElementById('avatarPreview').src = originalAvatar;

                // Reset remove avatar flag
                document.getElementById('remove_avatar').value = '0';

                // Reset role checkboxes to original state
                const originalRoles = @json($assignedRoles);
                document.querySelectorAll('input[name="roles[]"]').forEach(checkbox => {
                    checkbox.checked = originalRoles.includes(checkbox.value);
                });
            }
        }

        // Password strength indicator
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthDiv = document.getElementById('passwordStrength');

            if (!password) {
                strengthDiv.innerHTML = '';
                return;
            }

            let strength = 0;
            let color = 'red';
            let text = 'Weak';

            // Check password criteria
            if (password.length >= 8) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;

            // Determine strength level
            if (strength <= 2) {
                color = 'red';
                text = 'Weak';
            } else if (strength <= 4) {
                color = 'orange';
                text = 'Medium';
            } else {
                color = 'green';
                text = 'Strong';
            }

            strengthDiv.innerHTML = `<span style="color: ${color}; font-weight: bold;">${text}</span>`;
        });
    </script>
@endpush
