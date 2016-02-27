<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{


    public function getCreatedTimeAttribute()
    {
        return date('m-d H:i',strtotime($this->created_at));
    }


    //评论对应的用户
    public function wcuser(){
        return $this->belongsTo('App\Wcuser');
    }

}
