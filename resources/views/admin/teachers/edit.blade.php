@extends('layouts.app')

@section('title', 'Edit Teacher')

@section('content')
    <div class="min-h-screen bg-gray-50 flex">
        <x-admin-sidebar active-route="admin.teachers.index" />

        <div class="flex-1 overflow-auto">
            <div class="container mx-auto p-6">
                <div class="max-w-4xl mx-auto">
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
                                <a href="{{ route('admin.teachers.index') }}"
                                    class="ml-2 text-blue-600 hover:text-blue-800">
                                    Teachers
                                </a>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                                <span class="ml-2 text-gray-500">Edit Teacher</span>
                            </li>
                        </ol>
                    </nav>

                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <!-- Header -->
                        <div class="bg-gradient-to-r from-blue-600 to-blue-800 p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h1 class="text-2xl font-bold text-white">Edit Teacher</h1>
                                    <p class="text-blue-100 mt-1">Update teacher information</p>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('admin.teachers.show', $teacher) }}"
                                        class="px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-lg transition-colors">
                                        <i class="fas fa-eye mr-2"></i> View
                                    </a>
                                    <a href="{{ route('admin.teachers.index') }}"
                                        class="px-4 py-2 bg-white text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                        <i class="fas fa-arrow-left mr-2"></i> Back
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Teacher Info Summary -->
                        <div class="p-6 border-b border-gray-200 bg-gray-50">
                            <div class="flex items-center space-x-4">
                                @if ($teacher->avatar)
                                    <img src="{{ asset('storage/' . $teacher->avatar) }}" alt="{{ $teacher->name }}"
                                        class="w-16 h-16 rounded-full border-2 border-white shadow-sm">
                                @else
                                    <div
                                        class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center border-2 border-white shadow-sm">
                                        <i class="fas fa-user text-blue-600 text-2xl"></i>
                                    </div>
                                @endif
                                <div>
                                    <h2 class="text-xl font-bold text-gray-900">{{ $teacher->user->name }}</h2>
                                    <div class="flex items-center space-x-4 mt-1">
                                        <span class="flex items-center text-gray-600">
                                            <i class="fas fa-id-badge text-blue-500 mr-2"></i>
                                            {{ $teacher->teacher_id ?? 'N/A' }}
                                        </span>
                                        <span class="flex items-center text-gray-600">
                                            <i class="fas fa-building text-blue-500 mr-2"></i>
                                            {{ $teacher->department->name ?? 'No Department' }}
                                        </span>
                                        <span class="flex items-center">
                                            <span
                                                class="w-2 h-2 rounded-full {{ $teacher->status === 'active' ? 'bg-green-500' : ($teacher->status === 'on_leave' ? 'bg-yellow-500' : 'bg-red-500') }} mr-2"></span>
                                            <span
                                                class="text-sm font-medium {{ $teacher->status === 'active' ? 'text-green-600' : ($teacher->status === 'on_leave' ? 'text-yellow-600' : 'text-red-600') }}">
                                                {{ ucfirst(str_replace('_', ' ', $teacher->status)) }}
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="p-6">
                            <!-- Validation Errors -->
                            @if ($errors->any())
                                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg">
                                    <div class="flex items-center">
                                        <i class="fas fa-exclamation-triangle text-red-500 text-xl mr-3"></i>
                                        <h3 class="text-red-800 font-semibold">Please fix the following errors:</h3>
                                    </div>
                                    <ul class="mt-2 list-disc list-inside text-red-700">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Success Message -->
                            @if (session('success'))
                                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-lg">
                                    <div class="flex items-center">
                                        <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                                        <p class="text-green-800 font-semibold">{{ session('success') }}</p>
                                    </div>
                                </div>
                            @endif

                            <form action="{{ route('admin.teachers.update', $teacher) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Personal Information -->
                                    <div class="space-y-4">
                                        <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Personal Information
                                        </h3>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                                            <input type="text" name="name" value="{{ old('name', $teacher->name) }}"
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                                                required>
                                            @error('name')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                            <input type="email" name="email"
                                                value="{{ old('email', $teacher->email) }}"
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                                                required>
                                            @error('email')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                                            <input type="text" name="phone"
                                                value="{{ old('phone', $teacher->phone) }}"
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('phone') border-red-500 @enderror">
                                            @error('phone')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Date of
                                                Birth</label>
                                            <input type="date" name="date_of_birth"
                                                value="{{ old('date_of_birth', $teacher->date_of_birth ? $teacher->date_of_birth->format('Y-m-d') : '') }}"
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('date_of_birth') border-red-500 @enderror">
                                            @error('date_of_birth')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                                            <select name="gender"
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('gender') border-red-500 @enderror">
                                                <option value="">Select Gender</option>
                                                <option value="male"
                                                    {{ old('gender', $teacher->gender) == 'male' ? 'selected' : '' }}>Male
                                                </option>
                                                <option value="female"
                                                    {{ old('gender', $teacher->gender) == 'female' ? 'selected' : '' }}>
                                                    Female</option>
                                                <option value="other"
                                                    {{ old('gender', $teacher->gender) == 'other' ? 'selected' : '' }}>
                                                    Other</option>
                                            </select>
                                            @error('gender')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Professional Information -->
                                    <div class="space-y-4">
                                        <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Professional
                                            Information</h3>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Teacher ID *</label>
                                            <input type="text" name="teacher_id"
                                                value="{{ old('teacher_id', $teacher->teacher_id) }}"
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('teacher_id') border-red-500 @enderror"
                                                required>
                                            @error('teacher_id')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Department
                                                *</label>
                                            <select name="department_id"
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('department_id') border-red-500 @enderror"
                                                required>
                                                <option value="">Select Department</option>
                                                @foreach ($departments as $department)
                                                    <option value="{{ $department->id }}"
                                                        {{ old('department_id', $teacher->department_id) == $department->id ? 'selected' : '' }}>
                                                        {{ $department->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('department_id')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Primary Subject
                                                *</label>
                                            <input type="text" name="subject"
                                                value="{{ old('subject', $teacher->subject) }}"
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('subject') border-red-500 @enderror"
                                                required>
                                            @error('subject')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label
                                                class="block text-sm font-medium text-gray-700 mb-2">Qualification</label>
                                            <input type="text" name="qualification"
                                                value="{{ old('qualification', $teacher->qualification) }}"
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('qualification') border-red-500 @enderror">
                                            @error('qualification')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Date of
                                                Joining</label>
                                            <input type="date" name="date_of_joining"
                                                value="{{ old('date_of_joining', $teacher->date_of_joining ? $teacher->date_of_joining->format('Y-m-d') : '') }}"
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('date_of_joining') border-red-500 @enderror">
                                            @error('date_of_joining')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Second Row -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                                        <select name="status"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('status') border-red-500 @enderror"
                                            required>
                                            <option value="">Select Status</option>
                                            <option value="active"
                                                {{ old('status', $teacher->status) == 'active' ? 'selected' : '' }}>Active
                                            </option>
                                            <option value="on_leave"
                                                {{ old('status', $teacher->status) == 'on_leave' ? 'selected' : '' }}>On
                                                Leave</option>
                                            <option value="inactive"
                                                {{ old('status', $teacher->status) == 'inactive' ? 'selected' : '' }}>
                                                Inactive</option>
                                        </select>
                                        @error('status')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Salary</label>
                                        <input type="number" name="salary"
                                            value="{{ old('salary', $teacher->salary) }}" step="0.01"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('salary') border-red-500 @enderror"
                                            placeholder="0.00">
                                        @error('salary')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Change Password</label>
                                        <input type="password" name="password"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror"
                                            placeholder="Leave blank to keep current">
                                        @error('password')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        <small class="text-gray-500">Leave blank to keep current password</small>
                                    </div>
                                </div>

                                <!-- Additional Fields -->
                                <div class="mt-6 space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                                        <textarea name="address" rows="2"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('address') border-red-500 @enderror">{{ old('address', $teacher->address) }}</textarea>
                                        @error('address')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
                                        <textarea name="bio" rows="3"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('bio') border-red-500 @enderror">{{ old('bio', $teacher->bio) }}</textarea>
                                        @error('bio')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Avatar</label>
                                        <div class="flex items-center space-x-4">
                                            @if ($teacher->avatar)
                                                <div class="relative">
                                                    <img src="{{ asset('storage/' . $teacher->avatar) }}"
                                                        alt="Current Avatar"
                                                        class="w-20 h-20 rounded-full border-2 border-gray-300">
                                                    <div
                                                        class="absolute -top-1 -right-1 bg-white rounded-full p-1 shadow-sm">
                                                        <input type="checkbox" name="remove_avatar" id="remove_avatar"
                                                            class="hidden">
                                                        <label for="remove_avatar"
                                                            class="cursor-pointer text-red-500 hover:text-red-700"
                                                            onclick="this.previousElementSibling.checked = !this.previousElementSibling.checked; this.classList.toggle('text-red-700')">
                                                            <i class="fas fa-times text-sm"></i>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-600">Current avatar</p>
                                                    <label class="flex items-center mt-1 text-sm text-gray-500">
                                                        <input type="checkbox" name="remove_avatar" value="1"
                                                            class="mr-2">
                                                        Remove avatar
                                                    </label>
                                                </div>
                                            @endif
                                            <div class="flex-1">
                                                <input type="file" name="avatar" accept="image/*"
                                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('avatar') border-red-500 @enderror">
                                                <small class="text-gray-500">Leave blank to keep current avatar</small>
                                                @error('avatar')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Actions -->
                                <div class="flex items-center justify-between mt-8 pt-6 border-t border-gray-200">
                                    <div class="space-x-3">
                                        <a href="{{ route('admin.teachers.show', $teacher) }}"
                                            class="px-5 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                                            <i class="fas fa-eye mr-2"></i> View Details
                                        </a>
                                        <button type="button"
                                            onclick="if(confirm('Are you sure you want to reset all changes?')) this.form.reset()"
                                            class="px-5 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                                            <i class="fas fa-undo mr-2"></i> Reset
                                        </button>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <a href="{{ route('admin.teachers.index') }}"
                                            class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                                            Cancel
                                        </a>
                                        <button type="submit"
                                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                            <i class="fas fa-save mr-2"></i> Update Teacher
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Password confirmation functionality
        document.addEventListener('DOMContentLoaded', function() {
            const passwordField = document.querySelector('input[name="password"]');
            if (passwordField) {
                const confirmField = document.createElement('input');
                confirmField.type = 'password';
                confirmField.name = 'password_confirmation';
                confirmField.className = passwordField.className + ' mt-2';
                confirmField.placeholder = 'Confirm new password';

                passwordField.parentNode.appendChild(confirmField);
            }
        });
    </script>
@endsection
