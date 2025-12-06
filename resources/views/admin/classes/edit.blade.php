@extends('layouts.app')

@section('title', 'Edit Class: ' . $class->name)

@section('content')
    <div class="min-h-screen bg-gray-50 flex">
        <x-admin-sidebar />

        <div class="flex-1 overflow-auto">
            <div class="container mx-auto p-6">
                <!-- Header -->
                <div class="mb-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Edit Class: {{ $class->name }}</h1>
                            <p class="text-gray-600 mt-2">Update class information</p>
                        </div>
                        <a href="{{ route('admin.classes.index') }}"
                            class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors flex items-center space-x-2">
                            <span class="material-icons-sharp text-sm">arrow_back</span>
                            <span>Back to Classes</span>
                        </a>
                    </div>
                </div>

                <!-- Breadcrumb -->
                <nav class="mb-6">
                    <ol class="flex items-center space-x-2 text-sm text-gray-600">
                        <li><a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600">Dashboard</a></li>
                        <li><span class="material-icons-sharp text-xs">chevron_right</span></li>
                        <li><a href="{{ route('admin.classes.index') }}" class="hover:text-blue-600">Classes</a></li>
                        <li><span class="material-icons-sharp text-xs">chevron_right</span></li>
                        <li class="text-gray-900">Edit Class</li>
                    </ol>
                </nav>

                <div class="max-w-4xl mx-auto">
                    <!-- Flash Messages -->
                    @if (session('success'))
                        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                            <div class="flex items-center space-x-2">
                                <span class="material-icons-sharp text-sm">check_circle</span>
                                <span class="font-medium">{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                            <div class="flex items-center space-x-2">
                                <span class="material-icons-sharp text-sm">error</span>
                                <span class="font-medium">{{ session('error') }}</span>
                            </div>
                        </div>
                    @endif

                    <!-- Class Information -->
                    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Class Code</p>
                                <p class="font-medium">{{ $class->code }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Enrolled Students</p>
                                <p class="font-medium">{{ $class->enrolled_count }} / {{ $class->capacity }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Status</p>
                                <span
                                    class="px-2 py-1 text-xs font-medium rounded-full
                                    {{ $class->status == 'active'
                                        ? 'bg-green-100 text-green-800'
                                        : ($class->status == 'inactive'
                                            ? 'bg-red-100 text-red-800'
                                            : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ ucfirst($class->status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Form Card -->
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <form action="{{ route('admin.classes.update', $class) }}" method="POST">
                            @include('admin.classes.partials.form-fields')

                            <!-- Form Actions -->
                            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                                <div class="flex items-center justify-between">
                                    <div class="flex space-x-3">
                                        <a href="{{ route('admin.classes.show', $class) }}"
                                            class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors flex items-center space-x-2">
                                            <span class="material-icons-sharp text-sm">visibility</span>
                                            <span>View Class</span>
                                        </a>
                                        <a href="{{ route('admin.classes.index') }}"
                                            class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                                            Cancel
                                        </a>
                                    </div>
                                    <div class="flex space-x-3">
                                        <button type="button" onclick="resetForm()"
                                            class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                                            Reset Changes
                                        </button>
                                        <button type="submit"
                                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2">
                                            <span class="material-icons-sharp text-sm">save</span>
                                            <span>Update Class</span>
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
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <style>
        .material-icons-sharp {
            font-size: inherit;
        }
    </style>
@endpush

@push('scripts')
    <script>
        function resetForm() {
            if (confirm('Are you sure you want to reset all changes?')) {
                window.location.reload();
            }
        }

        // Validate end time is after start time
        document.getElementById('end_time').addEventListener('change', function() {
            const startTime = document.getElementById('start_time').value;
            const endTime = this.value;

            if (startTime && endTime && startTime >= endTime) {
                alert('End time must be after start time');
                this.value = '';
                this.focus();
            }
        });

        // Capacity validation
        document.getElementById('capacity').addEventListener('input', function() {
            const enrolledCount = {{ $class->enrolled_count }};
            if (this.value < enrolledCount) {
                alert('Capacity cannot be less than currently enrolled students (' + enrolledCount + ')');
                this.value = enrolledCount;
                this.focus();
            }
            if (this.value < 1) {
                this.value = 1;
            }
            if (this.value > 100) {
                this.value = 100;
            }
        });

        // Validate academic year format
        document.getElementById('academic_year').addEventListener('blur', function() {
            const pattern = /^\d{4}-\d{4}$/;
            if (!pattern.test(this.value)) {
                alert('Academic year must be in the format: YYYY-YYYY');
                this.focus();
            }
        });

        // Form submission validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const requiredFields = ['name', 'code', 'grade_level', 'section', 'academic_year', 'capacity'];
            let isValid = true;

            requiredFields.forEach(field => {
                const element = document.getElementById(field);
                if (!element.value.trim()) {
                    isValid = false;
                    element.classList.add('border-red-500');
                } else {
                    element.classList.remove('border-red-500');
                }
            });

            // Validate academic year format
            const academicYear = document.getElementById('academic_year').value;
            const yearPattern = /^\d{4}-\d{4}$/;
            if (academicYear && !yearPattern.test(academicYear)) {
                isValid = false;
                document.getElementById('academic_year').classList.add('border-red-500');
            }

            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields correctly');
            }
        });
    </script>
@endpush
