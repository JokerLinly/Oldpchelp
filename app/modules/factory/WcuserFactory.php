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
    /**
     * 自选条件查询用户
     * @author JokerLinly
     * @date   2016-08-28
     * @param  array      $field  [description]
     * @param  [type]     $openid [description]
     * @return [type]             [description]
     */
    public static function getWcuser(String $condition,$field = ['*'],$data)
    {
        if (empty($data) ) {
            return ErrorMessage::getMessage(10000);
        }

        return self::WcuserModel()->select($field)->where($condition, $data)->first();
    }
}