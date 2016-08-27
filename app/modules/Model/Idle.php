<?php

namespace modules\Model;

use Illuminate\Database\Eloquent\Model;

class Idle extends Model
{
    protected $fillable = ['date','pcer_id'];

    
    public function pcer()
    {
         return $this->belongsTo('App\Model\Pcer');
    }
}
