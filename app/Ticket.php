<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{

    public function getPcerNameAttribute()
    {
        if ($this->pcer && !empty($this->pcer)) {
            return $this->pcer->name;
        }

        return '暂无';
    }

     /**
     *获取订单对应的维修员*
     */
    public function pcer()
    {
        return $this->belongsTo('App\Pcer');
    }

    /*创建订单对应的状态*/
        public function condition()
    {
        return $this->hasMany('App\Condition');
    }
    /**
     *获取订单对应的维修员*
     */
    public function pcadmin()
    {
        return $this->belongsTo('App\Pcadmin');
    }

    /*订单对应的消息*/
    public function comment()
    {
        return $this->hasMany('App\Comment');
    }

}
