@extends('layouts.app')

@section('title', 'Posts')

@section('content')
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Latest Posts</h1>
            @auth
                <a href="{{ route('posts.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                    Create Post
                </a>
            @endauth
        </div>

        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($posts as $post)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    @if ($post->featured_image)
                        <a href="{{ route('posts.show', $post) }}">
                            <img src="{{ $post->getFeaturedImageUrl() }}" alt="{{ $post->title }}"
                                class="w-full h-48 object-cover hover:opacity-90 transition-opacity duration-300">
                        </a>
                    @endif
                    <div class="p-6">
                        <h2 class="text-xl font-semibold mb-2">
                            <a href="{{ route('posts.show', $post) }}" class="hover:text-blue-600 transition-colors duration-200">
                                {{ $post->title }}
                            </a>
                        </h2>
                        <p class="text-gray-600 mb-4">{{ $post->excerpt }}</p>

                        {{-- Post Metadata (Author and Date) --}}
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                            <span>By {{ $post->user->name }}</span>
                            <span>{{ $post->created_at->diffForHumans() }}</span>
                        </div>

                        {{-- Likes & Share Action Bar --}}
                        <div class="flex items-center justify-between text-sm mb-4">
                            {{-- Like/Unlike Button Logic --}}
                            <div class="flex items-center space-x-2">
                                @auth
                                    <button
                                        onclick="toggleLike({{ $post->id }})"
                                        id="like-button-{{ $post->id }}"
                                        class="{{ $post->is_liked_by_user ? 'text-pink-600 hover:text-pink-800' : 'text-blue-600 hover:text-blue-800' }} flex items-center font-medium transition-colors duration-200"
                                        aria-label="{{ $post->is_liked_by_user ? 'Unlike this post' : 'Like this post' }}">
                                        <span id="like-icon-{{ $post->id }}" class="mr-1">
                                            {{ $post->is_liked_by_user ? '❤️' : '🤍' }}
                                        </span>
                                        <span id="like-text-{{ $post->id }}">
                                            {{ $post->is_liked_by_user ? 'Liked' : 'Like' }}
                                        </span>
                                    </button>
                                @else
                                    <a href="{{ route('login') }}" class="text-gray-400 hover:text-gray-600 flex items-center">
                                        🤍 Login to Like
                                    </a>
                                @endauth
                                <span class="text-gray-500" id="like-count-{{ $post->id }}">
                                    {{ $post->likes_count }} Likes
                                </span>
                            </div>

                            {{-- Share Link --}}
                            <div>
                                <button
                                    onclick="sharePost(event, '{{ addslashes($post->title) }}', '{{ route('posts.show', $post) }}')"
                                    class="text-green-600 hover:text-green-800 flex items-center"
                                    aria-label="Share this post">
                                    📤 Share
                                </button>
                            </div>
                        </div>
                        {{-- End Action Bar --}}

                        {{-- Comments Section --}}
                        <div class="text-sm text-gray-700 border-t pt-3">
                            <a href="{{ route('posts.show', $post) }}#comments" class="text-blue-600 hover:underline flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                </svg>
                                {{ $post->comments_count }} Comments
                            </a>
                        </div>
                        {{-- End Comments Section --}}
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $posts->links() }}
        </div>
    </div>
@endsection

@push('scripts')
<script>
// CSRF token setup
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

