<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class Post2Controller extends Controller
{
    private $post;
    public function __construct(Post $post){
        $this->post = $post; //$this->post = new Post;
    }

    public function index(){
        $all_posts = $this->post->latest()->withTrashed()->paginate(10);

        return view('admin.posts.index')->with('all_posts', $all_posts);
    }

    public function hide($id){
        $this->post->destroy($id);

        return redirect()->back();
    }

    public function unhide($id){
        $this->post->onlyTrashed()->findOrFail($id)->restore();

        return redirect()->back();
    }
}
