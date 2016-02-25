<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }


    public function conditions()
    {
        return $this->hasMany('App\Condition');
    }
}
