<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
	protected $fillable = ['year_name', 'dept_id'];
	protected $table = 'year';


	public function department()
	{
		return $this->belongsTo('App\Department', 'dept_id');
	}


	public function candidate()
	{
		return $this->hasMany('App\Candidate', 'year_id');
	}

	public function voter()
	{
		return $this->hasMany('App\User', 'year_id');
	}
}
