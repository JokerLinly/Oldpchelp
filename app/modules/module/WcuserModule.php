<?php
namespace  App\modules\module;

use App\modules\factory\WcuserFactory;

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

    /**
     * 自选条件查询
     * @author JokerLinly
     * @date   2016-08-28
     * @param  String     $condition 
     * @param  array      $field     [description]
     * @param  [type]     $data      [description]
     * @return model
     */
    public static function getWcuserByCondition(String $condition,$field= ['*'],$data)
    {
        # code...
    }
}