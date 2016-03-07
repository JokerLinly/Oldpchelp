<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pcer extends Model
{
    /**
     * 获取维修工的订单
     */
    public function tickets()
    {
        return $this->hasMany('App\Ticket');
    }

    /*
        一个PCer对应一个wcuser
     */
    public function wcuser()
    {
        return $this->belongsTo('App\Wcuser');
    }

    /*
        一个PCer对应一个pcadmin
     */
    public function pcadmin()
    {
        return $this->hasOne('App\Pcadmin');
    }

    /*
        一个PCer对应多个idle
     */
    public function idle()
    {
        return $this->hasMany('App\Idle');
    }
}
