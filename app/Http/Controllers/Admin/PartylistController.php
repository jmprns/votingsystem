<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Model
use App\Partylist;
use App\Candidate;

use DB;

class PartylistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $partyData = DB::table('partylist')
                    ->select(DB::raw("*, (SELECT count(*) FROM candidates WHERE candidates.party_id = partylist.id) party_count"))
                    ->get();
        return view('admin.partylist.index')
                ->with('partyData', $partyData);
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
        $request->validate([
            'name' => 'required'
        ]);

       $insert = Partylist::create([
            "party_name" => $request->name
        ]);

        echo json_encode(array('status' => TRUE, 'response' => 200, 'party_id' => $insert->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $party = Partylist::find($id);
        $member = DB::table('candidates')
            ->select('*', DB::raw('candidates.id as cand_id '))
            ->where('candidates.party_id', '=', $id)
            ->join('elections', 'elections.id', '=', 'candidates.cand_elc_id')
            ->join('partylist', 'partylist.id', '=', 'candidates.party_id')
            ->join('positions', 'positions.id', '=', 'candidates.pos_id')
            ->join('year', 'candidates.year_id', '=', 'year.id')
            ->join('department', 'year.dept_id', '=', 'department.id')
            ->get();
        return view('admin.partylist.member')->with('members', $member)->with('party', $party);
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
        $request->validate([
            'name' => 'required'
        ]);
        
        $update = Partylist::find($id);
        $update->party_name = $request->name;
        $update->save();

        echo json_encode(array('status' => TRUE, 'response' => 200));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $update = Candidate::where('party_id', $id)->get();
      
        foreach($update as $upd){
            $up = Candidate::find($upd->id);
            $up->party_id = 1;
            $up->save();
        }

        Partylist::find($id)->delete();
        echo json_encode(array('status' => TRUE, 'response' => 200));
    }
}
