@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
    <div class="min-h-screen bg-gray-50 flex">
        <x-admin-sidebar active-route="admin.users.index" />

        <div class="flex-1 overflow-auto">
            <!-- Header -->
            <div class="bg-white shadow-sm border-b border-gray-200">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Edit User</h1>
                            <p class="text-gray-600 mt-1">Update user account information</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('admin.users.index') }}"
                                class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors flex items-center gap-2">
                                <i class="fas fa-arrow-left"></i>
                                Back to Users
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container mx-auto p-6">
                <div class="max-w-4xl mx-auto">
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <form action="{{ route('admin.users.update', $user) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Profile Header -->
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-8 border-b border-gray-200">
                                <div class="flex items-center space-x-6">
                                    <!-- Avatar Upload -->
                                    <div class="relative">
                                        <div
                                            class="w-24 h-24 rounded-2xl border-4 border-white shadow-lg overflow-hidden bg-gray-100">
                                            <img id="avatarPreview"
                                                src="{{ $user->avatar ? asset('storage/users/' . $user->avatar) : asset('images/default-avatar.png') }}"
                                                alt="{{ $user->name }}" class="w-full h-full object-cover">
                                        </div>
                                        <label for="avatar"
                                            class="absolute bottom-0 right-0 bg-blue-600 text-white p-2 rounded-full cursor-pointer hover:bg-blue-700 transition-colors shadow-lg">
                                            <i class="fas fa-camera text-sm"></i>
                                            <input type="file" id="avatar" name="avatar" class="hidden"
                                                accept="image/*" onchange="previewImage(this)">
                                        </label>
                                    </div>

                                    @if ($user->avatar)
                                        <div class="mt-2">
                                            <button type="button" onclick="confirmRemoveAvatar()"
                                                class="text-red-600 hover:text-red-800 text-sm flex items-center gap-1">
                                                <i class="fas fa-trash"></i>
                                                Remove Avatar
                                            </button>
                                        </div>

                                        <script>
                                            function confirmRemoveAvatar() {
                                                if (confirm('Are you sure you want to remove the avatar?')) {
                                                    fetch('{{ route('admin.users.avatar.remove', $user) }}', {
                                                        method: 'DELETE',
                                                        headers: {
                                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                            'Content-Type': 'application/json'
                                                        }
                                                    }).then(response => {
                                                        if (response.ok) {
                                                            location.reload();
                                                        } else {
                                                            alert('Failed to remove avatar.');
                                                        }
                                                    });
                                                }
                                            }
                                        </script>
                                    @endif

                                    <div class="flex-1">
                                        <h2 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h2>
                                        <p class="text-gray-600 mt-1">{{ $user->email }}</p>
                                        <div class="flex items-center space-x-4 mt-3">
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                            {{ $user->status === 'active'
                                                ? 'bg-green-100 text-green-800'
                                                : ($user->status === 'inactive'
                                                    ? 'bg-red-100 text-red-800'
                                                    : 'bg-yellow-100 text-yellow-800') }}">
                                                <i
                                                    class="fas
                                                {{ $user->status === 'active'
                                                    ? 'fa-check-circle'
                                                    : ($user->status === 'inactive'
                                                        ? 'fa-times-circle'
                                                        : 'fa-clock') }}
                                                mr-1 text-xs">
                                                </i>
                                                {{ ucfirst($user->status) }}
                                            </span>
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                                <i class="fas fa-user-tag mr-1 text-xs"></i>
                                                {{ ucfirst($user->roles->first()->name ?? 'No Role') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="p-6">
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                    <!-- Basic Information -->
                                    <div class="space-y-6">
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                                <i class="fas fa-user-circle text-blue-600 mr-2"></i>
                                                Basic Information
                                            </h3>

                                            <div class="space-y-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-2">Full Name
                                                        *</label>
                                                    <input type="text" name="name"
                                                        value="{{ old('name', $user->name) }}" required
                                                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
                                                    @error('name')
                                                        <p class="text-red-500 text-sm mt-1 flex items-center">
                                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                                            {{ $message }}
                                                        </p>
                                                    @enderror
                                                </div>

                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email
                                                        Address *</label>
                                                    <input type="email" name="email"
                                                        value="{{ old('email', $user->email) }}" required
                                                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
                                                    @error('email')
                                                        <p class="text-red-500 text-sm mt-1 flex items-center">
                                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                                            {{ $message }}
                                                        </p>
                                                    @enderror
                                                </div>

                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone
                                                        Number</label>
                                                    <input type="tel" name="phone"
                                                        value="{{ old('phone', $user->phone) }}"
                                                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                                        placeholder="+1 (555) 123-4567">
                                                    @error('phone')
                                                        <p class="text-red-500 text-sm mt-1 flex items-center">
                                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                                            {{ $message }}
                                                        </p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Account Settings -->
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                                <i class="fas fa-cog text-blue-600 mr-2"></i>
                                                Account Settings
                                            </h3>

                                            <div class="space-y-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-2">Role
                                                        *</label>
                                                    <select name="role" required
                                                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
                                                        <option value="">Select Role</option>
                                                        @foreach ($roles as $role)
                                                            <option value="{{ $role->name }}"
                                                                {{ old('role', $user->roles->first()->name ?? '') == $role->name ? 'selected' : '' }}>
                                                                {{ ucfirst($role->name) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('role')
                                                        <p class="text-red-500 text-sm mt-1 flex items-center">
                                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                                            {{ $message }}
                                                        </p>
                                                    @enderror
                                                </div>

                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-2">Status
                                                        *</label>
                                                    <select name="status" required
                                                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
                                                        <option value="">Select Status</option>
                                                        <option value="active"
                                                            {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>
                                                            Active</option>
                                                        <option value="inactive"
                                                            {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>
                                                            Inactive</option>
                                                        <option value="pending"
                                                            {{ old('status', $user->status) == 'pending' ? 'selected' : '' }}>
                                                            Pending</option>
                                                    </select>
                                                    @error('status')
                                                        <p class="text-red-500 text-sm mt-1 flex items-center">
                                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                                            {{ $message }}
                                                        </p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Security & Additional Info -->
                                    <div class="space-y-6">
                                        <!-- Password Update -->
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                                <i class="fas fa-lock text-blue-600 mr-2"></i>
                                                Security Settings
                                            </h3>

                                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                                                <div class="flex items-start">
                                                    <i class="fas fa-info-circle text-yellow-600 mt-0.5 mr-3"></i>
                                                    <div class="text-sm text-yellow-800">
                                                        <p class="font-medium">Password Update</p>
                                                        <p class="mt-1">Leave password fields blank to keep the current
                                                            password.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="space-y-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-2">New
                                                        Password</label>
                                                    <div class="relative">
                                                        <input type="password" name="password" id="password"
                                                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                                            placeholder="Enter new password">
                                                        <button type="button" onclick="togglePassword('password')"
                                                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </div>
                                                    @error('password')
                                                        <p class="text-red-500 text-sm mt-1 flex items-center">
                                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                                            {{ $message }}
                                                        </p>
                                                    @enderror
                                                </div>

                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-2">Confirm New
                                                        Password</label>
                                                    <div class="relative">
                                                        <input type="password" name="password_confirmation"
                                                            id="password_confirmation"
                                                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                                            placeholder="Confirm new password">
                                                        <button type="button"
                                                            onclick="togglePassword('password_confirmation')"
                                                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Additional Information -->
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                                <i class="fas fa-address-card text-blue-600 mr-2"></i>
                                                Additional Information
                                            </h3>

                                            <div class="space-y-4">
                                                <div>
                                                    <label
                                                        class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                                                    <textarea name="address" rows="3"
                                                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors resize-none"
                                                        placeholder="Enter full address">{{ old('address', $user->address) }}</textarea>
                                                    @error('address')
                                                        <p class="text-red-500 text-sm mt-1 flex items-center">
                                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                                            {{ $message }}
                                                        </p>
                                                    @enderror
                                                </div>

                                                <!-- User Metadata -->
                                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                                    <h4 class="text-sm font-medium text-gray-900 mb-3">Account Information
                                                    </h4>
                                                    <div class="space-y-2 text-sm">
                                                        <div class="flex justify-between">
                                                            <span class="text-gray-600">Member Since:</span>
                                                            <span
                                                                class="font-medium text-gray-900">{{ $user->created_at->format('M d, Y') }}</span>
                                                        </div>
                                                        <div class="flex justify-between">
                                                            <span class="text-gray-600">Last Updated:</span>
                                                            <span
                                                                class="font-medium text-gray-900">{{ $user->updated_at->format('M d, Y') }}</span>
                                                        </div>
                                                        <div class="flex justify-between">
                                                            <span class="text-gray-600">Last Login:</span>
                                                            <span class="font-medium text-gray-900">
                                                                {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-200">
                                    <a href="{{ route('admin.users.index') }}"
                                        class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-medium flex items-center gap-2">
                                        <i class="fas fa-times"></i>
                                        Cancel
                                    </a>
                                    <button type="submit"
                                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium flex items-center gap-2 shadow-sm">
                                        <i class="fas fa-save"></i>
                                        Update User
                                    </button>
                                </div>
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
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('avatarPreview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = field.nextElementSibling.querySelector('i');

            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Add some interactivity
        document.addEventListener('DOMContentLoaded', function() {
            // Add loading state to form submission
            const form = document.querySelector('form');
            form.addEventListener('submit', function() {
                const submitBtn = form.querySelector('button[type="submit"]');
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Updating...';
                submitBtn.disabled = true;
            });
        });
    </script>
@endpush

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            ring: 2px;
        }

        .transition-colors {
            transition: all 0.2s ease-in-out;
        }
    </style>
@endpush
