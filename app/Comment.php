<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

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
    
    //评论对应的用户
    public function wcuser()
    {
        return $this->belongsTo('App\Wcuser');
    }

}
