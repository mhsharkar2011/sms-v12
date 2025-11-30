@extends('layouts.app')

@section('title', $user->name ?? 'Profile')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Profile Header Card -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="flex items-center space-x-6">
                    <!-- Profile Picture -->
                    <div class="flex-shrink-0">
                        <img src="{{ $user->avatar_url ?? 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($user->email ?? ''))) . '?s=120&d=mp' }}"
                            alt="{{ $user->name }}" class="rounded-full w-24 h-24 sm:w-32 sm:h-32 border-2 border-gray-200">
                    </div>

                    <!-- Profile Information -->
                    <div class="flex-grow">
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $user->name }}</h1>
                        <p class="text-lg text-gray-600 mt-1">{{ $user->email }}</p>

                        @if (!empty($user->bio))
                            <p class="text-gray-700 mt-3">{{ $user->bio }}</p>
                        @endif

                        <div class="flex items-center space-x-4 mt-4 text-sm text-gray-500">
                            <span>Joined {{ $user->created_at->diffForHumans() }}</span>

                            @if ($user->last_seen)
                                <span class="flex items-center">
                                    <span class="h-2 w-2 bg-green-500 rounded-full mr-1"></span>
                                    Last seen {{ $user->last_seen->diffForHumans() }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex-shrink-0">
                        @can('update', $user)
                            <a href="{{ route('profile.edit', $user) }}"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Edit Profile
                            </a>
                        @endcan
                    </div>
                </div>
            </div>

            <!-- Additional Profile Information -->
            @if ($user->location || $user->website)
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <h3 class="text-lg font-medium text-gray-900">About</h3>
                        <div class="mt-4 space-y-2">
                            @if ($user->location)
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $user->location }}
                                </div>
                            @endif

                            @if ($user->website)
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                    </svg>
                                    <a href="{{ $user->website }}" target="_blank"
                                        class="text-blue-600 hover:text-blue-800">
                                        {{ $user->website }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- User Statistics -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-gray-900">Statistics</h3>
                    <div class="mt-4 grid grid-cols-2 gap-4">
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-gray-900">
                                {{ $user->posts_count ?? ($user->posts->count() ?? 0) }}
                            </div>
                            <div class="text-sm text-gray-600">Posts</div>
                        </div>
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-gray-900">
                                {{ $user->comments_count ?? 0 }}
                            </div>
                            <div class="text-sm text-gray-600">Comments</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Posts -->
            @if (isset($user->posts) && $user->posts->isNotEmpty())
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-4xl">
                        <h3 class="text-lg font-medium text-gray-900">Recent Posts</h3>
                        <div class="mt-4 space-y-4">
                            @foreach ($user->posts->take(5) as $post)
                                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition duration-150">
                                    <a href="{{ route('posts.show', $post) }}" class="block">
                                        <h4 class="text-lg font-semibold text-gray-900 hover:text-blue-600">
                                            {{ $post->title }}
                                        </h4>
                                        <p class="text-gray-600 mt-1 line-clamp-2">
                                            {{ Str::limit($post->excerpt ?? $post->content, 150) }}
                                        </p>
                                        <div class="flex items-center justify-between mt-3">
                                            <span class="text-sm text-gray-500">
                                                {{ $post->created_at->diffForHumans() }}
                                            </span>
                                            <span class="text-sm text-gray-500">
                                                {{ $post->comments_count ?? $post->comments->count() }} comments
                                            </span>
                                        </div>
                                    </a>
                                </div>
                            @endforeach

                            @if ($user->posts->count() > 5)
                                <div class="text-center mt-6">
                                    <a href="{{ route('users.posts', $user) }}"
                                        class="inline-flex items-center px-4 py-2 bg-gray-100 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 focus:bg-gray-200 active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        View All Posts
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Danger Zone (for profile owner) -->
            @can('delete', $user)
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <h3 class="text-lg font-medium text-red-600">Danger Zone</h3>
                        <div class="mt-4">
                            <form action="{{ route('profile.destroy', $user) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Delete Account
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endcan
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endpush
