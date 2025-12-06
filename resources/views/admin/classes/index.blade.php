@extends('layouts.app')

@section('title', 'Class Management')

@section('content')
    <div class="min-h-screen bg-gray-50 flex">
        <x-admin-sidebar active-route="admin.classes.index" />

        <div class="flex-1 overflow-auto">
            <div class="container mx-auto p-6">
                <!-- Header -->
                <div class="mb-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Class Management</h1>
                            <p class="text-gray-600 mt-2">Manage classes, assign teachers, and organize students</p>
                        </div>
                        <a href="{{ route('admin.classes.create') }}"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2">
                            <span class="material-icons-sharp text-sm">add</span>
                            <span>Create New Class</span>
                        </a>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Total Classes</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $totalClasses }}</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <span class="material-icons-sharp text-blue-600">class</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Active Classes</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $activeClasses }}</p>
                            </div>
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <span class="material-icons-sharp text-green-600">check_circle</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Total Students</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $totalStudents }}</p>
                            </div>
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                <span class="material-icons-sharp text-purple-600">school</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Avg. Class Size</p>
                                <p class="text-2xl font-bold text-gray-900">{{ number_format($averageClassSize, 1) }}</p>
                            </div>
                            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                                <span class="material-icons-sharp text-orange-600">people</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Flash Messages -->
                @if (session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Search and Filters -->
                <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
                    <form method="GET" action="{{ route('admin.classes.index') }}">
                        <div class="flex flex-col md:flex-row gap-4 items-end">
                            <div class="flex flex-col md:flex-row gap-4 flex-1">
                                <!-- Search -->
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Search Classes</label>
                                    <div class="relative">
                                        <input type="search" name="q" value="{{ request('q') }}"
                                            class="w-full border border-gray-300 rounded-lg pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="Search by name, code, teacher...">
                                        <span
                                            class="material-icons-sharp absolute left-3 top-2 text-gray-400 text-sm">search</span>
                                    </div>
                                </div>

                                <!-- Grade Level Filter -->
                                <div class="md:w-48">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Grade Level</label>
                                    <select name="grade_level"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <option value="">All Grades</option>
                                        @foreach ($gradeLevels as $level)
                                            <option value="{{ $level }}"
                                                {{ request('grade_level') == $level ? 'selected' : '' }}>
                                                {{ $level }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Status Filter -->
                                <div class="md:w-40">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                    <select name="status"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <option value="">All Status</option>
                                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>
                                            Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="flex space-x-2">
                                <button type="submit"
                                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                    Search
                                </button>
                                <a href="{{ route('admin.classes.index') }}"
                                    class="border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Classes Table -->
                @if ($classes->count())
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Class Details</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Teacher</th>
                                        <th
                                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Students</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status</th>
                                        <th
                                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($classes as $class)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div
                                                        class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 mr-4">
                                                        <span class="material-icons-sharp text-sm">class</span>
                                                    </div>
                                                    <div>
                                                        <a href="{{ route('admin.classes.show', $class) }}"
                                                            class="text-lg font-semibold text-gray-900 hover:text-blue-600 transition-colors">
                                                            {{ $class->name }}
                                                        </a>
                                                        <div class="text-sm text-gray-500 mt-1">
                                                            {{ $class->code }} • {{ $class->room_number ?? 'No Room' }} •
                                                            {{ $class->academic_year }}
                                                        </div>
                                                        <div class="text-xs text-gray-400 mt-1">
                                                            Grade {{ $class->grade_level }} • Section
                                                            {{ $class->section }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if ($class->classTeacher)
                                                    <div class="flex items-center">
                                                        <div
                                                            class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center text-green-600 text-xs font-bold mr-3">
                                                            {{ substr($class->classTeacher->name, 0, 1) }}
                                                        </div>
                                                        <div>
                                                            <div class="text-sm font-medium text-gray-900">
                                                                {{ $class->classTeacher->name }}</div>
                                                            <div class="text-xs text-gray-500">
                                                                {{ $class->classTeacher->email ?? '' }}</div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="text-gray-400 text-sm">Not assigned</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <div class="flex flex-col items-center">
                                                    <span
                                                        class="text-lg font-semibold text-gray-900">{{ $class->current_strength }}/{{ $class->capacity }}</span>
                                                    <div class="w-24 bg-gray-200 rounded-full h-2 mt-1">
                                                        <div class="bg-blue-600 h-2 rounded-full"
                                                            style="width: {{ ($class->current_strength / $class->capacity) * 100 }}%">
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $class->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                    {{ ucfirst($class->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                                <div class="flex items-center justify-end space-x-2">
                                                    <!-- Assign Student Button -->
                                                    <button
                                                        onclick="openAssignStudentModal({{ $class->id }}, '{{ $class->name }}')"
                                                        class="bg-green-600 text-white px-3 py-1.5 rounded-lg text-sm hover:bg-green-700 transition-colors flex items-center space-x-1"
                                                        title="Assign Students to {{ $class->name }}">
                                                        <span class="material-icons-sharp text-xs">person_add</span>
                                                        <span>Students</span>
                                                    </button>

                                                    <!-- Assign Teacher Button -->
                                                    <button
                                                        onclick="openAssignTeacherModal({{ $class->id }}, '{{ $class->name }}')"
                                                        class="bg-blue-600 text-white px-3 py-1.5 rounded-lg text-sm hover:bg-blue-700 transition-colors flex items-center space-x-1"
                                                        title="Assign Teacher">
                                                        <span class="material-icons-sharp text-xs">person_add</span>
                                                        <span>Teacher</span>
                                                    </button>

                                                    <!-- View Button -->
                                                    <a href="{{ route('admin.classes.show', $class) }}"
                                                        class="border border-gray-300 text-gray-700 px-3 py-1.5 rounded-lg text-sm hover:bg-gray-50 transition-colors flex items-center space-x-1">
                                                        <span class="material-icons-sharp text-xs">visibility</span>
                                                        <span>View</span>
                                                    </a>

                                                    <!-- Dropdown Menu -->
                                                    <div class="relative">
                                                        <button
                                                            class="w-8 h-8 border border-gray-300 rounded-lg flex items-center justify-center hover:bg-gray-50 transition-colors dropdown-toggle">
                                                            <span
                                                                class="material-icons-sharp text-gray-600 text-sm">more_vert</span>
                                                        </button>
                                                        <div
                                                            class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-10 hidden dropdown-menu">
                                                            <a href="{{ route('admin.classes.edit', $class) }}"
                                                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center space-x-2">
                                                                <span class="material-icons-sharp text-sm">edit</span>
                                                                <span>Edit Class</span>
                                                            </a>
                                                            <a href="#"
                                                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center space-x-2">
                                                                <span class="material-icons-sharp text-sm">schedule</span>
                                                                <span>Class Schedule</span>
                                                            </a>
                                                            <a href="#"
                                                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center space-x-2">
                                                                <span
                                                                    class="material-icons-sharp text-sm">assignment</span>
                                                                <span>Attendance</span>
                                                            </a>
                                                            <div class="border-t border-gray-200 my-1"></div>
                                                            <form action="{{ route('admin.classes.destroy', $class) }}"
                                                                method="POST" class="block">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    onclick="return confirm('Are you sure you want to delete {{ $class->name }}? This cannot be undone.')"
                                                                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100 flex items-center space-x-2">
                                                                    <span
                                                                        class="material-icons-sharp text-sm">delete</span>
                                                                    <span>Delete Class</span>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6 bg-white rounded-xl shadow-sm p-4">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-700">
                                Showing {{ $classes->firstItem() }} to {{ $classes->lastItem() }} of
                                {{ $classes->total() }} classes
                            </div>
                            <div class="flex space-x-2">
                                @if ($classes->onFirstPage())
                                    <span
                                        class="px-3 py-1 border border-gray-300 rounded-lg text-gray-400 cursor-not-allowed">Previous</span>
                                @else
                                    <a href="{{ $classes->previousPageUrl() }}"
                                        class="px-3 py-1 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">Previous</a>
                                @endif

                                @foreach ($classes->getUrlRange(1, $classes->lastPage()) as $page => $url)
                                    @if ($page == $classes->currentPage())
                                        <span
                                            class="px-3 py-1 bg-blue-600 text-white rounded-lg">{{ $page }}</span>
                                    @else
                                        <a href="{{ $url }}"
                                            class="px-3 py-1 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">{{ $page }}</a>
                                    @endif
                                @endforeach

                                @if ($classes->hasMorePages())
                                    <a href="{{ $classes->nextPageUrl() }}"
                                        class="px-3 py-1 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">Next</a>
                                @else
                                    <span
                                        class="px-3 py-1 border border-gray-300 rounded-lg text-gray-400 cursor-not-allowed">Next</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-white rounded-xl shadow-sm p-12 text-center">
                        <div class="text-gray-400 mb-4">
                            <span class="material-icons-sharp text-6xl">class</span>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Classes Found</h3>
                        <p class="text-gray-600 mb-6">Get started by creating your first class.</p>
                        <a href="{{ route('admin.classes.create') }}"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            Create New Class
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Include Modals -->
    @include('admin.classes.partials.assign-student-modal')
    @include('admin.classes.partials.assign-teacher-modal')

@endsection

@push('styles')
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <style>
        .dropdown-menu {
            display: none;
        }

        .dropdown-toggle:hover+.dropdown-menu,
        .dropdown-menu:hover {
            display: block;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Dropdown functionality
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.dropdown-toggle').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const dropdown = this.nextElementSibling;
                    dropdown.classList.toggle('hidden');
                });
            });

            // Close dropdowns when clicking outside
            document.addEventListener('click', function() {
                document.querySelectorAll('.dropdown-menu').forEach(dropdown => {
                    dropdown.classList.add('hidden');
                });
            });
        });

        // Modal functions (to be implemented in separate modal files)
        function openAssignStudentModal(classId, className) {
            // This will be handled by the assign-student-modal component
            console.log('Assign student to class:', classId, className);
            // Show modal with AJAX form for assigning students
            alert('Assign Student Modal for: ' + className);
        }

        function openAssignTeacherModal(classId, className) {
            // This will be handled by the assign-teacher-modal component
            console.log('Assign teacher to class:', classId, className);
            // Show modal with AJAX form for assigning teacher
            alert('Assign Teacher Modal for: ' + className);
        }

        // Dropdown functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize dropdowns
            document.querySelectorAll('.dropdown-toggle').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const dropdown = this.nextElementSibling;
                    dropdown.classList.toggle('hidden');
                });
            });

            // Close dropdowns when clicking outside
            document.addEventListener('click', function() {
                document.querySelectorAll('.dropdown-menu').forEach(dropdown => {
                    dropdown.classList.add('hidden');
                });
            });
        });

        // Global modal state
        let currentAssignStudentModal = null;

        function openAssignStudentModal(classId, className) {
            // Close any existing modal first
            closeAssignStudentModal();

            // Create modal HTML
            const modalHtml = `
            <div id="assignStudentModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
                <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-hidden">
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between p-6 border-b border-gray-200">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Assign Students to ${className}</h2>
                            <p class="text-gray-600 mt-1">Add or remove students from this class</p>
                        </div>
                        <button onclick="closeAssignStudentModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <span class="material-icons-sharp">close</span>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="p-6">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Search Students</label>
                            <input type="text"
                                   id="studentSearch"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Search by name, ID, or email...">
                        </div>

                        <!-- Students List -->
                        <div id="studentsListContainer" class="max-h-96 overflow-y-auto border border-gray-200 rounded-lg">
                            <div class="p-4">
                                <p class="text-gray-500 text-sm">Loading students...</p>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex items-center justify-end space-x-3 p-6 border-t border-gray-200 bg-gray-50">
                        <button onclick="closeAssignStudentModal()"
                                class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                            Cancel
                        </button>
                        <button onclick="saveStudentAssignments(${classId})"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2">
                            <span class="material-icons-sharp text-sm">save</span>
                            <span>Save Assignments</span>
                        </button>
                    </div>
                </div>
            </div>
        `;

            // Add modal to body
            document.body.insertAdjacentHTML('beforeend', modalHtml);
            currentAssignStudentModal = document.getElementById('assignStudentModal');

            // Load students via AJAX
            loadStudentsForAssignment(classId);

            // Add click outside to close
            currentAssignStudentModal.addEventListener('click', function(event) {
                if (event.target === this) {
                    closeAssignStudentModal();
                }
            });
        }

        function closeAssignStudentModal() {
            if (currentAssignStudentModal) {
                currentAssignStudentModal.remove();
                currentAssignStudentModal = null;
            }
        }

        function loadStudentsForAssignment(classId) {
            const modalBody = document.getElementById('studentsListContainer');
            if (!modalBody) return;

            modalBody.innerHTML = '<div class="p-4"><p class="text-gray-500 text-sm">Loading students...</p></div>';

            // For now, simulate data - replace with actual API call
            setTimeout(() => {
                // Mock data - replace with your actual API response
                const mockStudents = [{
                        id: 1,
                        first_name: 'John',
                        last_name: 'Doe',
                        student_id: 'S001',
                        email: 'john@example.com'
                    },
                    {
                        id: 2,
                        first_name: 'Jane',
                        last_name: 'Smith',
                        student_id: 'S002',
                        email: 'jane@example.com'
                    },
                    {
                        id: 3,
                        first_name: 'Bob',
                        last_name: 'Johnson',
                        student_id: 'S003',
                        email: 'bob@example.com'
                    }
                ];

                const mockAssignedStudents = [1, 2]; // IDs of assigned students

                renderStudentsList(mockStudents, mockAssignedStudents);
            }, 1000);

            // Actual API call (uncomment when ready):
            /*
            fetch(`/admin/classes/${classId}/students-data`)
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    renderStudentsList(data.students, data.assignedStudents);
                })
                .catch(error => {
                    console.error('Error loading students:', error);
                    modalBody.innerHTML = '<div class="p-4"><p class="text-red-500 text-sm">Error loading students</p></div>';
                });
            */
        }

        function renderStudentsList(students, assignedStudents) {
            const modalBody = document.getElementById('studentsListContainer');
            if (!modalBody) return;

            if (!students || students.length === 0) {
                modalBody.innerHTML = '<div class="p-4"><p class="text-gray-500 text-sm">No students found.</p></div>';
                return;
            }

            let html = '<div class="divide-y divide-gray-200">';

            students.forEach(student => {
                const isAssigned = assignedStudents.includes(student.id);

                html += `
                <div class="p-4 hover:bg-gray-50 transition-colors">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold text-sm">
                                ${student.first_name ? student.first_name.charAt(0) : '?'}
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">
                                    ${student.first_name || ''} ${student.last_name || ''}
                                </div>
                                <div class="text-xs text-gray-500">${student.student_id || 'N/A'} • ${student.email || 'No email'}</div>
                            </div>
                        </div>
                        <label class="inline-flex items-center">
                            <input type="checkbox"
                                   ${isAssigned ? 'checked' : ''}
                                   data-student-id="${student.id}"
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 h-5 w-5">
                        </label>
                    </div>
                </div>
            `;
            });

            html += '</div>';
            modalBody.innerHTML = html;
        }

        function saveStudentAssignments(classId) {
            const checkboxes = document.querySelectorAll('#assignStudentModal input[type="checkbox"]');
            const assignedStudentIds = Array.from(checkboxes)
                .filter(checkbox => checkbox.checked)
                .map(checkbox => checkbox.getAttribute('data-student-id'));

            const saveButton = document.querySelector('#assignStudentModal button[onclick*="saveStudentAssignments"]');
            if (!saveButton) return;

            const originalText = saveButton.innerHTML;
            saveButton.innerHTML =
                '<span class="material-icons-sharp text-sm animate-spin">refresh</span><span>Saving...</span>';
            saveButton.disabled = true;

            // Simulate API call - replace with actual
            setTimeout(() => {
                console.log('Saving assignments for class:', classId, 'Students:', assignedStudentIds);

                // Show success message
                showNotification('Students assigned successfully!', 'success');
                closeAssignStudentModal();

                // Re-enable button
                saveButton.innerHTML = originalText;
                saveButton.disabled = false;
            }, 1500);

            // Actual API call (uncomment when ready):
            /*
            fetch(`/admin/classes/${classId}/assign-students`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        student_ids: assignedStudentIds
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification('Students assigned successfully!', 'success');
                        closeAssignStudentModal();
                    } else {
                        throw new Error(data.message || 'Failed to assign students');
                    }
                })
                .catch(error => {
                    console.error('Error saving assignments:', error);
                    showNotification('Error assigning students: ' + error.message, 'error');
                })
                .finally(() => {
                    saveButton.innerHTML = originalText;
                    saveButton.disabled = false;
                });
            */
        }

        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 p-4 rounded-lg text-white z-50 ${
            type === 'success' ? 'bg-green-500' :
            type === 'error' ? 'bg-red-500' : 'bg-blue-500'
        }`;
            notification.textContent = message;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        // Assign Teacher Modal (simplified version)
        function openAssignTeacherModal(classId, className) {
            alert('Assign Teacher Modal for: ' + className + '\nThis would open a teacher assignment modal.');
            // Implement similar to student modal
        }
    </script>
@endpush
