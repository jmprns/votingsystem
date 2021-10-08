<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Log;

use Auth;

class LogController extends Controller
{

	
	public function __construct(Request $request)
	{
		if($request->lvl == 0){
			$this->middleware('auth:admin');
		}else{
			$this->middleware('auth');
		}
	}

    public function index(Request $request)
    {
    	if(!isset($request->action) || !isset($request->lvl)){
    		return abort(404);
    	}

    	if($request->action == 'in'){
    		
    		Log::create([
    			"user_id" => Auth::user()->id,
    			"user_lvl" => $request->lvl,
    			"action" => 0
    		]);

    		if($request->lvl == 0){
    			return redirect('admin/dashboard');
    		}else{
    			return redirect('/ballot');
    		}
    	}else{
    		Log::create([
    			"user_id" => Auth::user()->id,
    			"user_lvl" => $request->lvl,
    			"action" => 1
    		]);

    		if($request->lvl == 0){
    			return redirect('admin/logout');
    		}else{
    			return redirect('/ballot/logout');
    		}
    	}

    	
    }
}
