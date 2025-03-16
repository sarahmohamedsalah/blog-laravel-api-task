<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    // Define fillable fields for mass assignment
    protected $fillable = [
        'post_id',
        'user_id',
        'comment',
    ];

    // Define the relationship with the Post model (each comment belongs to a post)
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // Define the relationship with the User model (each comment belongs to a user)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
