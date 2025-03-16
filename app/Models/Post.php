<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
    protected $fillable = [
        'title',
        'content',
        'category',
        'author_id',  // Assuming author_id is the foreign key for the user
    ];
}
