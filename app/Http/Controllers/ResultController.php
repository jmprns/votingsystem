<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Election;
use App\Position;

class ResultController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index($id)
    {
    	$election = Election::find($id);

        if(!$election){
            return abort(404);
        }

    	$positions = Position::with(['candidates.info','candidates.info.course','candidates.info.year', 'candidates.party', 'candidates' => function($q){$q->withCount('votes');}])->where('elc_id', $id)->get();
    	
        return view('election.result')
    			->with('election', $election)
    			->with('positions', $positions);
    }

    public function printAll($id)
    {
        return view('election.resultPrintAll');
    }

    public function printWinner($id)
    {
        return view('election.resultPrintWinner');
    }
}
   