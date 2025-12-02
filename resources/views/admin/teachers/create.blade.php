@extends('layouts.app')

@section('title', 'Add New Teacher')

@section('content')
    <div class="min-h-screen bg-gray-50 flex">
        <x-admin-sidebar active-route="admin.teachers.index" />

        <div class="flex-1 overflow-auto">
            <div class="container mx-auto p-6">
                <div class="max-w-4xl mx-auto">
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <!-- Validation Errors Display -->
                        @if ($errors->any())
                            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500">
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
                            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500">
                                <div class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                                    <p class="text-green-800 font-semibold">{{ session('success') }}</p>
                                </div>
                            </div>
                        @endif

                        <div class="mb-6">
                            <h1 class="text-2xl font-bold text-gray-900">Add New Teacher</h1>
                            <p class="text-gray-600 mt-1">Fill in the teacher's information below</p>
                        </div>

                        <form action="{{ route('admin.teachers.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Personal Information -->
                                <div class="space-y-4">
                                    <h3 class="text-lg font-semibold text-gray-900">Personal Information</h3>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                                        <input type="text" name="name" value="{{ old('name') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                                            required>
                                        @error('name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                        <input type="email" name="email" value="{{ old('email') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                                            required>
                                        @error('email')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Password *</label>
                                        <input type="password" name="password"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror"
                                            required>
                                        @error('password')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Confirm Password
                                            *</label>
                                        <input type="password" name="password_confirmation"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                            required>
                                    </div>
                                </div>

                                <!-- Professional Information -->
                                <div class="space-y-4">
                                    <h3 class="text-lg font-semibold text-gray-900">Professional Information</h3>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                                        <input type="text" name="phone" value="{{ old('phone') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('phone') border-red-500 @enderror">
                                        @error('phone')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Date of Birth</label>
                                        <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('date_of_birth') border-red-500 @enderror">
                                        @error('date_of_birth')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Teacher ID *</label>
                                        <input type="text" name="teacher_id" value="{{ old('teacher_id') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('teacher_id') border-red-500 @enderror"
                                            required>
                                        @error('teacher_id')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Department *</label>
                                        <select name="department_id"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('department_id') border-red-500 @enderror"
                                            required>
                                            <option value="">Select Department</option>
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}"
                                                    {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                                    {{ $department->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('department_id')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Second Row -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Primary Subject *</label>
                                    <input type="text" name="subject" value="{{ old('subject') }}"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('subject') border-red-500 @enderror"
                                        required>
                                    @error('subject')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Qualification</label>
                                    <input type="text" name="qualification" value="{{ old('qualification') }}"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('qualification') border-red-500 @enderror">
                                    @error('qualification')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Date of Joining</label>
                                    <input type="date" name="date_of_joining" value="{{ old('date_of_joining') }}"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('date_of_joining') border-red-500 @enderror">
                                    @error('date_of_joining')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Third Row -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                                    <select name="status"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('status') border-red-500 @enderror"
                                        required>
                                        <option value="">Select Status</option>
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="on_leave" {{ old('status') == 'on_leave' ? 'selected' : '' }}>On
                                            Leave</option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                            Inactive</option>
                                    </select>
                                    @error('status')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                                    <select name="gender"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('gender') border-red-500 @enderror">
                                        <option value="">Select Gender</option>
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male
                                        </option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female
                                        </option>
                                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other
                                        </option>
                                    </select>
                                    @error('gender')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Salary</label>
                                    <input type="number" name="salary" value="{{ old('salary') }}" step="0.01"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('salary') border-red-500 @enderror"
                                        placeholder="0.00">
                                    @error('salary')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Additional Fields -->
                            <div class="mt-6 space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                                    <textarea name="address" rows="2"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('address') border-red-500 @enderror">{{ old('address') }}</textarea>
                                    @error('address')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
                                    <textarea name="bio" rows="3"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('bio') border-red-500 @enderror">{{ old('bio') }}</textarea>
                                    @error('bio')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Avatar</label>
                                    <input type="file" name="avatar" accept="image/*"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('avatar') border-red-500 @enderror">
                                    @error('avatar')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="flex items-center justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                                <a href="{{ route('admin.teachers.index') }}"
                                    class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                                    Cancel
                                </a>
                                <button type="submit"
                                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                    Add Teacher
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
