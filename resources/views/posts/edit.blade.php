@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg rounded-lg p-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-6">Edit Post</h1>

            <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Title -->
                <div class="mb-6">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Post Title *</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}"
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
                        placeholder="Write your post content here..." required>{{ old('content', $post->content) }}</textarea>
                    @error('content')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Excerpt -->
                <div class="mb-6">
                    <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">Excerpt</label>
                    <textarea name="excerpt" id="excerpt" rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Brief description of your post (optional)">{{ old('excerpt', $post->excerpt) }}</textarea>
                </div>

                <!-- Current Featured Image -->
                @if ($post->featured_image)
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Current Featured Image</label>
                        <div class="flex items-center space-x-4">
                            <img src="{{ $post->getFeaturedImageUrl() }}" alt="Current featured image"
                                class="w-32 h-32 object-cover rounded-lg">
                            <div>
                                <p class="text-sm text-gray-600">Current image</p>
                                <label class="flex items-center mt-2">
                                    <input type="checkbox" name="remove_featured_image" value="1" class="rounded">
                                    <span class="ml-2 text-sm text-gray-600">Remove featured image</span>
                                </label>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- New Featured Image -->
                <div class="mb-6">
                    <label for="featured_image" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ $post->featured_image ? 'Replace Featured Image' : 'Featured Image' }}
                    </label>
                    <input type="file" name="featured_image" id="featured_image" accept="image/*"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Status -->
                <div class="mb-6">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" id="status"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="draft" {{ old('status', $post->status) == 'draft' ? 'selected' : '' }}>Draft
                        </option>
                        <option value="published" {{ old('status', $post->status) == 'published' ? 'selected' : '' }}>
                            Published</option>
                    </select>
                </div>

                <!-- Meta Title -->
                <div class="mb-6">
                    <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-2">Meta Title (SEO)</label>
                    <input type="text" name="meta_title" id="meta_title"
                        value="{{ old('meta_title', $post->meta_title) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Optional meta title for SEO">
                </div>

                <!-- Meta Description -->
                <div class="mb-6">
                    <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-2">Meta Description
                        (SEO)</label>
                    <textarea name="meta_description" id="meta_description" rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Optional meta description for SEO">{{ old('meta_description', $post->meta_description) }}</textarea>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                    <a href="{{ route('posts.show', $post) }}"
                        class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-150">
                        Cancel
                    </a>
                    <div class="flex space-x-4">
                        <button type="submit"
                            class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-150">
                            Update Post
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
