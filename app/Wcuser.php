<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wcuser extends Model
{

/*    public function getPassTypeAttribute()
    {
        switch ($this->state) {
            case 0 :
            return 'pass';
            case 1 : 
            return 'nopass';
        }

    }*/
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
        return $this->hasOne('App\Pcer');
    }

  
}
