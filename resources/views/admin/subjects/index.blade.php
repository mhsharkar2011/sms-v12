@extends('layouts.admin')

@section('title', 'Subjects Management')

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
                            <h1 class="text-2xl font-bold text-gray-900">Subjects Management</h1>
                            <p class="text-gray-600 mt-1">Manage all subjects in the curriculum</p>
                        </div>
                        <a href="{{ route('admin.subjects.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <i class="fas fa-plus-circle mr-2"></i>Add New Subject
                        </a>
                    </div>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                        <div class="bg-white rounded-lg shadow border-l-4 border-blue-500 p-4">
                            <div class="flex items-center">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-600 uppercase">Total Subjects</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ $subjects->total() }}</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <i class="fas fa-book text-2xl text-gray-300"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg shadow border-l-4 border-green-500 p-4">
                            <div class="flex items-center">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-600 uppercase">Active Subjects</p>
                                    <p class="text-2xl font-bold text-gray-900">
                                        {{ $subjects->where('is_active', true)->count() }}</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <i class="fas fa-check-circle text-2xl text-gray-300"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg shadow border-l-4 border-cyan-500 p-4">
                            <div class="flex items-center">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-600 uppercase">Core Subjects</p>
                                    <p class="text-2xl font-bold text-gray-900">
                                        {{ $subjects->where('category', 'core')->count() }}</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <i class="fas fa-star text-2xl text-gray-300"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg shadow border-l-4 border-yellow-500 p-4">
                            <div class="flex items-center">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-600 uppercase">Average Difficulty</p>
                                    <p class="text-2xl font-bold text-gray-900">
                                        {{ number_format($subjects->avg('difficulty_level') ?? 0, 1) }}/5</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <i class="fas fa-chart-line text-2xl text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filters Card -->
                    <div class="bg-white rounded-lg shadow mb-6">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 flex items-center">
                                <i class="fas fa-filter mr-2 text-blue-500"></i>Filters & Search
                            </h3>
                        </div>
                        <div class="p-4 sm:p-6">
                            <form action="{{ route('admin.subjects.index') }}" method="GET" id="filterForm">
                                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Search Subjects</label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-search text-gray-400"></i>
                                            </div>
                                            <input type="text" name="search"
                                                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                                                placeholder="Name or code..." value="{{ request('search') }}">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                                        <select name="category"
                                            class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">All Categories</option>
                                            <option value="core" {{ request('category') == 'core' ? 'selected' : '' }}>
                                                Core</option>
                                            <option value="elective"
                                                {{ request('category') == 'elective' ? 'selected' : '' }}>Elective</option>
                                            <option value="extracurricular"
                                                {{ request('category') == 'extracurricular' ? 'selected' : '' }}>
                                                Extracurricular</option>
                                            <option value="vocational"
                                                {{ request('category') == 'vocational' ? 'selected' : '' }}>Vocational
                                            </option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                        <select name="is_active"
                                            class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">All Status</option>
                                            <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>
                                                Active</option>
                                            <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>
                                                Inactive</option>
                                        </select>
                                    </div>

                                    <div class="flex items-end space-x-2">
                                        <button type="submit"
                                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 flex-1">
                                            <i class="fas fa-filter mr-2"></i>Apply
                                        </button>
                                        <a href="{{ route('admin.subjects.index') }}"
                                            class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            <i class="fas fa-redo mr-2"></i>Reset
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Subjects Table Card -->
                    <div class="bg-white rounded-lg shadow">
                        <div
                            class="px-4 py-5 sm:px-6 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                            <h3 class="text-lg font-medium text-gray-900 flex items-center mb-2 sm:mb-0">
                                <i class="fas fa-list mr-2 text-blue-500"></i>Subjects List
                            </h3>
                            <div class="flex items-center space-x-3">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    Showing {{ $subjects->firstItem() ?? 0 }}-{{ $subjects->lastItem() ?? 0 }} of
                                    {{ $subjects->total() }}
                                </span>
                                <div class="relative">
                                    <button type="button"
                                        class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <i class="fas fa-download mr-2"></i>Export
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Subject</th>
                                            <th scope="col"
                                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Category</th>
                                            <th scope="col"
                                                class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Credits</th>
                                            <th scope="col"
                                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Difficulty</th>
                                            <th scope="col"
                                                class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Status</th>
                                            <th scope="col"
                                                class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse($subjects as $subject)
                                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                                <td class="px-4 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div
                                                            class="flex-shrink-0 h-10 w-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                                            {{ substr($subject->code, 0, 3) }}
                                                        </div>
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-gray-900">
                                                                {{ $subject->name }}</div>
                                                            <div class="text-sm text-gray-500">{{ $subject->code }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-4 whitespace-nowrap">
                                                    @php
                                                        $categoryColors = [
                                                            'core' => 'bg-blue-100 text-blue-800',
                                                            'elective' => 'bg-green-100 text-green-800',
                                                            'extracurricular' => 'bg-yellow-100 text-yellow-800',
                                                            'vocational' => 'bg-cyan-100 text-cyan-800',
                                                        ];
                                                        $categoryIcons = [
                                                            'core' => 'fa-star',
                                                            'elective' => 'fa-list',
                                                            'extracurricular' => 'fa-running',
                                                            'vocational' => 'fa-tools',
                                                        ];
                                                    @endphp
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $categoryColors[$subject->category] ?? 'bg-gray-100 text-gray-800' }}">
                                                        <i
                                                            class="fas {{ $categoryIcons[$subject->category] ?? 'fa-circle' }} mr-1 text-xs"></i>
                                                        {{ ucfirst($subject->category) }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-4 whitespace-nowrap text-center">
                                                    <span
                                                        class="text-lg font-bold text-blue-600">{{ $subject->credit_hours }}</span>
                                                    <div class="text-xs text-gray-500">hours</div>
                                                </td>
                                                <td class="px-4 py-4 whitespace-nowrap">
                                                    <div class="flex items-center space-x-3">
                                                        <div class="flex-shrink-0">
                                                            <div class="text-xs text-gray-500">Level
                                                                {{ $subject->difficulty_level }}</div>
                                                            <div class="flex space-x-1">
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    <i
                                                                        class="fas fa-star text-{{ $i <= $subject->difficulty_level ? 'yellow-400' : 'gray-300' }} text-xs"></i>
                                                                @endfor
                                                            </div>
                                                        </div>
                                                        <div class="flex-1">
                                                            <div class="w-full bg-gray-200 rounded-full h-1.5">
                                                                <div class="h-1.5 rounded-full
                                                                @if ($subject->difficulty_level <= 2) bg-green-500
                                                                @elseif($subject->difficulty_level <= 4) bg-yellow-500
                                                                @else bg-red-500 @endif"
                                                                    style="width: {{ ($subject->difficulty_level / 5) * 100 }}%">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-4 whitespace-nowrap text-center">
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $subject->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                        <i
                                                            class="fas {{ $subject->is_active ? 'fa-check' : 'fa-times' }} mr-1 text-xs"></i>
                                                        {{ $subject->is_active ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <div class="flex justify-end space-x-2">
                                                        <a href="{{ route('admin.subjects.show', $subject->id) }}"
                                                            class="text-blue-600 hover:text-blue-900 p-1 rounded transition-colors duration-150"
                                                            title="View Details">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('admin.subjects.edit', $subject->id) }}"
                                                            class="text-yellow-600 hover:text-yellow-900 p-1 rounded transition-colors duration-150"
                                                            title="Edit Subject">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('admin.subjects.destroy', $subject->id) }}"
                                                            method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="text-red-600 hover:text-red-900 p-1 rounded transition-colors duration-150"
                                                                title="Delete Subject"
                                                                onclick="return confirm('Are you sure you want to delete this subject? This action cannot be undone.')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="px-4 py-12 text-center">
                                                    <div class="flex flex-col items-center justify-center">
                                                        <i class="fas fa-book text-4xl text-gray-300 mb-3"></i>
                                                        <h4 class="text-lg font-medium text-gray-900 mb-2">No subjects
                                                            found</h4>
                                                        <p class="text-gray-500 mb-4">No subjects match your current
                                                            filters.</p>
                                                        @if (request()->hasAny(['search', 'category', 'is_active']))
                                                            <a href="{{ route('admin.subjects.index') }}"
                                                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                                <i class="fas fa-redo mr-2"></i>Clear Filters
                                                            </a>
                                                        @else
                                                            <a href="{{ route('admin.subjects.create') }}"
                                                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                                <i class="fas fa-plus mr-2"></i>Create First Subject
                                                            </a>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="px-4 py-3 bg-gray-50 border-t border-gray-200 sm:px-6">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                <div class="text-sm text-gray-700 mb-2 sm:mb-0">
                                    Showing {{ $subjects->firstItem() ?? 0 }} to {{ $subjects->lastItem() ?? 0 }} of
                                    {{ $subjects->total() }} results
                                </div>
                                <div>
                                    {{ $subjects->links() }}
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

            // Auto-submit form on filter change
            const filterForm = document.getElementById('filterForm');
            const filterSelects = filterForm.querySelectorAll('select');

            filterSelects.forEach(select => {
                select.addEventListener('change', function() {
                    filterForm.submit();
                });
            });
        });
    </script>
@endpush
