<?php
namespace App\modules\base;

use App\modules\model\Wcuser;

/**
* 微信用户的基础类
*/
class WcuserBase
{
    public static function WcuserModel()
    {
        return new Wcuser();
    }
}