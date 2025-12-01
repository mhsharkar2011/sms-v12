<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function like(Post $post)
    {
        // Check if already liked
        if ($post->likes()->where('user_id', auth()->id())->exists()) {
            return response()->json([
                'message' => 'Already liked',
                'likes_count' => $post->likes()->count()
            ], 200);
        }

        // Create the like
        $post->likes()->attach(auth()->id());

        // Reload the relationship to get updated count
        $post->loadCount('likes');

        return response()->json([
            'message' => 'Post liked successfully',
            'likes_count' => $post->likes_count,
            'liked' => true
        ], 200);
    }

    public function unlike(Post $post)
    {
        // Check if not already liked
        if (!$post->likes()->where('user_id', auth()->id())->exists()) {
            return response()->json([
                'message' => 'Not liked yet',
                'likes_count' => $post->likes()->count()
            ], 200);
        }

        // Remove the like
        $post->likes()->detach(auth()->id());

        // Reload the relationship to get updated count
        $post->loadCount('likes');

        return response()->json([
            'message' => 'Post unliked successfully',
            'likes_count' => $post->likes_count,
            'liked' => false
        ], 200);
    }
}