async function toggleLike(postId, button, likeIcon, likeText, likeCount) {
    console.log('Toggling like for post:', postId);

    try {
        button.disabled = true;

        // Determine current state
        const isCurrentlyLiked = likeIcon.textContent.trim() === '❤️';
        const method = isCurrentlyLiked ? 'DELETE' : 'POST';
        const url = isCurrentlyLiked
            ? `/posts/${postId}/unlike`
            : `/posts/${postId}/like`;

        console.log('URL:', url, 'Method:', method);

        const response = await fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            credentials: 'same-origin'
        });

        // Get raw response first
        const responseText = await response.text();
        console.log('Response status:', response.status);
        console.log('Response text:', responseText.substring(0, 500));

        // Try to parse as JSON
        let data;
        try {
            data = JSON.parse(responseText);
        } catch (e) {
            console.error('Failed to parse JSON:', e);
            console.error('Raw response:', responseText);
            throw new Error('Server returned invalid JSON');
        }

        if (!response.ok) {
            throw new Error(data.message || `Server error: ${response.status}`);
        }

        // Update UI
        if (isCurrentlyLiked) {
            // Just unliked
            likeIcon.textContent = '🤍';
            likeText.textContent = 'Like';
            button.classList.remove('text-pink-600', 'hover:text-pink-800');
            button.classList.add('text-blue-600', 'hover:text-blue-800');
            button.setAttribute('aria-label', 'Like this post');
        } else {
            // Just liked
            likeIcon.textContent = '❤️';
            likeText.textContent = 'Liked';
            button.classList.remove('text-blue-600', 'hover:text-blue-800');
            button.classList.add('text-pink-600', 'hover:text-pink-800');
            button.setAttribute('aria-label', 'Unlike this post');
        }

        // Update count
        if (data.likes_count !== undefined) {
            likeCount.textContent = `${data.likes_count} Likes`;
        } else if (data.likes_count === 0) {
            likeCount.textContent = '0 Likes';
        }

        // Animation
        likeIcon.style.transform = 'scale(1.3)';
        setTimeout(() => {
            likeIcon.style.transform = 'scale(1)';
        }, 200);

    } catch (error) {
        console.error('Like error details:', error);

        // More specific error messages
        if (error.message.includes('401') || error.message.includes('419')) {
            alert('Your session has expired. Please login again.');
            window.location.href = '/login';
        } else if (error.message.includes('500')) {
            alert('Server error. Please try again later.');
        } else {
            alert('Failed to update like. Please try again.');
        }
    } finally {
        button.disabled = false;
    }
}
async function sharePost(event, title, url) {
    try {
        if (navigator.share) {
            await navigator.share({
                title: title,
                text: 'Check out this post!',
                url: url,
            });
        } else if (navigator.clipboard) {
            await navigator.clipboard.writeText(url);

            // Show success feedback
            const button = event.target.closest('button') || event.target;
            const originalText = button.textContent;
            button.textContent = '✅ Copied!';
            button.classList.remove('text-green-600', 'hover:text-green-800');
            button.classList.add('text-green-700');

            setTimeout(() => {
                button.textContent = originalText;
                button.classList.remove('text-green-700');
                button.classList.add('text-green-600', 'hover:text-green-800');
            }, 2000);
        } else {
            // Fallback for older browsers
            const tempInput = document.createElement('input');
            tempInput.value = url;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);
            alert('Link copied to clipboard!');
        }
    } catch (error) {
        if (error.name !== 'AbortError') {
            console.error('Error sharing:', error);
            showShareOptions(title, url);
        }
    }
}

function showShareOptions(title, url) {
    // Remove existing modal if any
    const existingModal = document.querySelector('.share-modal-overlay');
    if (existingModal) existingModal.remove();

    // Create modal
    const shareModal = document.createElement('div');
    shareModal.className = 'share-modal-overlay fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
    shareModal.innerHTML = `
        <div class="bg-white rounded-lg p-6 max-w-sm w-full mx-4">
            <h3 class="text-lg font-semibold mb-4">Share Post</h3>
            <p class="text-gray-600 mb-4">Copy the link or share via:</p>
            <div class="space-y-3">
                <div class="flex items-center">
                    <input type="text" value="${url}" readonly
                           class="border rounded-l px-3 py-2 text-sm flex-1" id="share-url-input">
                    <button onclick="copyShareUrl()"
                            class="bg-blue-500 text-white px-4 py-2 rounded-r text-sm hover:bg-blue-600">
                        Copy
                    </button>
                </div>
                <div class="pt-4 border-t">
                    <a href="https://twitter.com/intent/tweet?text=${encodeURIComponent(title)}&url=${encodeURIComponent(url)}"
                       target="_blank"
                       class="text-blue-400 hover:text-blue-600 flex items-center mb-3 no-underline">
                        <span class="mr-2">🐦</span> Share on Twitter
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}"
                       target="_blank"
                       class="text-blue-600 hover:text-blue-800 flex items-center no-underline">
                        <span class="mr-2">📘</span> Share on Facebook
                    </a>
                </div>
            </div>
            <button onclick="closeShareModal()"
                    class="mt-6 w-full bg-gray-100 hover:bg-gray-200 text-gray-800 py-2 rounded">
                Close
            </button>
        </div>
    `;
    document.body.appendChild(shareModal);
}

function copyShareUrl() {
    const input = document.getElementById('share-url-input');
    if (input) {
        input.select();
        navigator.clipboard.writeText(input.value).then(() => {
            const copyBtn = input.nextElementSibling;
            const originalText = copyBtn.textContent;
            copyBtn.textContent = 'Copied!';
            copyBtn.classList.add('bg-green-500');
            setTimeout(() => {
                copyBtn.textContent = originalText;
                copyBtn.classList.remove('bg-green-500');
            }, 2000);
        });
    }
}

function closeShareModal() {
    const modal = document.querySelector('.share-modal-overlay');
    if (modal) modal.remove();
}

// Make functions available globally
window.toggleLike = toggleLike;
window.sharePost = sharePost;
window.copyShareUrl = copyShareUrl;
window.closeShareModal = closeShareModal;
</script>
@endpush

{{-- Make sure CSRF token meta tag is in your layout --}}
@push('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
