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
     * 验证用户是否有权限查看当前内容
     * @author JokerLinly
     * @date   2016-08-28
     * @param  String     $openid    [description]
     * @param  [type]     $wcuser_id [description]
     * @return boole
     */
    public static function checkValidates(String $openid, $wcuser_id)
    {
        return WcuserFactory::checkValidates($openid, $wcuser_id);
    }

    /**
     * 验证用户是否有权限查看当前内容
     * @author JokerLinly
     * @date   2016-08-28
     * @param  String     $openid    [description]
     * @param  [type]     $ticket_id [description]
     * @return [type]                [description]
     */
    public static function checkValidatesByTicket(String $openid, $ticket_id)
    {
        return WcuserFactory::checkValidatesByTicket($openid, $wcuser_id);
    }

    /**
     * 增加微信用户
     * @author JokerLinly
     * @date   2016-08-29
     * @param  [type]     $openid [description]
     */
    public static function addWcuser($openid)
    {
        return WcuserFactory::addWcuser($openid);
    }

    /**
     * 更新用户关注状态
     * @author JokerLinly
     * @date   2016-08-29
     * @param  [type]     $subscribe [description]
     * @param  [type]     $wcuser_id [description]
     * @return [type]                [description]
     */
    public static function updateSubscribe($subscribe,$wcuser_id)
    {
        return WcuserFactory::updateSubscribe($subscribe,$wcuser_id);
    }
}