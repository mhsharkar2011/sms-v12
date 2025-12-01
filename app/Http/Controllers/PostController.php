<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

// Make sure it extends Controller
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $posts = Post::published()
            ->with(['comments.user'])
            ->withCount(['comments', 'likes'])
            ->latest()
            ->paginate(10);

        return view('landing', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:10',
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        try {
            $post = Post::create([
                'title' => $validated['title'],
                'content' => $validated['content'],
                'excerpt' => $validated['excerpt'],
                'status' => $validated['status'],
                'meta_title' => $validated['meta_title'],
                'meta_description' => $validated['meta_description'],
                'user_id' => auth()->id(),
                'published_at' => $validated['status'] === 'published' ? now() : null,
            ]);

            if ($request->hasFile('featured_image')) {
                $path = $request->file('featured_image')->store('posts', 'public');
                $post->update(['featured_image' => $path]);
            }

            $message = $validated['status'] === 'published'
                ? 'Post published successfully!'
                : 'Post saved as draft.';

            return redirect()->route('posts.show', $post)
                ->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create post. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): View
    {
        if (!$post->isPublished() && !auth()->user()?->can('update', $post)) {
            abort(404);
        }

        $post->load(['user', 'comments.user', 'comments.replies.user']);

        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post): View
    {
        // This will now work because we extend Controller
        $this->authorize('update', $post);

        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post): RedirectResponse
    {
        // This will now work because we extend Controller
        $this->authorize('update', $post);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:10',
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        try {
            $updateData = [
                'title' => $validated['title'],
                'content' => $validated['content'],
                'excerpt' => $validated['excerpt'],
                'status' => $validated['status'],
                'meta_title' => $validated['meta_title'],
                'meta_description' => $validated['meta_description'],
            ];

            if ($validated['status'] === 'published' && $post->status !== 'published') {
                $updateData['published_at'] = now();
            }

            if ($request->has('remove_featured_image') && $post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
                $updateData['featured_image'] = null;
            }

            if ($request->hasFile('featured_image')) {
                if ($post->featured_image) {
                    Storage::disk('public')->delete($post->featured_image);
                }

                $path = $request->file('featured_image')->store('posts', 'public');
                $updateData['featured_image'] = $path;
            }

            $post->update($updateData);

            return redirect()->route('posts.show', $post)
                ->with('success', 'Post updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update post. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): RedirectResponse
    {
        // This will now work because we extend Controller
        $this->authorize('delete', $post);

        try {
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }

            $post->delete();

            return redirect()->route('posts.index')
                ->with('success', 'Post deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete post. Please try again.');
        }
    }
}
