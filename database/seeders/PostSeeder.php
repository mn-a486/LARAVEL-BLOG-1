<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first(); // 最初のユーザーに紐づけ

        Post::create([
            'user_id' => $user->id,
            'category_id' => 1,
            'title' => 'First Post',
            'body' => 'This is a sample post.',
            'image' => 'sample.jpg', // storageに画像がなくてもOK
        ]);
    }
}
