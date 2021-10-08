<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;



class Voter extends Authenticatable
{
    use Notifiable;

    protected $guard = 'voter';

    protected $fillable = [
        'username', 'password', 'fname', 'lname', 'position', 'lvl', 'image'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $table = 'users';


}
