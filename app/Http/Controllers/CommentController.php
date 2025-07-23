<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;

class CommentController extends Controller
{
    private $comment;
    public function __construct(Comment $comment){
        $this->comment = $comment;
    }

    public function store(Request $request, $post_id){
        $request->validate([
            'comment_body'.$post_id => 'required|max:100'
        ],[
            "comment_body$post_id.required" => 'A comment is required.',
            "comment_body$post_id.max" => 'Maximum of 100 characters only.'
        ]);

        $this->comment->body = $request->input('comment_body'.$post_id);
        $this->comment->user_id = Auth::user()->id;
        $this->comment->post_id = $post_id;
        $this->comment->save();

        //go back to previous page
        return redirect()->back();
    }


    public function destroy($id){
        $this->comment->destroy($id);

        return redirect()->back();

}

}
