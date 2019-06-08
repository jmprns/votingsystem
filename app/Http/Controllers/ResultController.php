<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index($id)
    {
    	return view('election.result');
    }
}
