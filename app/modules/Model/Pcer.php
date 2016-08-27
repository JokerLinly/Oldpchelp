<?php

namespace App\modules\Model;

use Illuminate\Database\Eloquent\Model;

class Pcer extends Model
{
    /**
     * 获取维修工的订单
     */
    public function tickets()
    {
        return $this->hasMany('Ticket');
    }

    /*
        一个PCer对应一个wcuser
     */
    public function wcuser()
    {
        return $this->belongsTo('Wcuser');
    }

    /*
        一个PCer对应一个pcadmin
     */
    public function pcadmin()
    {
        return $this->hasOne('Pcadmin');
    }

    /*
        一个PCer对应多个idle
     */
    public function idle()
    {
        return $this->hasMany('Idle');
    }
    
    public function pcerlevel()
    {
        return $this->belongsTo('Pcerlevel');
    }
}
