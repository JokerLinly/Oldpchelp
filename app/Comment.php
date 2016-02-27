<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //评论对应的用户
    public function wcuser(){
        return $this->belongsTo('App\Wcuser');
    }

}
