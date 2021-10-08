<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'password', 'alias', 'fname', 'lname', 'mname', 'year_id', 'elc_id', 'cast', 'number'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function year()
    {
        return $this->belongsTo('App\Year', 'year_id');
    }

    public function elc()
    {
        return $this->belongsTo('App\Election', 'elc_id');
    }

}
