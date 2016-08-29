<?php

namespace App\modules\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Rely extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    protected $table = 'relys';
}
