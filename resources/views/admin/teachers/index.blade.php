@extends('layouts.admin')

@section('title', 'Teacher Management')

@section('content')
    <div class="min-h-screen bg-gray-50 flex">
        <x-admin-sidebar active-route="admin.teachers.index" />

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <div class="container mx-auto p-6">
                <!-- Header -->
                <div class="bg-white/80 backdrop-blur-xl border-b border-gray-200/60 sticky top-0 z-30">
                    <div class="px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <button class="lg:hidden text-gray-500 hover:text-gray-700">
                                    <i class="fas fa-bars text-lg"></i>
                                </button>
                                <div>
                                    <h1
                                        class="text-2xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">
                                        Teacher Management
                                    </h1>
                                    <p class="text-gray-500 mt-1">Manage all teacher records and information</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="relative group">
                                    <input type="text" placeholder="Search teachers..."
                                        class="pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white/50 backdrop-blur-sm w-64 transition-all duration-200 group-hover:bg-white/80">
                                    <span
                                        class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-500">
                                        <i class="fas fa-search"></i>
                                    </span>
                                </div>
                                <button onclick="openImportModal()"
                                    class="px-4 py-2.5 border border-gray-200 rounded-xl text-gray-600 hover:bg-white hover:shadow-sm transition-all duration-200 flex items-center gap-2 backdrop-blur-sm">
                                    <i class="fas fa-file-import"></i>
                                    <span class="hidden sm:inline">Import</span>
                                </button>
                                <a href="{{ route('admin.teachers.create') }}"
                                    class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-4 py-2.5 rounded-xl flex items-center gap-2 transition-all duration-200 shadow-lg shadow-blue-500/25 hover:shadow-xl hover:shadow-blue-500/30">
                                    <i class="fas fa-plus"></i>
                                    <span class="hidden sm:inline">Add Teacher</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <!-- Stats Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
                        <!-- Total Teachers -->
                        <div
                            class="bg-white rounded-2xl shadow-xs border border-gray-100 p-6 hover:shadow-md transition-all duration-300 group">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Total Teachers</p>
                                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_teachers'] }}</p>
                                    <div class="flex items-center mt-3">
                                        <span
                                            class="text-xs text-green-600 bg-green-50 px-2.5 py-1 rounded-full flex items-center gap-1">
                                            <i class="fas fa-arrow-up text-xs"></i>
                                            {{ $stats['total_teachers'] ?? 0 }}% active
                                        </span>
                                    </div>
                                </div>
                                <div
                                    class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/25 group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-chalkboard-teacher text-white text-xl"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Active Teachers -->
                        <div
                            class="bg-white rounded-2xl shadow-xs border border-gray-100 p-6 hover:shadow-md transition-all duration-300 group">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Active Teachers</p>
                                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['active_teachers'] ?? 0 }}
                                    </p>
                                    <div class="flex items-center mt-3">
                                        <span class="text-xs text-green-600 bg-green-50 px-2.5 py-1 rounded-full">
                                            {{ number_format($stats['active_percentage'] ?? 0) }}% of total
                                        </span>
                                    </div>
                                </div>
                                <div
                                    class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg shadow-green-500/25 group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-user-check text-white text-xl"></i>
                                </div>
                            </div>
                        </div>

                        <!-- On Leave -->
                        <div
                            class="bg-white rounded-2xl shadow-xs border border-gray-100 p-6 hover:shadow-md transition-all duration-300 group">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">On Leave</p>
                                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['onLeaveTeachers'] ?? 0 }}
                                    </p>
                                    <div class="flex items-center mt-3">
                                        <span class="text-xs text-yellow-600 bg-yellow-50 px-2.5 py-1 rounded-full">
                                            {{ number_format($stats['onLeavePercentage'] ?? 0) }}% on leave
                                        </span>
                                    </div>
                                </div>
                                <div
                                    class="w-14 h-14 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl flex items-center justify-center shadow-lg shadow-yellow-500/25 group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-umbrella-beach text-white text-xl"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Inactive Teachers -->
                        <div
                            class="bg-white rounded-2xl shadow-xs border border-gray-100 p-6 hover:shadow-md transition-all duration-300 group">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Inactive</p>
                                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['inactiveTeachers'] ?? 0 }}
                                    </p>
                                    <div class="flex items-center mt-3">
                                        <span class="text-xs text-red-600 bg-red-50 px-2.5 py-1 rounded-full">
                                            {{ number_format($stats['inactivePercentage'] ?? 0) }}% inactive
                                        </span>
                                    </div>
                                </div>
                                <div
                                    class="w-14 h-14 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl flex items-center justify-center shadow-lg shadow-red-500/25 group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-user-slash text-white text-xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filters Card -->
                    <div class="bg-white rounded-2xl shadow-xs border border-gray-100 p-6 mb-6">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
                            <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                <i class="fas fa-filter text-blue-500"></i>
                                Filters & Search
                            </h2>
                            <div class="text-sm text-gray-500 bg-gray-50 px-3 py-1.5 rounded-lg">
                                @if (isset($teachers) && $teachers->count() > 0)
                                    Showing {{ $teachers->count() }} of {{ $teachers->total() }} teachers
                                @else
                                    No teachers found
                                @endif
                            </div>
                        </div>

                        <form method="GET" action="{{ route('admin.teachers.index') }}"
                            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                            <!-- Search -->
                            <div class="lg:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Search Teachers</label>
                                <div class="relative group">
                                    <input type="text" name="search" placeholder="Name, email, or ID..."
                                        value="{{ request('search') }}"
                                        class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-200 group-hover:bg-white/80">
                                    <span
                                        class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-500">
                                        <i class="fas fa-search"></i>
                                    </span>
                                </div>
                            </div>

                            <!-- Department -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Department</label>
                                <select name="department_id"
                                    class="w-full px-3 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-200 hover:bg-white/80">
                                    <option value="">All Departments</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}"
                                            {{ request('department_id') == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Status -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                <select name="status"
                                    class="w-full px-3 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-200 hover:bg-white/80">
                                    <option value="">All Status</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="on_leave" {{ request('status') == 'on_leave' ? 'selected' : '' }}>On
                                        Leave
                                    </option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                </select>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-end gap-2">
                                <button type="submit"
                                    class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-4 py-3 rounded-xl transition-all duration-200 shadow-lg shadow-blue-500/25 hover:shadow-xl hover:shadow-blue-500/30 flex items-center justify-center gap-2">
                                    <i class="fas fa-filter"></i>
                                    Apply
                                </button>
                                <a href="{{ route('admin.teachers.index') }}"
                                    class="flex-1 bg-gray-500 hover:bg-gray-600 text-white px-4 py-3 rounded-xl transition-all duration-200 flex items-center justify-center gap-2">
                                    <i class="fas fa-refresh"></i>
                                    Reset
                                </a>
                            </div>
                        </form>
                    </div>

                    <!-- Teachers Table Card -->
                    <div class="bg-white rounded-2xl shadow-xs border border-gray-100 overflow-hidden">
                        <!-- Table Header -->
                        <div
                            class="px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                <i class="fas fa-list text-blue-500"></i>
                                Teacher Records
                            </h2>
                            <div class="flex items-center gap-3">
                                <button
                                    class="px-3 py-2 border border-gray-200 rounded-xl text-gray-600 hover:bg-gray-50 transition-all duration-200 flex items-center gap-2">
                                    <i class="fas fa-download"></i>
                                    <span class="hidden sm:inline">Export</span>
                                </button>
                                <div class="text-sm text-gray-500 bg-gray-50 px-3 py-1.5 rounded-lg">
                                    @if (isset($teachers) && $teachers->count() > 0)
                                        Showing {{ $teachers->firstItem() ?? 0 }}-{{ $teachers->lastItem() ?? 0 }} of
                                        {{ $teachers->total() }}
                                    @else
                                        Showing 0 teachers
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-gray-50/80 border-b border-gray-100">
                                        <th
                                            class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                            Teacher</th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                            Department</th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                            Contact</th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                            Status</th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                            Joined</th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse($teachers ?? [] as $teacher)
                                        <tr class="hover:bg-gray-50/50 transition-all duration-200 group">
                                            <!-- Teacher Info -->
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center space-x-4">
                                                    <div class="relative">
                                                        <div class="flex-shrink-0 h-10 w-10">
                                                            @if ($teacher->avatar && Storage::exists($teacher->avatar))
                                                                <img class="h-10 w-10 rounded-full object-cover"
                                                                    src="{{ asset('storage/avatars' . $teacher->avatar_url) ?? asset('avatars/default-avatar.png') }}"
                                                                    alt="{{ $teacher->user->name }}">
                                                            @else
                                                                <img class="h-10 w-10 rounded-full object-cover"
                                                                    src="{{ asset('avatars/default-avatar.png') }}"
                                                                    alt="{{ $teacher->user->name }}">
                                                            @endif
                                                        </div>
                                                        <div
                                                            class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full border-2 border-white
                                                    {{ $teacher->status == 'active' ? 'bg-green-400' : ($teacher->status == 'on_leave' ? 'bg-yellow-400' : 'bg-red-400') }}">
                                                        </div>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <div class="flex items-center space-x-2">
                                                            <p class="text-sm font-semibold text-gray-900 truncate">
                                                                {{ $teacher->name }}</p>
                                                            @if ($teacher->status == 'active')
                                                                <span
                                                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-xs bg-blue-100 text-blue-800">
                                                                    <i class="fas fa-award mr-1 text-xs"></i>
                                                                    Verified
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <p class="text-sm text-gray-500 truncate">{{ $teacher->email }}
                                                        </p>
                                                        <p class="text-xs text-gray-400 mt-1">ID:
                                                            {{ $teacher->teacher_id }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- Department -->
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center space-x-2">
                                                    @if ($teacher->department)
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                                            <i class="fas fa-building mr-1.5 text-xs"></i>
                                                            {{ $teacher->department->name }}
                                                        </span>
                                                    @else
                                                        <span class="text-gray-400 text-sm">—</span>
                                                    @endif
                                                </div>
                                            </td>

                                            <!-- Contact -->
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $teacher->email }}</div>
                                                @if ($teacher->phone)
                                                    <div class="text-xs text-gray-500 flex items-center gap-1 mt-1">
                                                        <i class="fas fa-phone text-gray-400"></i>
                                                        {{ $teacher->phone }}
                                                    </div>
                                                @endif
                                            </td>

                                            <!-- Status -->
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium border
                                            {{ $teacher->status == 'active'
                                                ? 'bg-green-50 text-green-700 border-green-200'
                                                : ($teacher->status == 'on_leave'
                                                    ? 'bg-yellow-50 text-yellow-700 border-yellow-200'
                                                    : 'bg-red-50 text-red-700 border-red-200') }}">
                                                    <i
                                                        class="fas
                                                {{ $teacher->status == 'active'
                                                    ? 'fa-check-circle'
                                                    : ($teacher->status == 'on_leave'
                                                        ? 'fa-umbrella-beach'
                                                        : 'fa-times-circle') }}
                                                mr-1.5 text-xs"></i>
                                                    {{ ucfirst(str_replace('_', ' ', $teacher->status)) }}
                                                </span>
                                            </td>

                                            <!-- Joined Date -->
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $teacher->date_of_joining?->format('M d, Y') ?? '—' }}
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    {{ $teacher->date_of_joining?->diffForHumans() ?? '' }}
                                                </div>
                                            </td>

                                            <!-- Actions -->
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div
                                                    class="flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition-all duration-200">
                                                    <a href="{{ route('admin.teachers.show', $teacher->id) }}"
                                                        class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-all duration-200 hover:shadow-sm"
                                                        title="View Profile">
                                                        <i class="fas fa-eye mr-1.5 text-xs"></i>
                                                        View
                                                    </a>
                                                    <a href="{{ route('admin.teachers.edit', $teacher->id) }}"
                                                        class="inline-flex items-center px-3 py-1.5 border border-blue-300 rounded-lg text-sm font-medium text-blue-700 bg-white hover:bg-blue-50 transition-all duration-200 hover:shadow-sm"
                                                        title="Edit Teacher">
                                                        <i class="fas fa-edit mr-1.5 text-xs"></i>
                                                        Edit
                                                    </a>
                                                    <form action="{{ route('admin.teachers.destroy', $teacher->id) }}"
                                                        method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="inline-flex items-center px-3 py-1.5 border border-red-300 rounded-lg text-sm font-medium text-red-700 bg-white hover:bg-red-50 transition-all duration-200 hover:shadow-sm"
                                                            title="Delete Teacher"
                                                            onclick="return confirm('Are you sure you want to delete this teacher?')">
                                                            <i class="fas fa-trash mr-1.5 text-xs"></i>
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-12 text-center">
                                                <div class="text-gray-400">
                                                    <i class="fas fa-chalkboard-teacher text-5xl mb-4 opacity-50"></i>
                                                    <p class="text-lg font-medium text-gray-500">No teachers found</p>
                                                    <p class="text-sm mt-2">No teacher records match your search criteria.
                                                    </p>
                                                    <a href="{{ route('admin.teachers.create') }}"
                                                        class="inline-flex items-center px-4 py-2 mt-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                                        <i class="fas fa-plus mr-2"></i>
                                                        Add First Teacher
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if (isset($teachers) && $teachers->hasPages())
                            <div
                                class="px-6 py-4 border-t border-gray-100 bg-gray-50/50 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
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
        <div id="importModal"
            class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center hidden z-50 p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95 opacity-0"
                id="modalContent">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900">Import Teachers</h3>
                </div>
                <div class="p-6">
                    <div
                        class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-blue-400 transition-colors duration-200">
                        <i class="fas fa-file-excel text-green-500 text-4xl mb-4"></i>
                        <p class="text-sm text-gray-600 mb-4">Upload Excel file with teacher data</p>
                        <input type="file" accept=".xlsx,.xls,.csv" class="hidden" id="fileInput">
                        <button onclick="document.getElementById('fileInput').click()"
                            class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-2.5 rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg shadow-blue-500/25">
                            Choose File
                        </button>
                    </div>
                    <div class="mt-4 text-xs text-gray-500 text-center">
                        <p>Download <a href="#" class="text-blue-600 hover:underline font-medium">template file</a>
                            for
                            reference</p>
                    </div>
                </div>
                <div class="px-6 py-4 border-t border-gray-100 flex justify-end gap-3">
                    <button onclick="closeImportModal()"
                        class="px-6 py-2 text-gray-600 hover:text-gray-800 transition-colors font-medium">
                        Cancel
                    </button>
                    <button
                        class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-2 rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg shadow-blue-500/25">
                        Import Teachers
                    </button>
                </div>
            </div>
        </div>
    @endsection

    @push('scripts')
        <script>
            function openImportModal() {
                const modal = document.getElementById('importModal');
                const content = document.getElementById('modalContent');
                modal.classList.remove('hidden');
                setTimeout(() => {
                    content.classList.remove('scale-95', 'opacity-0');
                    content.classList.add('scale-100', 'opacity-100');
                }, 50);
            }

            function closeImportModal() {
                const modal = document.getElementById('importModal');
                const content = document.getElementById('modalContent');
                content.classList.remove('scale-100', 'opacity-100');
                content.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            }

            // Close modal when clicking outside
            document.addEventListener('click', function(e) {
                if (e.target.id === 'importModal') {
                    closeImportModal();
                }
            });

            // Add smooth animations on page load
            document.addEventListener('DOMContentLoaded', function() {
                // Animate stats cards
                const statsCards = document.querySelectorAll('.grid > div');
                statsCards.forEach((card, index) => {
                    card.style.animationDelay = `${index * 100}ms`;
                    card.classList.add('animate-fade-in-up');
                });
            });
        </script>

        <style>
            @keyframes fade-in-up {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .animate-fade-in-up {
                animation: fade-in-up 0.6s ease-out forwards;
            }
        </style>
    @endpush
