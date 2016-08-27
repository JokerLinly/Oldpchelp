<?php

namespace modules\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pcadmin extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    public function pcer()
    {
        return $this->belongsTo('App\Model\Pcer');
    }

}
