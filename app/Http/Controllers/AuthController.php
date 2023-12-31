<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        // Create a new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->assignRole('User');

        return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
    }

    

    public function login(Request $request)
    {
        // Validate the request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Attempt to authenticate the user
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('token')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'user_id' => $user->id,
                'access_token' => $token
            ], 200);
        }

        return response()->json(['message' => 'Login failed'], 401);
    }

    
    public function logout(Request $request)
    {
        // Revoke the user's current token, effectively logging them out
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout successful'], 200);
    }


// ...

public function deleteUser(Request $request,$id)
    {
        // Get the user ID from the request

        // Find the user by ID
        $user = User::find($id);
    

        // Check if the user exists
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }


        // Use a database transaction to ensure data consistency
        DB::beginTransaction();

        try {
            // Revoke all of the user's tokens, effectively logging them out
            if(Auth::user()===$user)
            {
                $user->tokens->each(function ($token) {
                    $token->delete();
                });
            }

            // Delete the user's account
            $user->delete();

            // Commit the transaction
            DB::commit();

            return response()->json(['message' => 'Account deleted successfully'], 200);
        } catch (\Exception $e) {
            // Something went wrong, rollback the transaction
            DB::rollback();

            return response()->json(['message' => 'Failed to delete account'], 500);
        }
    }

    public function showAllUsers()
    {
    
        $users = User::all();
    
        return response()->json([
            'message' => 'Users retrieved successfully',
            'data' => $users,
        ]);
    }
    

}

