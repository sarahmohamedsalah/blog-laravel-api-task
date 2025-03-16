<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request, $postId)
    {
        // Validate that 'comment' is required and is a string
        $request->validate([
            'comment' => 'required|string',
        ]);

        // Create a new comment and associate it with the post and the authenticated user
        $comment = Comment::create([
            'post_id' => $postId,   // Associate the comment with the post
            'user_id' => auth()->id(),  // Associate the comment with the authenticated user
            'comment' => $request->comment,  // The content of the comment
        ]);

        // Return the created comment as a JSON response with a 201 Created status
        return response()->json($comment, 201);
    }
}
