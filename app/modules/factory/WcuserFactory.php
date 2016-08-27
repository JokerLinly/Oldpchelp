<?php 
namespace factory;

use modules\base\WcuserBase;
use ErrorMessage;

/**
* 微信用户工厂类
*/
class WcuserFactory extends WcuserBase
{

    public static function getWcuser($field = ['*'],$openid)
    {
        if (empty($id) && !is_numeric($id) && $id < 1) {
            return ErrorMessage::getMessage(10000);
        }

        return self::WcuserModel()->select($field)->where('openid', $openid)->first();
    }
}