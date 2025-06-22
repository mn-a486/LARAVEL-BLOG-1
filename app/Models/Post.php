<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    # Post - User
    #to get the owner of the post
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_post');
    }
}
