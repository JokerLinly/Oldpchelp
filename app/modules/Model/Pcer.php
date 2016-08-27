<?php

namespace modules\Model;

use Illuminate\Database\Eloquent\Model;

class Pcer extends Model
{
    /**
     * 获取维修工的订单
     */
    public function tickets()
    {
        return $this->hasMany('App\Model\Ticket');
    }

    /*
        一个PCer对应一个wcuser
     */
    public function wcuser()
    {
        return $this->belongsTo('App\Model\Wcuser');
    }

    /*
        一个PCer对应一个pcadmin
     */
    public function pcadmin()
    {
        return $this->hasOne('App\Model\Pcadmin');
    }

    /*
        一个PCer对应多个idle
     */
    public function idle()
    {
        return $this->hasMany('App\Model\Idle');
    }
    
    public function pcerlevel()
    {
        return $this->belongsTo('App\Model\Pcerlevel');
    }
}
