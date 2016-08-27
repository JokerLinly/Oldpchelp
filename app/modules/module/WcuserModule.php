<?php
namespace modules\Module;

use modules\factory\WcuserFactory;

/**
* 微信用户模块
*/
class WcuserModule
{
    /**
     * 根据openid查询用户信息
     * @author JokerLinly
     * @date   2016-08-27
     * @param  array      $field  [description]
     * @param  [type]     $openid [description]
     * @return [type]             [description]
     */
    public static function getWcuser($field = ['*'],$openid)
    {
        return WcuserFactory::getWcuser($field = ['*'], $openid);
    }
}