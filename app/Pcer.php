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




}
