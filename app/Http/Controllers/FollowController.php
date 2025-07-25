<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Follow;

class FollowController extends Controller
{
    private $follow;
    public function __construct(Follow $follow){
        $this->follow = $follow;
    }

    public function store($user_id){
        $this->follow->follower_id = Auth::user()->id; // who clicked the "follow" button
        $this->follow->following_id = $user_id;  // who is target of follow
        $this->follow->save();

        return redirect()->back();
    }

    public function destroy($user_id){
        $this->follow->where('follower_id', Auth::user()->id)
                    ->where('following_id', $user_id)
                    ->delete();

        return redirect()->back();

    }
}
