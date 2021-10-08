<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Models
use App\Election;
use App\Position;
use App\Partylist;
use App\Candidate;
use App\Sms;
use App\Activity;
use App\User;
 
// Facades
use DB;
use Storage;
use Auth;
use File;
use Faker;

class CandidateController extends Controller
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
    public function create($id, $vid)
    {

        if(!$id && !$vid){
            return abort(404);
        }

        $cx = User::find($vid);

        if(!$cx){return abort(404);}

        if($cx->isCandidate == 1){return abort(500);}


        $position = Position::where('elc_id', $id)->get();
        $deptyear = DB::table('department')
                    ->join('year', 'department.id', '=', 'year.dept_id')
                    ->get();
        $partylist = Partylist::all();
        $election = Election::find($id);
        $voter = User::where('id', $vid)->where('elc_id', $id)->get()->first();

        if(!$election && !$voter){
            return abort(404);
        }

        return view('admin.candidate.add')
                    ->with('election', $election)
                    ->with('voter', $voter)
                    ->with('position', $position)
                    ->with('deptyear', $deptyear)
                    ->with('partylist', $partylist);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        $voter = User::find($request->id);

        if($voter->isCandidate == 1)
        {
            return response()->json([
                'message' => 'Voter is already candidate.'
            ], 406);
        }


        // Validating inputs
        $request->validate([
            'party' => 'required',
            'elc' => 'required',
            'pos' => 'required'
        ]);

        // Validating the party
        if(preg_match('/[A-Za-z]/', $request->party)){
            return response()->json([
                'message' => 'Invalid Party.'
            ], 406);
        }

        // Validating Election
        if(preg_match('/[A-Za-z]/', $request->elc)){
            return response()->json([
                'message' => 'Invalid Election.'
            ], 406);
        }

        // Validating Position
        if(preg_match('/[A-Za-z]/', $request->pos)){
            return response()->json([
                'message' => 'Invalid Position.'
            ], 406);
        }

        // Validating image
        if($request->image == "data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/2wBDAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/wAARCADIAMgDAREAAhEBAxEB/8QAFQABAQAAAAAAAAAAAAAAAAAAAAv/xAAUEAEAAAAAAAAAAAAAAAAAAAAA/8QAFAEBAAAAAAAAAAAAAAAAAAAAAP/EABQRAQAAAAAAAAAAAAAAAAAAAAD/2gAMAwEAAhEDEQA/AJ/4AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP//Z"){
            return response()->json([
                'message' => 'Invalid image file.'
            ], 406);
        }

        if($request->image == ""){

            $imageName = '00.png';

           
        }else{

            //Image Decoding
            $image = $request->image;
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = unique_string().".jpg";
            $destination = public_path()."/media/candidates/".$imageName;
            $actualImage = base64_decode($image);
            $move = file_put_contents($destination, $actualImage);

        }

        // Creating a candidate
         Candidate::create([
                "fname" => $voter->fname,
                "lname" => $voter->lname,
                "mname" => $voter->mname,
                "party_id" => $request->party,
                "year_id" => $voter->year_id,
                "pos_id" => $request->pos,
                "cand_elc_id" => $request->elc,
                "number" => $voter->number,
                "voter_id" => $voter->id,
                "image" => $imageName
        ]);

         // Updating the voter stat
         $voter->isCandidate = 1;
         $voter->save();


        $position = Position::find($request->pos);
        $elc = Election::find($request->elc);

        $message = "Congratulation {$request->fname}! You have been nominated as {$position->position_name} in upcomming {$elc->elc_name}.";


        //Sending SMS DIRECTLY
        if(substr($request->num, 0, 2) == '09' && strlen($request->num) == 11){
            $send = send_sms($request->num, $message);
        }

        
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
        $candidate = Candidate::find($id);

        if(!$candidate){
            return abort(404);
        }


        $election = Election::find($candidate->cand_elc_id);

        $position = Position::where('elc_id', $candidate->cand_elc_id)->get();
        $deptyear = DB::table('department')
                    ->join('year', 'department.id', '=', 'year.dept_id')
                    ->get();
        $partylist = Partylist::all();


        return view('admin.candidate.edit')
                    ->with('partylist', $partylist)
                    ->with('deptyear', $deptyear)
                    ->with('position', $position)
                    ->with('candidate', $candidate)
                    ->with('election', $election);
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

        // Validating inputs
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'party' => 'required',
            'year' => 'required',
            'elc' => 'required',
            'pos' => 'required',
            'num' => 'required'
        ]);

        // Validating the party
        if(preg_match('/[A-Za-z]/', $request->party)){
            return response()->json([
                'message' => 'Invalid Party.'
            ], 406);
        }

        // Validating Election
        if(preg_match('/[A-Za-z]/', $request->elc)){
            return response()->json([
                'message' => 'Invalid Election.'
            ], 406);
        }

        // Validating Year Level
        if(preg_match('/[A-Za-z]/', $request->year)){
            return response()->json([
                'message' => 'Invalid Department and Year Level.'
            ], 406);
        }

        // Validating Position
        if(preg_match('/[A-Za-z]/', $request->pos)){
            return response()->json([
                'message' => 'Invalid Position.'
            ], 406);
        }

        // Validating Number
        if(preg_match('/[A-Za-z]/', $request->num)){
            return response()->json([
                'message' => 'Invalid Number.'
            ], 406);
        }


        if($request->image !== NULL){

            // Validating image
            if($request->image == "data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/2wBDAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/wAARCADIAMgDAREAAhEBAxEB/8QAFQABAQAAAAAAAAAAAAAAAAAAAAv/xAAUEAEAAAAAAAAAAAAAAAAAAAAA/8QAFAEBAAAAAAAAAAAAAAAAAAAAAP/EABQRAQAAAAAAAAAAAAAAAAAAAAD/2gAMAwEAAhEDEQA/AJ/4AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP//Z"){
                return response()->json([
                    'message' => 'Invalid image file.'
                ], 406);
            }
            

            //Image Decoding
            $image = $request->image;
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = unique_string().".jpg";
            $destination = public_path()."/media/candidates/".$imageName;
            $actualImage = base64_decode($image);
            $move = file_put_contents($destination, $actualImage);

            $update = Candidate::find($request->id);


            if($update->image !== '00.png'){
                //Deleting the current image
                $image_path = public_path()."/media/candidates/".$update->image;
                File::delete($image_path);
            }

            $update->fname = $request->fname;
            $update->lname = $request->lname;
            $update->party_id = $request->party;
            $update->year_id = $request->year;
            $update->pos_id = $request->pos;
            $update->cand_elc_id = $request->elc;
            $update->number = $request->num;
            $update->image = $imageName;
            $update->save();

        }else{
            $update = Candidate::find($request->id);

            $update->fname = $request->fname;
            $update->lname = $request->lname;
            $update->party_id = $request->party;
            $update->year_id = $request->year;
            $update->pos_id = $request->pos;
            $update->cand_elc_id = $request->elc;
            $update->number = $request->num;
            $update->save();
        }

        $cx = Candidate::find($request->id);

        Activity::create([
            'action' => 'Update candidate.',
            'message' => "Update information of {$cx->fname} {$cx->lname}.",
            'author' => Auth::user()->fname." ".Auth::user()->lname
        ]);

        echo json_encode(array('status' => TRUE, 'response' => 200));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $cx = Candidate::find($request->id);

        Activity::create([
            'action' => 'Delete candidate.',
            'message' => "Delete {$cx->fname} {$cx->lname} as a candidate.",
            'author' => Auth::user()->fname." ".Auth::user()->lname
        ]);

        if($cx->image !== '00.png'){
            //Deleting the current image
            $image_path = public_path()."/media/candidates/".$cx->image;
            File::delete($image_path);
        }

        // Update voter
        $cv = User::find($cx->voter_id);
        $cv->isCandidate = 0;
        $cv->save();

        $cx->delete();
        echo json_encode(array('status' => TRUE, 'response' => 200));

    }
}
