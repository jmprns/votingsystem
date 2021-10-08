<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Facades
use DB;
use Hash;
use Auth;
use Faker;

// Models
use App\Election;
use App\User;
use App\SMS;
use App\Activity;
use App\Log;
use App\Year;


class VoterController extends Controller
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

        $years = Year::with('department')->get();
        $userData = DB::table('users')
            ->select('*', DB::raw('users.id as user_id '))
            ->join('elections', 'users.elc_id', '=', 'elections.id')
            ->join('year', 'users.year_id', '=', 'year.id')
            ->join('department', 'year.dept_id', '=', 'department.id')
            ->get();

        $elections = Election::all();

        return view('admin.voter.index')
                ->with('elections', $elections)
                ->with('userData', $userData)
                ->with('years', $years);
    }

    public function print()
    {
       $voters = User::with('year.department', 'elc')->get();

        return view('admin.voter.print')
                ->with('voters', $voters);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $deptyear = DB::table('department')
                    ->join('year', 'department.id', '=', 'year.dept_id')
                    ->get();

        $election = Election::all();


        return view('admin.voter.add')
                ->with('deptyear', $deptyear)
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
        $faker = Faker\Factory::create();

        // Validation required field
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'num' => 'required',
            'year' => 'required',
            'elc' => 'required'
        ]);
        


        // Validating the number
        if(preg_match('/[A-Za-z]/', $request->num)){
            return response()->json([
                'message' => 'Invalid number.'
            ], 406);
        }

        // Validating the election and department
        if(preg_match('/[A-Za-z]/', $request->elc)){
            return response()->json([
                'message' => 'Invalid Election.'
            ], 406);
        }

        if(preg_match('/[A-Za-z]/', $request->year)){
            return response()->json([
                'message' => 'Invalid Department and Year.'
            ], 406);
        }

        // Generating Password
        $password = voter_password();
        $passHash = Hash::make($password);

        $mname = $request->mname;

        $mid = ucfirst($mname[0]);

        // Saving the data
        $insert = User::create([
            'password' => $passHash,
            'alias' => $password,
            'fname' => $request->fname,
            'lname' => $request->lname,
            'mname' => $mid,
            'year_id' => $request->year,
            'elc_id' => $request->elc,
            'cast' => '0',
            'number' => $request->num
        ]);


        return response()->json([
            'message' => 'success'
        ], 200);
        



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
        $userInfo = User::find($id);

        $deptyear = DB::table('department')
                    ->join('year', 'department.id', '=', 'year.dept_id')
                    ->get();

        $election = Election::all();

        if(!$userInfo){
            return abort(404);
        }




        return view('admin.voter.edit')
                ->with('deptyear', $deptyear)
                ->with('userInfo', $userInfo)
                ->with('election', $election);
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

        // Validation required field
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'num' => 'required',
            'year' => 'required',
            'elc' => 'required',
            'pwd' => 'required'
        ]);


        // Validating the number
        if(preg_match('/[A-Za-z]/', $request->num)){
            return response()->json([
                'message' => 'Invalid number.'
            ], 406);
        }

        // Validating the election and department
        if(preg_match('/[A-Za-z]/', $request->elc)){
            return response()->json([
                'message' => 'Invalid Election.'
            ], 406);
        }

        if(preg_match('/[A-Za-z]/', $request->year)){
            return response()->json([
                'message' => 'Invalid Department and Year.'
            ], 406);
        }


        $hash = Hash::make($request->pwd);

        $update = User::find($id);

        Activity::create([
            'action' => 'Update voter.',
            'message' => "Update information of {$update->fname} {$update->lname}.",
            'author' => Auth::user()->fname." ".Auth::user()->lname
        ]);

        $update->fname = $request->fname;
        $update->lname = $request->lname;
        $update->mname = $request->mname;
        $update->password = $hash;
        $update->alias = $request->pwd;
        $update->year_id = $request->year;
        $update->elc_id = $request->elc;
        $update->number = $request->num;

        $update->save();



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
        $id = $request->id;
        $user = User::find($id);

        Activity::create([
            'action' => 'Delete voter.',
            'message' => "Delete information of {$user->fname} {$user->lname}.",
            'author' => Auth::user()->fname." ".Auth::user()->lname
        ]);

        $user->delete();

        $logd = Log::where('user_id', $id)->where('user_lvl', 1)->get();

        foreach($logd as $log){
            Log::find($log->id)->delete();
        }

        echo json_encode(array('status' => TRUE, 'response' => 200));
    }


    public function action(Request $request)
    {
        switch ($request->aid) {

            case '1':

            if(!$request->ids){
                return response()->json([
                        'message' => 'Select at least two voters!'
                    ], 406);
            }

            foreach($request->ids as $id){
                User::find($id)->delete();
            }

            return response()->json([
                        'message' => 'Voters has been deleted'
            ], 200);

            break;

            case '2':

                if(!$request->id){
                    return response()->json([
                            'message' => 'Select an election!'
                        ], 406);
                }

                if(isAlive('127.0.0.1', 9501) !== true){
                    return response()->json([
                        'message' => 'Ozeki Gateway is offline. Please check your connection.'
                    ], 406);
                }

                $voters = User::where('elc_id', $request->id)->get();

                $app_name = env('APP_NAME');

                foreach($voters as $voter){
                    $message = "Welcome to {$app_name}. Your credentials are: \n\n User I.D.: {$voter->id}\nPassword: {$voter->alias}";
                    
                    //Sending SMS DIRECTLY
                    if(substr($voter->number, 0, 2) == '09' && strlen($voter->number) == 11){
                        $send = send_sms($voter->number, $message);
                        
                  }
                }

               return response()->json([
                        'message' => 'Credentials has been sent.'
                    ], 200);

            break;

            case '3':

                if($request->year == ''){
                    return response()->json([
                            'message' => 'Select department!'
                        ], 406);
                }

                if($request->elc == ''){
                    return response()->json([
                            'message' => 'Select election!'
                        ], 406);
                }

                if(!$request->ids){
                    return response()->json([
                            'message' => 'Select at least two voters!'
                        ], 406);
                }

                foreach($request->ids as $id){

                    // Generating Password
                    $password = voter_password();
                    $passHash = Hash::make($password);

                    $voter = User::find($id);
                    $voter->password = $passHash;
                    $voter->alias = $password;
                    $voter->isCandidate = 0;
                    $voter->year_id = $request->year;
                    $voter->elc_id = $request->elc;
                    $voter->cast = 0;

                    $voter->save();

                }

                 return response()->json([
                        'message' => 'Credentials has been sent.'
                    ], 200);


            break;

            default:
                # code...
                break;
        }
    }
}
