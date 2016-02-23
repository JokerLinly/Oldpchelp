<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wcuser extends Model
{
    public function chats()
    {
        return $this->hasMany('App\Chat');
    }
}
