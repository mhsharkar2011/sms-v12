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

                <!-- Likes & Share Action Bar -->
                <div class="flex items-center justify-between border-t border-gray-200 pt-6 mt-8">
                    <!-- Like Section -->
                    <div class="flex items-center space-x-4">
                        @auth
                            <button
                                onclick="toggleLike({{ $post->id }})"
                                id="like-button-{{ $post->id }}"
                                class="flex items-center space-x-2 px-4 py-2 rounded-lg transition-all duration-200 {{ $post->is_liked_by_user ? 'bg-red-50 text-red-600 hover:bg-red-100' : 'bg-gray-50 text-gray-700 hover:bg-gray-100' }}"
                                aria-label="{{ $post->is_liked_by_user ? 'Unlike this post' : 'Like this post' }}">
                                <span id="like-icon-{{ $post->id }}" class="material-icons {{ $post->is_liked_by_user ? 'text-red-500' : 'text-gray-500' }}">
                                    {{ $post->is_liked_by_user ? 'favorite' : 'favorite_border' }}
                                </span>
                                <span id="like-text-{{ $post->id }}" class="font-medium">
                                    {{ $post->is_liked_by_user ? 'Liked' : 'Like' }}
                                </span>
                                <span class="ml-1" id="like-count-{{ $post->id }}">
                                    ({{ $post->likes_count ?? $post->likes->count() }})
                                </span>
                            </button>

                            <!-- Who liked this post (Optional) -->
                            @if($post->likes_count > 0)
                                <div class="flex items-center text-sm text-gray-600">
                                    <span class="material-icons text-sm mr-1">group</span>
                                    <span>{{ $post->likes_count }} people liked this</span>
                                </div>
                            @endif
                        @else
                            <a href="{{ route('login') }}"
                               class="flex items-center space-x-2 px-4 py-2 rounded-lg bg-gray-50 text-gray-700 hover:bg-gray-100 transition-all duration-200">
                                <span class="material-icons text-gray-500">favorite_border</span>
                                <span class="font-medium">Like</span>
                                <span class="ml-1">({{ $post->likes_count ?? $post->likes->count() }})</span>
                            </a>
                        @endauth
                    </div>

                    <!-- Share Section -->
                    <div class="flex items-center space-x-4">
                        <button
                            onclick="sharePost('{{ addslashes($post->title) }}', '{{ route('posts.show', $post) }}')"
                            class="flex items-center space-x-2 px-4 py-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition-all duration-200"
                            aria-label="Share this post">
                            <span class="material-icons">share</span>
                            <span class="font-medium">Share</span>
                        </button>

                        <!-- Save/Bookmark (Optional) -->
                        <button class="flex items-center space-x-2 px-4 py-2 rounded-lg bg-gray-50 text-gray-700 hover:bg-gray-100 transition-all duration-200"
                                aria-label="Save post">
                            <span class="material-icons">bookmark_border</span>
                        </button>
                    </div>
                </div>
                <!-- End Action Bar -->

                @can('update', $post)
                    <div class="flex space-x-4 mt-8 pt-6 border-t">
                        <a href="{{ route('posts.edit', $post) }}"
                           class="flex items-center space-x-1 text-blue-600 hover:text-blue-800">
                            <span class="material-icons text-sm">edit</span>
                            <span>Edit</span>
                        </a>
                        <form action="{{ route('posts.destroy', $post) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this post?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="flex items-center space-x-1 text-red-600 hover:text-red-800">
                                <span class="material-icons text-sm">delete</span>
                                <span>Delete</span>
                            </button>
                        </form>
                    </div>
                @endcan
            </div>
        </article>

        <!-- Comments Section -->
        <div class="mt-8 bg-white shadow-lg rounded-lg p-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold flex items-center">
                    <span class="material-icons mr-2">comment</span>
                    Comments ({{ $post->comments->count() }})
                </h2>

                @if($post->comments->count() > 0)
                    <div class="text-sm text-gray-600 flex items-center">
                        <span class="material-icons text-sm mr-1">sort</span>
                        <span>Sort by: Newest</span>
                    </div>
                @endif
            </div>

            @auth
                <!-- Comment Form -->
                <form action="{{ route('comments.store', $post) }}" method="POST" class="mb-8">
                    @csrf
                    <div class="flex items-start space-x-4">
                        <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}"
                            class="w-10 h-10 rounded-full mt-2">
                        <div class="flex-1">
                            <div class="mb-4">
                                <textarea name="content" rows="3"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                    placeholder="Write a comment..."></textarea>
                                @error('content')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex justify-end">
                                <button type="submit"
                                        class="flex items-center space-x-2 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-all duration-200">
                                    <span class="material-icons text-sm">send</span>
                                    <span>Post Comment</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            @else
                <div class="bg-gray-50 rounded-lg p-6 mb-6 text-center">
                    <span class="material-icons text-gray-400 text-4xl mb-3">comment</span>
                    <p class="text-gray-600 mb-3">
                        Please <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-medium">log in</a>
                        to join the conversation.
                    </p>
                    <p class="text-sm text-gray-500">
                        Already have an account?
                        <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Sign in</a>
                    </p>
                </div>
            @endauth

            <!-- Comments List -->
            <div class="space-y-6">
                @foreach ($post->comments as $comment)
                    <div id="comment-{{ $comment->id }}" class="border-b border-gray-100 pb-6 last:border-b-0">
                        <div class="flex items-start space-x-4">
                            <img src="{{ $comment->user->avatar_url }}" alt="{{ $comment->user->name }}"
                                class="w-10 h-10 rounded-full">
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <div>
                                        <h4 class="font-semibold text-gray-900">{{ $comment->user->name }}</h4>
                                        <span class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>

                                    @can('delete', $comment)
                                        <form action="{{ route('comments.destroy', $comment) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="flex items-center space-x-1 text-red-600 hover:text-red-800 text-sm">
                                                <span class="material-icons text-sm">delete</span>
                                                <span>Delete</span>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                                <p class="text-gray-700 mt-2 leading-relaxed">{{ $comment->content }}</p>

                                <!-- Comment Actions -->
                                <div class="flex items-center space-x-4 mt-3">
                                    <button class="flex items-center space-x-1 text-gray-600 hover:text-blue-600 text-sm">
                                        <span class="material-icons text-sm">thumb_up</span>
                                        <span>Like</span>
                                    </button>
                                    <button class="flex items-center space-x-1 text-gray-600 hover:text-blue-600 text-sm">
                                        <span class="material-icons text-sm">reply</span>
                                        <span>Reply</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                @if($post->comments->count() === 0)
                    <div class="text-center py-12">
                        <span class="material-icons text-gray-300 text-6xl mb-4">forum</span>
                        <h3 class="text-xl font-semibold text-gray-600 mb-2">No comments yet</h3>
                        <p class="text-gray-500">Be the first to share what you think!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('styles')
        <!-- Material Icons CSS -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    @endpush

    @push('scripts')
        <script>
            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

            async function toggleLike(postId) {
                const likeButton = document.getElementById(`like-button-${postId}`);
                const likeIcon = document.getElementById(`like-icon-${postId}`);
                const likeText = document.getElementById(`like-text-${postId}`);
                const likeCount = document.getElementById(`like-count-${postId}`);

                if (!likeButton || !likeIcon || !likeText || !likeCount) {
                    console.error('Like elements not found');
                    return;
                }

                try {
                    likeButton.disabled = true;

                    // Try the new simple route first
                    const response = await fetch(`/simple-like/${postId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        credentials: 'include'
                    });

                    console.log('Response status:', response.status);

                    if (response.status === 401) {
                        // Not authenticated, redirect to login
                        window.location.href = '/login';
                        return;
                    }

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const data = await response.json();
                    console.log('Like response:', data);

                    // Update UI based on response
                    if (data.is_liked) {
                        // Now liked
                        likeIcon.textContent = 'favorite';
                        likeIcon.classList.remove('text-gray-500');
                        likeIcon.classList.add('text-red-500');
                        likeText.textContent = 'Liked';
                        likeButton.classList.remove('bg-gray-50', 'text-gray-700', 'hover:bg-gray-100');
                        likeButton.classList.add('bg-red-50', 'text-red-600', 'hover:bg-red-100');
                        likeButton.setAttribute('aria-label', 'Unlike this post');
                    } else {
                        // Now unliked
                        likeIcon.textContent = 'favorite_border';
                        likeIcon.classList.remove('text-red-500');
                        likeIcon.classList.add('text-gray-500');
                        likeText.textContent = 'Like';
                        likeButton.classList.remove('bg-red-50', 'text-red-600', 'hover:bg-red-100');
                        likeButton.classList.add('bg-gray-50', 'text-gray-700', 'hover:bg-gray-100');
                        likeButton.setAttribute('aria-label', 'Like this post');
                    }

                    // Update like count
                    likeCount.textContent = `(${data.likes_count})`;

                    // Add animation
                    likeIcon.style.transform = 'scale(1.2)';
                    setTimeout(() => {
                        likeIcon.style.transform = 'scale(1)';
                    }, 200);

                } catch (error) {
                    console.error('Error toggling like:', error);

                    // Show error feedback
                    const originalText = likeText.textContent;
                    const originalIcon = likeIcon.textContent;

                    likeText.textContent = 'Error';
                    likeIcon.textContent = 'error';
                    likeIcon.classList.remove('text-gray-500', 'text-red-500');
                    likeIcon.classList.add('text-yellow-500');
                    likeButton.classList.add('bg-yellow-50');

                    setTimeout(() => {
                        likeText.textContent = originalText;
                        likeIcon.textContent = originalIcon;
                        likeIcon.classList.remove('text-yellow-500');
                        likeButton.classList.remove('bg-yellow-50');
                    }, 2000);

                } finally {
                    likeButton.disabled = false;
                }
            }

            async function sharePost(title, url) {
                try {
                    if (navigator.share) {
                        await navigator.share({
                            title: title,
                            text: 'Check out this post!',
                            url: url,
                        });
                    } else {
                        // Fallback: Copy to clipboard
                        await navigator.clipboard.writeText(url);

                        // Show success message
                        showNotification('Link copied to clipboard!', 'success');
                    }
                } catch (error) {
                    if (error.name !== 'AbortError') {
                        console.error('Error sharing:', error);

                        // Fallback: Show share modal
                        showShareModal(title, url);
                    }
                }
            }

            function showShareModal(title, url) {
                // Remove existing modal if any
                const existingModal = document.querySelector('.share-modal');
                if (existingModal) existingModal.remove();

                const modal = document.createElement('div');
                modal.className = 'share-modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
                modal.innerHTML = `
                    <div class="bg-white rounded-xl p-6 max-w-md w-full mx-4 shadow-2xl">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-bold text-gray-900">Share Post</h3>
                            <button onclick="closeShareModal()" class="text-gray-400 hover:text-gray-600">
                                <span class="material-icons">close</span>
                            </button>
                        </div>

                        <div class="mb-6">
                            <p class="text-gray-600 mb-3">Copy the link:</p>
                            <div class="flex">
                                <input type="text" value="${url}" readonly
                                       class="flex-1 border border-gray-300 rounded-l-lg px-4 py-3 text-sm bg-gray-50">
                                <button onclick="copyShareUrl()"
                                        class="bg-blue-600 text-white px-4 py-3 rounded-r-lg hover:bg-blue-700 transition-colors">
                                    <span class="material-icons text-sm">content_copy</span>
                                </button>
                            </div>
                        </div>

                        <div class="border-t pt-4">
                            <p class="text-gray-600 mb-3">Or share via:</p>
                            <div class="grid grid-cols-3 gap-3">
                                <a href="https://twitter.com/intent/tweet?text=${encodeURIComponent(title)}&url=${encodeURIComponent(url)}"
                                   target="_blank"
                                   class="flex flex-col items-center justify-center p-4 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors">
                                    <span class="material-icons mb-1">flutter_dash</span>
                                    <span class="text-sm font-medium">Twitter</span>
                                </a>
                                <a href="https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}"
                                   target="_blank"
                                   class="flex flex-col items-center justify-center p-4 rounded-lg bg-blue-100 text-blue-700 hover:bg-blue-200 transition-colors">
                                    <span class="material-icons mb-1">facebook</span>
                                    <span class="text-sm font-medium">Facebook</span>
                                </a>
                                <a href="mailto:?subject=${encodeURIComponent(title)}&body=${encodeURIComponent('Check out this post: ' + url)}"
                                   class="flex flex-col items-center justify-center p-4 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 transition-colors">
                                    <span class="material-icons mb-1">email</span>
                                    <span class="text-sm font-medium">Email</span>
                                </a>
                            </div>
                        </div>

                        <button onclick="closeShareModal()"
                                class="w-full mt-6 bg-gray-100 hover:bg-gray-200 text-gray-800 py-3 rounded-lg font-medium transition-colors">
                            Close
                        </button>
                    </div>
                `;

                document.body.appendChild(modal);
            }

            function copyShareUrl() {
                const input = document.querySelector('.share-modal input');
                if (input) {
                    input.select();
                    navigator.clipboard.writeText(input.value).then(() => {
                        const copyBtn = input.nextElementSibling;
                        copyBtn.innerHTML = '<span class="material-icons text-sm">check</span>';
                        copyBtn.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                        copyBtn.classList.add('bg-green-600', 'hover:bg-green-700');

                        setTimeout(() => {
                            copyBtn.innerHTML = '<span class="material-icons text-sm">content_copy</span>';
                            copyBtn.classList.remove('bg-green-600', 'hover:bg-green-700');
                            copyBtn.classList.add('bg-blue-600', 'hover:bg-blue-700');
                        }, 2000);
                    });
                }
            }

            function closeShareModal() {
                const modal = document.querySelector('.share-modal');
                if (modal) modal.remove();
            }

            function showNotification(message, type = 'info') {
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 transform transition-all duration-300 ${
                    type === 'success' ? 'bg-green-100 text-green-800' :
                    type === 'error' ? 'bg-red-100 text-red-800' :
                    'bg-blue-100 text-blue-800'
                }`;
                notification.innerHTML = `
                    <div class="flex items-center">
                        <span class="material-icons mr-2">
                            ${type === 'success' ? 'check_circle' :
                              type === 'error' ? 'error' : 'info'}
                        </span>
                        <span>${message}</span>
                    </div>
                `;

                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.remove();
                }, 3000);
            }
        </script>

        <!-- CSRF Token Meta Tag -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush
@endsection
