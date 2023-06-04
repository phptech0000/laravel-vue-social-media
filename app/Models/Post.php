<?php

namespace App\Models;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


/*
|--------------------------------------------------------------------------
| Relationships
|--------------------------------------------------------------------------
|
| belongsTo() represents a one-to-one or many-to-one relationship, 
| where the current model belongs to another model.
| 
| 
| hasMany() represents a one-to-many relationship, where the current 
| model can have multiple instances of the related model.
*/

class Post extends Model
{
    use HasFactory;

    // Each post is associated with a single user.
    // Post model would have a foreign key column, typically named 'user_id'
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // inside comments we will have 'post_id' column
    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy("created_at", "desc");
    }
}
