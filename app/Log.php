<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = ['user_id', 'description', 'user_lvl'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function voter()
    {
        return $this->belongsTo('App\Voter', 'user_id');
    }
}
