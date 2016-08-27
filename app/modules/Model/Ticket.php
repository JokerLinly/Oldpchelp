<?php

namespace modules\Model;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{

    protected $fillable = ['pcadmin_id','pcer_id','state'];

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

    public function getUseTimeAttribute()
    {
        $startdate= $this->created_at;
        $enddate= $this->updated_at;
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

    public function getDifferHendleAttribute()
    {
        $startdate= $this->updated_at;
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

    public function getUpdatedTimeAttribute()
    {
        return date('Y-m-d H:i',strtotime($this->updated_at));
    }

    public function getLatestTimeAttribute()
    {
        return date('d',strtotime($this->updated_at));
    }


     /**
     *获取订单对应的维修员*
     */
    public function pcer()
    {
        return $this->belongsTo('App\Model\Pcer');
    }

    public function wcuser()
    {
        return $this->belongsTo('App\Model\Wcuser');
    }

    /*创建订单对应的状态*/
        public function condition()
    {
        return $this->hasMany('App\Model\Condition');
    }
    /**
     *获取订单对应的管理员*
     */
    public function pcadmin()
    {
        return $this->belongsTo('App\Pcadmin');
    }

    /*订单对应的消息*/
    public function comment()
    {
        return $this->hasMany('App\Model\Comment');
    }

    

}
