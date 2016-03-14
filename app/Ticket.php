<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{

/*    public function getPcerNameAttribute()
    {
        if ($this->pcer && !empty($this->pcer)) {
            return $this->pcer->name;
        }

        return '暂无';
    }
*/
    public function getDifferTimeAttribute()
    {
        $startdate= $this->created_at;
        $enddate= date("Y-m-d H:i:s");
        $date=floor((strtotime($enddate)-strtotime($startdate))/86400);
        $hour=floor((strtotime($enddate)-strtotime($startdate))%86400/3600);
        if ($date==0) {
            return $hour."小时";
        }elseif ($hour==0) {
            return $date."天";
        } else {
            return $date."天".$hour."小时";
        }
    }


    public function getCreatedTimeAttribute()
    {
        return date('m-d H:i',strtotime($this->created_at));
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
