<?php

namespace App\Models;

use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    // in the *_comments_* migration, we will have a 'post_id' foreign key
    public function post()
    {
        return $this->belongsTo(Post::class);
    }


    // in the *_comments_* migration, we will have a 'user_id' foreign key
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
