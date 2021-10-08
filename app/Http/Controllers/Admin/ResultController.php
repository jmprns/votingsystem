<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Election;
use App\Position;
use App\Candidate;
use App\Department;
use App\Year;
use App\User;

use DB;
use Auth;
class ResultController extends Controller
{

      public function __construct()
      {
        $this->middleware('auth:admin');
      }

      public function index($id)
      {

            $election = Election::where('id', $id)->with('position')->get()->first();

            $elc = Election::find($id);

            $elc_info['position'] = $elc->position()->count();
            $elc_info['candidate'] = $elc->candidate()->count();
            $elc_info['voter'] = $elc->voter()->count();
            $elc_info['uncast'] = $elc->uncast()->count();
            $elc_info['cast'] = $elc->cast()->count();

            $positions = Position::where('elc_id', $id)->with('candidate.year.department', 'candidate.party')->get();

            return view('admin.result.index')
                        ->with('election', $election)
                        ->with('elc_info', $elc_info)
                        ->with('positions', $positions);



            
      }

      public function all($id)
      {
            $elc = Election::find($id);

            if(is_between(time(), $elc->start, $elc->end) == true){
                  return view('admin.misc.result')->with('elc', $elc);
            }

            $elc_info['position'] = $elc->position()->count();
            $elc_info['candidate'] = $elc->candidate()->count();
            $elc_info['voter'] = $elc->voter()->count();
            $elc_info['uncast'] = $elc->uncast()->count();
            $elc_info['cast'] = $elc->cast()->count();

            $positions = Position::where('elc_id', $id)->with('candidate.year.department', 'candidate.party')->get();
            $voters = User::with('year')->where('elc_id', $id)->get();

            // return $voters;

      	return view('admin.result.all')
                        ->with('positions', $positions)
                        ->with('voters', $voters)
                        ->with('elc', $elc)
                        ->with('elc_info', $elc_info);
      }

      public function win($id)
      {
      	$elc = Election::find($id);

            if(is_between(time(), $elc->start, $elc->end) == true){
                  return view('admin.misc.result')->with('elc', $elc);
            }

            $elc_info['position'] = $elc->position()->count();
            $elc_info['candidate'] = $elc->candidate()->count();
            $elc_info['voter'] = $elc->voter()->count();
            $elc_info['uncast'] = $elc->uncast()->count();
            $elc_info['cast'] = $elc->cast()->count();

            $positions = Position::where('elc_id', $id)->with('candidate.year.department', 'candidate.party')->get();
            $voters = User::with('year.department')->where('elc_id', $id)->get();


            return view('admin.result.win')
                        ->with('positions', $positions)
                        ->with('voters', $voters)
                        ->with('elc', $elc)
                        ->with('elc_info', $elc_info);
      } 

      public function send(Request $request)
      {
            $id = $request->id;
            $elc = Election::find($id);

            if(isAlive('127.0.0.1', 9501) !== true){
                    return response()->json([
                        'message' => 'Ozeki Gateway is offline. Please check your connection.'
                    ], 406);
            }

            if(!$elc){
                  return response()->json([
                        'message' => 'Election not found.'
                  ], 406);
            }

            if(Auth::user()->lvl == 1){
                  return response()->json([
                        'message' => 'You are not eligible to announce the result.'
                  ], 406);
            }

            if(time() < $elc->end){
                  return response()->json([
                        'message' => 'Election still open.'
                  ], 406);
            }


            $positions = Position::where('elc_id', $id)->with('candidate.year.department', 'candidate.party')->get();
            
            $voters = User::with('year.department')->where('elc_id', $id)->get();


            $winners = array();

            foreach($positions as $position){

                  // ALL SELECT
                  if($position->type == 1){

                        if($position->max > 1){
                              foreach($position->candidate->take($position->max) as $candidate){
                                    $winners[] = "{$position->position_name}: {$candidate->lname}, {$candidate->fname} {$candidate->mname}.";
                              }
                        }
                        else{
                              foreach($position->candidate->take(1) as $candidate){
                                   $winners[] = "{$position->position_name}: {$candidate->lname}, {$candidate->fname} {$candidate->mname}."; 
                              }
                        }
                  } //END ALL SELECT


                  // DEPARTMENT SELECT
                  elseif($position->type == 2){

                        $department_array = array();

                        foreach($position->candidate as $candidate){
                              if(!in_array($candidate->year->dept_id, $department_array)){
                                    $department_array[] = $candidate->year->dept_id;
                              }
                        }

                        if($position->max > 1){

                              foreach($department_array as $dept_id){

                                    foreach($position->candidate->where('year.dept_id', $dept_id)->take($position->max) as $candidate){
                                          if($candidate->year->dept_id == $dept_id){
                                                $winners[] = "{$position->position_name} ({$candidate->year->department->dept_name}): {$candidate->lname}, {$candidate->fname} {$candidate->mname}."; 
                                          }
                                    }

                              }

                        }else{

                              foreach($department_array as $dept_id){

                                    foreach($position->candidate->where('year.dept_id', $dept_id)->take(1) as $candidate){
                                          if($candidate->year->dept_id == $dept_id){
                                                $winners[] = "{$position->position_name} ({$candidate->year->department->dept_name}): {$candidate->lname}, {$candidate->fname} {$candidate->mname}.";
                                          }
                                    }

                              }
                        }

                  } //END DEPARTMENT SELECT

                  // YEAR SELECT
                  elseif($position->type == 3){

                        $year_array = array();

                        foreach($position->candidate as $candidate){
                              if(!in_array($candidate->year_id, $year_array)){
                                    $year_array[] = $candidate->year_id;
                              }
                        }

                        if($position->max > 1){

                              foreach($year_array as $year_id){

                                    foreach($position->candidate->where('year_id', $year_id)->sortBy('year_id')->take($position->max) as $candidate){
                                          if($candidate->year_id == $year_id){
                                                $winners[] = "{$position->position_name} ({$candidate->year->department->dept_name} - {$candidate->year->year_name}): {$candidate->lname}, {$candidate->fname} {$candidate->mname}."; 
                                          }
                                    }

                              }

                        }else{

                              foreach($year_array as $year_id){

                                    foreach($position->candidate->where('year_id', $year_id)->sortBy('year_id')->take($position->max) as $candidate){
                                          if($candidate->year_id == $year_id){
                                                $winners[] = "{$position->position_name} ({$candidate->year->department->dept_name} - {$candidate->year->year_name}): {$candidate->lname}, {$candidate->fname} {$candidate->mname}."; 
                                          }
                                    }

                              }
                        }

                  } //END YEAR SELECT

                  else{
                        continue;
                  }
            }



           foreach($voters as $voter){

                  $win = implode($winners, "\n\n");
                  $message = "The election result for {$elc->elc_name} is out! This is the following winners:\n\n{$win}\n\nCongratulations for the winner. Thank you for your participation.";

                  //Sending SMS DIRECTLY
                  if(substr($voter->number, 0, 2) == '09' && strlen($voter->number) == 11){
                        $send = send_sms($voter->number, $message);
                  }
           
           }

           return response()->json([
                        'message' => 'Election result has been published.'
                  ], 200);



      }
}
