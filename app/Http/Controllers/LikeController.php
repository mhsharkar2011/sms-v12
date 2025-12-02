<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

class LikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Add this toggle method
    public function toggle(Request $request, Post $post)
    {
        // Check if it's an AJAX request or form submission
        if ($request->ajax()) {
            // Handle AJAX request (your JavaScript)
            // ... your existing code ...
        } else {
            // Handle form submission (regular POST)
            $user = Auth::user();

            $existingLike = Like::where('user_id', $user->id)
                ->where('post_id', $post->id)
                ->first();

            if ($existingLike) {
                $existingLike->delete();
                $message = 'Post unliked';
            } else {
                Like::create([
                    'user_id' => $user->id,
                    'post_id' => $post->id,
                ]);
                $message = 'Post liked';
            }

            return back()->with('success', $message);
        }
    }
    /**
     * Like a post
     */
    public function like(Post $post)
    {
        $user = Auth::user();

        // Check if user already liked the post
        $existingLike = Like::where('user_id', $user->id)
            ->where('post_id', $post->id)
            ->first();

        if ($existingLike) {
            return response()->json([
                'message' => 'You already liked this post.',
                'likes_count' => $post->likes()->count()
            ], 400);
        }

        // // Create new like
        // $like = new Like();
        // $like->user_id = Auth::id();
        // $like->post_id = $post->id;
        // $like->save();

        // Create new like
        $like = Like::create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);
        // Refresh post to get updated likes count
        $post->refresh();

        return response()->json([
            'message' => 'Post liked successfully.',
            'likes_count' => $post->likes()->count(),
            'is_liked' => true
        ], 201);
    }

    /**
     * Unlike a post
     */
    public function unlike(Post $post)
    {
        $user = Auth::user();
        $like = Like::where('user_id', $user->id)
            ->where('post_id', $post->id)
            ->first();

        if (!$like) {
            return response()->json([
                'message' => 'You have not liked this post.',
                'likes_count' => $post->likes()->count()
            ], 400);
        }

        $like->delete();

        // Refresh post to get updated likes count
        $post->refresh();

        return response()->json([
            'message' => 'Post unliked successfully.',
            'likes_count' => $post->likes()->count(),
            'is_liked' => false
        ], 200);
    }
    /**
     * Toggle like/unlike
     */
    // public function toggle(Post $post)
    // {
    //     $user = Auth::user();
    //     $like = Like::where('user_id', $user->id)
    //         ->where('post_id', $post->id)
    //         ->first();
    //     if ($like) {
    //         $like->delete();
    //         $action = 'unliked';
    //         $isLiked = false;
    //     } else {
    //         Like::create([
    //             'user_id' => $user->id,
    //             'post_id' => $post->id,
    //         ]);
    //         $action = 'liked';
    //         $isLiked = true;
    //     }
    //     // Refresh to get updated count
    //     $post->refresh();
    //     return response()->json([
    //         'message' => "Post {$action} successfully.",
    //         'likes_count' => $post->likes()->count(),
    //         'is_liked' => $isLiked
    //     ], $action === 'liked' ? 201 : 200);
    // }
}
