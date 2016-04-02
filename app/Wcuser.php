<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wcuser extends Model
{
    /*
     * 管理PC队员关联
     */
    public function pcer()
    {
        return $this->hasOne('App\Pcer');
    }

    public function chat()
    {
        return $this->hasMany('App\Chat');
    }

    public function ticket()
    {
        return $this->hasMany('App\Ticket');
    }

    

  
}
