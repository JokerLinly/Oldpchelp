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
        if (empty($wcuser_id) || $wcuser_id < 1 ) {
            return ErrorMessage::getMessage(10000);
        }
        $result = self::WcuserModel()::where('id',$wcuser_id)->update(['subscribe'=> $subscribe]);
        if ($result) {
            return true;
        }
        return false;
    }

}