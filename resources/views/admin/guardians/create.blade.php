@extends('layouts.app')

@section('title', 'Add New Guardian')

@section('content')
    <div class="min-h-screen bg-gray-50 flex">
        <x-admin-sidebar active-route="admin.guardians.index" />

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Add New Guardian</h1>
                <p class="mt-1 text-sm text-gray-600">Create a new guardian profile</p>
            </div>

            <!-- Display Validation Errors -->
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
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

            <div class="bg-white shadow rounded-lg">
                <form action="{{ route('admin.guardians.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="space-y-6 p-6">
                        <!-- Avatar Upload -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Profile Picture</h3>
                            <div class="flex items-center space-x-6">
                                <div class="relative">
                                    <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-white shadow-lg">
                                        <img id="avatarPreview"
                                            src="https://ui-avatars.com/api/?name=Guardian&color=FFFFFF&background=4F46E5&size=96"
                                            alt="Avatar Preview" class="w-full h-full object-cover">
                                    </div>
                                    <div id="avatarLoading"
                                        class="hidden absolute inset-0 bg-gray-800 bg-opacity-50 rounded-full flex items-center justify-center">
                                        <i class="fas fa-spinner fa-spin text-white text-xl"></i>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="mb-3">
                                        <input type="file" name="avatar" id="avatar" accept="image/*" class="hidden">
                                        <button type="button" onclick="document.getElementById('avatar').click()"
                                            class="cursor-pointer bg-white border border-gray-300 text-gray-700 px-4 py-2.5 rounded-lg hover:bg-gray-50 transition-colors flex items-center gap-2 inline-flex">
                                            <i class="fas fa-upload"></i>
                                            Upload Profile Picture
                                        </button>
                                    </div>
                                    <p class="text-xs text-gray-500">
                                        Maximum file size: 2MB. Allowed formats: JPG, PNG, GIF.
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        For a better result, use a square image (e.g., 400x400 pixels).
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Personal Information -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Personal Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="first_name" class="block text-sm font-medium text-gray-700">First Name
                                        *</label>
                                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                        required>
                                </div>
                                <div>
                                    <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name
                                        *</label>
                                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                        required>
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                        required>
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                                    <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700">Password *</label>
                                    <input type="password" name="password" id="password"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                        required>
                                    <div id="passwordStrength" class="mt-1 text-xs"></div>
                                </div>
                                <div>
                                    <label for="password_confirmation"
                                        class="block text-sm font-medium text-gray-700">Confirm Password *</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                        required>
                                </div>
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700">Status *</label>
                                    <select name="status" id="status"
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        required>
                                        <option value="">Select Status</option>
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="on_leave" {{ old('status') == 'on_leave' ? 'selected' : '' }}>On
                                            Leave</option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                            Inactive</option>
                                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending
                                        </option>
                                    </select>
                                </div>
                                <div>
                                    <label for="guardian_id" class="block text-sm font-medium text-gray-700">Guardian ID
                                        *</label>
                                    <input type="text" name="guardian_id" id="guardian_id"
                                        value="{{ old('guardian_id') }}"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                        required>
                                    @error('guardian_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Guardian Details -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Guardian Details</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="relationship" class="block text-sm font-medium text-gray-700">Relationship
                                        *</label>
                                    <select name="relationship" id="relationship"
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        required>
                                        <option value="">Select Relationship</option>
                                        <option value="Parent" {{ old('relationship') == 'Parent' ? 'selected' : '' }}>
                                            Parent</option>
                                        <option value="Guardian"
                                            {{ old('relationship') == 'Guardian' ? 'selected' : '' }}>Guardian</option>
                                        <option value="Grandparent"
                                            {{ old('relationship') == 'Grandparent' ? 'selected' : '' }}>Grandparent
                                        </option>
                                        <option value="Aunt/Uncle"
                                            {{ old('relationship') == 'Aunt/Uncle' ? 'selected' : '' }}>Aunt/Uncle</option>
                                        <option value="Sibling" {{ old('relationship') == 'Sibling' ? 'selected' : '' }}>
                                            Sibling</option>
                                        <option value="Other" {{ old('relationship') == 'Other' ? 'selected' : '' }}>
                                            Other</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="occupation"
                                        class="block text-sm font-medium text-gray-700">Occupation</label>
                                    <input type="text" name="occupation" id="occupation"
                                        value="{{ old('occupation') }}"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label for="employer" class="block text-sm font-medium text-gray-700">Employer</label>
                                    <input type="text" name="employer" id="employer" value="{{ old('employer') }}"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label for="work_phone" class="block text-sm font-medium text-gray-700">Work
                                        Phone</label>
                                    <input type="tel" name="work_phone" id="work_phone"
                                        value="{{ old('work_phone') }}"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label for="work_email" class="block text-sm font-medium text-gray-700">Work
                                        Email</label>
                                    <input type="email" name="work_email" id="work_email"
                                        value="{{ old('work_email') }}"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>
                        </div>

                        <!-- Emergency Contact -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Emergency Contact Information
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="emergency_contact_name"
                                        class="block text-sm font-medium text-gray-700">Emergency Contact Name</label>
                                    <input type="text" name="emergency_contact_name" id="emergency_contact_name"
                                        value="{{ old('emergency_contact_name') }}"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label for="emergency_contact_phone"
                                        class="block text-sm font-medium text-gray-700">Emergency Contact Phone</label>
                                    <input type="tel" name="emergency_contact_phone" id="emergency_contact_phone"
                                        value="{{ old('emergency_contact_phone') }}"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label for="emergency_contact_relationship"
                                        class="block text-sm font-medium text-gray-700">Relationship</label>
                                    <input type="text" name="emergency_contact_relationship"
                                        id="emergency_contact_relationship"
                                        value="{{ old('emergency_contact_relationship') }}"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>
                        </div>

                        <!-- Preferences & Permissions -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Preferences & Permissions</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                                <div class="flex items-center">
                                    <input type="hidden" name="is_primary" value="0">
                                    <input type="checkbox" name="is_primary" id="is_primary" value="1"
                                        {{ old('is_primary', 0) == '1' ? 'checked' : '' }}
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="is_primary" class="ml-2 block text-sm text-gray-900">Primary
                                        Contact</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="hidden" name="can_pickup" value="0">
                                    <input type="checkbox" name="can_pickup" id="can_pickup" value="1"
                                        {{ old('can_pickup', 0) == '1' ? 'checked' : '' }}
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="can_pickup" class="ml-2 block text-sm text-gray-900">Can Pickup</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="hidden" name="receive_sms_alerts" value="0">
                                    <input type="checkbox" name="receive_sms_alerts" id="receive_sms_alerts"
                                        value="1" {{ old('receive_sms_alerts', 1) == '1' ? 'checked' : '' }}
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="receive_sms_alerts" class="ml-2 block text-sm text-gray-900">SMS
                                        Alerts</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="hidden" name="receive_email_alerts" value="0">
                                    <input type="checkbox" name="receive_email_alerts" id="receive_email_alerts"
                                        value="1" {{ old('receive_email_alerts', 1) == '1' ? 'checked' : '' }}
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="receive_email_alerts" class="ml-2 block text-sm text-gray-900">Email
                                        Alerts</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" name="is_active" id="is_active" value="1"
                                        {{ old('is_active', 1) == '1' ? 'checked' : '' }}
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="is_active" class="ml-2 block text-sm text-gray-900">Active</label>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Notes -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Additional Information</h3>
                            <div class="space-y-6">
                                <div>
                                    <label for="medical_notes" class="block text-sm font-medium text-gray-700">Medical
                                        Notes</label>
                                    <textarea name="medical_notes" id="medical_notes" rows="3"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('medical_notes') }}</textarea>
                                </div>
                                <div>
                                    <label for="notes" class="block text-sm font-medium text-gray-700">Additional
                                        Notes</label>
                                    <textarea name="notes" id="notes" rows="3"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('notes') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Associated Students -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Associated Students</h3>
                            <p class="text-sm text-gray-500 mb-4">Select students that this guardian is responsible for</p>
                            <div class="space-y-4" id="students-container">
                                <div class="flex items-center space-x-4">
                                    <select name="student_ids[]"
                                        class="flex-1 py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option value="">Select Student</option>
                                        @foreach ($students as $student)
                                            <option value="{{ $student->id }}"
                                                {{ in_array($student->id, old('student_ids', [])) ? 'selected' : '' }}>
                                                {{ $student->user->name ?? $student->full_name }}
                                                ({{ $student->student_id ?? 'N/A' }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="button" onclick="addStudentField()"
                                        class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <i class="fas fa-plus mr-1"></i> Add Student
                                    </button>
                                </div>
                            </div>
                            <p class="mt-2 text-xs text-gray-500">Leave blank if not associated with any students yet</p>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="px-6 py-3 bg-gray-50 text-right sm:px-6 rounded-b-lg">
                        <a href="{{ route('admin.guardians.index') }}"
                            class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-3">
                            Cancel
                        </a>
                        <button type="submit"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Create Guardian
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
@endpush

@push('scripts')
    <script>
        let studentCount = 1;

        function addStudentField() {
            studentCount++;
            const container = document.getElementById('students-container');
            const newField = document.createElement('div');
            newField.className = 'flex items-center space-x-4 mt-2';
            newField.innerHTML = `
                <select name="student_ids[]"
                        class="flex-1 py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">Select Student</option>
                    @foreach ($students as $student)
                    <option value="{{ $student->id }}">{{ $student->user->name ?? $student->full_name }} ({{ $student->student_id ?? 'N/A' }})</option>
                    @endforeach
                </select>
                <button type="button"
                        onclick="this.parentElement.remove()"
                        class="inline-flex items-center px-3 py-2 border border-red-300 shadow-sm text-sm leading-4 font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <i class="fas fa-trash mr-1"></i> Remove
                </button>
            `;
            container.appendChild(newField);
        }

        // Avatar preview functionality
        document.addEventListener('DOMContentLoaded', function() {
            const avatarInput = document.getElementById('avatar');
            const avatarPreview = document.getElementById('avatarPreview');
            const avatarLoading = document.getElementById('avatarLoading');

            if (avatarInput) {
                avatarInput.addEventListener('change', function(event) {
                    const file = event.target.files[0];
                    const maxSize = 2 * 1024 * 1024; // 2MB

                    if (!file) return;

                    // Check file size
                    if (file.size > maxSize) {
                        alert('File size exceeds 2MB limit. Please choose a smaller file.');
                        this.value = '';
                        return;
                    }

                    // Check file type
                    const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
                    if (!validTypes.includes(file.type)) {
                        alert('Only JPG, PNG, and GIF files are allowed.');
                        this.value = '';
                        return;
                    }

                    // Show loading
                    avatarLoading.classList.remove('hidden');

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        avatarPreview.src = e.target.result;
                        avatarLoading.classList.add('hidden');
                    };
                    reader.onerror = function() {
                        avatarLoading.classList.add('hidden');
                        alert('Error reading file. Please try another image.');
                        avatarInput.value = '';
                    };
                    reader.readAsDataURL(file);
                });
            }

            // Password strength indicator
            const passwordInput = document.getElementById('password');
            const passwordStrength = document.getElementById('passwordStrength');

            if (passwordInput && passwordStrength) {
                passwordInput.addEventListener('input', function() {
                    const password = this.value;

                    if (!password) {
                        passwordStrength.innerHTML = '';
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

                    passwordStrength.innerHTML =
                        `<span style="color: ${color}; font-weight: bold;">${text}</span>`;
                });
            }
        });
    </script>
@endpush
