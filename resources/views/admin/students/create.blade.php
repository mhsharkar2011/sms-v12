@extends('layouts.app')

@section('title', 'Add New Student')

@section('content')
    <div class="min-h-screen bg-gray-50 flex">
        <x-admin-sidebar active-route="admin.students.index" />

        <div class="flex-1 overflow-auto">
            <!-- Header -->
            <div class="bg-white shadow-sm border-b border-gray-200">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Add New Student</h1>
                            <p class="text-gray-600 mt-1">Create a new student account with user credentials</p>
                        </div>
                        <div class="flex items-center space-x-4">
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
                        <form action="{{ route('admin.students.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Student Basic Information Section -->
                            <div class="p-6 border-b border-gray-200">
                                <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center gap-2">
                                    <i class="fas fa-user-graduate text-blue-600"></i>
                                    Student Basic Information
                                </h2>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <!-- First Name -->
                                    <div>
                                        <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">
                                            First Name *
                                        </label>
                                        <input type="text" name="first_name" id="first_name"
                                            value="{{ old('first_name') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('first_name') border-red-500 @enderror"
                                            placeholder="Enter first name" required>
                                        @error('first_name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Last Name -->
                                    <div>
                                        <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">
                                            Last Name *
                                        </label>
                                        <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('last_name') border-red-500 @enderror"
                                            placeholder="Enter last name" required>
                                        @error('last_name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                            Email Address *
                                        </label>
                                        <input type="email" name="email" id="email" value="{{ old('email') }}"
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
                                        <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
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
                                            value="{{ old('date_of_birth') }}"
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
                                </div>
                            </div>

                            <!-- Account Information Section -->
                            <div class="p-6 border-b border-gray-200">
                                <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center gap-2">
                                    <i class="fas fa-lock text-green-600"></i>
                                    Account Information
                                </h2>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Password -->
                                    <div>
                                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                            Password *
                                        </label>
                                        <input type="password" name="password" id="password"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror"
                                            placeholder="Enter password" required>
                                        @error('password')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        <div id="passwordStrength" class="mt-1 text-xs"></div>
                                    </div>

                                    <!-- Confirm Password -->
                                    <div>
                                        <label for="password_confirmation"
                                            class="block text-sm font-medium text-gray-700 mb-2">
                                            Confirm Password *
                                        </label>
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="Confirm password" required>
                                    </div>
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
                                            value="{{ old('admission_number', \App\Models\Student::generateAdmissionNumber()) }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('admission_number') border-red-500 @enderror"
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
                                            value="{{ old('student_id', \App\Models\Student::generateStudentId()) }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('student_id') border-red-500 @enderror"
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
                                            @foreach ($classes ?? [] as $class)
                                                <option value="{{ $class->id }}"
                                                    {{ old('class_id') == $class->id ? 'selected' : '' }}>
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
                                                    {{ old('grade_level') == $level ? 'selected' : '' }}>
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
                                            value="{{ old('roll_number') }}"
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
                                            value="{{ old('section') }}"
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
                                            value="{{ old('academic_year', date('Y') . '-' . (date('Y') + 1)) }}"
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
                                            value="{{ old('admission_date', date('Y-m-d')) }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('admission_date') border-red-500 @enderror"
                                            required>
                                        @error('admission_date')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Personal Details Section -->
                            <div class="p-6 border-b border-gray-200">
                                <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center gap-2">
                                    <i class="fas fa-id-card text-orange-600"></i>
                                    Personal Details
                                </h2>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <!-- Blood Group -->
                                    <div>
                                        <label for="blood_group" class="block text-sm font-medium text-gray-700 mb-2">
                                            Blood Group
                                        </label>
                                        <select name="blood_group" id="blood_group"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            <option value="">Select Blood Group</option>
                                            <option value="A+" {{ old('blood_group') == 'A+' ? 'selected' : '' }}>A+
                                            </option>
                                            <option value="A-" {{ old('blood_group') == 'A-' ? 'selected' : '' }}>A-
                                            </option>
                                            <option value="B+" {{ old('blood_group') == 'B+' ? 'selected' : '' }}>B+
                                            </option>
                                            <option value="B-" {{ old('blood_group') == 'B-' ? 'selected' : '' }}>B-
                                            </option>
                                            <option value="AB+" {{ old('blood_group') == 'AB+' ? 'selected' : '' }}>AB+
                                            </option>
                                            <option value="AB-" {{ old('blood_group') == 'AB-' ? 'selected' : '' }}>AB-
                                            </option>
                                            <option value="O+" {{ old('blood_group') == 'O+' ? 'selected' : '' }}>O+
                                            </option>
                                            <option value="O-" {{ old('blood_group') == 'O-' ? 'selected' : '' }}>O-
                                            </option>
                                        </select>
                                    </div>

                                    <!-- Nationality -->
                                    <div>
                                        <label for="nationality" class="block text-sm font-medium text-gray-700 mb-2">
                                            Nationality
                                        </label>
                                        <input type="text" name="nationality" id="nationality"
                                            value="{{ old('nationality', 'Indian') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="Nationality">
                                    </div>

                                    <!-- Religion -->
                                    <div>
                                        <label for="religion" class="block text-sm font-medium text-gray-700 mb-2">
                                            Religion
                                        </label>
                                        <input type="text" name="religion" id="religion"
                                            value="{{ old('religion') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="Religion">
                                    </div>

                                    <!-- Caste -->
                                    <div>
                                        <label for="caste" class="block text-sm font-medium text-gray-700 mb-2">
                                            Caste
                                        </label>
                                        <input type="text" name="caste" id="caste" value="{{ old('caste') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="Caste">
                                    </div>
                                </div>
                            </div>

                            <!-- Address Information Section -->
                            <div class="p-6 border-b border-gray-200">
                                <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center gap-2">
                                    <i class="fas fa-home text-indigo-600"></i>
                                    Address Information
                                </h2>

                                <div class="grid grid-cols-1 gap-6">
                                    <!-- Address -->
                                    <div>
                                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                                            Address
                                        </label>
                                        <textarea name="address" id="address" rows="3"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="Enter full address">{{ old('address') }}</textarea>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                                        <!-- City -->
                                        <div>
                                            <label for="city" class="block text-sm font-medium text-gray-700 mb-2">
                                                City
                                            </label>
                                            <input type="text" name="city" id="city"
                                                value="{{ old('city') }}"
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                placeholder="City">
                                        </div>

                                        <!-- State -->
                                        <div>
                                            <label for="state" class="block text-sm font-medium text-gray-700 mb-2">
                                                State
                                            </label>
                                            <input type="text" name="state" id="state"
                                                value="{{ old('state') }}"
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                placeholder="State">
                                        </div>

                                        <!-- Pincode -->
                                        <div>
                                            <label for="pincode" class="block text-sm font-medium text-gray-700 mb-2">
                                                Pincode
                                            </label>
                                            <input type="text" name="pincode" id="pincode"
                                                value="{{ old('pincode') }}"
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                placeholder="Pincode">
                                        </div>

                                        <!-- Country -->
                                        <div>
                                            <label for="country" class="block text-sm font-medium text-gray-700 mb-2">
                                                Country
                                            </label>
                                            <input type="text" name="country" id="country"
                                                value="{{ old('country', 'India') }}"
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                placeholder="Country">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Emergency Contact Section -->
                            <div class="p-6 border-b border-gray-200">
                                <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center gap-2">
                                    <i class="fas fa-phone-alt text-red-600"></i>
                                    Emergency Contact
                                </h2>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <!-- Emergency Contact Name -->
                                    <div>
                                        <label for="emergency_contact_name"
                                            class="block text-sm font-medium text-gray-700 mb-2">
                                            Contact Name
                                        </label>
                                        <input type="text" name="emergency_contact_name" id="emergency_contact_name"
                                            value="{{ old('emergency_contact_name') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="Emergency contact name">
                                    </div>

                                    <!-- Emergency Contact Phone -->
                                    <div>
                                        <label for="emergency_contact_phone"
                                            class="block text-sm font-medium text-gray-700 mb-2">
                                            Contact Phone
                                        </label>
                                        <input type="tel" name="emergency_contact_phone" id="emergency_contact_phone"
                                            value="{{ old('emergency_contact_phone') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="Emergency phone number">
                                    </div>

                                    <!-- Emergency Contact Relation -->
                                    <div>
                                        <label for="emergency_contact_relation"
                                            class="block text-sm font-medium text-gray-700 mb-2">
                                            Relation
                                        </label>
                                        <input type="text" name="emergency_contact_relation"
                                            id="emergency_contact_relation"
                                            value="{{ old('emergency_contact_relation') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="Relation (e.g., Father, Mother)">
                                    </div>
                                </div>
                            </div>

                            <!-- Medical Information Section -->
                            <div class="p-6 border-b border-gray-200">
                                <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center gap-2">
                                    <i class="fas fa-heartbeat text-pink-600"></i>
                                    Medical Information
                                </h2>

                                <div class="grid grid-cols-1 gap-6">
                                    <!-- Medical Notes -->
                                    <div>
                                        <label for="medical_notes" class="block text-sm font-medium text-gray-700 mb-2">
                                            Medical Notes
                                        </label>
                                        <textarea name="medical_notes" id="medical_notes" rows="3"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="Any medical conditions or notes">{{ old('medical_notes') }}</textarea>
                                    </div>

                                    <!-- Allergies -->
                                    <div>
                                        <label for="allergies" class="block text-sm font-medium text-gray-700 mb-2">
                                            Allergies (comma separated)
                                        </label>
                                        <input type="text" name="allergies" id="allergies"
                                            value="{{ old('allergies') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="e.g., Peanuts, Dust, Pollen">
                                    </div>

                                    <!-- Medications -->
                                    <div>
                                        <label for="medications" class="block text-sm font-medium text-gray-700 mb-2">
                                            Medications (comma separated)
                                        </label>
                                        <input type="text" name="medications" id="medications"
                                            value="{{ old('medications') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="e.g., Inhaler, Insulin">
                                    </div>

                                    <!-- Special Instructions -->
                                    <div>
                                        <label for="special_instructions"
                                            class="block text-sm font-medium text-gray-700 mb-2">
                                            Special Instructions
                                        </label>
                                        <textarea name="special_instructions" id="special_instructions" rows="2"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="Any special instructions">{{ old('special_instructions') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Options Section -->
                            <div class="p-6 border-b border-gray-200">
                                <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center gap-2">
                                    <i class="fas fa-cog text-gray-600"></i>
                                    Additional Options
                                </h2>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <!-- Transport Route -->
                                    <div>
                                        <label for="transport_route" class="block text-sm font-medium text-gray-700 mb-2">
                                            Transport Route
                                        </label>
                                        <input type="text" name="transport_route" id="transport_route"
                                            value="{{ old('transport_route') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="Transport route">
                                    </div>

                                    <!-- Boarding Status -->
                                    <div class="flex items-center space-x-3">
                                        <input type="checkbox" name="is_boarder" id="is_boarder" value="1"
                                            {{ old('is_boarder') ? 'checked' : '' }}
                                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <label for="is_boarder" class="text-sm font-medium text-gray-700">
                                            Is Boarder Student
                                        </label>
                                    </div>

                                    <!-- Transport Usage -->
                                    <div class="flex items-center space-x-3">
                                        <input type="checkbox" name="uses_transport" id="uses_transport" value="1"
                                            {{ old('uses_transport') ? 'checked' : '' }}
                                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <label for="uses_transport" class="text-sm font-medium text-gray-700">
                                            Uses School Transport
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Profile & Status Section -->
                            <div class="p-6">
                                <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center gap-2">
                                    <i class="fas fa-user-circle text-teal-600"></i>
                                    Profile & Status
                                </h2>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Profile Photo -->
                                    <div>
                                        <label for="avatar" class="block text-sm font-medium text-gray-700 mb-2">
                                            Profile Photo
                                        </label>
                                        <div class="flex items-center space-x-4">
                                            <div
                                                class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center overflow-hidden border-2 border-dashed border-gray-300">
                                                <img id="avatarPreview" src="" alt="Preview"
                                                    class="hidden w-full h-full object-cover">
                                                <i class="fas fa-user text-gray-400 text-2xl" id="avatarPlaceholder"></i>
                                            </div>
                                            <div class="flex-1">
                                                <input type="file" name="avatar" id="avatar" accept="image/*"
                                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                    onchange="previewImage(this)">
                                                <p class="mt-1 text-xs text-gray-500">JPG, PNG or GIF (Max: 2MB)</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Status -->
                                    <div>
                                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                            Account Status *
                                        </label>
                                        <select name="status" id="status"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            required>
                                            <option value="active"
                                                {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                                Inactive</option>
                                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>
                                                Pending</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                                <div class="flex items-center justify-between">
                                    <a href="{{ route('admin.students.index') }}"
                                        class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors flex items-center gap-2">
                                        <i class="fas fa-times"></i>
                                        Cancel
                                    </a>
                                    <div class="flex space-x-3">
                                        <button type="button" onclick="resetForm()"
                                            class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors flex items-center gap-2">
                                            <i class="fas fa-redo"></i>
                                            Reset Form
                                        </button>
                                        <button type="submit"
                                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
                                            <i class="fas fa-user-plus"></i>
                                            Create Student
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Help Text -->
                    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-xl p-4">
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-info-circle text-blue-600 text-sm mt-0.5"></i>
                            <div>
                                <h3 class="text-sm font-medium text-blue-900">Creating a New Student</h3>
                                <ul class="mt-2 text-sm text-blue-800 list-disc list-inside space-y-1">
                                    <li>All fields marked with * are required</li>
                                    <li>Student ID and Admission Number are auto-generated</li>
                                    <li>Student will be created with a user account for system access</li>
                                    <li>Medical information is important for emergency situations</li>
                                    <li>Emergency contact details are crucial for safety</li>
                                </ul>
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
@endpush

@push('scripts')
    <script>
        function previewImage(input) {
            const preview = document.getElementById('avatarPreview');
            const placeholder = document.getElementById('avatarPlaceholder');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                }

                reader.readAsDataURL(input.files[0]);
            } else {
                preview.classList.add('hidden');
                placeholder.classList.remove('hidden');
            }
        }

        function resetForm() {
            if (confirm('Are you sure you want to reset the form? All entered data will be lost.')) {
                document.querySelector('form').reset();

                // Reset image preview
                const preview = document.getElementById('avatarPreview');
                const placeholder = document.getElementById('avatarPlaceholder');
                preview.classList.add('hidden');
                placeholder.classList.remove('hidden');

                // Reset auto-generated fields
                document.getElementById('admission_number').value = '{{ \App\Models\Student::generateAdmissionNumber() }}';
                document.getElementById('student_id').value = '{{ \App\Models\Student::generateStudentId() }}';
                document.getElementById('academic_year').value = '{{ date('Y') . '-' . (date('Y') + 1) }}';
                document.getElementById('admission_date').value = '{{ date('Y-m-d') }}';
                document.getElementById('status').value = 'active';
            }
        }

        // Password strength indicator
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthIndicator = document.getElementById('passwordStrength');

            let strength = 'Weak';
            let color = 'text-red-600';

            if (password.length >= 8) {
                strength = 'Medium';
                color = 'text-yellow-600';
            }
            if (password.length >= 12 && /[A-Z]/.test(password) && /[0-9]/.test(password) && /[^A-Za-z0-9]/.test(
                    password)) {
                strength = 'Strong';
                color = 'text-green-600';
            }

            strengthIndicator.innerHTML = `<span class="${color}">${strength} password</span>`;
        });

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;

            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Passwords do not match. Please check your entries.');
                document.getElementById('password_confirmation').focus();
            }
        });

        // Set max date for date of birth (at least 5 years old)
        window.addEventListener('load', function() {
            const today = new Date();
            const maxDate = new Date(today.getFullYear() - 5, today.getMonth(), today.getDate());
            document.getElementById('date_of_birth').max = maxDate.toISOString().split('T')[0];

            // Set min date for date of birth (reasonable limit)
            const minDate = new Date(today.getFullYear() - 25, today.getMonth(), today.getDate());
            document.getElementById('date_of_birth').min = minDate.toISOString().split('T')[0];
        });

        // Auto-fill name for user account
        document.getElementById('first_name').addEventListener('blur', function() {
            const firstName = this.value.trim();
            const lastName = document.getElementById('last_name').value.trim();

            if (firstName && lastName) {
                // This will be used to create the user account name
                console.log('Full name:', firstName + ' ' + lastName);
            }
        });
    </script>
@endpush
