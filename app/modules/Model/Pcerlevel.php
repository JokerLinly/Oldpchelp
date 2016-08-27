<?php

namespace modules\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pcerlevel extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function pcers()
    {
        return $this->hasMany('App\Model\Pcer');
    }
}
