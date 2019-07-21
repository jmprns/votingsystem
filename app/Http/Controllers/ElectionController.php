<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Election;
use App\Voter;
use App\Position;
use App\Candidate;
use App\Vote;
use App\Log;

class ElectionController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }
    /**
    *
	* Election Index
	* Handles the list of elections
	* URL : /election/
	*
	*/
	public function index()
	{
        // $count['voters'] = 
		$elections = Election::all();

		return view('election.index')->with('elections', $elections);
	}

	/**
    *
	* Election Add
	* Handles adding of elections
	* URL : /election/add
	*
	*/
	public function create(Request $request)
	{
		//Requiring all fields
        $request->validate([
            'electionName' => 'required',
            'startDate' => 'required',
            'startTime' => 'required',
            'endDate' => 'required',
            'endTime' => 'required'
        ]);


        // Parsing input time to Carbon Object
        $start = Carbon::parse($request->startDate." ".$request->startTime.":00");
        $end = Carbon::parse($request->endDate." ".$request->endTime.":00");

        // Checking if time is correct
        if($start > $end){

        	return response()->json([
        		'message' => "Invalid time range."
        	], 406);

        }


        // Insert the information into database
        Election::create([
        	'name' => $request->electionName,
        	'start' => $start,
        	'end' => $end
        ]);

        return response()->json([
        	'message' => "{$request->electionName} has been added."
        ]);


	}

    /**
    *
    * Election Precinct Show
    * Handle showing of specifi election
    * URL : /election/show/{id}
    *
    */
    public function show($id)
    {
        $election = Election::find($id);

        // Validating if election is exist
        if(!$election){
            return abort(404);
        }

        $positions = Position::with('candidates')->where('elc_id', $id)->get();

        $voters = Voter::with('course', 'year')->where('elc_id', $id)->get();

        $candidates = Candidate::with('info', 'position', 'party')->where('elc_id', $id)->get();

        return view('election.show')
                ->with('election', $election)
                ->with('positions', $positions)
                ->with('candidates', $candidates)
                ->with('voters', $voters);
    }

    public function edit(Request $request)
    {
        //Requiring all fields
        $request->validate([
            'electionName' => 'required',
            'startDate' => 'required',
            'startTime' => 'required',
            'endDate' => 'required',
            'endTime' => 'required'
        ]);


        // Parsing input time to Carbon Object
        $start = Carbon::parse($request->startDate." ".$request->startTime);
        $end = Carbon::parse($request->endDate." ".$request->endTime);

        // Checking if time is correct
        if($start > $end){

            return response()->json([
                'message' => "Invalid time range."
            ], 406);

        }

        $election = Election::find($request->electionId);
        $election->name = $request->electionName;
        $election->start = $start;
        $election->end = $end;
        $election->save();

        return response()->json([
            'message' => 'Election has been updated.'
        ],200);
    }

    /**
    *
    * Election Delete
    * Handle deleteting of specifi election
    * URL : /election/delete/{id}
    *
    */
    public function delete(Request $request, $id)
    {
        // Deleting all positions
        Position::where('elc_id', $id)->delete();

        $candidates = Candidate::where('elc_id', $id)->get();
        foreach($candidates as $candidate){
            // Deleting all votes
            Vote::where('candidate_id', $candidate->id)->delete();
        }
        // Deleting the candidate
        Candidate::where('elc_id', $id)->delete();

        $voters = Voter::where('elc_id', $id)->get();
        foreach($voters as $voter){
            Log::where('user_lvl', 1)->where('user_id', $voter->id)->delete();
        }
        Voter::where('elc_id', $id)->delete();

        Election::find($id)->delete();

        return response()->json([
            'message' => 'Election has been deleted.'
        ],200);



    }

}
