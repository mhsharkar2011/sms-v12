@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <article class="bg-white shadow-lg rounded-lg overflow-hidden">
            @if ($post->featured_image)
                <img src="{{ $post->getFeaturedImageUrl() }}" alt="{{ $post->title }}" class="w-full h-64 object-cover">
            @endif

            <div class="p-8">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $post->title }}</h1>

                <div class="flex items-center text-gray-600 mb-6">
                    <img src="{{ $post->user->avatar_url }}" alt="{{ $post->user->name }}"
                        class="w-10 h-10 rounded-full mr-3">
                    <div>
                        <p class="font-semibold">{{ $post->user->name }}</p>
                        <p class="text-sm">{{ $post->created_at->format('F j, Y') }} • {{ $post->getReadingTime() }} min
                            read</p>
                    </div>
                </div>

                <div class="prose max-w-none mb-8">
                    {!! Str::markdown($post->content) !!}
                </div>

                @can('update', $post)
                    <div class="flex space-x-4 mt-8 pt-6 border-t">
                        <a href="{{ route('posts.edit', $post) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                        <form action="{{ route('posts.destroy', $post) }}" method="POST"
                            onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                        </form>
                    </div>
                @endcan
            </div>
        </article>
        {{-- Likes & Share Action Bar (New Addition) --}}
        <div class="flex items-center justify-between text-sm mb-4">
            {{-- Like Button (Requires Backend Logic to function fully) --}}
            <div class="flex items-center space-x-2">
                {{-- This is a placeholder link, you'd link this to a controller route --}}
                <a href="#" class="text-blue-600 hover:text-blue-800 flex items-center">
                    {{-- Placeholder for a Heart Icon (using simple text) --}}
                    ❤️ Like
                </a>
                <span class="text-gray-500">
                    {{ $post->likes_count ?? $post->likes->count() }} Likes
                </span>
            </div>

            {{-- Share Link --}}
            <div>
                {{-- This opens the native share dialogue if supported by the browser --}}
                <a href="#"
                    onclick="navigator.share({
                               title: '{{ $post->title }}',
                               url: '{{ route('posts.show', $post) }}'
                           })"
                    class="text-green-600 hover:text-green-800">
                    📤 Share Post
                </a>
            </div>
        </div>
        {{-- End Action Bar --}}
        <!-- Comments Section -->
        <div class="mt-8 bg-white shadow-lg rounded-lg p-8">
            <h2 class="text-2xl font-bold mb-6">Comments ({{ $post->comments->count() }})</h2>

            @auth
                <!-- Comment Form -->
                <form action="{{ route('comments.store', $post) }}" method="POST" class="mb-8">
                    @csrf
                    <div class="mb-4">
                        <textarea name="content" rows="4"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Add a comment..."></textarea>
                        @error('content')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                        Post Comment
                    </button>
                </form>
            @else
                <p class="text-gray-600 mb-6">
                    <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Log in</a> to leave a comment.
                </p>
            @endauth

            <!-- Comments List -->
            <div class="space-y-6">
                @foreach ($post->comments as $comment)
                    <div id="comment-{{ $comment->id }}" class="border-b border-gray-200 pb-6">
                        <div class="flex items-start space-x-3">
                            <img src="{{ $comment->user->avatar_url }}" alt="{{ $comment->user->name }}"
                                class="w-8 h-8 rounded-full">
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <h4 class="font-semibold">{{ $comment->user->name }}</h4>
                                    <span class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-gray-700 mt-2">{{ $comment->content }}</p>

                                @can('delete', $comment)
                                    <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="mt-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Delete</button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
