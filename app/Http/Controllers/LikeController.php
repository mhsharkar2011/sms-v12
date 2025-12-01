<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


    public function like(Post $post)
    {
        auth()->user()->likes()->attach($post->id);

        return response()->json([
            'likes_count' => $post->likes()->count(),
            'message' => 'Post liked successfully'
        ]);
    }

    public function unlike(Post $post)
    {
        auth()->user()->likes()->detach($post->id);

        return response()->json([
            'likes_count' => $post->likes()->count(),
            'message' => 'Post unliked successfully'
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Like $like)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Like $like)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Like $like)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Like $like)
    {
        //
    }
}
