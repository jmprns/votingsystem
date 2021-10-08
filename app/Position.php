<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = ['position_name', 'type', 'max', 'elc_id'];

    public function candidate()
    {
    	return $this->hasMany('App\Candidate', 'pos_id')->orderBy('votes', 'desc');
    }

    public function take()
    {
    	// return $this->
    }

}
