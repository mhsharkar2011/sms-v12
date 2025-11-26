@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
    <div class="min-h-screen bg-gray-50 flex">
        <x-admin-sidebar active-route="admin.notifications" />

        <div class="flex-1 overflow-auto">
            <!-- Header -->
            <div class="bg-white shadow-sm border-b border-gray-200">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Notifications</h1>
                            <p class="text-gray-600 mt-1">Your recent alerts and messages</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="text-sm text-gray-500">
                                <span class="font-medium">{{ auth()->user()->unreadNotifications->count() }}</span> unread
                                notifications
                            </div>
                            <div class="flex items-center space-x-2">
                                <button onclick="markAllAsRead()"
                                    class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors flex items-center gap-2">
                                    <i class="fas fa-check-double"></i>
                                    Mark All as Read
                                </button>
                                <button onclick="clearAllNotifications()"
                                    class="px-4 py-2 border border-red-300 rounded-lg text-red-700 hover:bg-red-50 transition-colors flex items-center gap-2">
                                    <i class="fas fa-trash"></i>
                                    Clear All
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container mx-auto p-6">
                <!-- Filter Tabs -->
                <div class="bg-white rounded-xl shadow-sm mb-6">
                    <div class="border-b border-gray-200">
                        <nav class="flex -mb-px">
                            <a href="{{ route('admin.notifications') }}?mark_as_read=true"
                                class="py-4 px-6 text-center border-b-2 font-medium text-sm {{ !request('filter') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                All Notifications
                            </a>
                            <a href="{{ route('admin.notifications') }}?filter=unread"
                                class="py-4 px-6 text-center border-b-2 font-medium text-sm {{ request('filter') == 'unread' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                Unread Only
                            </a>
                            <a href="{{ route('notifications.byType', 'user_registered') }}"
                                class="py-4 px-6 text-center border-b-2 font-medium text-sm {{ request()->is('notifications/type/user_registered') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                User Registrations
                            </a>
                            <a href="{{ route('notifications.byType', 'system') }}"
                                class="py-4 px-6 text-center border-b-2 font-medium text-sm {{ request()->is('notifications/type/system') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                System Alerts
                            </a>
                        </nav>
                    </div>
                </div>

                <!-- Notifications List -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    @if ($notifications->count() > 0)
                        <div class="divide-y divide-gray-100">
                            @foreach ($notifications as $notification)
                                @php
                                    $data = $notification->data;
                                    $isUnread = is_null($notification->read_at);
                                @endphp
                                <div
                                    class="p-6 hover:bg-gray-50 transition-colors {{ $isUnread ? 'bg-blue-50 border-l-4 border-blue-500' : 'bg-white' }}">
                                    <div class="flex items-start justify-between">
                                        <div class="flex items-start space-x-4 flex-1">
                                            <!-- Notification Icon -->
                                            <div
                                                class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0
                                            {{ $data['type'] == 'user_registered'
                                                ? 'bg-green-100 text-green-600'
                                                : ($data['type'] == 'system'
                                                    ? 'bg-blue-100 text-blue-600'
                                                    : ($data['type'] == 'warning'
                                                        ? 'bg-yellow-100 text-yellow-600'
                                                        : ($data['type'] == 'error'
                                                            ? 'bg-red-100 text-red-600'
                                                            : 'bg-gray-100 text-gray-600'))) }}">
                                                <i
                                                    class="fas
                                                {{ $data['type'] == 'user_registered'
                                                    ? 'fa-user-plus'
                                                    : ($data['type'] == 'system'
                                                        ? 'fa-cog'
                                                        : ($data['type'] == 'warning'
                                                            ? 'fa-exclamation-triangle'
                                                            : ($data['type'] == 'error'
                                                                ? 'fa-exclamation-circle'
                                                                : 'fa-bell'))) }} text-lg">
                                                </i>
                                            </div>

                                            <!-- Notification Content -->
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center space-x-2 mb-2">
                                                    <h3 class="font-semibold text-gray-900 text-lg">
                                                        {{ $data['title'] ?? 'Notification' }}</h3>
                                                    @if ($isUnread)
                                                        <span
                                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                            New
                                                        </span>
                                                    @endif
                                                </div>
                                                <p class="text-gray-600">{{ $data['message'] ?? 'No message provided.' }}
                                                </p>

                                                <!-- Additional Data -->
                                                @if (isset($data['user_name']) || isset($data['user_email']))
                                                    <div class="mt-3 p-3 bg-gray-50 rounded-lg">
                                                        <div class="text-sm text-gray-600">
                                                            @if (isset($data['user_name']))
                                                                <strong>User:</strong> {{ $data['user_name'] }}
                                                            @endif
                                                            @if (isset($data['user_email']))
                                                                <br><strong>Email:</strong> {{ $data['user_email'] }}
                                                            @endif
                                                            @if (isset($data['role']))
                                                                <br><strong>Role:</strong> {{ ucfirst($data['role']) }}
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="flex items-center space-x-4 mt-3">
                                                    <span class="text-sm text-gray-500">
                                                        <i class="fas fa-clock mr-1"></i>
                                                        {{ $notification->created_at->diffForHumans() }}
                                                    </span>
                                                    @if (isset($data['type']))
                                                        <span class="text-sm text-gray-500 capitalize">
                                                            <i class="fas fa-tag mr-1"></i>
                                                            {{ str_replace('_', ' ', $data['type']) }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="flex items-center space-x-2 ml-4">
                                            @if (isset($data['url']))
                                                <a href="{{ $data['url'] }}"
                                                    class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                                                    <i class="fas fa-eye mr-2"></i>
                                                    View
                                                </a>
                                            @endif

                                            @if ($isUnread)
                                                <button onclick="markAsRead('{{ $notification->id }}')"
                                                    class="inline-flex items-center px-3 py-2 border border-green-300 rounded-lg text-sm font-medium text-green-700 bg-white hover:bg-green-50 transition-colors">
                                                    <i class="fas fa-check mr-2"></i>
                                                    Mark Read
                                                </button>
                                            @else
                                                <button onclick="markAsUnread('{{ $notification->id }}')"
                                                    class="inline-flex items-center px-3 py-2 border border-yellow-300 rounded-lg text-sm font-medium text-yellow-700 bg-white hover:bg-yellow-50 transition-colors">
                                                    <i class="fas fa-undo mr-2"></i>
                                                    Mark Unread
                                                </button>
                                            @endif

                                            <button onclick="deleteNotification('{{ $notification->id }}')"
                                                class="inline-flex items-center px-3 py-2 border border-red-300 rounded-lg text-sm font-medium text-red-700 bg-white hover:bg-red-50 transition-colors">
                                                <i class="fas fa-trash mr-2"></i>
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                            {{ $notifications->links() }}
                        </div>
                    @else
                        <div class="p-12 text-center">
                            <div class="w-24 h-24 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-bell-slash text-gray-400 text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No notifications found</h3>
                            <p class="text-gray-500 mb-6">
                                @if (request('filter') == 'unread')
                                    You have no unread notifications.
                                @else
                                    You're all caught up! Check back later for new notifications.
                                @endif
                            </p>
                            @if (request('filter') == 'unread')
                                <a href="{{ route('admin.notifications') }}"
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                                    View All Notifications
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Mark notification as read
        function markAsRead(notificationId) {
            fetch(`/notifications/${notificationId}/read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                });
        }

        // Mark notification as unread
        function markAsUnread(notificationId) {
            fetch(`/notifications/${notificationId}/unread`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                });
        }

        // Mark all as read
        function markAllAsRead() {
            if (!confirm('Are you sure you want to mark all notifications as read?')) return;

            fetch('/notifications/mark-all-read', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                });
        }

        // Delete single notification
        function deleteNotification(notificationId) {
            if (!confirm('Are you sure you want to delete this notification?')) return;

            fetch(`/notifications/${notificationId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                });
        }

        // Clear all notifications
        function clearAllNotifications() {
            if (!confirm('Are you sure you want to clear all notifications? This action cannot be undone.')) return;

            fetch('/notifications', {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                });
        }

        // Auto-refresh unread count every 30 seconds
        // Update the auto-refresh function in your notification blade file
        setInterval(() => {
            fetch('/notifications/unread-count')
                .then(response => response.json())
                .then(data => {
                    // Update badge count in sidebar
                    const badges = document.querySelectorAll('.notification-badge');
                    badges.forEach(badge => {
                        if (data.unread_count > 0) {
                            badge.textContent = data.unread_count;
                            badge.classList.remove('hidden');
                            badge.classList.add('inline-flex');
                        } else {
                            badge.classList.add('hidden');
                            badge.classList.remove('inline-flex');
                        }
                    });
                })
                .catch(error => console.error('Error fetching unread count:', error));
        }, 30000);
    </script>
@endpush

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
@endpush
