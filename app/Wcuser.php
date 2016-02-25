<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wcuser extends Model
{
    public function chats()
    {
        return $this->hasMany('App\Chat');
    }

    public function tickets()
    {
        return $this->hasMany('App\Ticket');
    }

    public function pcers()
    {
        return $this->hasMany('App\Pcer');
    }

    public function pcadmins()
    {
        return $this->hasMany('App\Pcadmin');
    }
}
