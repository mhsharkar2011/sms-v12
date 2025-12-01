@extends('layouts.app')

@section('title', 'School Management System')

@section('content')
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
        <div class="max-w-7xl mx-auto px-4 py-20">
            <div class="text-center">
                <h1 class="text-5xl font-bold mb-6">Welcome to School Management System</h1>
                <p class="text-xl mb-8 max-w-2xl mx-auto">
                    Streamline your educational institution with our comprehensive school management solution.
                    Manage students, teachers, and parents all in one platform.
                </p>
                <div class="space-x-4">
                    <a href="{{ route('register') }}"
                        class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
                        Get Started
                    </a>
                    <a href="#features"
                        class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-indigo-600 transition duration-300">
                        Learn More
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-4xl font-bold text-center text-gray-900 mb-12">Features</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Student Feature -->
                <div class="bg-white rounded-lg shadow-lg p-8 text-center hover:shadow-xl transition duration-300">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-user-graduate text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-4">Student Portal</h3>
                    <p class="text-gray-600">
                        Access courses, assignments, grades, and track your academic progress in one place.
                    </p>
                </div>

                <!-- Teacher Feature -->
                <div class="bg-white rounded-lg shadow-lg p-8 text-center hover:shadow-xl transition duration-300">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-chalkboard-teacher text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-4">Teacher Dashboard</h3>
                    <p class="text-gray-600">
                        Manage classes, assignments, grading, and communicate with students and parents.
                    </p>
                </div>

                <!-- Parent Feature -->
                <div class="bg-white rounded-lg shadow-lg p-8 text-center hover:shadow-xl transition duration-300">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-users text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-4">Parent Monitoring</h3>
                    <p class="text-gray-600">
                        Monitor your child's progress, attendance, and communicate with teachers easily.
                    </p>
                </div>
            </div>
        </div>
    </section>


    <section id="features" class="py-20 bg-gray-50">
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
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        @if ($post->featured_image)
                            <img src="{{ $post->getFeaturedImageUrl() }}" alt="{{ $post->title }}"
                                class="w-full h-48 object-cover">
                        @endif
                        <div class="p-6">
                            <h2 class="text-xl font-semibold mb-2">
                                <a href="{{ route('posts.show', $post) }}" class="hover:text-blue-600">
                                    {{ $post->title }}
                                </a>
                            </h2>
                            <p class="text-gray-600 mb-4">{{ $post->excerpt }}</p>

                            {{-- Post Metadata (Author and Date) --}}
                            <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                                <span>By {{ $post->user->name ?? 'Unknown Author' }}</span>
                                <span>{{ $post->created_at->diffForHumans() }}</span>
                            </div>

                            {{-- Likes & Share Action Bar --}}
                            <div class="flex items-center justify-between text-sm mb-4">

                                {{-- Like/Unlike Button Logic --}}
                                <div class="flex items-center space-x-2">
                                    @auth
                                        {{-- Check if the current user has liked this specific post --}}
                                        <button onclick="toggleLike({{ $post->id }})" id="like-button-{{ $post->id }}"
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
                                        {{-- Not authenticated --}}
                                        <a href="{{ route('login') }}"
                                            class="text-gray-400 hover:text-gray-600 flex items-center">
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
                                        onclick="sharePost('{{ addslashes($post->title) }}', '{{ route('posts.show', $post) }}')"
                                        class="text-green-600 hover:text-green-800 flex items-center"
                                        aria-label="Share this post">
                                        📤 Share Post
                                    </button>
                                </div>
                            </div>
                            {{-- End Action Bar --}}

                            {{-- Comments Section --}}
                            <div class="text-sm text-gray-700">
                                <a href="{{ route('posts.show', $post) }}#comments" class="text-blue-600 hover:underline">
                                    {{ $post->comments_count }} Comments
                                </a>

                                @if ($post->comments->count())
                                    <p class="mt-1 text-gray-500">
                                        Latest comment by:
                                        <strong>{{ $post->comments->first()->user->name ?? 'Anonymous' }}</strong>
                                    </p>
                                @endif
                            </div>
                            {{-- End Comments Section --}}
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Add JavaScript for AJAX likes and share functionality --}}
            <script>
                // CSRF token for AJAX requests
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                async function toggleLike(postId) {
                    try {
                        const likeButton = document.getElementById(`like-button-${postId}`);
                        const likeIcon = document.getElementById(`like-icon-${postId}`);
                        const likeText = document.getElementById(`like-text-${postId}`);
                        const likeCount = document.getElementById(`like-count-${postId}`);

                        // Disable button during request
                        likeButton.disabled = true;

                        // Determine if we're liking or unliking
                        const isCurrentlyLiked = likeIcon.textContent.trim() === '❤️';
                        const method = isCurrentlyLiked ? 'DELETE' : 'POST';
                        const url = isCurrentlyLiked ?
                            `/posts/${postId}/unlike` :
                            `/posts/${postId}/like`;

                        const response = await fetch(url, {
                            method: method,
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            }
                        });

                        if (response.ok) {
                            const data = await response.json();

                            // Update UI
                            if (isCurrentlyLiked) {
                                // Just unliked
                                likeIcon.textContent = '🤍';
                                likeText.textContent = 'Like';
                                likeButton.classList.remove('text-pink-600', 'hover:text-pink-800');
                                likeButton.classList.add('text-blue-600', 'hover:text-blue-800');
                            } else {
                                // Just liked
                                likeIcon.textContent = '❤️';
                                likeText.textContent = 'Liked';
                                likeButton.classList.remove('text-blue-600', 'hover:text-blue-800');
                                likeButton.classList.add('text-pink-600', 'hover:text-pink-800');
                            }

                            // Update like count
                            likeCount.textContent = `${data.likes_count} Likes`;

                            // Add animation feedback
                            likeIcon.style.transform = 'scale(1.3)';
                            setTimeout(() => {
                                likeIcon.style.transform = 'scale(1)';
                            }, 200);

                        } else {
                            throw new Error('Failed to update like');
                        }
                    } catch (error) {
                        console.error('Error toggling like:', error);
                        alert('Failed to update like. Please try again.');
                    } finally {
                        // Re-enable button
                        likeButton.disabled = false;
                    }
                }

                async function sharePost(title, url) {
                    try {
                        if (navigator.share) {
                            // Use Web Share API if available
                            await navigator.share({
                                title: title,
                                text: 'Check out this post!',
                                url: url,
                            });
                        } else if (navigator.clipboard) {
                            // Fallback: Copy link to clipboard
                            await navigator.clipboard.writeText(url);

                            // Show success feedback
                            const originalText = event.target.textContent;
                            event.target.textContent = '✅ Copied!';
                            event.target.classList.remove('text-green-600', 'hover:text-green-800');
                            event.target.classList.add('text-green-700');

                            setTimeout(() => {
                                event.target.textContent = originalText;
                                event.target.classList.remove('text-green-700');
                                event.target.classList.add('text-green-600', 'hover:text-green-800');
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
                            // User cancelled share, don't show error
                            console.error('Error sharing:', error);

                            // Show manual share options
                            showShareOptions(title, url);
                        }
                    }
                }

                function showShareOptions(title, url) {
                    // Create a modal or dropdown with share options
                    const shareModal = document.createElement('div');
                    shareModal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
                    shareModal.innerHTML = `
        <div class="bg-white rounded-lg p-6 max-w-sm w-full mx-4">
            <h3 class="text-lg font-semibold mb-4">Share Post</h3>
            <p class="text-gray-600 mb-4">Copy the link or share via:</p>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-gray-700">Link:</span>
                    <input type="text" value="${url}" readonly
                           class="border rounded px-2 py-1 text-sm flex-1 mx-2">
                    <button onclick="copyToClipboard('${url}')"
                            class="bg-blue-500 text-white px-3 py-1 rounded text-sm hover:bg-blue-600">
                        Copy
                    </button>
                </div>
                <div class="pt-4 border-t">
                    <a href="https://twitter.com/intent/tweet?text=${encodeURIComponent(title)}&url=${encodeURIComponent(url)}"
                       target="_blank"
                       class="text-blue-400 hover:text-blue-600 block mb-2">
                        🐦 Share on Twitter
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}"
                       target="_blank"
                       class="text-blue-600 hover:text-blue-800 block">
                        📘 Share on Facebook
                    </a>
                </div>
            </div>
            <button onclick="this.closest('.fixed').remove()"
                    class="mt-6 w-full bg-gray-100 hover:bg-gray-200 text-gray-800 py-2 rounded">
                Close
            </button>
        </div>
    `;
                    document.body.appendChild(shareModal);
                }

                function copyToClipboard(text) {
                    navigator.clipboard.writeText(text).then(() => {
                        alert('Link copied to clipboard!');
                    });
                }
            </script>

            {{-- Make sure CSRF token meta tag exists in your layout --}}
            @if (!View::hasSection('csrf-meta'))
                @section('csrf-meta')
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                @endsection
            @endif

            <div class="mt-6">
                {{ $posts->links() }}
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-4xl font-bold text-indigo-600 mb-2">500+</div>
                    <div class="text-gray-600">Students</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-indigo-600 mb-2">50+</div>
                    <div class="text-gray-600">Teachers</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-indigo-600 mb-2">1000+</div>
                    <div class="text-gray-600">Parents</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-indigo-600 mb-2">98%</div>
                    <div class="text-gray-600">Satisfaction</div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-4xl font-bold text-center text-gray-900 mb-12">How It Works</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-indigo-100 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-indigo-600 font-bold">1</span>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Register</h3>
                    <p class="text-gray-600">Create your account as a student, teacher, or parent</p>
                </div>
                <div class="text-center">
                    <div class="bg-indigo-100 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-indigo-600 font-bold">2</span>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Setup</h3>
                    <p class="text-gray-600">Complete your profile and get familiar with the dashboard</p>
                </div>
                <div class="text-center">
                    <div class="bg-indigo-100 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-indigo-600 font-bold">3</span>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Engage</h3>
                    <p class="text-gray-600">Start managing your educational activities efficiently</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-indigo-600 text-white">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-4">Ready to Get Started?</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">
                Join thousands of educational institutions using our platform to streamline their operations.
            </p>
            <a href="{{ route('register') }}"
                class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
                Create Your Account
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h4 class="text-lg font-semibold mb-4">SchoolSystem</h4>
                    <p class="text-gray-400">
                        Comprehensive school management solution for modern educational institutions.
                    </p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white">Home</a></li>
                        <li><a href="#features" class="hover:text-white">Features</a></li>
                        <li><a href="#" class="hover:text-white">About</a></li>
                        <li><a href="#" class="hover:text-white">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Contact</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li>Email: info@schoolsystem.com</li>
                        <li>Phone: +1 (555) 123-4567</li>
                        <li>Address: 123 Education St, City</li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Follow Us</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2024 School Management System. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Smooth scroll for anchor links -->
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
@endsection
