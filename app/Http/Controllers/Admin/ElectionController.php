<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Election;
use App\User;
use App\Position;
use App\Candidate;
use App\Activity;

 
//Facades
use DB;
use Auth;
use File;

class ElectionController extends Controller
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
        $data = Election::withCount('candidate', 'voter', 'uncast', 'cast')->get();
        return view('admin.election.index')->with('data', $data);

        // return $data;
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
            'name' => 'required',
            'startDate' => 'required',
            'startTime' => 'required',
            'endDate' => 'required',
            'endTime' => 'required'
        ]);

        //fetching the election form data
        $elc_name = $request->name;
        $startDate = $request->startDate;
        $startTime = $request->startTime;
        $endDate = $request->endDate;
        $endTime = $request->endTime;

        //Converting Start Date-time to Start Timestamp
        $s1 = $request->startDate."T".$request->startTime;
        $start = strtotime($s1);

        //Converting End Date-time to End Timestamp
        $e1 = $request->endDate."T".$request->endTime;
        $end = strtotime($e1);

        if($start > $end){
            return response()->json([
                'message' => 'Invalid date/time range'
            ], 406);
        }

        //Inserting to Database
        Election::create([
            "elc_name" => $elc_name,
            "start" => $start,
            "end" => $end
        ]);

        echo json_encode(array('status' => TRUE, 'response' => 200, 'message' => $s1.$e1));


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
            $election = Election::where('id', $id)->with('position')->withCount('uncast')->get()->first();

            $positions = Position::where('elc_id', $id)->where('type', 1)->with('candidate.year.department', 'candidate.party')->get();

            if($positions->count() == 0){
                return abort(300);
            }

            return view('admin.election.show')
                        ->with('election', $election)
                        ->with('positions', $positions);
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

        //Requiring all fields
        $request->validate([
            'name' => 'required',
            'startDate' => 'required',
            'startTime' => 'required',
            'endDate' => 'required',
            'endTime' => 'required'
        ]);

        //Converting Start Date-time to Start Timestamp
        $s1 = $request->startDate."T".$request->startTime;
        $start = strtotime($s1);

        //Converting End Date-time to End Timestamp
        $e1 = $request->endDate."T".$request->endTime;
        $end = strtotime($e1);

        if($start > $end){
            return response()->json([
                'message' => 'Invalid date/time range'
            ], 406);
        }

        $update = Election::find($request->id);
       
        Activity::create([
            'action' => 'Update election.',
            'message' => "Update information of {$update->elc_name}.",
            'author' => Auth::user()->fname." ".Auth::user()->lname
        ]);

        $update->elc_name = $request->name;
        $update->start = $start;
        $update->end = $end;
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
        $election = Election::find($id);
        $name = $election->elc_name;
        $election->delete();

        $voter = User::where('elc_id', '=', $id);
        $voter->delete();

        $candidatex = Candidate::where('cand_elc_id', '=', $id);
        $candidates = Candidate::where('cand_elc_id', '=', $id)->get();

        foreach($candidates as $candidate){
            if($candidate->image !== '00.png'){
                //Deleting the current image
                $image_path = public_path()."/media/candidates/".$candidate->image;
                File::delete($image_path);
            }
        }

        $candidatex->delete();

        $position = Position::where('elc_id', '=', $id);
        $position->delete();

        Activity::create([
            'action' => 'Delete election.',
            'message' => "Delete election {$name}.",
            'author' => Auth::user()->fname." ".Auth::user()->lname
        ]);

        return redirect('/admin/election')->with("message", "delete")->with("election_name", $name);
    }


    public function voter($id)
    {
        return redirect('/admin/voters/add')->with('elc_id', $id);
    }
}
