@extends('layouts.app')

@section('title', 'Admin Profile')

@section('content')
    <div class="min-h-screen bg-gray-50 flex">
        <x-admin-sidebar active-route="admin.profile" />

        <div class="flex-1 overflow-auto">
            <!-- Header -->
            <div class="bg-white shadow-sm border-b border-gray-200">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">My Profile</h1>
                            <p class="text-gray-600 mt-1">Manage your account settings and preferences</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                <i class="fas fa-shield-alt mr-2"></i>
                                Administrator
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container mx-auto p-6">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Left Column - Profile Info -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Personal Information Card -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h2 class="text-lg font-semibold text-gray-900">Personal Information</h2>
                                <p class="text-sm text-gray-600 mt-1">Update your personal details and contact information</p>
                            </div>
                            <div class="p-6">
                                <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Avatar Upload -->
                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-medium text-gray-700 mb-4">Profile Picture</label>
                                            <div class="flex items-center space-x-6">
                                                <div class="relative">
                                                    <img id="avatar-preview"
                                                         class="h-24 w-24 rounded-2xl object-cover border-2 border-white shadow-lg"
                                                         src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('images/default-avatar.png') }}"
                                                         alt="{{ auth()->user()->name }}">
                                                    <div class="absolute -bottom-2 -right-2 w-6 h-6 bg-green-400 border-2 border-white rounded-full"></div>
                                                </div>
                                                <div class="flex-1">
                                                    <input type="file"
                                                           name="avatar"
                                                           id="avatar"
                                                           accept="image/*"
                                                           class="hidden"
                                                           onchange="previewImage(this)">
                                                    <label for="avatar"
                                                           class="cursor-pointer bg-white border border-gray-300 rounded-lg px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors inline-flex items-center gap-2">
                                                        <i class="fas fa-camera"></i>
                                                        Change Photo
                                                    </label>
                                                    <p class="text-xs text-gray-500 mt-2">JPG, PNG or GIF. Max size 2MB.</p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Name -->
                                        <div>
                                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                                            <input type="text"
                                                   name="name"
                                                   id="name"
                                                   value="{{ old('name', auth()->user()->name) }}"
                                                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                                   required>
                                            @error('name')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Email -->
                                        <div>
                                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                                            <input type="email"
                                                   name="email"
                                                   id="email"
                                                   value="{{ old('email', auth()->user()->email) }}"
                                                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                                   required>
                                            @error('email')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Phone -->
                                        <div>
                                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                            <input type="tel"
                                                   name="phone"
                                                   id="phone"
                                                   value="{{ old('phone', auth()->user()->phone) }}"
                                                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
                                            @error('phone')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Address -->
                                        <div class="md:col-span-2">
                                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                                            <textarea name="address"
                                                      id="address"
                                                      rows="3"
                                                      class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors resize-none">{{ old('address', auth()->user()->address) }}</textarea>
                                            @error('address')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Bio -->
                                        <div class="md:col-span-2">
                                            <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
                                            <textarea name="bio"
                                                      id="bio"
                                                      rows="3"
                                                      placeholder="Tell us a little about yourself..."
                                                      class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors resize-none">{{ old('bio', auth()->user()->bio) }}</textarea>
                                            @error('bio')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                                        <button type="button"
                                                class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-medium">
                                            Cancel
                                        </button>
                                        <button type="submit"
                                                class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium flex items-center gap-2">
                                            <i class="fas fa-save"></i>
                                            Save Changes
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Security Settings Card -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h2 class="text-lg font-semibold text-gray-900">Security Settings</h2>
                                <p class="text-sm text-gray-600 mt-1">Manage your password and security preferences</p>
                            </div>
                            <div class="p-6">
                                <form action="{{ route('admin.profile.password') }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="space-y-4">
                                        <div>
                                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Current Password *</label>
                                            <input type="password"
                                                   name="current_password"
                                                   id="current_password"
                                                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                                   required>
                                            @error('current_password')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">New Password *</label>
                                                <input type="password"
                                                       name="password"
                                                       id="password"
                                                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                                       required>
                                                @error('password')
                                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div>
                                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password *</label>
                                                <input type="password"
                                                       name="password_confirmation"
                                                       id="password_confirmation"
                                                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                                       required>
                                            </div>
                                        </div>

                                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                            <div class="flex">
                                                <i class="fas fa-exclamation-triangle text-yellow-500 mt-0.5 mr-3"></i>
                                                <div>
                                                    <h4 class="text-sm font-medium text-yellow-800">Password Requirements</h4>
                                                    <ul class="text-xs text-yellow-700 mt-1 list-disc list-inside space-y-1">
                                                        <li>Minimum 8 characters</li>
                                                        <li>At least one uppercase letter</li>
                                                        <li>At least one number</li>
                                                        <li>At least one special character</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex justify-end mt-6 pt-6 border-t border-gray-200">
                                        <button type="submit"
                                                class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium flex items-center gap-2">
                                            <i class="fas fa-lock"></i>
                                            Update Password
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Sidebar -->
                    <div class="space-y-6">
                        <!-- Profile Summary Card -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <div class="text-center">
                                <div class="relative inline-block">
                                    <img class="h-20 w-20 rounded-2xl object-cover border-2 border-white shadow-lg mx-auto"
                                         src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('images/default-avatar.png') }}"
                                         alt="{{ auth()->user()->name }}">
                                    <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-400 border-2 border-white rounded-full"></div>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mt-4">{{ auth()->user()->name }}</h3>
                                <p class="text-sm text-gray-600">{{ auth()->user()->email }}</p>

                                <div class="mt-4 space-y-2">
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-gray-500">Role:</span>
                                        <span class="font-medium text-gray-900">Administrator</span>
                                    </div>
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-gray-500">Status:</span>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Active
                                        </span>
                                    </div>
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-gray-500">Member since:</span>
                                        <span class="font-medium text-gray-900">{{ auth()->user()->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-gray-500">Last login:</span>
                                        <span class="font-medium text-gray-900">{{ auth()->user()->last_login_at?->format('M d, Y') ?? 'Never' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions Card -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900">Quick Actions</h3>
                            </div>
                            <div class="p-4 space-y-2">
                                <a href="{{ route('admin.notifications') }}"
                                   class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 transition-colors group">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                                        <i class="fas fa-bell text-blue-600"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">Notifications</p>
                                        <p class="text-xs text-gray-500">Manage alerts</p>
                                    </div>
                                    <i class="fas fa-chevron-right text-gray-400 group-hover:text-gray-600"></i>
                                </a>

                                <a href="{{ route('admin.settings') }}"
                                   class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 transition-colors group">
                                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-200 transition-colors">
                                        <i class="fas fa-cog text-green-600"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">System Settings</p>
                                        <p class="text-xs text-gray-500">Platform configuration</p>
                                    </div>
                                    <i class="fas fa-chevron-right text-gray-400 group-hover:text-gray-600"></i>
                                </a>

                                <a href="{{ route('admin.reports') }}"
                                   class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 transition-colors group">
                                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                                        <i class="fas fa-chart-bar text-purple-600"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">Reports</p>
                                        <p class="text-xs text-gray-500">View analytics</p>
                                    </div>
                                    <i class="fas fa-chevron-right text-gray-400 group-hover:text-gray-600"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Activity Stats Card -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900">Activity Overview</h3>
                            </div>
                            <div class="p-6 space-y-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-users text-blue-600"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">Users Managed</p>
                                            <p class="text-xs text-gray-500">This month</p>
                                        </div>
                                    </div>
                                    <span class="text-lg font-bold text-blue-600">247</span>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-check-circle text-green-600"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">Tasks Completed</p>
                                            <p class="text-xs text-gray-500">This week</p>
                                        </div>
                                    </div>
                                    <span class="text-lg font-bold text-green-600">42</span>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-clock text-orange-600"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">Pending Actions</p>
                                            <p class="text-xs text-gray-500">Requires attention</p>
                                        </div>
                                    </div>
                                    <span class="text-lg font-bold text-orange-600">8</span>
                                </div>
                            </div>
                        </div>
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

    // Add some interactive features
    document.addEventListener('DOMContentLoaded', function() {
        // Password strength indicator
        const passwordInput = document.getElementById('password');
        if (passwordInput) {
            passwordInput.addEventListener('input', function() {
                const password = this.value;
                const strengthIndicator = document.getElementById('password-strength');

                if (!strengthIndicator) {
                    const indicator = document.createElement('div');
                    indicator.id = 'password-strength';
                    indicator.className = 'mt-2 text-xs font-medium';
                    this.parentNode.appendChild(indicator);
                }

                const strength = checkPasswordStrength(password);
                const indicator = document.getElementById('password-strength');
                indicator.textContent = strength.text;
                indicator.className = `mt-2 text-xs font-medium ${strength.color}`;
            });
        }
    });

    function checkPasswordStrength(password) {
        let strength = 0;

        if (password.length >= 8) strength++;
        if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
        if (password.match(/\d/)) strength++;
        if (password.match(/[^a-zA-Z\d]/)) strength++;

        switch(strength) {
            case 0:
            case 1:
                return { text: 'Very Weak', color: 'text-red-600' };
            case 2:
                return { text: 'Weak', color: 'text-orange-600' };
            case 3:
                return { text: 'Good', color: 'text-yellow-600' };
            case 4:
                return { text: 'Strong', color: 'text-green-600' };
            default:
                return { text: '', color: '' };
        }
    }
</script>
@endpush

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
@endpush
