<?php

namespace App\modules\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\modules\Model\Wcuser;

class Comment extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    public function getCreatedTimeAttribute()
    {
        return date('m-d H:i', strtotime($this->created_at));
    }

    public function getUpdatedTimeAttribute()
    {
        return date('Y-m-d H:i', strtotime($this->updated_at));
    }

    public function getLatestTimeAttribute()
    {
        return date('d', strtotime($this->updated_at));
    }

    public function getSenterNameAttribute()
    {
        switch ($this->from) {
            case '0':
                return "机主";
                break;
            default:
                $wcuser = Wcuser::where('id', $this->wcuser_id)
                    ->whereNotIn('state', [0])
                    ->select('id')
                    ->with(['pcer'=> function ($query) {
                        $query->select('wcuser_id', 'name');
                    }])
                    ->first();
                if ($wcuser) {
                    return $wcuser->toArray()['pcer']['name'];
                }
                return "系统";
                break;
        }
    }

    public function getSenterNicknameAttribute()
    {
        switch ($this->from) {
            case '0':
                return "机主";
                break;
            default:
                $wcuser = Wcuser::where('id', $this->wcuser_id)
                    ->whereNotIn('state', [0])
                    ->select('id')
                    ->with(['pcer'=> function ($query) {
                        $query->select('wcuser_id', 'nickname');
                    }])
                    ->first();
                if ($wcuser) {
                    return $wcuser->toArray()['pcer']['nickname'];
                }
                return "系统";
                break;
        }
    }
    
    //评论对应的用户
    public function wcuser()
    {
        return $this->belongsTo(Wcuser::class);
    }
}
