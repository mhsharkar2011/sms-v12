@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
<div class="min-h-screen bg-gray-50 flex">
    <x-admin-sidebar active-route="admin.notifications" />

    <div class="flex-1 overflow-auto">
        <div class="bg-white shadow-sm border-b border-gray-200">
            <div class="px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Notifications</h1>
                        <p class="text-gray-600 mt-1">Your recent alerts and messages</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button onclick="markAllAsRead()"
                            class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                            Mark All as Read
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mx-auto p-6">
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                @if(auth()->user()->notifications->count() > 0)
                    <div class="divide-y divide-gray-100">
                        @foreach(auth()->user()->notifications as $notification)
                            <div class="p-6 hover:bg-gray-50 transition-colors {{ $notification->read() ? 'bg-white' : 'bg-blue-50' }}">
                                <div class="flex items-start justify-between">
                                    <div class="flex items-start space-x-4">
                                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-bell text-blue-600"></i>
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-gray-900">{{ $notification->data['title'] ?? 'Notification' }}</h3>
                                            <p class="text-gray-600 mt-1">{{ $notification->data['message'] ?? '' }}</p>
                                            <p class="text-sm text-gray-500 mt-2">{{ $notification->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        @if(!$notification->read())
                                            <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                                        @endif
                                        @if(isset($notification->data['url']))
                                            <a href="{{ $notification->data['url'] }}"
                                               class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                View
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-12 text-center">
                        <div class="w-24 h-24 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-bell-slash text-gray-400 text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No notifications</h3>
                        <p class="text-gray-500">You're all caught up! Check back later for new notifications.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function markAllAsRead() {
    fetch('{{ route("notifications.markAllRead") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    }).then(response => {
        if (response.ok) {
            location.reload();
        }
    });
}
</script>
@endpush
