<?php

namespace modules\Model;

use Illuminate\Database\Eloquent\Model;

class Wcuser extends Model
{
    /*
     * 管理PC队员关联
     */
    public function pcer()
    {
        return $this->hasOne('App\Model\Pcer');
    }

    public function chat()
    {
        return $this->hasMany('App\Model\Chat');
    }

    public function ticket()
    {
        return $this->hasMany('App\Model\Ticket');
    }

    

  
}
