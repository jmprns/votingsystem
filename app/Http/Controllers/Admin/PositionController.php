<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Position;
use App\Election;
use App\Candidate;
use App\User;

class PositionController extends Controller
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
        if($election == NULL){
            return abort(404);
        }else{
            return view('admin.position.add')->with('elc', $election);
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Position::create([
            "position_name" => $request->name,
            "type" => $request->type,
            "max" => $request->max,
            "elc_id" => $request->elc
        ]);

        echo json_encode(array('status' => TRUE, 'response' => 200));
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

        if($position == NULL){
            return abort(404);
        }else{

            $election = Election::find($position->elc_id);
            return view('admin.position.edit')
                    ->with('elc', $election)
                    ->with('position', $position);

        }
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
        $update = Position::find($id);
        $update->position_name = $request->name;
        $update->type = $request->type;
        $update->max = $request->max;
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
        $delete = Position::find($id)->delete();

        $candidates = Candidate::where('pos_id', $id)->get();

        foreach($candidates as $candidate){
            $update = User::find($candidate->voter_id);
            if($update->elc_id == $candidate->cand_elc_id){
                $update->isCandidate = 0;
                $update->save();
            }
        }

        $candidate = Candidate::where('pos_id', $id)->delete();

        echo json_encode(array('status' => TRUE, 'response' => 200));
    }
}
