<?php

namespace App\modules\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Wcuser extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    /*
     * 管理PC队员关联
     */
    public function pcer()
    {
        return $this->hasOne(Pcer::class);
    }

    public function chat()
    {
        return $this->hasMany(Chat::class);
    }

    public function ticket()
    {
        return $this->hasMany(Ticket::class);
    }

    

  
}
