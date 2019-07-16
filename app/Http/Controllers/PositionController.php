<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Election;
use App\Position;
use App\Candidate;
use App\Voter;

class PositionController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {

        $election = Election::find($id);

        // Validating if election is exist
        if(!$election){
            return abort(404);
        }


        return view('position.create')
                ->with('election', $election);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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

        // validating type
        if($request->type > 3){
            return response()->json([
                'message' => 'Invalid Position Type.'
            ], 406);
        }

        Position::create([
            'name' => $request->name,
            'type' => $request->type,
            'max' => $request->choice,
            'elc_id' => $request->election
        ]);

        return response()->json([
            'message' => 'Position has been added.'
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
        $position = Position::find($id);

        if(!$position){
            return abort(404);
        }

        $election = Election::find($position->elc_id);

        return view('position.edit')
                ->with('election', $election)
                ->with('position', $position);

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
        $position = Position::find($id);

        if(!$position){
                return abort(404);
        }

        $position->name = $request->name;
        $position->type = $request->type;
        $position->max = $request->max;

        $position->save();

        return response()->json([
            'message' => 'Position has been updated.'
        ], 200);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $position = Position::find($id);

        $elc_id = $position->elc_id;

        $position->delete();

        $candidates = Candidate::where('position_id', $id)->get();

        foreach($candidates as $candidate){

            $voter = Voter::find($candidate->voter_id);
            $voter->isCandidate = 0;
            $voter->save();

            Candidate::find($candidate->id)->delete();

        }

        return redirect("/election/show/{$elc_id}")->with('success', 'Position has been deleted.');

    }
}
