<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    private $user;
    public function __construct(User $user){
        $this->user = $user;
    }

    public function show($id){
        $user = $this->user->findOrFail($id);

        return view('user.profile.show')->with('user', $user);
    }

    public function edit(){
        return view('user.profile.edit');
        
    }

    public function update(Request $request){
        $request->validate([
            'avatar' => 'max:1048|mimes:jpeg,jpg,png,gif' ,
            'name' => 'required|max:50',
            'email' => 'required|max:50|email|unique:users,email,'.Auth::user()->id,
            // adding/creating -- unique:<table>,<column> -- unique:users,email
            // updating: unique:<table>,<column>,<id>   -- unique:users,email,1
            'introduction' => 'max:100'
        ]);

        $user = $this->user->findOrFail(Auth::user()->id);

        if($request->avatar){
            $user->avatar = "data:image/".$request->avatar->extension().";base64,".base64_encode
            (file_get_contents($request->avatar));
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->introduction = $request->introduction;

        $user->save();

        return redirect()->route('profile.show', Auth::user()->id);
    }

    public function followers($id){
        $user =$this->user->findOrFail($id);

        return view('user.profile.followers')->with('user', $user);

    }

    public function following($id){
        $user =$this->user->findOrFail($id);

        return view('user.profile.following')->with('user', $user);
    }

    public function updatePassword(Request $request){
        //check current password
        $user = $this->user->findOrFail(Auth::user()->id);
        if(! Hash::check($request->old_password, $user->password)){
            //go back, display validation error
            return redirect()->back()->with('wrong_current_password', 'Current password is incorrect. Please try again.
            ');
        }

        //new password cannot be same as current password
        if($request->old_password == $request->new_password){
            return redirect()->back()->with('same_current_password', 'New password cannpt be the same as current password. Please try again.');
        }

        //new password confirmation| min 8 characters
        $request->validate([
            'new_password' => 'required|min:8|alpha_num|confirmed'
            //confirmed -- when using this, have 2 inputs named: "x" and "x_confirmation"     
        ]);

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('change_password_success', 'Successfully changed password!');
    }
}
