<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $post = Post::first();

        Comment::create([
            'user_id' => $user->id,
            'post_id' => $post->id,
            'body' => 'Nice post!',
        ]);
    }
}
