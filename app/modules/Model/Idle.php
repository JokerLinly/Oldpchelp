<?php

namespace App\modules\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Idle extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    protected $fillable = ['date','pcer_id'];
    
    public function pcer()
    {
         return $this->belongsTo('Pcer');
    }
}
