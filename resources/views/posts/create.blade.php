@extends('layouts.app')

@section('title', 'Create Post')

@section('content')
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg rounded-lg p-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-6">Create New Post</h1>

            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Title -->
                <div class="mb-6">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Post Title *</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-500 @enderror"
                        placeholder="Enter post title" required>
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Content -->
                <div class="mb-6">
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Content *</label>
                    <textarea name="content" id="content" rows="12"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('content') border-red-500 @enderror"
                        placeholder="Write your post content here..." required>{{ old('content') }}</textarea>
                    @error('content')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Excerpt -->
                <div class="mb-6">
                    <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">Excerpt</label>
                    <textarea name="excerpt" id="excerpt" rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Brief description of your post (optional)">{{ old('excerpt') }}</textarea>
                    <p class="text-sm text-gray-500 mt-1">If left blank, an excerpt will be generated from your content.</p>
                </div>

                <!-- Featured Image -->
                <div class="mb-6">
                    <label for="featured_image" class="block text-sm font-medium text-gray-700 mb-2">Featured Image</label>
                    <input type="file" name="featured_image" id="featured_image" accept="image/*"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('featured_image') border-red-500 @enderror">
                    @error('featured_image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-sm text-gray-500 mt-1">Supported formats: JPEG, PNG, JPG, GIF. Max size: 2MB</p>
                </div>

                <!-- Status -->
                <div class="mb-6">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" id="status"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status') == 'published' || !old('status') ? 'selected' : '' }}>
                            Published</option>
                    </select>
                </div>

                <!-- Meta Title -->
                <div class="mb-6">
                    <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-2">Meta Title (SEO)</label>
                    <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Optional meta title for SEO">
                </div>

                <!-- Meta Description -->
                <div class="mb-6">
                    <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-2">Meta Description
                        (SEO)</label>
                    <textarea name="meta_description" id="meta_description" rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Optional meta description for SEO">{{ old('meta_description') }}</textarea>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                    <a href="{{ route('posts.index') }}"
                        class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-150">
                        Cancel
                    </a>
                    <div class="flex space-x-4">
                        <button type="submit" name="status" value="draft"
                            class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-150">
                            Save as Draft
                        </button>
                        <button type="submit" name="status" value="published"
                            class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-150">
                            Publish Post
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Simple Markdown Preview Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const contentTextarea = document.getElementById('content');
            const titleInput = document.getElementById('title');
            const excerptTextarea = document.getElementById('excerpt');

            // Auto-generate excerpt if empty and content changes
            contentTextarea.addEventListener('blur', function() {
                if (!excerptTextarea.value && contentTextarea.value) {
                    const content = contentTextarea.value.replace(/[#*`~]/g, '').substring(0, 150);
                excerptTextarea.value = content + (content.length === 150 ? '...' : '');
            }
        });

        // Auto-generate meta title if empty and title changes
        titleInput.addEventListener('blur', function() {
            const metaTitle = document.getElementById('meta_title');
            if (!metaTitle.value && titleInput.value) {
                metaTitle.value = titleInput.value;
            }
        });
    });



    async function toggleLike(postId) {
        const likeButton = document.getElementById(`like-button-${postId}`);
        const likeIcon = document.getElementById(`like-icon-${postId}`);
        const likeText = document.getElementById(`like-text-${postId}`);
        const likeCount = document.getElementById(`like-count-${postId}`);

        // Store current state locally
        const isCurrentlyLiked = likeIcon.textContent.trim() === '❤️';

        if (!likeButton || !likeIcon || !likeText || !likeCount) {
            console.error('Like elements not found');
            return;
        }

        try {
            likeButton.disabled = true;

            // Create form data
            const formData = new FormData();
            formData.append('_token', csrfToken);

            const url = isCurrentlyLiked ?
                `/posts/${postId}/unlike` :
                `/posts/${postId}/like`;
            const method = isCurrentlyLiked ? 'DELETE' : 'POST';

            const response = await fetch(url, {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: formData,
            });

            const data = await response.json();

            if (response.ok) {
                // Update UI based on response
                const liked = data.liked !== undefined ? data.liked : !isCurrentlyLiked;

                likeIcon.textContent = liked ? '❤️' : '🤍';
                likeText.textContent = liked ? 'Liked' : 'Like';

                // Update classes
                likeButton.classList.toggle('text-pink-600', liked);
                likeButton.classList.toggle('text-blue-600', !liked);
                likeButton.classList.toggle('hover:text-pink-800', liked);
                likeButton.classList.toggle('hover:text-blue-800', !liked);

                // Update count
                if (data.likes_count !== undefined) {
                    likeCount.textContent = `${data.likes_count} Likes`;
                    }

                    // Animation
                    likeIcon.style.transform = 'scale(1.3)';
                    setTimeout(() => {
                        likeIcon.style.transform = 'scale(1)';
                    }, 200);
                } else {
                    throw new Error(data.message || 'Request failed');
                }
            } catch (error) {
                console.error('Like error:', error);
                alert(error.message || 'Something went wrong. Please try again.');
            } finally {
                likeButton.disabled = false;
            }
        }
    </script>

    <style>
        /* Custom styles for better form appearance */
        input:focus,
        textarea:focus,
        select:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
    </style>
@endsection
