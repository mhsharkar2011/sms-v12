@extends('layouts.app')

@section('title', 'Teachers Management')

@section('content')
    <div class="min-h-screen bg-gray-50 flex">
        <x-admin-sidebar />

        <div class="flex-1 overflow-auto">
            <div class="container mx-auto p-6">
                <!-- Flash Messages -->
                @if (session('success'))
                    <div class="alert-success mb-6">
                        <div class="bg-green-50 border border-green-200 rounded-xl p-4 shadow-sm">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-check-circle text-green-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                                    </div>
                                </div>
                                <button type="button" onclick="this.parentElement.parentElement.remove()"
                                    class="text-green-400 hover:text-green-600 transition-colors">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert-error mb-6">
                        <div class="bg-red-50 border border-red-200 rounded-xl p-4 shadow-sm">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-exclamation-circle text-red-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                                    </div>
                                </div>
                                <button type="button" onclick="this.parentElement.parentElement.remove()"
                                    class="text-red-400 hover:text-red-600 transition-colors">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Header -->
                <div class="mb-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Teachers Management</h1>
                            <p class="text-gray-600 mt-2">Manage teacher records, assignments, and information</p>
                        </div>
                        <a href="{{ route('admin.teachers.create') }}"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2">
                            <i class="fas fa-plus"></i>
                            <span>Add New Teacher</span>
                        </a>
                    </div>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    @php
                        // Default stats if not provided by controller
                        $defaultStats = [
                            'total_teachers' => 0,
                            'active_today' => 0,
                            'on_leave' => 0,
                            'subjects_covered' => 0,
                        ];
                        $stats = $stats ?? $defaultStats;
                    @endphp

                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Total Teachers</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_teachers'] }}</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-users text-blue-600"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Active Today</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $stats['active_today'] }}</p>
                            </div>
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-check-circle text-green-600"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">On Leave</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $stats['on_leave'] }}</p>
                            </div>
                            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-umbrella-beach text-yellow-600"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Subjects Covered</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $stats['subjects_covered'] }}</p>
                            </div>
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-book text-purple-600"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rest of your view remains the same -->
                <!-- Filters -->
                <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                    <form method="GET" action="{{ route('admin.teachers.index') }}"
                        class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                            <div class="relative">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Search teachers..."
                                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <i
                                    class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                            <select name="subject"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">All Subjects</option>
                                @foreach ($subjects ?? [] as $subject)
                                    <option value="{{ $subject }}"
                                        {{ request('subject') == $subject ? 'selected' : '' }}>
                                        {{ $subject }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select name="status"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active
                                </option>
                                <option value="on_leave" {{ request('status') == 'on_leave' ? 'selected' : '' }}>On Leave
                                </option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                        </div>

                        <div class="flex items-end space-x-2">
                            <button type="submit"
                                class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center space-x-2">
                                <i class="fas fa-filter"></i>
                                <span>Apply Filters</span>
                            </button>
                            <a href="{{ route('admin.teachers.index') }}"
                                class="flex-1 bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors flex items-center justify-center space-x-2">
                                <i class="fas fa-refresh"></i>
                                <span>Reset</span>
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Teachers Table -->
                <div class="bg-white rounded-xl shadow-sm">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <h2 class="text-xl font-bold text-gray-900">All Teachers</h2>
                            <div class="text-sm text-gray-600">
                                Showing {{ $teachers->firstItem() ?? 0 }} to {{ $teachers->lastItem() ?? 0 }} of
                                {{ $teachers->total() ?? 0 }} teachers
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-200 bg-gray-50">
                                    <th class="text-left py-4 px-6 text-sm font-medium text-gray-700">Teacher</th>
                                    <th class="text-left py-4 px-6 text-sm font-medium text-gray-700">Subject</th>
                                    <th class="text-left py-4 px-6 text-sm font-medium text-gray-700">Classes</th>
                                    <th class="text-left py-4 px-6 text-sm font-medium text-gray-700">Contact</th>
                                    <th class="text-left py-4 px-6 text-sm font-medium text-gray-700">Status</th>
                                    <th class="text-left py-4 px-6 text-sm font-medium text-gray-700">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($teachers ?? [] as $teacher)
                                    <tr class="hover:bg-gray-50 transition-colors group">
                                        <td class="py-4 px-6">
                                            <div class="flex items-center space-x-3">
                                                <div
                                                    class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                    @if (isset($teacher->avatar) && $teacher->avatar)
                                                        <img src="{{ asset('storage/' . $teacher->avatar) }}"
                                                            alt="{{ $teacher->name }}"
                                                            class="w-10 h-10 rounded-full object-cover">
                                                    @else
                                                        <i class="fas fa-user text-blue-600"></i>
                                                    @endif
                                                </div>
                                                <div>
                                                    <p class="font-medium text-gray-900">{{ $teacher->name }}</p>
                                                    <p class="text-sm text-gray-600">ID: {{ $teacher->teacher_id }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6 text-sm text-gray-900">
                                            {{ $teacher->subject }}
                                        </td>
                                        <td class="py-4 px-6 text-sm text-gray-900">
                                            @if (isset($teacher->classes) && $teacher->classes->count() > 0)
                                                {{ $teacher->classes->pluck('name')->implode(', ') }}
                                            @else
                                                <span class="text-gray-400">Not assigned</span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6 text-sm text-gray-900">
                                            <div>{{ $teacher->email }}</div>
                                            @if ($teacher->phone)
                                                <div class="text-gray-600">{{ $teacher->phone }}</div>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6">
                                            @php
                                                $statusColors = [
                                                    'active' => 'bg-green-100 text-green-800',
                                                    'on_leave' => 'bg-yellow-100 text-yellow-800',
                                                    'inactive' => 'bg-red-100 text-red-800',
                                                ];
                                                $statusColor =
                                                    $statusColors[$teacher->status] ?? 'bg-gray-100 text-gray-800';
                                            @endphp
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusColor }}">
                                                {{ ucfirst(str_replace('_', ' ', $teacher->status)) }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-6">
                                            <div
                                                class="flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                                <a href="{{ route('admin.teachers.edit', $teacher) }}"
                                                    class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center hover:bg-blue-200 transition-colors"
                                                    title="Edit Teacher">
                                                    <i class="fas fa-edit text-sm"></i>
                                                </a>
                                                <a href="{{ route('admin.teachers.show', $teacher) }}"
                                                    class="w-8 h-8 bg-green-100 text-green-600 rounded-lg flex items-center justify-center hover:bg-green-200 transition-colors"
                                                    title="View Details">
                                                    <i class="fas fa-eye text-sm"></i>
                                                </a>
                                                <form action="{{ route('admin.teachers.destroy', $teacher) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        onclick="return confirm('Are you sure you want to delete {{ $teacher->name }}? This action cannot be undone.')"
                                                        class="w-8 h-8 bg-red-100 text-red-600 rounded-lg flex items-center justify-center hover:bg-red-200 transition-colors"
                                                        title="Delete Teacher">
                                                        <i class="fas fa-trash text-sm"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-8 px-6 text-center">
                                            <div
                                                class="w-24 h-24 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                                <i class="fas fa-users text-gray-400 text-2xl"></i>
                                            </div>
                                            <h3 class="text-lg font-medium text-gray-900 mb-2">No teachers found</h3>
                                            <p class="text-gray-500 mb-4">
                                                @if (request()->anyFilled(['search', 'subject', 'status']))
                                                    Try adjusting your search filters or
                                                @endif
                                                Add your first teacher to get started.
                                            </p>
                                            @if (request()->anyFilled(['search', 'subject', 'status']))
                                                <a href="{{ route('admin.teachers.index') }}"
                                                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors mr-2">
                                                    <i class="fas fa-refresh mr-2"></i>
                                                    Clear filters
                                                </a>
                                            @endif
                                            <a href="{{ route('admin.teachers.create') }}"
                                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                                                <i class="fas fa-plus mr-2"></i>
                                                Add New Teacher
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if (isset($teachers) && $teachers->hasPages())
                        <div class="p-6 border-t border-gray-200">
                            <div class="flex items-center justify-between">
                                <p class="text-sm text-gray-700">
                                    Showing {{ $teachers->firstItem() }} to {{ $teachers->lastItem() }} of
                                    {{ $teachers->total() }} teachers
                                </p>
                                <div class="flex items-center space-x-2">
                                    {{ $teachers->links() }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
