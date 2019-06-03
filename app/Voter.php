<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voter extends Model
{
    protected $fillable = [
    	'name', 
    	'password', 
    	'course_id', 
    	'year_id', 
    	'elc_id', 
    	'isCandidate', 
    	'cast'
    ];

    public function course()
    {
    	return $this->belongsTo('App\Course', 'course_id');
    }

    public function year()
    {
    	return $this->belongsTo('App\Year', 'year_id');
    }

    public function election()
    {
    	return $this->belongsTo('App\Election', 'elc_id');
    }
}
