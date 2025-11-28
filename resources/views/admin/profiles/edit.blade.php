@extends('layouts.app')

@section('title', 'Edit ' . $admin->name)

@section('content')
    <div class="min-h-screen bg-gray-50 flex">
        <x-admin-sidebar active-route="admin.users.index" />

        <div class="flex-1 overflow-auto">
            <!-- Header -->
            <div class="bg-white shadow-sm border-b border-gray-200">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('admin.admins.show', $admin) }}"
                                class="text-gray-400 hover:text-gray-600 transition-colors">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">Edit {{ $admin->name }}</h1>
                                <p class="text-gray-600 mt-1">Update administrator information and permissions</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('admin.admins.show', $admin) }}"
                                class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container mx-auto p-6">
                <div class="max-w-4xl mx-auto">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900">Edit Administrator</h2>
                        </div>

                        <form action="{{ route('admin.admins.update', $admin) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="p-6 space-y-6">
                                <!-- Personal Information -->
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Personal Information</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Avatar -->
                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-medium text-gray-700 mb-4">Profile
                                                Picture</label>
                                            <div class="flex items-center space-x-6">
                                                <div class="relative">
                                                    <img id="avatar-preview"
                                                        class="h-24 w-24 rounded-2xl object-cover border-2 border-white shadow-lg"
                                                        src="{{ $admin->avatar ? asset('storage/' . $admin->avatar) : asset('images/default-avatar.png') }}"
                                                        alt="{{ $admin->name }}">
                                                    <div
                                                        class="absolute -bottom-2 -right-2 w-6 h-6 bg-green-400 border-2 border-white rounded-full">
                                                    </div>
                                                </div>
                                                <div class="flex-1">
                                                    <input type="file" name="avatar" id="avatar" accept="image/*"
                                                        class="hidden" onchange="previewImage(this)">
                                                    <label for="avatar"
                                                        class="cursor-pointer bg-white border border-gray-300 rounded-lg px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors inline-flex items-center gap-2">
                                                        <i class="fas fa-camera"></i>
                                                        Change Photo
                                                    </label>
                                                    @if ($admin->avatar)
                                                        <div class="mt-2">
                                                            <label class="inline-flex items-center">
                                                                <input type="checkbox" name="remove_avatar" value="1"
                                                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                                                <span class="ml-2 text-sm text-gray-600">Remove current
                                                                    photo</span>
                                                            </label>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Name -->
                                        <div>
                                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full
                                                Name *</label>
                                            <input type="text" name="name" id="name"
                                                value="{{ old('name', $admin->name) }}"
                                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                                required>
                                            @error('name')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Email -->
                                        <div>
                                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email
                                                Address *</label>
                                            <input type="email" name="email" id="email"
                                                value="{{ old('email', $admin->email) }}"
                                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                                required>
                                            @error('email')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Phone -->
                                        <div>
                                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone
                                                Number</label>
                                            <input type="tel" name="phone" id="phone"
                                                value="{{ old('phone', $admin->phone) }}"
                                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
                                            @error('phone')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Status -->
                                        <div>
                                            <label for="status"
                                                class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                                            <select name="status" id="status"
                                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                                required>
                                                <option value="active"
                                                    {{ old('status', $admin->status) == 'active' ? 'selected' : '' }}>
                                                    Active</option>
                                                <option value="inactive"
                                                    {{ old('status', $admin->status) == 'inactive' ? 'selected' : '' }}>
                                                    Inactive</option>
                                                <option value="pending"
                                                    {{ old('status', $admin->status) == 'pending' ? 'selected' : '' }}>
                                                    Pending</option>
                                            </select>
                                            @error('status')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Bio -->
                                        <div class="md:col-span-2">
                                            <label for="bio"
                                                class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
                                            <textarea name="bio" id="bio" rows="3"
                                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors resize-none">{{ old('bio', $admin->bio) }}</textarea>
                                            @error('bio')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Role & Permissions -->
                                <div class="border-t border-gray-200 pt-6">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Role & Permissions</h3>
                                    <div class="space-y-4">
                                        <!-- Role -->
                                        <div>
                                            <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Role
                                                *</label>
                                            <select name="role" id="role"
                                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                                required>
                                                <option value="">Select a role</option>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->name }}"
                                                        {{ $admin->hasRole($role->name) ? 'selected' : '' }}>
                                                        {{ ucfirst($role->name) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('role')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Permissions -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-3">Additional
                                                Permissions</label>
                                            <div
                                                class="grid grid-cols-1 md:grid-cols-2 gap-3 max-h-60 overflow-y-auto p-4 border border-gray-200 rounded-lg">
                                                @foreach ($permissions as $permission)
                                                    <label class="inline-flex items-center">
                                                        <input type="checkbox" name="permissions[]"
                                                            value="{{ $permission->name }}"
                                                            {{ $admin->hasPermissionTo($permission->name) ? 'checked' : '' }}
                                                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                                        <span
                                                            class="ml-2 text-sm text-gray-700">{{ $permission->name }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                            @error('permissions')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Danger Zone -->
                                @if ($admin->id !== auth()->id())
                                    <div class="border-t border-gray-200 pt-6">
                                        <h3 class="text-lg font-medium text-red-900 mb-4">Danger Zone</h3>
                                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <h4 class="text-sm font-medium text-red-800">Delete this administrator
                                                    </h4>
                                                    <p class="text-sm text-red-600 mt-1">Once deleted, this action cannot
                                                        be undone.</p>
                                                </div>
                                                <button type="button" onclick="confirmDelete()"
                                                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm font-medium">
                                                    Delete Admin
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Form Actions -->
                            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex justify-end space-x-4">
                                <a href="{{ route('admin.admins.show', $admin) }}"
                                    class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-medium">
                                    Cancel
                                </a>
                                <button type="submit"
                                    class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium flex items-center gap-2">
                                    <i class="fas fa-save"></i>
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function previewImage(input) {
            const preview = document.getElementById('avatar-preview');
            const file = input.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                }

                reader.readAsDataURL(file);
            }
        }

        function confirmDelete() {
            if (confirm('Are you sure you want to delete this administrator? This action cannot be undone.')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route('admin.admins.destroy', $admin) }}';

                const csrf = document.createElement('input');
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';
                form.appendChild(csrf);

                const method = document.createElement('input');
                method.name = '_method';
                method.value = 'DELETE';
                form.appendChild(method);

                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
@endpush

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
@endpush
