<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;

class CommentController extends Controller
{
    public function createComment(Request $request)
    {
        $validatedData = $request->validate([
            'comment' => 'required|max:500',
            'post_id' => 'required',
        ]);
        
        $comment = new Comment;
        $comment->comment = $request->input('comment');
        $user=Auth::user();
        if(!$user)
        {
            $comment->user_id=0;
        }
        else
        {
            $comment->user_id = $user->id; // Assign the user ID to the comment.
        }
        $comment->post_id = $request-> input('post_id');
        $comment->save();
        
        // Prepare a JSON response indicating success
        $response = [
            'message' => 'Comment added successfully',
            'comment' => $comment, 
        ];

        return response()->json($response, 201);
    }

    public function deleteComment(Request $request, Comment $comment)
    {
        // Check if the authenticated user is the owner of the comment or an admin (you can customize this logic)
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Delete the comment
        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully'], 200);
    }

    public function showComments(Request $request, $post_id)
    {
        $post = Post::find($post_id);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }
        $comments = Comment::where('post_id', $post_id)->get();

        return response()->json(['comments' => $comments], 200);
    }

    
}
