<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    private $user;
    public function __construct(User $user){
        $this->user = $user;
    }

    public function index(Request $request){

        if($request->search){
            $all_users = $this->user->orderBy('name')->withTrashed()
                                    ->where('name', 'LIKE', '%'.$request->search.'%')
                                    ->paginate(10);              

        }else{
        //get all users, order by user name
        $all_users = $this->user->orderBy('name')->withTrashed()->paginate(10); //get()
        //paginate(n) -- show page with n items
        //withTrashed() -- includes soft-deleted records when you get data
        }
        return view('admin.users.index')->with('all_users', $all_users)
                                        ->with('search', $request->search);
    }

    public function deactivate($id){
        $this->user->destroy($id);
        return redirect()->back(); //go to previous page (even using pagination)
    }

    public function activate($id){
        // restore()
        $this->user->onlyTrashed()->findOrFail($id)->restore();
        //onlyTrashed() -- will only get soft-deleted records
        return redirect()->back();
    }

    public function suggested(){
         $suggestedUsers = User::orderBy('followers_count', 'desc')->limit(10)->get();
         return view('users.suggested', compact('suggestedUsers'));
    }

}

