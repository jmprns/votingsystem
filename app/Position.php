<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = [
    	'name',
    	'type',
    	'max',
    	'elc_id'
    ];

    public function candidates()
    {
    	return $this->hasMany('App\Candidate', 'position_id');
    }
}
