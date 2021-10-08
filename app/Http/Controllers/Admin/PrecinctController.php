<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Position;
use App\Election;

use DB;

class PrecinctController extends Controller
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
    public function index($id)
    {
        $voterData = DB::table('users')
            ->select('*', DB::raw('users.id as user_id '))
            ->where('elc_id', '=', $id)
            ->join('elections', 'users.elc_id', '=', 'elections.id')
            ->join('year', 'users.year_id', '=', 'year.id')
            ->join('department', 'year.dept_id', '=', 'department.id')
            ->get();

        $candidates = DB::table('candidates')
            ->select('*', DB::raw('candidates.id as cand_id '))
            ->where('elc_id', '=', $id)
            ->join('elections', 'elections.id', '=', 'candidates.cand_elc_id')
            ->join('partylist', 'partylist.id', '=', 'candidates.party_id')
            ->join('positions', 'positions.id', '=', 'candidates.pos_id')
            ->join('year', 'candidates.year_id', '=', 'year.id')
            ->join('department', 'year.dept_id', '=', 'department.id')
            ->get();

        $election = Election::find($id);

        if(!$election){
            return abort(404);
        }

        $position = DB::table('positions')
                    ->select(DB::raw("*, (SELECT count(*) FROM candidates WHERE positions.id = candidates.pos_id) cand_count"))
                    ->where('elc_id', '=', $id)
                    ->get();

        return view('admin.precinct.index')
                ->with('election', $election)
                ->with('voters', $voterData)
                ->with('candidates', $candidates)
                ->with('position', $position);
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
        //
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
