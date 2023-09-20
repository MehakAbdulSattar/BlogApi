<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{

    public function createPost(Request $request)
    {
    //     // Validation rules
    //     $rules = [
    //         'title' => 'required|max:255',
    //         'description' => 'required',
    //         'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    //     ];

    //     // Validate the request
    //     $validator = Validator::make($request->all(), $rules);

    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 400);
    //     }

    //     // Handle image upload (if needed)
    //     if ($request->hasFile('image')) {
    //         $imagePath = $request->file('image')->store('uploads', 'public');
    //     } else {
    //         $imagePath = null;
    //     }

    //     // Create a new post
    //     $post = Post::create([
    //         'title' => $request->input('title'),
    //         'description' => $request->input('description'),
    //         'image' => $imagePath,
    //         'user_id' => auth()->user()->id,
    //     ]);

    //     // Return a JSON response indicating success
    //     return response()->json(['message' => 'Post created successfully', 'post' => $post], 201);
    }

}
