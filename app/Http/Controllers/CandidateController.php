<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Election;
use App\Candidate;
use App\Position;
use App\Voter;
use App\Party;

class CandidateController extends Controller
{
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
    public function create($eid, $vid)
    {
        $election = Election::find($eid);

        // Validating if election is exist
        if(!$election){
            return abort(404);
        }

        $voter = Voter::find($vid);
        if(!$voter){
            return abort(404);
        }

        $positions = Position::where('elc_id', $eid)->get();
        $parties = Party::all();

        return view('candidate.create')
                ->with('election', $election)
                ->with('voter', $voter)
                ->with('positions', $positions)
                ->with('parties', $parties);
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
            'position' => 'required',
            'party' => 'required'
        ]);

        // Validating Position
        $position = Position::find($request->position);
        if(!$position){
            return response()->json([
                'message' => 'Invalid position.'
            ],406);
        }

        // Validating Party
        $party = Party::find($request->party);
        if(!$party){
            return response()->json([
                'message' => 'Invalid party.'
            ],406);
        }

        // Validating voter
        $voter = Voter::find($request->voter);
        if(!$voter){
            return response()->json([
                'message' => 'Voter not found.'
            ],406);
        }
        if($voter->isCandidate != 0){
            return response()->json([
                'message' => 'Voter is already candidate.'
            ],406);
        }

        // Validating image
        if($request->image == "data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/2wBDAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/wAARCADIAMgDAREAAhEBAxEB/8QAFQABAQAAAAAAAAAAAAAAAAAAAAv/xAAUEAEAAAAAAAAAAAAAAAAAAAAA/8QAFAEBAAAAAAAAAAAAAAAAAAAAAP/EABQRAQAAAAAAAAAAAAAAAAAAAAD/2gAMAwEAAhEDEQA/AJ/4AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP//Z"){
            $imageName = 'default.jpg';
        }

        if($request->image == ""){

            $imageName = 'default.jpg';

           
        }else{

            //Image Decoding
            $image = $request->image;
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = time().str_random(10).".jpg";
            $destination = public_path()."/img/candidates/".$imageName;
            $actualImage = base64_decode($image);
            $move = file_put_contents($destination, $actualImage);

        }

        // Inserting into the database
        Candidate::create([
            'voter_id' => $voter->id,
            'position_id' => $position->id,
            'elc_id' => $voter->elc_id,
            'party_id' => $party->id,
            'image' => $imageName
        ]);

        // Updating voters info
        $voter->isCandidate = 1;
        $voter->save();

        // return 200 status
        return response()->json([
            'message' => 'Candidate has been added.'
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
