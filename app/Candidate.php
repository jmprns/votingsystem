<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    protected $fillable = [
    	'voter_id',
    	'position_id',
    	'elc_id',
    	'party_id',
    	'image'
    ];

    public function info()
    {
    	return $this->belongsTo('App\Voter', 'voter_id');
    }

    public function position()
    {
    	return $this->belongsTo('App\Position', 'position_id');
    }

    public function election()
    {
    	return $this->belongsTo('App\Election', 'elc_id');
    }

    public function party()
    {
    	return $this->belongsTo('App\Party', 'party_id');
    }

    public function votes()
    {
        return $this->hasMany('App\Vote', 'candidate_id');
    }
}
