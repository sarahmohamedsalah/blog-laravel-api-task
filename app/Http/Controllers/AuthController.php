<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{


    public function register(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users', // Ensure email is unique
            'password' => 'required|string|min:8|confirmed', // Ensure password_confirmation is included
            'role' => 'required|in:admin,author', // Role validation
        ]);

        // Create the new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), // Encrypt password
            'role' => $request->role,  // Store the role
        ]);

        // Generate JWT token
        $token = JWTAuth::fromUser($user);

        // Return the response with the token
        return response()->json(['sucess' => $user], 201);
    }


    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if ($token = JWTAuth::attempt($credentials)) {
            return response()->json(['token' => $token]);
        }

        return response()->json(['error' => 'Invalid credentials'], 401);
    }
}
