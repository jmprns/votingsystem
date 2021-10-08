<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    protected $fillable = ['fname', 'lname','mname', 'party_id', 'year_id', 'pos_id', 'cand_elc_id', 'votes', 'voter_id', 'number', 'image'];

    public function position()
    {
    	return $this->belongsTo('App\Position', 'pos_id');
    }

    public function party()
    {
    	return $this->belongsTo('App\Partylist', 'party_id');
    }

    public function year()
    {
    	return $this->belongsTo('App\Year', 'year_id');
    }

    public function election()
    {
        return $this->belongsTo('App\Election', 'cand_elc_id');
    }
}
