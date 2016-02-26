<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wcuser extends Model
{
    public function chat()
    {
        return $this->hasMany('App\Chat');
    }

    public function ticket()
    {
        return $this->hasMany('App\Ticket');
    }

    public function pcer()
    {
        return $this->hasMany('App\Pcer');
    }

    public function pcadmin()
    {
        return $this->hasMany('App\Pcadmin');
    }
}
