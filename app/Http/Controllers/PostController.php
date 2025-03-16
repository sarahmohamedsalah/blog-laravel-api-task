<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function __construct()
    {
        // All routes here will require authentication, and some will need specific roles
        $this->middleware('auth:api');
    }

    // Create Post: Only authors can create their own posts
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|in:Technology,Lifestyle,Education',
        ]);

        // Create a new post and associate it with the logged-in user (author)
        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'category' => $request->category,
            'author_id' => auth()->id(),  // Associate with the logged-in user (author)
        ]);

        return response()->json($post, 201);
    }

    // List all posts: Admin can view all posts, authors can view their own posts
    public function index(Request $request)
    {
        // Initialize the query to fetch posts
        $query = Post::query();

        // Admin can see all posts, authors can only see their own posts
        if (auth()->user()->role === 'author') {
            $query->where('author_id', auth()->id());  // Authors can only view their own posts
        }

        // Filter by category (optional)
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        // Filter by author (optional)
        if ($request->has('author') && $request->author) {
            $query->where('author_id', $request->author);
        }

        // Filter by date range (start_date and end_date)
        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = $request->start_date;
            $endDate = $request->end_date;

            // Optionally, validate that the dates are valid
            if ($startDate && $endDate && strtotime($startDate) !== false && strtotime($endDate) !== false) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
        }

        // Apply pagination
        $posts = $query->paginate(10);  // You can adjust the number (10) for pagination as needed

        return response()->json($posts);
    }


    // Show a specific post: Anyone can view a post, but only the author or admin can update or delete it
    public function show($id)
    {
        $post = Post::with('author')->findOrFail($id);
        return response()->json($post);
    }

    // Update Post: Only the post author or an admin can update the post
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        // Check if the user is authorized to update the post (either they are the author or an admin)
        if ($post->author_id !== auth()->id() && auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $post->update($request->only('title', 'content', 'category'));

        return response()->json($post);
    }

    // Delete Post: Only the post author or an admin can delete the post
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        // Check if the user is authorized to delete the post (either they are the author or an admin)
        if ($post->author_id !== auth()->id() && auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $post->delete();

        return response()->json(['message' => 'Post deleted']);
    }
}
