<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Hash;
use Auth;

use App\Log;
use App\Vote;

class SettingsController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index()
    {
        $users = User::all();

        $logs['users'] = Log::with('user')->where('user_lvl', 0)->get();
        $logs['voters'] = Log::with('voter')->where('user_lvl', 1)->get();

        $votes = Vote::with('candidate.election', 'voter')->get();

        return view('settings.index')
                ->with('logs', $logs)
                ->with('votes', $votes)
                ->with('users', $users);

        // echo Agent::browser();
    }

    public function add_admin(Request $request)
    {
        // validate the input information about the user
        $request->validate([
            'lname' => 'required',
            'fname' => 'required',
            'username' => 'required',
            'password' => 'required',
            'cpassword' => 'required'
        ]);

        // checking if password match
        if($request->password != $request->cpassword){
            return response()->json([
                'message' => 'Password mismatch.'
            ],406);
        }

        // checking if username is exists
        $checkUsername = User::where('username', $request->username)->get()->count();
        if($checkUsername != 0){
            return response()->json([
                'message' => 'Username already exists.'
            ],406);
        }

        $create = User::create([
            'name' => $request->lname."__".$request->fname."__".$request->mname,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'lvl' => 1
        ]);

        return response()->json([
            'message' => 'User has been registered.'
        ],200);
    }

    public function update_admin(Request $request)
    {
        $user = User::find(Auth::user()->id);

        if($request->type == 1){

            $user->name = $request->lname."__".$request->fname."__".$request->mname;
            $user->save();

            return response()->json([
                'message' => 'Profile has been updated.'
            ],200);


        }elseif($request->type == 2){

            // check if npass and cpass match
            if($request->npass != $request->cpass){
                return response()->json([
                    'message' => 'Password mismatch.'
                ],406);
            }

            // check if old pass match in database
            if(Hash::check($request->opass, Auth::user()->password) == false){
                return response()->json([
                    'message' => 'Wrong password.'
                ],406);
            }

            $user->password = Hash::make($request->npass);
            $user->save();

            return response()->json([
                'message' => 'Credentials has been updated.'
            ],200);

        }else{

        }

        return response()->json([
            'message' => 'Something went wrong.'
        ],406);


    }

    public function delete_admin($id)
    {

        if($id == 1){
            return redirect('/settings')->with('error', 'You cannot delete this admin.');
        }

        $user = User::find($id);

        if(!$user){
            return redirect('/settings')->with('error', 'User not found.');
        }

        $user->delete();

        return redirect('/settings')->with('success', 'User has been deleted.');
    }

}
