<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Election;
use App\Position;
use App\Candidate;
use App\Year;
use App\User;
use App\Vote;

use DB;

class BallotController extends Controller
{


	public function __construct()
	{
		$this->middleware('auth');

	}


    public function index()
    {


        // Verification proccess

        // Checking cast status
        if(Auth::user()->cast == 1){
            return view('ballot.cast');
        }

        // Election Verification
        $election = Election::find(Auth::user()->elc_id);
        if($election == null || $election->count() == 0){return view('ballot.404');}
        $start = $election['start'];
        $end = $election['end'];
        if($start >= time() || $end <= time()){return view('ballot.close');}

        $cand_count = Candidate::where('cand_elc_id', Auth::user()->elc_id)->count();

        if($cand_count == 0){return view('ballot.null');}

        $positions = Position::where('elc_id', Auth::user()->elc_id)->with('candidate.year.department', 'candidate.party')->get();

        $userInfo = User::where('id', Auth::user()->id)->with('year.department')->first();

    	return view('ballot.ballot')
                ->with('election', $election)
                ->with('userInfo', $userInfo)
                ->with('positions', $positions);

    }

    public function review(Request $request)
    {
        // Fetching all request and convert them into array
        $a = $request->all();

        // Counter for skipping the _token
        $counter = 0;

        // Candidates ID array
        $candidate_array = array();

        // Iterate all the request
        foreach($a as $b){

            //Skipping the token
            if($counter++ == 0) continue;

            //Skipping NULL request
            if($b == NULL) continue;

            //Getting the value of multiple array
            if(is_array($b) == true){

                //Iterate each value of array
                foreach($b as $c){
                    // Pushing data to array
                    $candidate_array[] = $c;
                }

            }

            // None array request
            else{
                // Pushing data to array
                $candidate_array[] = $b;
            }

        }//end-foreach

        $datas = array();

        foreach($candidate_array as $cand_id){
            $cdd = Candidate::with('position')->find($cand_id);
            $datas[] = $cdd->position->position_name." - ".$cdd->fname." ".$cdd->lname;
        }

        return response()->json($datas);

    }

    public function cast(Request $request)
    {
    	// Fetching all request and convert them into array
    	$a = $request->all();

    	// Counter for skipping the _token
    	$counter = 0;

    	// Candidates ID array
    	$candidate_array = array();

    	// Iterate all the request
    	foreach($a as $b){

    		//Skipping the token
    		if($counter++ == 0) continue;

    		//Skipping NULL request
    		if($b == NULL) continue;

    		//Getting the value of multiple array
    		if(is_array($b) == true){

    			//Iterate each value of array
    			foreach($b as $c){
    				// Pushing data to array
    				$candidate_array[] = $c;
    			}

    		}

    		// None array request
    		else{
    			// Pushing data to array
    			$candidate_array[] = $b;
    		}

    	}//end-foreach

    	// Inserting Votes
    	foreach($candidate_array as $cand_id){
    		$insert = Candidate::find($cand_id);
    		$insert->votes = $insert->votes+1;
    		$insert->save();

            //Inserting in the logs
            Vote::create([
                'user_id' => Auth::user()->id,
                'cand_id' => $cand_id,
                'timestamp' => time()
            ]);
    	}

		// Changing voter status
		$voter = User::find(Auth::user()->id);
		$voter->cast = 1;
		$voter->save();


        //sending message
        $message = "Your vote has been cast. Thank you for voting.";
        //Sending SMS DIRECTLY
        if(substr(Auth::user()->number, 0, 2) == '09' && strlen(Auth::user()->number) == 11){
            $send = send_sms(Auth::user()->number, $message);
        }

		// redirect to cast page
		return redirect('/ballot');
    }


}
