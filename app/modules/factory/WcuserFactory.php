<?php 
namespace App\modules\factory;

use App\modules\base\WcuserBase;
use App\modules\factory\TicketFactory;
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
     * @return array              [description]
     */
    public static function getWcuser($field = ['*'],$openid)
    {
        if (empty($openid) ) {
            return ErrorMessage::getMessage(10000);
        }
        
        $wcuser = self::WcuserModel()->select($field)->where('openid', $openid)->first();
        if ($wcuser) {
            return $wcuser->toArray();
        }
        return $wcuser;
    }

    public static function getWcuserById($field = ['*'],$id)
    {
        if (empty($id) || $id < 1) {
            return ErrorMessage::getMessage(10000);
        }
        $wcuser = self::WcuserModel()->select($field)->where('id', $id)->first();
        
        if (!$wcuser) {
            return $wcuser;
        }
        return $wcuser->toArray();
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
        $result = self::WcuserModel()->where('id',$wcuser_id)->update(['subscribe'=> $subscribe]);
        if ($result) {
            return true;
        }
        return false;
    }

    /**
     * 验证用户是否有权限查看当前内容
     * @author JokerLinly
     * @date   2016-08-29
     * @param  $openid    [description]
     * @param  [type]     $wcuser_id [description]
     * @return [type]                [description]
     */
    public static function checkValidates($openid, $wcuser_id)
    {
        if (empty($openid) ) {
            return ErrorMessage::getMessage(10000);
        }

        if (empty($wcuser_id) || $wcuser_id < 1 ) {
            return ErrorMessage::getMessage(10000);
        }

        $wcuser = self::getWcuser('id',$openid);
        if (!empty($wcuser) && $wcuser['id'] == $wcuser_id) {
            return true;
        }
        return false;
    }

    /**
     * 验证用户是否有权限查看当前订单内容
     * @author JokerLinly
     * @date   2016-08-29
     * @param  [type]     $openid    [description]
     * @param  [type]     $ticket_id [description]
     * @return [type]                [description]
     */
    public static function checkValidatesByTicket($openid, $ticket_id)
    {
        if (empty($openid) ) {
            return ErrorMessage::getMessage(10000);
        }

        if (empty($ticket_id) || $ticket_id < 1 ) {
            return ErrorMessage::getMessage(10000);
        }
        
        $wcuser = self::getWcuser('id',$openid);
        if (empty($wcuser)) {
            return false;
        }

        $ticket = TicketFactory::getTicketById($ticket_id);
        if (!empty($ticket) && $ticket['wcuser_id'] == $wcuser['id']) {
            return true;
        }
        return false;
    }

    /**
     * 保存用户发送过来的内容
     * @author JokerLinly
     * @date   2016-08-29
     * @param  [type]     $wcuser_id [description]
     * @param  [type]     $content   [description]
     */
    public static function addChat($wcuser_id, $content)
    {
        if (empty($wcuser_id) || $wcuser_id < 1 ) {
            return ErrorMessage::getMessage(10000);
        }

        $chat = self::ChatModel();
        $chat->wcuser_id = $wcuser_id;
        $chat->content = $content;
        $chat->save();
        
        return $chat;
    }
}