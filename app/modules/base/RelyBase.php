<?php
namespace App\modules\base;

use App\modules\Model\Rely;

/**
* 消息回复的基础类
*/
class RelyBase{
    public static function RelyModel()
    {
        return new Rely();
    }
}