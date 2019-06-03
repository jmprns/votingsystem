<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    protected $fillable = ['name'];

    public function candidates()
    {
    	return $this->hasMany('App\Candidate', 'party_id');
    }
}
