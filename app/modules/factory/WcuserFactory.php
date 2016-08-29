<?php 
namespace App\modules\factory;

use App\modules\base\WcuserBase;
use ErrorMessage;
use EasyWeChat;

/**
* 微信用户工厂类
*/
class WcuserFactory extends WcuserBase
{
    /**
     * 新增用户
     * @author JokerLinly
     * @date   2016-08-29
     * @param  [type]     $openid [description]
     */
    public static function addWcuser($openid)
    {
        if (empty($openid) ) {
            return ErrorMessage::getMessage(10000);
        }
        $userService = EasyWeChat::user(); 
        $user = $userService->get($openid);

        $wcuser = self::WcuserModel();
        $wcuser->subscribe = $user->subscribe;
        $wcuser->openid = $openid;
        $wcuser->save();
        dd($wcuser);
        return $wcuser;
    }

    /**
     * 查询是否存在这个账户
     * @author JokerLinly
     * @date   2016-08-29
     * @param  array      $field  [description]
     * @param  [type]     $openid [description]
     * @return [type]             [description]
     */
    public static function getWcuser($field = ['*'],$openid)
    {
        if (empty($openid) ) {
            return ErrorMessage::getMessage(10000);
        }

        return self::WcuserModel()->select($field)->where('openid', $openid)->first();
    }

}