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

            <div class="bg-white shadow rounded-lg">
                <form action="{{ route('admin.guardians.store') }}" method="POST">
                    @csrf

                    <div class="space-y-6 p-6">
                        <!-- Personal Information -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Personal Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="first_name" class="block text-sm font-medium text-gray-700">First Name
                                        *</label>
                                    <input type="text" name="first_name" id="first_name" required
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name
                                        *</label>
                                    <input type="text" name="last_name" id="last_name" required
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                                    <input type="email" name="email" id="email" required
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone *</label>
                                    <input type="tel" name="phone" id="phone" required
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>
                        </div>

                        <!-- Guardian Details -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Guardian Details</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="relationship"
                                        class="block text-sm font-medium text-gray-700">Relationship</label>
                                    <select name="relationship" id="relationship"
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option value="">Select Relationship</option>
                                        <option value="Parent">Parent</option>
                                        <option value="Guardian">Guardian</option>
                                        <option value="Grandparent">Grandparent</option>
                                        <option value="Aunt/Uncle">Aunt/Uncle</option>
                                        <option value="Sibling">Sibling</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="occupation"
                                        class="block text-sm font-medium text-gray-700">Occupation</label>
                                    <input type="text" name="occupation" id="occupation"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label for="employer" class="block text-sm font-medium text-gray-700">Employer</label>
                                    <input type="text" name="employer" id="employer"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label for="work_phone" class="block text-sm font-medium text-gray-700">Work
                                        Phone</label>
                                    <input type="tel" name="work_phone" id="work_phone"
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
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label for="emergency_contact_phone"
                                        class="block text-sm font-medium text-gray-700">Emergency Contact Phone</label>
                                    <input type="tel" name="emergency_contact_phone" id="emergency_contact_phone"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label for="emergency_contact_relationship"
                                        class="block text-sm font-medium text-gray-700">Relationship</label>
                                    <input type="text" name="emergency_contact_relationship"
                                        id="emergency_contact_relationship"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>
                        </div>

                        <!-- Preferences & Permissions -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Preferences & Permissions</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                                <div class="flex items-center">
                                    <input type="checkbox" name="is_primary" id="is_primary" value="1"
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="is_primary" class="ml-2 block text-sm text-gray-900">Primary Contact</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" name="can_pickup" id="can_pickup" value="1"
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="can_pickup" class="ml-2 block text-sm text-gray-900">Can Pickup</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" name="receive_sms_alerts" id="receive_sms_alerts"
                                        value="1"
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="receive_sms_alerts" class="ml-2 block text-sm text-gray-900">SMS
                                        Alerts</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" name="receive_email_alerts" id="receive_email_alerts"
                                        value="1"
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="receive_email_alerts" class="ml-2 block text-sm text-gray-900">Email
                                        Alerts</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" name="is_active" id="is_active" value="1" checked
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
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                                </div>
                                <div>
                                    <label for="notes" class="block text-sm font-medium text-gray-700">Additional
                                        Notes</label>
                                    <textarea name="notes" id="notes" rows="3"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Associated Students -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Associated Students</h3>
                            <div class="space-y-4" id="students-container">
                                <div class="flex items-center space-x-4">
                                    <select name="students[]"
                                        class="flex-1 py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option value="">Select Student</option>
                                        @foreach ($students as $student)
                                            <option value="{{ $student->id }}">{{ $student->user->name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" onclick="addStudentField()"
                                        class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Add Student
                                    </button>
                                </div>
                            </div>
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
    @endsection

    @push('scripts')
        <script>
            let studentCount = 1;

            function addStudentField() {
                studentCount++;
                const container = document.getElementById('students-container');
                const newField = document.createElement('div');
                newField.className = 'flex items-center space-x-4 mt-2';
                newField.innerHTML = `
            <select name="students[]"
                    class="flex-1 py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="">Select Student</option>
                @foreach ($students as $student)
                <option value="{{ $student->id }}">{{ $student->user->name }}</option>
                @endforeach
            </select>
            <button type="button"
                    onclick="this.parentElement.remove()"
                    class="inline-flex items-center px-3 py-2 border border-red-300 shadow-sm text-sm leading-4 font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                Remove
            </button>
        `;
                container.appendChild(newField);
            }
        </script>
    @endpush
