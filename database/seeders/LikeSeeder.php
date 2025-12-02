<?php

namespace Database\Seeders;

use App\Models\Like;
use App\Models\User;
use App\Models\Post;
use Illuminate\Database\Seeder;

class LikeSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $posts = Post::all();

        foreach ($posts as $post) {
            // Get random number of users to like this post
            $randomUsers = $users->random(rand(0, min(10, $users->count())));

            foreach ($randomUsers as $user) {
                Like::create([
                    'user_id' => $user->id,
                    'post_id' => $post->id,
                ]);
            }
        }
    }
}
