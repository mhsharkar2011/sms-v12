@extends('layouts.app')

@section('title', 'User Management')

@section('content')
    <div class="min-h-screen bg-gray-50 flex">
        <x-admin-sidebar />

        <div class="flex-1 overflow-auto">
            <div class="container mx-auto p-6">
                <!-- Header -->
                <div class="mb-6 flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">User Management</h1>
                        <p class="text-gray-600 mt-2">Manage all system users and permissions</p>
                    </div>
                    <button onclick="openAddUserModal()"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
                        <i class="fas fa-plus"></i>
                        Add New User
                    </button>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-white rounded-xl shadow-sm p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total Users</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $totalUsers ?? 0 }}</p>
                            </div>
                            <div class="p-3 bg-blue-100 rounded-lg">
                                <i class="fas fa-users text-blue-600"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Active Users</p>
                                <p class="text-2xl font-bold text-green-600">{{ $activeUsers ?? 0 }}</p>
                            </div>
                            <div class="p-3 bg-green-100 rounded-lg">
                                <i class="fas fa-user-check text-green-600"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Admins</p>
                                <p class="text-2xl font-bold text-purple-600">{{ $adminUsers ?? 0 }}</p>
                            </div>
                            <div class="p-3 bg-purple-100 rounded-lg">
                                <i class="fas fa-shield-alt text-purple-600"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Pending</p>
                                <p class="text-2xl font-bold text-yellow-600">{{ $pendingUsers ?? 0 }}</p>
                            </div>
                            <div class="p-3 bg-yellow-100 rounded-lg">
                                <i class="fas fa-clock text-yellow-600"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Users Table -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                        <h2 class="text-lg font-semibold text-gray-900">All Users</h2>
                        <div class="flex gap-3">
                            <select id="roleFilter" onchange="filterUsers()"
                                class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
                                <option value="">All Roles</option>
                                <option value="admin">Admin</option>
                                <option value="teacher">Teacher</option>
                                <option value="student">Student</option>
                                <option value="parent">Parent</option>
                            </select>
                            <select id="statusFilter" onchange="filterUsers()"
                                class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
                                <option value="">All Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="pending">Pending</option>
                            </select>
                            <div class="relative">
                                <input type="text" id="searchInput" placeholder="Search users..."
                                    class="border border-gray-300 rounded-lg pl-10 pr-4 py-2 text-sm w-64">
                                <i
                                    class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-100">
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        User</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Role</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Last Login</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($users as $user)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <img class="h-10 w-10 rounded-full object-cover"
                                                        src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/default-avatar.png') }}"
                                                        alt="{{ $user->name }}">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                                    <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $user->role === 'admin'
                                            ? 'bg-purple-100 text-purple-800'
                                            : ($user->role === 'teacher'
                                                ? 'bg-blue-100 text-blue-800'
                                                : ($user->role === 'student'
                                                    ? 'bg-green-100 text-green-800'
                                                    : 'bg-gray-100 text-gray-800')) }}">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $user->status === 'active'
                                            ? 'bg-green-100 text-green-800'
                                            : ($user->status === 'inactive'
                                                ? 'bg-red-100 text-red-800'
                                                : 'bg-yellow-100 text-yellow-800') }}">
                                                {{ ucfirst($user->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center gap-2">
                                                <button onclick="openEditModal({{ $user->id }})"
                                                    class="text-blue-600 hover:text-blue-900 transition-colors"
                                                    title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button onclick="openProfileModal({{ $user->id }})"
                                                    class="text-green-600 hover:text-green-900 transition-colors"
                                                    title="View Profile">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                @if ($user->status === 'active')
                                                    <button onclick="toggleStatus({{ $user->id }}, 'inactive')"
                                                        class="text-orange-600 hover:text-orange-900 transition-colors"
                                                        title="Deactivate">
                                                        <i class="fas fa-pause"></i>
                                                    </button>
                                                @else
                                                    <button onclick="toggleStatus({{ $user->id }}, 'active')"
                                                        class="text-green-600 hover:text-green-900 transition-colors"
                                                        title="Activate">
                                                        <i class="fas fa-play"></i>
                                                    </button>
                                                @endif
                                                <button onclick="confirmDelete({{ $user->id }})"
                                                    class="text-red-600 hover:text-red-900 transition-colors"
                                                    title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-100">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit User Modal -->
    <div id="userModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 id="modalTitle" class="text-lg font-semibold text-gray-900">Add New User</h3>
            </div>
            <form id="userForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="p-6 space-y-4">
                    <!-- Avatar Upload -->
                    <div class="flex justify-center">
                        <div class="relative">
                            <img id="avatarPreview" src="{{ asset('images/default-avatar.png') }}"
                                class="w-20 h-20 rounded-full object-cover border-2 border-gray-300">
                            <label for="avatar"
                                class="absolute bottom-0 right-0 bg-blue-600 text-white p-1 rounded-full cursor-pointer hover:bg-blue-700 transition-colors">
                                <i class="fas fa-camera text-xs"></i>
                                <input type="file" id="avatar" name="avatar" class="hidden" accept="image/*"
                                    onchange="previewImage(this)">
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <input type="text" name="name" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                        <select name="role" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="student">Student</option>
                            <option value="teacher">Teacher</option>
                            <option value="admin">Admin</option>
                            <option value="parent">Parent</option>
                        </select>
                    </div>

                    <div id="passwordFields">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input type="password" name="password"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Leave blank to keep current">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="pending">Pending</option>
                        </select>
                    </div>
                </div>
                <div class="px-6 py-4 border-t border-gray-200 flex justify-end gap-3">
                    <button type="button" onclick="closeModal()"
                        class="px-4 py-2 text-gray-600 hover:text-gray-800 transition-colors">Cancel</button>
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">Save
                        User</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Profile View Modal -->
    <div id="profileModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4">
            <!-- Profile content will be loaded via AJAX -->
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Modal functions
        function openAddUserModal() {
            document.getElementById('modalTitle').textContent = 'Add New User';
            document.getElementById('userForm').action = "{{ route('users.store') }}";
            document.getElementById('userForm').reset();
            document.getElementById('avatarPreview').src = "{{ asset('images/default-avatar.png') }}";
            document.getElementById('passwordFields').style.display = 'block';
            document.getElementById('userModal').classList.remove('hidden');
        }

        function openEditModal(userId) {
            document.getElementById('modalTitle').textContent = 'Edit User';
            document.getElementById('userForm').action = `/users/${userId}`;
            document.getElementById('passwordFields').style.display = 'none';

            // Load user data via AJAX
            fetch(`/users/${userId}/edit`)
                .then(response => response.json())
                .then(user => {
                    document.querySelector('input[name="name"]').value = user.name;
                    document.querySelector('input[name="email"]').value = user.email;
                    document.querySelector('select[name="role"]').value = user.role;
                    document.querySelector('select[name="status"]').value = user.status;
                    if (user.avatar) {
                        document.getElementById('avatarPreview').src = `/storage/${user.avatar}`;
                    }
                    document.getElementById('userModal').classList.remove('hidden');
                });
        }

        function openProfileModal(userId) {
            fetch(`/users/${userId}/profile`)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('profileModal').innerHTML = html;
                    document.getElementById('profileModal').classList.remove('hidden');
                });
        }

        function closeModal() {
            document.getElementById('userModal').classList.add('hidden');
            document.getElementById('profileModal').classList.add('hidden');
        }

        // Image preview
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('avatarPreview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // User actions
        function toggleStatus(userId, status) {
            if (confirm('Are you sure you want to change this user\'s status?')) {
                fetch(`/users/${userId}/status`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        status: status
                    })
                }).then(() => location.reload());
            }
        }

        function confirmDelete(userId) {
            if (confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
                fetch(`/users/${userId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }).then(() => location.reload());
            }
        }

        // Filter functions
        function filterUsers() {
            const role = document.getElementById('roleFilter').value;
            const status = document.getElementById('statusFilter').value;
            const search = document.getElementById('searchInput').value;

            // Implement filtering logic here (could be AJAX or form submission)
            window.location.href = `{{ route('users.index') }}?role=${role}&status=${status}&search=${search}`;
        }

        // Close modal when clicking outside
        document.addEventListener('click', function(e) {
            if (e.target.id === 'userModal' || e.target.id === 'profileModal') {
                closeModal();
            }
        });
    </script>
@endpush
