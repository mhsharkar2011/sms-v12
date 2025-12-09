@extends('layouts.app')

@section('title', 'Student Management')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 flex">
        <x-admin-sidebar active-route="admin.students.index" />

        <div class="flex-1 overflow-auto">
            <!-- Modern Header -->
            <div class="bg-white/80 backdrop-blur-lg shadow-sm border-b border-gray-200/50">
                <div class="px-6 py-4">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            <h1
                                class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                                Student Management
                            </h1>
                            <p class="text-gray-600 mt-1">Manage all student records and information</p>
                        </div>
                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                            <div class="relative w-full sm:w-auto">
                                <div class="relative">
                                    <input type="text" placeholder="Search students..."
                                        class="w-full sm:w-64 pl-10 pr-4 py-2.5 border border-gray-300/50 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white/50 backdrop-blur-sm shadow-sm transition-all duration-300 focus:shadow-md">
                                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                        <i class="fas fa-search"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="flex gap-2 w-full sm:w-auto">
                                <button onclick="openImportModal()"
                                    class="flex-1 sm:flex-none px-4 py-2.5 border border-gray-300/50 rounded-xl text-gray-700 hover:bg-gray-50/50 transition-all duration-300 hover:shadow-md flex items-center justify-center gap-2 backdrop-blur-sm">
                                    <i class="fas fa-file-import text-blue-500"></i>
                                    <span class="hidden sm:inline">Import</span>
                                </button>
                                <a href="{{ route('admin.students.create') }}"
                                    class="flex-1 sm:flex-none px-4 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-xl flex items-center justify-center gap-2 transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                    <i class="fas fa-plus"></i>
                                    <span class="hidden sm:inline">Add Student</span>
                                    <span class="sm:hidden">Add</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container mx-auto p-4 md:p-6">
                <!-- Stats Cards Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <!-- Total Students -->
                    <div
                        class="bg-white/80 backdrop-blur-sm rounded-2xl p-5 shadow-sm border border-gray-200/50 hover:shadow-md transition-all duration-300 hover:border-blue-200/50 group">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total Students</p>
                                <p class="text-2xl md:text-3xl font-bold text-gray-900 mt-2">
                                    {{ $stats['total_students'] ?? 0 }}
                                </p>
                                <div class="flex items-center mt-3">
                                    <span
                                        class="text-xs font-medium text-green-600 bg-green-50 px-2.5 py-1 rounded-full flex items-center gap-1">
                                        <i class="fas fa-arrow-up text-xs"></i>
                                        {{ $stats['active_percentage'] ?? 0 }}% active
                                    </span>
                                </div>
                            </div>
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-blue-100 to-blue-200 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-users text-blue-600 text-lg"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Active Students -->
                    <div
                        class="bg-white/80 backdrop-blur-sm rounded-2xl p-5 shadow-sm border border-gray-200/50 hover:shadow-md transition-all duration-300 hover:border-green-200/50 group">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Active Students</p>
                                <p class="text-2xl md:text-3xl font-bold text-gray-900 mt-2">
                                    {{ $stats['activeStudents'] ?? 0 }}
                                </p>
                                <div class="flex items-center mt-3">
                                    <span class="text-xs font-medium text-green-600 bg-green-50 px-2.5 py-1 rounded-full">
                                        {{ number_format($stats['active_percentage'] ?? 0, 1) }}% active
                                    </span>
                                </div>
                            </div>
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-green-100 to-green-200 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-user-check text-green-600 text-lg"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Students -->
                    <div
                        class="bg-white/80 backdrop-blur-sm rounded-2xl p-5 shadow-sm border border-gray-200/50 hover:shadow-md transition-all duration-300 hover:border-purple-200/50 group">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Pending Students</p>
                                <p class="text-2xl md:text-3xl font-bold text-gray-900 mt-2">
                                    {{ $stats['pendingStudents'] ?? 0 }}
                                </p>
                                <div class="flex items-center mt-3">
                                    <span class="text-xs font-medium text-purple-600 bg-purple-50 px-2.5 py-1 rounded-full">
                                        {{ number_format($stats['pendingPercentage'] ?? 0, 1) }}% pending
                                    </span>
                                </div>
                            </div>
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-purple-100 to-purple-200 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-clock text-purple-600 text-lg"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Inactive Students -->
                    <div
                        class="bg-white/80 backdrop-blur-sm rounded-2xl p-5 shadow-sm border border-gray-200/50 hover:shadow-md transition-all duration-300 hover:border-orange-200/50 group">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Inactive Students</p>
                                <p class="text-2xl md:text-3xl font-bold text-gray-900 mt-2">
                                    {{ $stats['inactiveStudents'] ?? 0 }}
                                </p>
                                <div class="flex items-center mt-3">
                                    <span
                                        class="text-xs font-medium text-orange-600 bg-orange-50 px-2.5 py-1 rounded-full flex items-center gap-1">
                                        <i class="fas fa-info-circle text-xs"></i>
                                        {{ number_format($stats['inactivePercentage'] ?? 0, 1) }}% inactive
                                    </span>
                                </div>
                            </div>
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-orange-100 to-orange-200 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-user-slash text-orange-600 text-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filters Card -->
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-sm p-5 mb-6 border border-gray-200/50">
                    <div class="flex flex-col md:flex-row md:items-center justify-between mb-5 gap-3">
                        <h2 class="text-lg font-semibold text-gray-900">Filters & Search</h2>
                        <div class="text-sm text-gray-500 bg-gray-50/50 px-3 py-1.5 rounded-lg">
                            @if (isset($students) && $students->count() > 0)
                                Showing {{ $students->count() }} of {{ $students->total() }} students
                            @else
                                Showing 0 students
                            @endif
                        </div>
                    </div>

                    <form method="GET" action="{{ route('admin.students.index') }}"
                        class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                            <div class="relative">
                                <input type="text" name="search" placeholder="Name, email, or ID..."
                                    value="{{ request('search') }}"
                                    class="w-full border border-gray-300/50 rounded-xl pl-10 pr-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white/50 backdrop-blur-sm">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                    <i class="fas fa-search"></i>
                                </span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                            <select name="role"
                                class="w-full border border-gray-300/50 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white/50 backdrop-blur-sm appearance-none">
                                <option value="">All Roles</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}"
                                        {{ request('role') == $role->name ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select name="status"
                                class="w-full border border-gray-300/50 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white/50 backdrop-blur-sm appearance-none">
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active
                                </option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive
                                </option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                            </select>
                        </div>

                        <div class="flex flex-col md:flex-row items-end gap-2">
                            <button type="submit"
                                class="flex-1 bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 py-2.5 rounded-xl hover:from-blue-600 hover:to-blue-700 transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                                <i class="fas fa-filter"></i>
                                Apply Filters
                            </button>
                            <a href="{{ route('admin.students.index') }}"
                                class="flex-1 bg-gray-500/10 text-gray-700 px-4 py-2.5 rounded-xl hover:bg-gray-500/20 transition-all duration-300 flex items-center justify-center gap-2 border border-gray-300/50">
                                <i class="fas fa-refresh"></i>
                                Reset
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Students Table Card -->
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-sm overflow-hidden border border-gray-200/50">
                    <div
                        class="px-5 py-4 border-b border-gray-200/50 flex flex-col md:flex-row md:items-center justify-between gap-3">
                        <h2 class="text-lg font-semibold text-gray-900">Student Records</h2>
                        <div class="flex items-center gap-3">
                            <button
                                class="px-3 py-2 border border-gray-300/50 rounded-xl text-gray-700 hover:bg-gray-50/50 transition-all duration-300 hover:shadow-md flex items-center gap-2">
                                <i class="fas fa-download"></i>
                                <span class="hidden md:inline">Export</span>
                            </button>
                            <div class="text-sm text-gray-500 bg-gray-50/50 px-3 py-1.5 rounded-lg">
                                @if (isset($students) && $students->count() > 0)
                                    Showing {{ $students->firstItem() ?? 0 }}-{{ $students->lastItem() ?? 0 }} of
                                    {{ $students->total() }} students
                                @else
                                    Showing 0 students
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full min-w-max">
                            <thead>
                                <tr class="bg-gradient-to-r from-gray-50/50 to-gray-100/50 border-b border-gray-200/50">
                                    <th
                                        class="px-5 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-user text-gray-400"></i>
                                            Student
                                        </div>
                                    </th>
                                    <th
                                        class="px-5 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-id-badge text-gray-400"></i>
                                            Role
                                        </div>
                                    </th>
                                    <th
                                        class="px-5 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-phone text-gray-400"></i>
                                            Contact Info
                                        </div>
                                    </th>
                                    <th
                                        class="px-5 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-circle text-gray-400"></i>
                                            Status
                                        </div>
                                    </th>
                                    <th
                                        class="px-5 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-calendar text-gray-400"></i>
                                            Created
                                        </div>
                                    </th>
                                    <th
                                        class="px-5 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-cog text-gray-400"></i>
                                            Actions
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200/50">
                                @if (isset($students) && $students->count() > 0)
                                    @foreach ($students as $student)
                                        <tr
                                            class="hover:bg-gradient-to-r hover:from-blue-50/30 hover:to-blue-50/10 transition-all duration-300 group">
                                            <!-- Student Info -->
                                            <td class="px-5 py-4">
                                                <div class="flex items-center gap-4">
                                                    <div class="relative">
                                                        <div
                                                            class="h-12 w-12 rounded-2xl bg-gradient-to-br from-blue-100 to-indigo-100 flex items-center justify-center shadow-sm overflow-hidden border-2 border-white">
                                                            @if ($student->avatar_url)
                                                                <img src="{{ $student->avatar_url }}"
                                                                    alt="{{ $student->full_name }}"
                                                                    class="h-full w-full object-cover">
                                                            @else
                                                                <i class="fas fa-user text-blue-500 text-lg"></i>
                                                            @endif
                                                        </div>
                                                        <div
                                                            class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full border-2 border-white shadow-sm
                                                        {{ $student->status == 'active'
                                                            ? 'bg-green-400'
                                                            : ($student->status == 'pending'
                                                                ? 'bg-yellow-400'
                                                                : 'bg-red-400') }}">
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="flex items-center gap-2 mb-1">
                                                            <p class="text-sm font-semibold text-gray-900">
                                                                {{ $student->full_name }}
                                                            </p>
                                                            @if ($student->status == 'active')
                                                                <span
                                                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-xs bg-gradient-to-r from-green-50 to-green-100 text-green-700 border border-green-200">
                                                                    <i class="fas fa-award mr-1"></i>
                                                                    Active
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <p class="text-sm text-gray-600">
                                                            {{ $student->schoolClass->name ?? 'N/A' }}</p>
                                                        <div class="flex flex-wrap gap-2 mt-1">
                                                            <span
                                                                class="text-xs text-gray-500 bg-gray-50 px-2 py-0.5 rounded-lg">
                                                                ID: {{ $student->student_id }}
                                                            </span>
                                                            @if ($student->section)
                                                                <span
                                                                    class="text-xs text-blue-600 bg-blue-50 px-2 py-0.5 rounded-lg">
                                                                    Sec: {{ $student->section->code }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- Role -->
                                            <td class="px-5 py-4">
                                                <div class="flex items-center gap-2">
                                                    <div
                                                        class="h-8 w-8 rounded-lg bg-gradient-to-br from-purple-50 to-purple-100 flex items-center justify-center">
                                                        <i class="fas fa-user-graduate text-purple-500 text-sm"></i>
                                                    </div>
                                                    <div>
                                                        <div class="text-sm font-medium text-gray-900">
                                                            Student
                                                        </div>
                                                        <div class="text-xs text-gray-500">
                                                            {{ $student->schoolClass->name ?? 'No Class' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- Contact Info -->
                                            <td class="px-5 py-4">
                                                <div class="space-y-1">
                                                    <div class="text-sm text-gray-900 flex items-center gap-2">
                                                        <i class="fas fa-user-tag text-gray-400 text-xs"></i>
                                                        {{ $student->emergency_contact_name ?? 'No Guardian' }}
                                                    </div>
                                                    <div class="text-sm text-gray-600 flex items-center gap-2">
                                                        <i class="fas fa-phone text-gray-400 text-xs"></i>
                                                        {{ $student->emergency_contact_phone ?? 'N/A' }}
                                                    </div>
                                                    <div class="text-sm text-gray-600 flex items-center gap-2">
                                                        <i class="fas fa-envelope text-gray-400 text-xs"></i>
                                                        {{ $student->user->email ?? 'N/A' }}
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- Status -->
                                            <td class="px-5 py-4">
                                                @php
                                                    $statusConfig = [
                                                        'active' => [
                                                            'color' => 'green',
                                                            'icon' => 'check-circle',
                                                            'bg' => 'from-green-50 to-green-100',
                                                            'text' => 'text-green-700',
                                                            'border' => 'border-green-200',
                                                        ],
                                                        'pending' => [
                                                            'color' => 'yellow',
                                                            'icon' => 'clock',
                                                            'bg' => 'from-yellow-50 to-yellow-100',
                                                            'text' => 'text-yellow-700',
                                                            'border' => 'border-yellow-200',
                                                        ],
                                                        'inactive' => [
                                                            'color' => 'red',
                                                            'icon' => 'times-circle',
                                                            'bg' => 'from-red-50 to-red-100',
                                                            'text' => 'text-red-700',
                                                            'border' => 'border-red-200',
                                                        ],
                                                    ];
                                                    $config =
                                                        $statusConfig[$student->status] ?? $statusConfig['inactive'];
                                                @endphp
                                                <span
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-gradient-to-r {{ $config['bg'] }} {{ $config['text'] }} border {{ $config['border'] }}">
                                                    <i class="fas fa-{{ $config['icon'] }}"></i>
                                                    {{ ucfirst($student->status) }}
                                                </span>
                                            </td>

                                            <!-- Created At -->
                                            <td class="px-5 py-4">
                                                <div class="text-sm text-gray-900 font-medium">
                                                    {{ $student->created_at->format('M d, Y') }}
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    {{ $student->created_at->diffForHumans() }}
                                                </div>
                                            </td>

                                            <!-- Actions -->
                                            <td class="px-5 py-4">
                                                <div class="flex items-center gap-1.5">
                                                    <!-- View Button -->
                                                    <a href="{{ route('admin.students.show', $student->id) }}"
                                                        class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium text-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 hover:from-gray-100 hover:to-gray-200 transition-all duration-300 border border-gray-200 hover:border-gray-300 hover:shadow-sm group/view"
                                                        title="View Profile">
                                                        <i
                                                            class="fas fa-eye group-hover/view:text-blue-500 transition-colors"></i>
                                                    </a>

                                                    <!-- Edit Button -->
                                                    <a href="{{ route('admin.students.edit', $student) }}"
                                                        class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium text-blue-700 bg-gradient-to-r from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 transition-all duration-300 border border-blue-200 hover:border-blue-300 hover:shadow-sm group/edit"
                                                        title="Edit Student">
                                                        <i
                                                            class="fas fa-edit group-hover/edit:text-blue-600 transition-colors"></i>
                                                    </a>

                                                    <!-- Delete Button (FIXED) -->
                                                    <form action="{{ route('admin.students.destroy', $student->id) }}"
                                                        method="POST" class="inline delete-form"
                                                        data-student-name="{{ $student->full_name }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" onclick="confirmDelete(this)"
                                                            class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium text-red-700 bg-gradient-to-r from-red-50 to-red-100 hover:from-red-100 hover:to-red-200 transition-all duration-300 border border-red-200 hover:border-red-300 hover:shadow-sm group/delete"
                                                            title="Delete Student">
                                                            <i
                                                                class="fas fa-trash group-hover/delete:text-red-600 transition-colors"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="px-5 py-12 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <div
                                                    class="h-24 w-24 rounded-2xl bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center mb-4 shadow-inner">
                                                    <i class="fas fa-users text-gray-300 text-3xl"></i>
                                                </div>
                                                <h3 class="text-lg font-medium text-gray-900 mb-2">No students found</h3>
                                                <p class="text-gray-600 max-w-sm text-center mb-4">
                                                    No student records match your search criteria. Try different filters or
                                                    add a new student.
                                                </p>
                                                <a href="{{ route('admin.students.create') }}"
                                                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl hover:from-blue-600 hover:to-blue-700 transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                                    <i class="fas fa-plus"></i>
                                                    Add New Student
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if (isset($students) && $students->hasPages())
                        <div
                            class="px-5 py-4 border-t border-gray-200/50 bg-gradient-to-r from-gray-50/50 to-gray-100/50 flex flex-col md:flex-row md:items-center justify-between gap-3">
                            <div class="text-sm text-gray-600">
                                Showing {{ $students->firstItem() }} to {{ $students->lastItem() }} of
                                {{ $students->total() }} entries
                            </div>
                            <div class="flex items-center">
                                {{ $students->links('vendor.pagination.tailwind') }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Import Modal -->
        <div id="importModal"
            class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center hidden z-50 p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md">
                <div class="px-6 py-4 border-b border-gray-200/50">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Import Students</h3>
                        <button onclick="closeImportModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="p-6">
                    <div
                        class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center bg-gradient-to-br from-gray-50/50 to-gray-100/50">
                        <i class="fas fa-file-excel text-green-500 text-4xl mb-4"></i>
                        <p class="text-sm text-gray-600 mb-4">Upload Excel file with student data</p>
                        <input type="file" accept=".xlsx,.xls,.csv" class="hidden" id="fileInput">
                        <button onclick="document.getElementById('fileInput').click()"
                            class="px-4 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl hover:from-blue-600 hover:to-blue-700 transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                            Choose File
                        </button>
                    </div>
                    <div class="mt-4 text-xs text-gray-500 text-center">
                        <p>Download <a href="#" class="text-blue-600 hover:underline font-medium">template file</a>
                            for reference</p>
                    </div>
                </div>
                <div class="px-6 py-4 border-t border-gray-200/50 flex justify-end gap-3">
                    <button onclick="closeImportModal()"
                        class="px-4 py-2.5 text-gray-600 hover:text-gray-800 hover:bg-gray-50 rounded-xl transition-colors">
                        Cancel
                    </button>
                    <button
                        class="px-4 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl hover:from-blue-600 hover:to-blue-700 transition-all duration-300 shadow-md hover:shadow-lg">
                        Import Students
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Import Modal Functions
        function openImportModal() {
            document.getElementById('importModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeImportModal() {
            document.getElementById('importModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close modal when clicking outside
        document.addEventListener('click', function(e) {
            if (e.target.id === 'importModal') {
                closeImportModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeImportModal();
            }
        });

        // DELETE FUNCTION FIX - Proper confirmation and form submission
        function confirmDelete(button) {
            const form = button.closest('.delete-form');
            const studentName = form.getAttribute('data-student-name') || 'this student';

            // SweetAlert2 or native confirm
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Are you sure?',
                    text: `You are about to delete ${studentName}. This action cannot be undone!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading state
                        const originalHTML = button.innerHTML;
                        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                        button.disabled = true;

                        // Submit the form
                        form.submit();
                    }
                });
            } else {
                // Fallback to native confirm
                if (confirm(`Are you sure you want to delete ${studentName}? This action cannot be undone!`)) {
                    // Show loading state
                    const originalHTML = button.innerHTML;
                    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                    button.disabled = true;

                    // Submit the form
                    form.submit();
                }
            }
        }

        // Add loading state to all delete buttons on form submit
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                const button = this.querySelector('button[type="button"]');
                if (button) {
                    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                    button.disabled = true;
                }
            });
        });

        // Smooth animations
        document.addEventListener('DOMContentLoaded', function() {
            // Animate stats cards on load
            const statsCards = document.querySelectorAll('.grid > div');
            statsCards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });

            // Add hover effects to table rows
            const tableRows = document.querySelectorAll('tbody tr');
            tableRows.forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateX(4px)';
                });
                row.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateX(0)';
                });
            });
        });
    </script>

    <!-- SweetAlert2 for better confirmations (optional) -->
    @if (config('app.env') === 'production')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @endif
@endpush

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Custom scrollbar */
        .overflow-x-auto::-webkit-scrollbar {
            height: 6px;
        }

        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: linear-gradient(to right, #3b82f6, #8b5cf6);
            border-radius: 10px;
        }

        /* Glass morphism effects */
        .backdrop-blur-sm {
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }

        /* Smooth transitions */
        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 300ms;
        }

        /* Gradient borders */
        .hover\:border-blue-200\/50:hover {
            border-color: rgba(191, 219, 254, 0.5);
        }
    </style>
@endpush
