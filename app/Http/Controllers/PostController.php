<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth; 

class PostController extends Controller
{

    public function create(Request $request)
    {
        $user=Auth::user();
        // Validation rules
        $rules = [
            'title' => 'required|max:255',
            'description' => 'required',
            
        ];

        // Validate the request
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Handle image upload (if needed)
        if ($request->hasFile('image')) 
        {
            $imagePath = $request->file('image')->store('uploads', 'public');
        } 
        else 
        {
            $imagePath = null;
        }

        // Create a new post
        $post = Post::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'image' => $imagePath,
            'user_id' => $user->id,
        ]);

        // Return a JSON response indicating success
        return response()->json(['message' => 'Post created successfully', 'post' => $post], 201);
    }

    public function editPost(Request $request, $id)
    {
        // Find the post by its ID
        $post = Post::find($id);
        $imagePath=null;
        // Check if the post exists
        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }
    
        // Validation rules for the update
        $rules = [
            'title' => 'required|max:255',
            'description' => 'required',
        ];
    
        // Validate the request
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
    
        // Handle image upload (if needed)
        if ($request->hasFile('image')) 
        {
            $imagePath = $request->file('image')->store('uploads', 'public');
        } 
        else 
        {
            $imagePath = null;
        }
    
        // Update the post attributes
        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->save();

        // Return a JSON response indicating success
        return response()->json(['message' => 'Post updated successfully', 'post' => $post]);
    }

    public function showAllPosts()
    {
        $user=Auth::user(); // Get the authenticated user
        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }
        
        // Fetch all posts associated with the logged-in user
        $userPosts = Post::where('user_id', $user->id)->get();
        //dd($userPosts);

        return response()->json(['post' => $userPosts], 200);

    }


    public function deletePost(Request $request, $id)
    {
       $post=Post::find($id);
        // Check if the authenticated user is the owner of the post
        if ($post->user_id !== Auth::user()->id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Delete the post
        $post->delete();

        return response()->json(['message' => 'Post deleted successfully'], 200);
    }



    public function index()
    {
        $posts = Post::all();
        return response()->json([
            'message' => 'Posts retrieved successfully',
            'data' => $posts,
        ]);
    }


}
