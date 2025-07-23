<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\Post2Controller;
use App\Http\Controllers\Admin\CategoryController;

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::group(['middleware' => 'auth'], function(){
    Route::get('/', [HomeController::class, 'index'])->name('home');

    //post
    Route::get('/post/create', [PostController::class, 'create'])->name('post.create');
    Route::post('/post/store', [PostController::class,'store'])->name('post.store');
    Route::get('/post/{id}/show',[PostController::class,'show'])->name('post.show');
    Route::get('/post/{id}/edit',[PostController::class,'edit'])->name('post.edit');
    Route::patch('post/{id}/update', [PostController::class, 'update'])->name('post.update');
    Route::delete('post/{id}/destroy', [PostController::class, 'destroy'])->name('post.destroy');
    

    //comment
    Route::post('/comment/{post_id}/store',[CommentController::class, 'store'])->name('comment.store');
    Route::delete('/comment/{id}/destroy', [CommentController::class, 'destroy'])->name('comment.destroy');

    //profile
    Route::get('/profile/{id}/show',[ProfileController::class,'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class,'edit'])->name('profile.edit');
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/{id}/followers', [ProfileController::class, 'followers'])->name('profile.followers');
    Route::get('/profile/{id}/following',[ProfileController::class, 'following'])->name('profile.following');
    Route::patch('/profile/update-password',[ProfileController::class, 'updatePassword'])->name('profile.updatePassword');

    //likes
    Route::post('/like/{post_id}/store', [LikeController::class, 'store'])->name('like.store');
    Route::delete('/like/{post_id}/destroy', [LikeController::class, 'destroy'])->name('like.destroy');

    //follows
    Route::post('/follow/{user_id}/store',[FollowController::class, 'store'])->name('follow.store');
    Route::delete('/follow/{user_id}/destroy', [FollowController::class, 'destroy'])->name('follow.destroy');

    //admin
    Route::group(['prefix' => '/admin', 'as' => 'admin.'], function(){
        //users
        Route::get('/users', [UserController::class, 'index'])->name('users');
        // /admin/users                                            
        Route::delete('/users/{id}/deactivate',[UserController::class, 'deactivate'])->name('users.deactivate');
        Route::patch('/users/{id}/activate', [UserController::class, 'activate'])->name('users.activate');

        //posts
        Route::get('/post', [Post2Controller::class, 'index'])->name('posts');
        Route::delete('/posts/{id}/hide', [Post2Coontroller::class, 'hide'])->name('posts.hide');
        Route::patch('/posts/{id}/unhide', [Post2Controller::class, 'unhide'])->name('posts.unhide');

        //categories
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
        Route::post('/categories/store', [CategoryController::class, 'store'])->name('categories.store');
        Route::delete('/categories/{id}/destroy', [CategoryController::class, 'destroy'])->name('categories.destroy');
        Route::patch('/categories/{id}/update', [CategoryController::class, 'update'])->name('categories.update');
       
    });

    Route::get('/suggested-users', [HomeController::class, 'suggestedUsers'])->name('suggestedUsers');

});


