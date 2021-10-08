<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = ['user_id', 'cand_id', 'timestamp'];

    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }

    public function candidate()
    {
    	return $this->belongsTo('App\Candidate', 'cand_id');
    }

}
