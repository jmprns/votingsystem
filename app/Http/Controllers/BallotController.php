<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Voter;
use App\Position;
use App\Candidate;
use App\Vote;
use App\Election;

use App\Log;

use Carbon\Carbon;

class BallotController extends Controller
{
	public function login()
	{
		return view('ballot.login');
	}
	
    public function form(Request $request)
    {
    	// check the credentials
    	$voter = Voter::where('id', $request->username)->where('password', $request->password)->get()->first();
    	if(!$voter){
    		return redirect()->back()->with('error', 'Invalid account.');
        }
        
        Log::create([
            'user_id' => $voter->id,
            'description' => 'Login in ballot',
            'user_lvl' => 1
        ]);

        // check if the election is open
        $election = Election::find($voter->elc_id);
        $start = Carbon::parse($election->start);
        $end = Carbon::parse($election->end);
        if($start > Carbon::now()){
            return redirect('/ballot/handler')->with('type', 3);
        }

        if($end < Carbon::now()){
            return redirect('/ballot/handler')->with('type', 4);
        }

        // check if voter already cast vote
        if($voter->cast == 1){
            return redirect('/ballot/handler')->with('type', 2);
        }





    	$positions = Position::with('candidates.info', 'candidates.party')->where('elc_id', $voter->elc_id)->get();

    	return view('ballot.form')
    			->with('voter', $voter)
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
            $cdd = Candidate::with('position', 'info')->find($cand_id);
            $cname = explode('__', $cdd->info->name);
            $datas[] = $cdd->position->name." - ".$cname[1]." ".$cname[0];
        }

        return response()->json($datas);
    }

    public function cast(Request $request, $vid)
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
           
            Vote::create([
                'voter_id' => $vid,
                'candidate_id' => $cand_id
            ]);
        }

        // Changing voter status
        $voter = Voter::find($vid);
        $voter->cast = 1;
        $voter->save();

        // Loging the actions
        Log::create([
            'user_id' => $voter->id,
            'description' => 'Cast vote.',
            'user_lvl' => 1
        ]);

        // redirect to cast page
        return redirect('/ballot/handler')->with('type', 1);
    }

    public function handler()
    {
        return view('ballot.handler');
    }

}
