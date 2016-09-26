<?php

namespace App\modules\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Idle extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $appends = ['chain_date'];
        
    public function pcer()
    {
         return $this->belongsTo('Pcer');
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
}
