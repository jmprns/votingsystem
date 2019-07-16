<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Voter;
use App\Election;
use App\Year;
use App\Course;
use App\Candidate;
use App\Vote;

use Hash;

class VoterController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $election = Election::find($id);

        // checking if election exists
        if(!$election){
            return abort(404);
        }

        $years = Year::all();
        return view('voter.add')
                ->with('election', $election)
                ->with('years', $years);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Requiring all fields
        $request->validate([
            'lname' => 'required',
            'fname' => 'required',
            'cy' => 'required',
            'election' => 'required'
        ]);

        $cy = explode('__', $request->cy);

        // Election Validation
        if(preg_match('/[A-Za-z]/', $request->election)){
            return response()->json([
                'message' => 'Invalid Election.'
            ], 406);
        }
        if(!Election::find($request->election)){
            return response()->json([
                'message' => 'Invalid Election.'
            ], 406);
        }

        // Course Validation
        if(preg_match('/[A-Za-z]/', $cy[0])){
            return response()->json([
                'message' => 'Invalid Course.'
            ], 406);
        }
        if(!Course::find($cy[0])){
            return response()->json([
                'message' => 'Invalid Course.'
            ], 406);
        }

        // Year Validation
        if(preg_match('/[A-Za-z]/', $cy[1])){
            return response()->json([
                'message' => 'Invalid Year.'
            ], 406);
        }
        if(!Year::find($cy[1])){
            return response()->json([
                'message' => 'Invalid Year.'
            ], 406);
        }

        Voter::create([
            'name' => $request->lname."__".$request->fname."__".$request->mname,
            'password' => voter_password(),
            'course_id' => $cy[0],
            'year_id' => $cy[1],
            'elc_id' => $request->election
        ]);

        return response()->json([
            'message' => 'Voter has been registered.'
        ],200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $voter = Voter::find($id);

        if(!$voter){
            return abort(404);
        }

        $years = Year::all();

        $election = Election::find($voter->elc_id);

        return view('voter.edit')
                ->with('voter', $voter)
                ->with('election', $election)
                ->with('years', $years);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $voter = Voter::find($id);

        if(!$voter){
            return response()->json([
                'message' => 'Voter not found.'
            ],406);
        }

        $cy = explode('__', $request->cy);


        $voter->name = $request->lname."__".$request->fname."__".$request->mname;
        $voter->course_id = $cy[0];
        $voter->year_id = $cy[1];
        $voter->save();

        return response()->json([
            'message' => 'Voter has been updated.'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $voter = Voter::find($id);

        //Validating the voter
        if(!$voter){
            return redirect('/voters/')->with('error', 'The voter you want to delete was not found in the system.');
        }

        $election_id = $voter->elc_id;

        $voter->delete();
        Candidate::where('voter_id', $id)->delete();
        Vote::where('voter_id', $id)->delete();

        return redirect("/election/show/{$election_id}")->with('success', 'The voter has been deleted in the system.');

    }
}
