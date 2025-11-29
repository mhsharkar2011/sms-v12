@extends('layouts.admin')

@section('title', 'Create New Subject')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <div class="flex">
            <!-- Admin Sidebar -->
            <div class="hidden md:flex md:w-64 md:flex-col">
                <x-admin-sidebar active-route="admin.subjects.index" />
            </div>

            <!-- Main Content -->
            <div class="flex-1 lg:ml-0">
                <!-- Mobile sidebar toggle -->
                <div class="lg:hidden">
                    <button id="sidebarToggle" class="p-4 text-gray-500 hover:text-gray-700">
                        <i class="fas fa-bars text-lg"></i>
                    </button>
                </div>

                <div class="p-4 lg:p-6">
                    <!-- Page Header -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
                        <div class="mb-4 sm:mb-0">
                            <h1 class="text-2xl font-bold text-gray-900">Create New Subject</h1>
                            <p class="text-gray-600 mt-1">Add a new subject to the curriculum</p>
                        </div>
                        <a href="{{ route('admin.subjects.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <i class="fas fa-arrow-left mr-2"></i>Back to Subjects
                        </a>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Main Form -->
                        <div class="lg:col-span-2">
                            <div class="bg-white rounded-lg shadow">
                                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                                        <i class="fas fa-book-medical mr-2 text-blue-500"></i>Subject Information
                                    </h3>
                                </div>
                                <div class="p-4 sm:p-6">
                                    <form action="{{ route('admin.subjects.store') }}" method="POST" id="subjectForm">
                                        @csrf

                                        <!-- Basic Information Section -->
                                        <div class="mb-6 p-4 bg-blue-50 rounded-lg border-l-4 border-blue-500">
                                            <h4
                                                class="text-sm font-semibold text-gray-700 uppercase tracking-wide flex items-center mb-3">
                                                <i class="fas fa-info-circle mr-2 text-blue-500"></i>Basic Information
                                            </h4>

                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <label for="name"
                                                        class="block text-sm font-medium text-gray-700 mb-1">
                                                        Subject Name <span class="text-red-500">*</span>
                                                    </label>
                                                    <div class="relative rounded-md shadow-sm">
                                                        <div
                                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                            <i class="fas fa-book text-gray-400"></i>
                                                        </div>
                                                        <input type="text" name="name" id="name"
                                                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-300 @enderror"
                                                            value="{{ old('name') }}" placeholder="Enter subject name"
                                                            required>
                                                    </div>
                                                    @error('name')
                                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                    @enderror
                                                </div>

                                                <div>
                                                    <label for="code"
                                                        class="block text-sm font-medium text-gray-700 mb-1">
                                                        Subject Code <span class="text-red-500">*</span>
                                                    </label>
                                                    <div class="relative rounded-md shadow-sm">
                                                        <div
                                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                            <i class="fas fa-code text-gray-400"></i>
                                                        </div>
                                                        <input type="text" name="code" id="code"
                                                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 @error('code') border-red-300 @enderror"
                                                            value="{{ old('code') }}" placeholder="e.g., MATH101"
                                                            required>
                                                    </div>
                                                    @error('code')
                                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="mt-4">
                                                <label for="description"
                                                    class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                                <div class="relative rounded-md shadow-sm">
                                                    <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                                                        <i class="fas fa-align-left text-gray-400"></i>
                                                    </div>
                                                    <textarea name="description" id="description"
                                                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-300 @enderror"
                                                        rows="4" placeholder="Enter subject description (optional)">{{ old('description') }}</textarea>
                                                </div>
                                                @error('description')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Subject Details Section -->
                                        <div class="mb-6 p-4 bg-green-50 rounded-lg border-l-4 border-green-500">
                                            <h4
                                                class="text-sm font-semibold text-gray-700 uppercase tracking-wide flex items-center mb-3">
                                                <i class="fas fa-cog mr-2 text-green-500"></i>Subject Details
                                            </h4>

                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                <div>
                                                    <label for="category"
                                                        class="block text-sm font-medium text-gray-700 mb-1">
                                                        Category <span class="text-red-500">*</span>
                                                    </label>
                                                    <select name="category" id="category"
                                                        class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('category') border-red-300 @enderror"
                                                        required>
                                                        <option value="">Select Category</option>
                                                        <option value="core"
                                                            {{ old('category') == 'core' ? 'selected' : '' }}>Core</option>
                                                        <option value="elective"
                                                            {{ old('category') == 'elective' ? 'selected' : '' }}>Elective
                                                        </option>
                                                        <option value="extracurricular"
                                                            {{ old('category') == 'extracurricular' ? 'selected' : '' }}>
                                                            Extracurricular</option>
                                                        <option value="vocational"
                                                            {{ old('category') == 'vocational' ? 'selected' : '' }}>
                                                            Vocational</option>
                                                    </select>
                                                    @error('category')
                                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                    @enderror
                                                </div>

                                                <div>
                                                    <label for="credit_hours"
                                                        class="block text-sm font-medium text-gray-700 mb-1">
                                                        Credit Hours <span class="text-red-500">*</span>
                                                    </label>
                                                    <div class="relative rounded-md shadow-sm">
                                                        <div
                                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                            <i class="fas fa-clock text-gray-400"></i>
                                                        </div>
                                                        <input type="number" name="credit_hours" id="credit_hours"
                                                            class="block w-full pl-10 pr-12 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 @error('credit_hours') border-red-300 @enderror"
                                                            value="{{ old('credit_hours', 1) }}" min="1"
                                                            max="10" required>
                                                        <div
                                                            class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                            <span class="text-gray-500">hours</span>
                                                        </div>
                                                    </div>
                                                    @error('credit_hours')
                                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                    @enderror
                                                </div>

                                                <div>
                                                    <label for="difficulty_level"
                                                        class="block text-sm font-medium text-gray-700 mb-1">
                                                        Difficulty Level <span class="text-red-500">*</span>
                                                    </label>
                                                    <select name="difficulty_level" id="difficulty_level"
                                                        class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('difficulty_level') border-red-300 @enderror"
                                                        required>
                                                        <option value="">Select Level</option>
                                                        <option value="1"
                                                            {{ old('difficulty_level') == '1' ? 'selected' : '' }}>
                                                            <span class="text-green-600">★</span> Very Easy
                                                        </option>
                                                        <option value="2"
                                                            {{ old('difficulty_level') == '2' ? 'selected' : '' }}>
                                                            <span class="text-blue-600">★★</span> Easy
                                                        </option>
                                                        <option value="3"
                                                            {{ old('difficulty_level') == '3' ? 'selected' : '' }}>
                                                            <span class="text-yellow-600">★★★</span> Moderate
                                                        </option>
                                                        <option value="4"
                                                            {{ old('difficulty_level') == '4' ? 'selected' : '' }}>
                                                            <span class="text-orange-600">★★★★</span> Difficult
                                                        </option>
                                                        <option value="5"
                                                            {{ old('difficulty_level') == '5' ? 'selected' : '' }}>
                                                            <span class="text-red-600">★★★★★</span> Very Difficult
                                                        </option>
                                                    </select>
                                                    @error('difficulty_level')
                                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Status Section -->
                                        <!-- Status Section -->
                                        <div class="p-4 bg-purple-50 rounded-lg border-l-4 border-purple-500">
                                            <h4
                                                class="text-sm font-semibold text-gray-700 uppercase tracking-wide flex items-center mb-3">
                                                <i class="fas fa-toggle-on mr-2 text-purple-500"></i>Status
                                            </h4>

                                            <div class="flex items-center">
                                                <div class="flex items-center h-5">
                                                    <input type="checkbox" name="is_active" id="is_active"
                                                        value="1"
                                                        class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded"
                                                        {{ old('is_active', true) ? 'checked' : '' }}>
                                                </div>
                                                <div class="ml-3 text-sm">
                                                    <label for="is_active" class="font-medium text-gray-700">Active
                                                        Subject</label>
                                                    <p class="text-gray-500">Active subjects will be available for
                                                        enrollment</p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="mt-8 pt-6 border-t border-gray-200">
                                            <div
                                                class="flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-3 sm:space-y-0">
                                                <button type="reset"
                                                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                    <i class="fas fa-redo mr-2"></i>Reset Form
                                                </button>
                                                <div class="flex space-x-3">
                                                    <a href="{{ route('admin.subjects.index') }}"
                                                        class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                        <i class="fas fa-times mr-2"></i>Cancel
                                                    </a>
                                                    <button type="submit"
                                                        class="inline-flex items-center px-6 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                        <i class="fas fa-plus-circle mr-2"></i>Create Subject
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar Tips -->
                        <div class="space-y-6">
                            <!-- Quick Tips Card -->
                            <div class="bg-white rounded-lg shadow">
                                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                                        <i class="fas fa-lightbulb mr-2 text-yellow-500"></i>Quick Tips
                                    </h3>
                                </div>
                                <div class="p-4 sm:p-6">
                                    <div class="space-y-4">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm text-gray-600">Subject codes must be unique and follow
                                                    your institution's naming convention</p>
                                            </div>
                                        </div>
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm text-gray-600">Core subjects are mandatory for all
                                                    students</p>
                                            </div>
                                        </div>
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm text-gray-600">Elective subjects allow students to choose
                                                    based on interests</p>
                                            </div>
                                        </div>
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm text-gray-600">Set appropriate difficulty levels to help
                                                    students with course selection</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Preview Card -->
                            <div class="bg-white rounded-lg shadow">
                                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                                        <i class="fas fa-eye mr-2 text-blue-500"></i>Live Preview
                                    </h3>
                                </div>
                                <div class="p-4 sm:p-6">
                                    <div class="space-y-4">
                                        <div>
                                            <p class="text-sm text-gray-500">Subject Code</p>
                                            <p id="preview-code" class="text-lg font-semibold text-gray-900">-</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Subject Name</p>
                                            <p id="preview-name" class="text-lg font-semibold text-gray-900">-</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Category</p>
                                            <span id="preview-category"
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">-</span>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Credit Hours</p>
                                            <p id="preview-credits" class="text-lg font-semibold text-gray-900">-</p>
                                        </div>
                                    </div>
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
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile sidebar toggle
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.querySelector('[x-admin-sidebar]').parentElement;

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('hidden');
                });
            }

            // Live preview functionality
            const nameInput = document.getElementById('name');
            const codeInput = document.getElementById('code');
            const categorySelect = document.getElementById('category');
            const creditInput = document.getElementById('credit_hours');

            function updatePreview() {
                // Update preview elements
                document.getElementById('preview-name').textContent = nameInput.value || '-';
                document.getElementById('preview-code').textContent = codeInput.value || '-';
                document.getElementById('preview-credits').textContent = creditInput.value ?
                    creditInput.value + ' hours' : '-';

                // Update category badge
                const category = categorySelect.value;
                const categoryBadge = document.getElementById('preview-category');
                if (category) {
                    const categoryText = category.charAt(0).toUpperCase() + category.slice(1);
                    categoryBadge.textContent = categoryText;

                    // Update badge color based on category
                    const categoryColors = {
                        'core': 'bg-blue-100 text-blue-800',
                        'elective': 'bg-green-100 text-green-800',
                        'extracurricular': 'bg-yellow-100 text-yellow-800',
                        'vocational': 'bg-cyan-100 text-cyan-800'
                    };
                    categoryBadge.className =
                        `inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${categoryColors[category] || 'bg-gray-100 text-gray-800'}`;
                } else {
                    categoryBadge.textContent = '-';
                    categoryBadge.className =
                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800';
                }
            }

            // Add event listeners for live preview
            [nameInput, codeInput, categorySelect, creditInput].forEach(element => {
                element.addEventListener('input', updatePreview);
                element.addEventListener('change', updatePreview);
            });

            // Initialize preview
            updatePreview();

            // Form reset handler
            document.querySelector('button[type="reset"]').addEventListener('click', function() {
                setTimeout(updatePreview, 100);
            });
        });
    </script>
@endpush
