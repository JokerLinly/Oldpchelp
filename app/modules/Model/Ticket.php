<?php

namespace App\modules\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * 创建时间格式
     * @author JokerLinly
     * @date   2016-09-07
     * @return [type]     [description]
     */
    public function getCreatedTimeAttribute()
    {
        if ($this->created_at) {
            return date('Y-m-d H:i', strtotime($this->created_at));
        }
    }

    public function getChainDateAttribute()
    {
        if ($this->date) {
            if ($this->date == 1) {
                return "星期一";
            } elseif ($this->date == 2) {
                return "星期二";
            } elseif ($this->date == 3) {
                return "星期三";
            } elseif ($this->date == 4) {
                return "星期四";
            } elseif ($this->date == 5) {
                return "星期五";
            } elseif ($this->date == 6) {
                return "星期六";
            } else {
                return "星期日";
            }
        }
    }

    public function getChainDate1Attribute()
    {
        if ($this->date1) {
            if ($this->date1 == 1) {
                return "星期一";
            } elseif ($this->date1 == 2) {
                return "星期二";
            } elseif ($this->date1 == 3) {
                return "星期三";
            } elseif ($this->date1 == 4) {
                return "星期四";
            } elseif ($this->date1 == 5) {
                return "星期五";
            } elseif ($this->date1 == 6) {
                return "星期六";
            } else {
                return "星期日";
            }
        }
    }

    public function getAssessSloganAttribute()
    {
        if ($this->assess) {
            if ($this->assess == 1) {
                return "赞赞哒！";
            } elseif ($this->assess == 2) {
                return "一般般吧！";
            } elseif ($this->assess == 3) {
                return "简直垃圾！";
            } else {
                return "暂无评价";
            }
        }
    }

    public function getOverTimeAttribute()
    {
        if ($this->updated_at <= date("Y-m-d", time()-3*24*3600) && empty($this->pcadmin_id) && empty($this->pcer_id)) {
            return true;
        }
        return false;
    }

    // public function getDifferTimeAttribute()
    // {
    //     $startdate= $this->created_at;
    //     $enddate= date("Y-m-d H:i:s");
    //     $date=floor((strtotime($enddate)-strtotime($startdate))/86400);
    //     $hour=floor((strtotime($enddate)-strtotime($startdate))%86400/3600);
    //     if ($date==0) {
    //         return $hour."小时";
    //     }elseif ($hour==0) {
    //         return $date."天";
    //     } else {
    //         return $date."天".$hour."小时";
    //     }
    // }

    // public function getUseTimeAttribute()
    // {
    //     $startdate= $this->created_at;
    //     $enddate= $this->updated_at;
    //     $date=floor((strtotime($enddate)-strtotime($startdate))/86400);
    //     $hour=floor((strtotime($enddate)-strtotime($startdate))%86400/3600);
    //     if ($date==0) {
    //         return $hour."小时";
    //     }elseif ($hour==0) {
    //         return $date."天";
    //     } else {
    //         return $date."天".$hour."小时";
    //     }
    // }

    // public function getDifferHendleAttribute()
    // {
    //     $startdate= $this->updated_at;
    //     $enddate= date("Y-m-d H:i:s");
    //     $date=floor((strtotime($enddate)-strtotime($startdate))/86400);
    //     $hour=floor((strtotime($enddate)-strtotime($startdate))%86400/3600);
    //     if ($date==0) {
    //         return $hour."小时";
    //     }elseif ($hour==0) {
    //         return $date."天";
    //     } else {
    //         return $date."天".$hour."小时";
    //     }
    // }



    // public function getUpdatedTimeAttribute()
    // {
    //     return date('Y-m-d H:i',strtotime($this->updated_at));
    // }

    // public function getLatestTimeAttribute()
    // {
    //     return date('d',strtotime($this->updated_at));
    // }


     /**
     *获取订单对应的维修员*
     */
    public function pcer()
    {
        return $this->belongsTo(Pcer::class);
    }

    public function wcuser()
    {
        return $this->belongsTo(Wcuser::class);
    }

    /**
     *获取订单对应的管理员*
     */
    public function pcadmin()
    {
        return $this->belongsTo(Pcadmin::class);
    }

    /*订单对应的消息*/
    public function comment()
    {
        return $this->hasMany(Comment::class);
    }

}
