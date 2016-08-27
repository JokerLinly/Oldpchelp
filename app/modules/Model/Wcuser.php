<?php

namespace App\modules\Model;

use Illuminate\Database\Eloquent\Model;

class Wcuser extends Model
{
    /*
     * 管理PC队员关联
     */
    public function pcer()
    {
        return $this->hasOne('Pcer');
    }

    public function chat()
    {
        return $this->hasMany('Chat');
    }

    public function ticket()
    {
        return $this->hasMany('Ticket');
    }

    

  
}
