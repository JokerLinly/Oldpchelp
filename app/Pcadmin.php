<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pcadmin extends Model
{

    public function pcer()
    {
        return $this->belongsTo('App\Pcer');
    }

}
