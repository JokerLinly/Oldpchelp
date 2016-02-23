<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
     public function wcuser()
    {
        return $this->belongsTo('App\Wcuser');
    }
}
