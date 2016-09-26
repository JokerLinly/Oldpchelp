<?php

namespace App\modules\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pcer extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function getLevelNameAttribute()
    {
        $level = self::pcerlevel()->where('id', $this->pcerlevel_id)->select('level_name')->first();
        return $level->level_name;
    }
    
    /**
     * 获取维修工的订单
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    /*
        一个PCer对应一个wcuser
     */
    public function wcuser()
    {
        return $this->belongsTo(Wcuser::class);
    }

    /*
        一个PCer对应一个pcadmin
     */
    public function pcadmin()
    {
        return $this->hasOne(Pcadmin::class);
    }

    /*
        一个PCer对应多个idle
     */
    public function idle()
    {
        return $this->hasMany(Idle::class);
    }
    
    public function pcerlevel()
    {
        return $this->belongsTo(Pcerlevel::class);
    }
}
