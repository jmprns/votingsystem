<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Election extends Model
{
    protected $fillable = ['name', 'start', 'end'];

    public function voters()
    {
    	return $this->hasMany('App\Voter', 'elc_id');
    }

    public function candidates()
    {
    	return $this->hasMany('App\Candidate', 'elc_id');
    }
}
