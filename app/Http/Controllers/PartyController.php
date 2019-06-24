<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Party;
use App\Candidate;

class PartyController extends Controller
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
        $parties = Party::all();
        return view('party.list')
                ->with('parties', $parties);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'name' => 'required'
        ]);

        // Checking if party is exist
        if(Party::where('name', $request->name)->get()->count() > 0){
            return response()->json([
                'message' => 'Partylist already registered.'
            ],406);
        }

        Party::create([
            'name' => $request->name
        ]);

        return response()->json([
            'message' => 'Partylist has been added.'
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
    public function update(Request $request)
    {
        $party = Party::find($request->pid);

        if(!$party){
            return response()->json([
                'message' => 'Invalid party.'
            ], 406);
        }

        $party->name = $request->pname;
        $party->save();

        return response()->json([
            'message' => 'Party has been updated.'
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
        // checking the party
        $party = Party::find($id);

        if($id == 1){
            return redirect()->back()->with('error', 'You cannot delete this party.');
        }

        // validating
        if(!$party){
            return redirect()->back()->with('error', 'Party not found in the system.');
        }

        $candidates = Candidate::where('party_id', $id)->get();

        foreach($candidates as $candidate){

            $cand = Candidate::find($candidate->id);
            $cand->party_id = 1;
            $cand->save();
        }

        Party::find($id)->delete();

        return redirect()->back()->with('success', 'Party has been deleted.');


    }
}
