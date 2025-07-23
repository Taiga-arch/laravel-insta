<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;

class CategoryController extends Controller
{
    private $category;
    private $post;
    public function __construct(Category $category, Post $post){
        $this->category = $category;
        $this->post = $post;
    }

    public function index(){
        $all_categories = $this->category->orderBy('name')->paginate(10);

        //get count of posts without category
        $count = 0;
        $all_posts = $this->post->all();
        foreach($all_posts as $post){
            if($post->categoryPosts->count() == 0)
                $count++;
        }

        return view('admin.categories.index')->with('all_categories', $all_categories)
                                            ->with('uncategorized_count', $count);
                                            // $uncategorized_count = $count;
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|max:50|unique:categories,name'
        ]);

        $this->category->name = ucwords($request->name);
        $this->category->save();

        return redirect()->route('admin.categories');
    }

    public function destroy($id){
        $this->category->destroy($id);

        return redirect()->back();
    }

    public function update(Request $request, $id){
        $request->validate([
            'categ_name'.$id => 'required|max:50|unique:categories,name,'.$id
        ],[
            "categ_name$id.required" => "Name is required.",
            "categ_name$id.max"     => "Maximum of 50 characters only.",
            "categ_name$id.unique"  => "That name is already taken."
        ]);

        $categ = $this->category->findOrFail($id);
        $categ->name = ucwords($request->input('categ_name'.$id));
        $categ->save();

        return redirect()->back();
    }
}
