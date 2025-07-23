<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Post $post, User $user)
    {
        $this->post = $post;
        $this->user = $user;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if($request->search){
            // if we have search, show search result data
            $home_posts = $this->post->latest()->where('description', 'LIKE', '%'.$request->search.'%')->get();
            //SELECT * FROM posts WHERE desctiption LIKE '%searchword%'


        }else{
           
        //get all posts, order bt newest/latest
        $all_posts = $this->post->latest()->get();

        //filter only posts by logged-in user OR followed user
        $home_posts = [];
        foreach($all_posts as $post){
            if($post->user_id == Auth::user()->id || $post->user->isFollowed())
                $home_posts []= $post;
        }
    }

        return view('user.home')->with('all_posts', $home_posts)
                                ->with('suggested_users', $this->getSuggestedUsers())
                                //$suggested_users = $this->getSuggestedUsers()
                                ->with('search', $request->search);
    }

    private function getSuggestedUsers(){
        $all_users = $this->user->all()->except(Auth::user()->id);
        //except(primary key ID) - removes the exception from the list

        $suggested_users = [];
        $count = 0;
        foreach($all_users as $user){
            if(!$user->isFollowed() && $count < 10){
                $suggested_users []= $user;
                $count++;
            }
        }

        return $suggested_users;
    }

public function suggestedUsers(){
    $all_users = $this->user->all()->except(Auth::user()->id);

    $suggested_users = [];

    foreach($all_users as $user){
        if(!$user->isFollowed() ){
            $suggested_users []= $user;
   
        }    
    }

    return view('user.suggested-users')->with('suggested_users', $suggested_users);
}

}
