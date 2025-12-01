<?php
// app/Http/Controllers/CommentController.php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Post $post): RedirectResponse
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $comment = Comment::create([
            'content' => $validated['content'],
            'user_id' => auth()->user()->id,
            'post_id' => $post->id, // <-- Use the bound $post object's ID
            'is_approved' => true,
            // Optional: you can use $validated['parent_id'] here if using nested comments
        ]);

        // Alternative approach using the relationship method (more Laravel idiomatic)
        // $comment = $post->comments()->create([
        //     'content' => $validated['content'],
        //     'user_id' => auth()->id(),
        //     'is_approved' => true,
        // ]);

        return redirect()->route('posts.show', $post)
            ->with('success', 'Comment added successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment): RedirectResponse
    {
        $this->authorize('update', $comment);

        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment->update($validated);

        return redirect()->route('posts.show', $comment->post)
            ->with('success', 'Comment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment): RedirectResponse
    {
        $this->authorize('delete', $comment);

        $post = $comment->post;
        $comment->delete();

        return redirect()->route('posts.show', $post)
            ->with('success', 'Comment deleted successfully.');
    }
}
