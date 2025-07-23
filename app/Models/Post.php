<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    
    //post has many category_post
    public function categoryPosts(){
        return $this->hasMany(CategoryPost::class);
    }

    //post belongs to user
    public function user(){
        return $this->belongsTo(User::class)->withTrashed();
    }

    //post has many comments 
    public function comments(){
        return $this->hasMany(Comment::class);
    }

    //post has many likes
    public function likes(){
        return $this->hasMany(Like::class);
    }

    //return true if $this post is already liked by logged-in user
    public function isLiked(){
        return $this->likes()->where('user_id', Auth::user()->id)->exists();
        //$this-> == post
        //$this->likes() == get all likes of post
        //where(...)  == in the likes, find the logged-in user
        //exists() == if where() found rows,  return true
    }
}
