<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Hash;

class BallotLoginController extends Controller
{

	public function __construct()
	{
		$this->middleware('guest:voter')->except('logout', 'ballotLogout');
	}

    public function login()
    {

    	return view('auth.ballot-login');
        // return Hash::make(123456);
    }

    public function auth(Request $request)
    {
    	
    	//Attemp to login

    	$id = $request->id;
        $newid = int().$id;
    	$pass = $request->pass;
    	
    	if(
           $a =  Auth::guard('voter')
                ->attempt([
                    'id' => $newid, 
                    'password' => $pass
                ])){
    		echo json_encode(array('status' => $new, 'response' => 200, 'result' => var_dump($a)));
    	}else{
            echo json_encode(array('status' => TRUE, 'response' => 100));
        }

    }

    public function ballotLogout()
    {
        Auth::guard('voter')->logout();
        return redirect('/ballot/login');
    }


}
