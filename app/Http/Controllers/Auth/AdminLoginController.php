<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;


class AdminLoginController extends Controller
{

	public function __construct()
	{
		$this->middleware('guest:admin')->except('logout', 'adminLogout');
	}

    public function showLoginForm()
    {
    	return view('auth.admin-login');
    }

    public function login(Request $request)
    {
    	
    	//Attemp to login

    	$username = $request->user;
    	$pass = $request->pass;
    	
    	if(
            Auth::guard('admin')
                ->attempt([
                    'username' => $username, 
                    'password' => $pass
                ], $request->remember)){

    		return redirect('/logging?action=in&lvl=0');
        }else{
            return redirect('/admin/login')->with("message", "error");
        }



    }

    public function adminLogout()
    {
        
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }


}
