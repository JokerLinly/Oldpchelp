<?php
namespace module;

use factory\WcuserFactory;

/**
* 微信用户模块
*/
class WcuserModule
{
    public static function getWcuser($field = ['*'],$openid)
    {
        return WcuserFactory::getWcuser($field = ['*'], $openid);
    }
}