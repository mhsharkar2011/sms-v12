@extends('layouts.app')

@section('title', 'Add New Teacher')

@section('content')
<div class="min-h-screen bg-gray-50 flex">
    <x-admin-sidebar active-route="admin.teachers.index" />

    <div class="flex-1 overflow-auto">
        <div class="container mx-auto p-6">
            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-xl shadow-sm p-6">
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
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                                    <input type="text" name="name" value="{{ old('name') }}"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                    <input type="email" name="email" value="{{ old('email') }}"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                                    <input type="text" name="phone" value="{{ old('phone') }}"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Date of Birth</label>
                                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>

                            <!-- Professional Information -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-semibold text-gray-900">Professional Information</h3>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Teacher ID</label>
                                    <input type="text" name="teacher_id" value="{{ old('teacher_id') }}"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Primary Subject</label>
                                    <input type="text" name="subject" value="{{ old('subject') }}"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Qualification</label>
                                    <input type="text" name="qualification" value="{{ old('qualification') }}"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Date of Joining</label>
                                    <input type="date" name="date_of_joining" value="{{ old('date_of_joining') }}"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                    <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="on_leave" {{ old('status') == 'on_leave' ? 'selected' : '' }}>On Leave</option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Fields -->
                        <div class="mt-6 space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                                <textarea name="address" rows="3"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('address') }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
                                <textarea name="bio" rows="3"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('bio') }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Avatar</label>
                                <input type="file" name="avatar" accept="image/*"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
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
