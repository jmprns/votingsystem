<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Vote;
use App\Log;
use App\Activity;

use Auth;

class LogController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth:admin');

        
    }

    public function votes()
    {
        if(Auth::user()->lvl > 0){
            return abort('404');
        }
        
    	$votes = Vote::with('user', 'candidate')->get();

    	return view('admin.log.votes')->with('votes', $votes);
    }

    public function voter()
    {
        if(Auth::user()->lvl > 0){
            return abort('404');
        }

    	$voters = Log::with('user')->where('user_lvl', 1)->orderBy('created_at', 'desc')->get();

        return view('admin.log.voter')->with('voters', $voters);
    }

    public function admin()
    {
        if(Auth::user()->lvl > 0){
            return abort('404');
        }

        $admins = Log::with('admin')->where('user_lvl', 0)->orderBy('created_at', 'desc')->get();

    	return view('admin.log.admin')->with('admins', $admins);
    }

    public function activity()
    {

        if(Auth::user()->lvl > 0){
            return abort('404');
        }

        $activities = Activity::all();

        return view('admin.log.activity')->with('activities', $activities);
    }
}
