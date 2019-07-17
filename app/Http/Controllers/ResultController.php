<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Election;
use App\Position;
use App\Voter;
use App\Candidate;

class ResultController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index($id)
    {
    	$election = Election::find($id);

        $count['candidates'] = Candidate::where('elc_id', $id)->get()->count();
        $count['voters'] = Voter::where('elc_id', $id)->get()->count();
        $count['uncast'] = Voter::where('elc_id', $id)->where('cast', 0)->get()->count();
        $count['cast'] = Voter::where('elc_id', $id)->where('cast', 1)->get()->count();

        if(!$election){
            return abort(404);
        }

    	$positions = Position::with(['candidates.info','candidates.info.course','candidates.info.year', 'candidates.party', 'candidates' => function($q){$q->withCount('votes');}])->where('elc_id', $id)->get();
    	


        return view('election.result')
                ->with('election', $election)
    			->with('count', $count)
    			->with('positions', $positions);
    }

    public function printAll($id)
    {
        $election = Election::find($id);
        $positions = Position::with(['candidates.info','candidates.info.course','candidates.info.year', 'candidates.party', 'candidates' => function($q){$q->withCount('votes');}])->where('elc_id', $id)->get();
        $voters = Voter::where('elc_id', $id)->get();
        return view('election.resultPrintAll')
                ->with('positions', $positions)
                ->with('voters', $voters)
                ->with('election', $election);
    }

    public function printWinner($id)
    {
        $election = Election::find($id);
        $positions = Position::with(['candidates.info','candidates.info.course','candidates.info.year', 'candidates.party', 'candidates' => function($q){$q->withCount('votes');}])->where('elc_id', $id)->get();
        $voters = Voter::where('elc_id', $id)->get();
        return view('election.resultPrintWinner')
                ->with('positions', $positions)
                ->with('voters', $voters)
                ->with('election', $election);
    }
}
   