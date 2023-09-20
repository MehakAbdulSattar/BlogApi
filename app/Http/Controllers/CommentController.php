<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $validatedData = $request->validate([
            'content' => 'required|max:500',
        ]);

        $comment = new Comment;
        $comment->content = $request->input('content');
        $comment->user_id = auth()->user()->id; // Assign the user ID to the comment.
        $comment->post_id = $post->id;
        $comment->save();

        return redirect()->route('posts.show', $post)->with('success', 'Comment added successfully');
    }

    
}
