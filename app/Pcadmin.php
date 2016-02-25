<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pcadmin extends Model
{
    public function tickets()
    {
        return $this->hasMany('App\Ticket');
    }
}
