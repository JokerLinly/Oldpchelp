<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pcer extends Model
{
    public function tickets()
    {
        return $this->hasMany('App\Ticket');
    }
}
