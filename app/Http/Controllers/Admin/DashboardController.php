<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Position;
use App\Election;
use App\Candidate;
use App\User;

use DB;

use Auth;


class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    public function index()
    {

        if(Auth::user()->lvl == 1 || Auth::user()->lvl == 0){

            $timeNow = time();

            $count = array();
            $count['elc'] = DB::table('elections')->count();
            $count['cand'] = DB::table('candidates')->count();
            $count['party'] = DB::table('partylist')->count();
            $count['users'] = DB::table('users')->count();


            $ongoing = Election::where('start', '<=', $timeNow)
                        ->where('end', '>=', $timeNow)
                        ->with('position')
                        ->withCount('position', 'candidate', 'voter', 'uncast', 'cast')
                        ->inRandomOrder()
                        ->get()
                        ->first();

            if($ongoing !== NULL){
                $ongoing_position = $ongoing->position->first();
                $ongoing_candidate = Candidate::where('pos_id', $ongoing_position['id'])->get();
                $positions = Position::where('elc_id', $ongoing->id)->with('candidate.year.department', 'candidate.party')->get();
            }else{
                $ongoing_position = NULL;
                $ongoing_candidate = NULL;
                $positions = NULL;
            }
            

        	

        	$recent = array();
        	$recent['candidate'] = Candidate::with('election')->orderBy('id', 'desc')->take(5)->get();
        	$recent['users'] = User::with('elc')->orderBy('id', 'desc')->take(5)->get();

            // return $positions;

        	return view('admin.dashboard')
        			->with('count', $count)
        			->with('recent', $recent)
                    ->with('ongoing', $ongoing)
                    ->with('ongoing_position', $ongoing_position)
                    ->with('positions', $positions)
                    ->with('ongoing_candidate', $ongoing_candidate);
        }else{
            $voters = User::with('year.department', 'elc')->get();
            return view('admin.misc.committee')->with('voters', $voters);
        }
    }

}
