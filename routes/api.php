<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware(['auth:sanctum'])->post('/logout', [AuthController::class,'logout']);


Route::middleware(['auth:sanctum'])->group(function () 
{
    Route::middleware(['permission:create_post'])->post('/createpost', [PostController::class, 'create']);
    Route::middleware(['permission:edit_post'])->post('/editpost/{id}', [PostController::class, 'editPost']);
    Route::middleware(['permission:show_post'])->get('/showposts', [PostController::class, 'showAllPosts']);
    Route::middleware(['permission:delete_post'])->delete('/deletepost/{id}', [PostController::class, 'deletePost']);
    Route::middleware(['permission:create_comment'])->post('/create/comment', [CommentController::class, 'createComment']);
    Route::middleware(['permission:delete_user'])->delete('/user', [AuthController::class,'deleteUser']);
    Route::middleware(['permission:delete_comment'])->delete('/comments/{comment}', [CommentController::Class,'deleteComment']);


});

Route::middleware(['guest'])->get('/posts', [PostController::class, 'index']);



