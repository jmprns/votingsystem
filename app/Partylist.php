<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partylist extends Model
{
    protected $fillable = ['party_name'];
    protected $table = 'partylist';
}
