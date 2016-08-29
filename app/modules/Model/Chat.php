<?php

namespace App\modules\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Chat extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function wcuser()
    {
        return $this->belongsTo('Wcuser');
    }
}
