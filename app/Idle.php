<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Idle extends Model
{
    protected $fillable = ['date','pcer_id'];

    
    public function pcer()
    {
         return $this->belongsTo('App\Pcer');
    }
}
