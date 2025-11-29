@extends('layouts.app')

@section('title', 'Teacher Management')

@section('content')
    <div class="min-h-screen bg-gray-50 flex">
        <x-admin-sidebar active-route="admin.teachers.index" />

        <div class="flex-1 overflow-auto">
            <!-- Header -->
            <div class="bg-white shadow-sm border-b border-gray-200">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Teacher Management</h1>
                            <p class="text-gray-600 mt-1">Manage all teacher records and information</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="relative">
                                <input type="text" placeholder="Search teachers..."
                                    class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent w-64">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                    <i class="fas fa-search"></i>
                                </span>
                            </div>
                            <button onclick="openImportModal()"
                                class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors flex items-center gap-2">
                                <i class="fas fa-file-import"></i>
                                Import
                            </button>
                            <a href="{{ route('admin.teachers.create') }}"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors shadow-sm">
                                <i class="fas fa-plus"></i>
                                Add Teacher
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container mx-auto p-6">
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Total Teachers Card -->
                    <div
                        class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500 hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total Teachers</p>
                                <p class="text-2xl font-bold text-gray-900 mt-1">
                                    {{ $stats['total_teachers'] }}
                                </p>
                                <div class="flex items-center mt-2">
                                    <span
                                        class="text-xs text-green-600 bg-green-50 px-2 py-1 rounded-full flex items-center">
                                        <i class="fas fa-arrow-up text-xs mr-1"></i>
                                        {{ $stats['active_percentage'] ?? 0 }}%
                                    </span>
                                </div>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-chalkboard-teacher text-blue-600 text-lg"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Active Teachers Card -->
                    <div
                        class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500 hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Active Teachers</p>
                                <p class="text-2xl font-bold text-gray-900 mt-1">
                                    {{ $stats['activeTeachers'] ?? 0 }}
                                </p>
                                <div class="flex items-center mt-2">
                                    <span class="text-xs text-green-600 bg-green-50 px-2 py-1 rounded-full">
                                        {{ number_format($stats['activePercentage'] ?? 0) }}% active
                                    </span>
                                </div>
                            </div>
                            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-user-check text-green-600 text-lg"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Teachers Card -->
                    <div
                        class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-500 hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Pending Teachers</p>
                                <p class="text-2xl font-bold text-gray-900 mt-1">
                                    {{ $stats['pendingTeachers'] ?? 0 }}
                                </p>
                                <div class="flex items-center mt-2">
                                    <span class="text-xs text-purple-600 bg-purple-50 px-2 py-1 rounded-full">
                                        {{ number_format($stats['pendingPercentage'] ?? 0) }}% pending
                                    </span>
                                </div>
                            </div>
                            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-clock text-purple-600 text-lg"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Inactive Teachers Card -->
                    <div
                        class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-orange-500 hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Inactive Teachers</p>
                                <p class="text-2xl font-bold text-gray-900 mt-1">
                                    {{ $stats['inactiveTeachers'] ?? 0 }}
                                </p>
                                <div class="flex items-center mt-2">
                                    <span
                                        class="text-xs text-orange-600 bg-orange-50 px-2 py-1 rounded-full flex items-center">
                                        <i class="fas fa-info-circle text-xs mr-1"></i>
                                        {{ number_format($stats['inactivePercentage'] ?? 0) }}% inactive
                                    </span>
                                </div>
                            </div>
                            <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-user-slash text-orange-600 text-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filters Card -->
                <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">Filters & Search</h2>
                        <div class="text-sm text-gray-500">
                            @if (isset($teachers))
                                Showing {{ $teachers->count() }} of {{ $teachers->total() }} teachers
                            @else
                                Showing 0 teachers
                            @endif
                        </div>
                    </div>

                    <form method="GET" action="{{ route('admin.teachers.index') }}"
                        class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                            <div class="relative">
                                <input type="text" name="search" placeholder="Name or email..."
                                    value="{{ request('search') }}"
                                    class="w-full border border-gray-300 rounded-lg pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                    <i class="fas fa-search"></i>
                                </span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Department</label>
                            <select name="department"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">All Departments</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}"
                                        {{ request('department') == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select name="status"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active
                                </option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive
                                </option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Employment Type</label>
                            <select name="employment_type"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">All Types</option>
                                <option value="full_time"
                                    {{ request('employment_type') == 'full_time' ? 'selected' : '' }}>Full Time</option>
                                <option value="part_time"
                                    {{ request('employment_type') == 'part_time' ? 'selected' : '' }}>Part Time</option>
                                <option value="contract" {{ request('employment_type') == 'contract' ? 'selected' : '' }}>
                                    Contract</option>
                            </select>
                        </div>

                        <div class="flex items-end space-x-2">
                            <button type="submit"
                                class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center gap-2">
                                <i class="fas fa-filter"></i>
                                Apply
                            </button>
                            <a href="{{ route('admin.teachers.index') }}"
                                class="flex-1 bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors flex items-center justify-center gap-2">
                                <i class="fas fa-refresh"></i>
                                Reset
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Teachers Table Card -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-gray-900">Teacher Records</h2>
                        <div class="flex items-center space-x-3">
                            <button
                                class="px-3 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors flex items-center gap-2">
                                <i class="fas fa-download"></i>
                                Export
                            </button>
                            <div class="text-sm text-gray-500">
                                @if (isset($teachers))
                                    Showing {{ $teachers->firstItem() ?? 0 }}-{{ $teachers->lastItem() ?? 0 }} of
                                    {{ $teachers->total() }} teachers
                                @else
                                    Showing 0 teachers
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-100">
                                    <th
                                        class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Teacher
                                    </th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Department
                                    </th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Contact Info
                                    </th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Employment Type
                                    </th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Created At
                                    </th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @if (isset($teachers) && $teachers->count() > 0)
                                    @foreach ($teachers as $teacher)
                                        <tr class="hover:bg-gray-50 transition-colors group">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center space-x-4">
                                                    <div class="relative">
                                                        <img class="h-12 w-12 rounded-xl object-cover border-2 border-white shadow-sm"
                                                            src="{{ $teacher->avatar ? asset('storage/' . $teacher->avatar) : asset('images/default-avatar.png') }}"
                                                            alt="{{ $teacher->name }}">
                                                        <div
                                                            class="absolute -bottom-1 -right-1 w-3 h-3
                                                            {{ $teacher->status == 'active'
                                                                ? 'bg-green-400'
                                                                : ($teacher->status == 'pending'
                                                                    ? 'bg-yellow-400'
                                                                    : 'bg-red-400') }}
                                                            rounded-full border-2 border-white">
                                                        </div>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <div class="flex items-center space-x-2">
                                                            <p class="text-sm font-semibold text-gray-900 truncate">
                                                                {{ $teacher->name }}</p>
                                                            @if ($teacher->status == 'active')
                                                                <span
                                                                    class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs bg-blue-100 text-blue-800">
                                                                    <i class="fas fa-award mr-1 text-xs"></i>
                                                                    Active
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <p class="text-sm text-gray-500 truncate">{{ $teacher->email }}
                                                        </p>
                                                        <p class="text-xs text-gray-400 mt-1">ID: {{ $teacher->id }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    @if ($teacher->department)
                                                        {{ $teacher->department->name }}
                                                    @else
                                                        <span class="text-gray-400">No department</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $teacher->email }}</div>
                                                @if ($teacher->phone)
                                                    <div class="text-xs text-gray-500">{{ $teacher->phone }}</div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    {{ $teacher->employment_type == 'full_time'
                                                        ? 'bg-blue-100 text-blue-800'
                                                        : ($teacher->employment_type == 'part_time'
                                                            ? 'bg-purple-100 text-purple-800'
                                                            : 'bg-orange-100 text-orange-800') }}">
                                                    <i
                                                        class="fas
                                                        {{ $teacher->employment_type == 'full_time'
                                                            ? 'fa-user-tie'
                                                            : ($teacher->employment_type == 'part_time'
                                                                ? 'fa-user-clock'
                                                                : 'fa-file-contract') }}
                                                        mr-1 text-xs"></i>
                                                    {{ ucfirst(str_replace('_', ' ', $teacher->employment_type)) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    {{ $teacher->status == 'active'
                                                        ? 'bg-green-100 text-green-800'
                                                        : ($teacher->status == 'pending'
                                                            ? 'bg-yellow-100 text-yellow-800'
                                                            : 'bg-red-100 text-red-800') }}">
                                                    <i
                                                        class="fas
                                                        {{ $teacher->status == 'active'
                                                            ? 'fa-check-circle'
                                                            : ($teacher->status == 'pending'
                                                                ? 'fa-clock'
                                                                : 'fa-times-circle') }}
                                                        mr-1 text-xs"></i>
                                                    {{ ucfirst($teacher->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ $teacher->created_at->format('M d, Y') }}</div>
                                                <div class="text-xs text-gray-500">
                                                    {{ $teacher->created_at->diffForHumans() }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div
                                                    class="flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <a href="{{ route('admin.teachers.show', $teacher->id) }}"
                                                        class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors"
                                                        title="View Profile">
                                                        <i class="fas fa-eye mr-1 text-xs"></i>
                                                        View
                                                    </a>
                                                    <a href="{{ route('admin.teachers.edit', $teacher->id) }}"
                                                        class="inline-flex items-center px-3 py-1.5 border border-blue-300 rounded-lg text-sm font-medium text-blue-700 bg-white hover:bg-blue-50 transition-colors"
                                                        title="Edit Teacher">
                                                        <i class="fas fa-edit mr-1 text-xs"></i>
                                                        Edit
                                                    </a>
                                                    <form action="{{ route('admin.teachers.destroy', $teacher->id) }}"
                                                        method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="inline-flex items-center px-3 py-1.5 border border-red-300 rounded-lg text-sm font-medium text-red-700 bg-white hover:bg-red-50 transition-colors"
                                                            title="Delete Teacher"
                                                            onclick="return confirm('Are you sure you want to delete this teacher?')">
                                                            <i class="fas fa-trash mr-1 text-xs"></i>
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="px-6 py-8 text-center">
                                            <div class="text-gray-500">
                                                <i class="fas fa-chalkboard-teacher text-4xl mb-4 text-gray-300"></i>
                                                <p class="text-lg font-medium">No teachers found</p>
                                                <p class="text-sm mt-2">No teacher records match your search criteria.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if (isset($teachers) && $teachers->hasPages())
                        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex items-center justify-between">
                            <div class="text-sm text-gray-500">
                                Showing {{ $teachers->firstItem() }} to {{ $teachers->lastItem() }} of
                                {{ $teachers->total() }} entries
                            </div>
                            <div class="flex items-center space-x-2">
                                {{ $teachers->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Import Modal -->
    <div id="importModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Import Teachers</h3>
            </div>
            <div class="p-6">
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center">
                    <i class="fas fa-file-excel text-green-500 text-3xl mb-4"></i>
                    <p class="text-sm text-gray-600 mb-4">Upload Excel file with teacher data</p>
                    <input type="file" accept=".xlsx,.xls,.csv" class="hidden" id="fileInput">
                    <button onclick="document.getElementById('fileInput').click()"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        Choose File
                    </button>
                </div>
                <div class="mt-4 text-xs text-gray-500">
                    <p>Download <a href="#" class="text-blue-600 hover:underline">template file</a> for reference
                    </p>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 flex justify-end gap-3">
                <button onclick="closeImportModal()"
                    class="px-4 py-2 text-gray-600 hover:text-gray-800 transition-colors">
                    Cancel
                </button>
                <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    Import Teachers
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function openImportModal() {
            document.getElementById('importModal').classList.remove('hidden');
        }

        function closeImportModal() {
            document.getElementById('importModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.addEventListener('click', function(e) {
            if (e.target.id === 'importModal') {
                closeImportModal();
            }
        });
    </script>
@endpush

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
@endpush
