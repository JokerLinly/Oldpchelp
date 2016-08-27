<?php 
namespace App\modules\factory;

use App\modules\base\WcuserBase;
use ErrorMessage;

/**
* 微信用户工厂类
*/
class WcuserFactory extends WcuserBase
{

    public static function getWcuser($field = ['*'],$openid)
    {
        if (empty($openid) ) {
            return ErrorMessage::getMessage(10000);
        }

        return self::WcuserModel()->select($field)->where('openid', $openid)->first();
    }
}