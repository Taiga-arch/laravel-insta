<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Post;

class PostController extends Controller
{
    private $post;
    public function __construct(Post $post){
        $this->post = $post;
    }

    public function create(){
            //get a list of all categories
            $all_categories = Category::all();
            return view('user.post.create')->with('all_categories', $all_categories);
    }

    public function store(Request $request){
        $request->validate([
            'categories' => 'required|array|between:1,3',
            'description' => 'required|max:1000',
            'image' => 'required|max:1048|mimes:jpeg,jpg,png,gif'
        ]);

        $this->post->description = $request->description;
        $this->post->user_id = Auth::user()->id;
        $this->post->image = "data:image/".$request->image->extension().";base64,".base64_encode(file_get_contents($request->image));
        $this->post->save();

        //save category_post
        $category_posts = [];
        foreach($request->categories as $category_id){
            $category_posts []= ['category_id' => $category_id];
        }
        // $category_posts = [
        //     ['category_id' => 1],
        //     ['category_id' => 2
        // ];
        $this->post->categoryPosts()->createMany($category_posts);

        // solution 2:
        // foreach($request->categories as $category_id){
        //     $category_post = [
        //         'category_id' => $category_id,
        //         'post_id' => $this->post->id
        //     ];
        //     CategoryPost::create($category_post);
        // }

        return redirect()->route('home');
    }

    public function show($id){
        //get data of post with ID=$id
        $post = $this->post->findOrFail($id);

        return view('user.post.show')->with('post', $post);

    }

    public function edit($id){
        $post = $this->post->findOrFail($id);
        
        //check if post belongs to logged-in user
        if($post->user_id !=Auth::user()->id){
            return redirect()->route('home');
        }



        $all_categories = Category::all();

        //get array of checked categories
        $selected_categories = [];
        foreach($post->categoryPosts as $category_post){
            $selected_categories []= $category_post->category_id;
        }

        return view('user.post.edit')->with('post',$post)
                                    ->with('all_categories', $all_categories)
                                    ->with('selected_categories',$selected_categories);
    }
    public function update(Request $request, $id){
        $request->validate([
            'categories' => 'required|array|between:1,3',
            'description' => 'required|max:1000',
            'image' => 'max:1048|mimes:jpeg,jpg,png,gif'
        ]);
    
        //find the row we want to update
        $post=$this->post->findOrFail($id);

        //update the columns from form data
        $post->description = $request->description;
        if($request->image){  // check if form has new image
            $post->image = "data:image/".$request->image->extension().";base64,".base64_encode(file_get_contents
            ($request->image));
        }
        //save changes
        $post->save();

        //updating categories
        $post->categoryPosts()->delete();

        $category_posts = [];
        foreach($request->categories as $category_id){
            $category_posts []= ['category_id' => $category_id];
        }
        // $category_posts = [
        //     ['category_id' => 1],
        //     ['category_id' => 2
        // ];
        $post->categoryPosts()->createMany($category_posts);

        return redirect()-> route('post.show', $id);

    }

    public function destroy($id){
        // $this->
        $this->post->findOrFail($id)->forceDelete(); //real delete when you have soft delete

        return redirect()->route('home');
    }
}

