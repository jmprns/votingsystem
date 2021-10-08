<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
	protected $fillable = ['user_id', 'user_lvl', 'action'];

	public function admin()
	{
		return $this->belongsTo('App\Admin', 'user_id');
	}

	public function user()
	{
		return $this->belongsTo('App\User', 'user_id');
	}
}
