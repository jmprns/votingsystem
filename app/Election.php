<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Election extends Model
{
    protected $fillable = ['elc_name', 'start', 'end'];


    public function position()
    {
    	return $this->hasMany('App\Position', 'elc_id');
    }

    public function candidate()
    {
    	return $this->hasMany('App\Candidate', 'cand_elc_id');
    }

    public function voter()
    {
    	return $this->hasMany('App\User', 'elc_id');
    }

    public function cast()
    {
    	return $this->voter()->where('users.cast', '=', 1);
    }

    public function uncast()
    {
    	return $this->voter()->where('users.cast', '=', 0);
    }
}
