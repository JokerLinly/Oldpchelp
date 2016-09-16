<?php
namespace  App\modules\module;

use App\modules\factory\TicketFactory;
use App\modules\factory\PcerFactory;
use ErrorMessage;

/**
* 订单模块
*/
class TicketModule 
{
    /**
     * 创建订单
     * @author JokerLinly
     * @date   2016-08-28
     * @param  array      $ticket [description]
     */
    public static function addTicket(array $ticket)
    {
        if (empty($ticket) || !is_array($ticket)) {
            return ErrorMessage::getMessage(10000);
        }

        return TicketFactory::addTicket($ticket);
    }

    /**
     * 用户获取自己创建的订单
     * @author JokerLinly
     * @date   2016-08-28
     * @param  [type]     $wcuser_id [description]
     * @return [type]                [description]
     */
    public static function searchTicket($wcuser_id)
    {
        if (empty($wcuser_id) || $wcuser_id < 1) {
            return ErrorMessage::getMessage(10000);
        }

        return TicketFactory::searchTicket($wcuser_id);
    }

    public static function getPcerSingleTicket($pcer_id, $ticket_id)
    {
        return TicketFactory::getPcerSingleTicket($pcer_id, $ticket_id);
    }

    /**
     * 用户获取单个订单信息
     * @author JokerLinly
     * @date   2016-08-28
     * @param  [type]     $id [description]
     * @return [type]         [description]
     */
    public static function getTicketById($id)
    {
        if (empty($id) || $id < 1) {
            return ErrorMessage::getMessage(10000);
        }
        return TicketFactory::getTicketById($id);
    }

    /**
     * 获取订单会话
     * @author JokerLinly
     * @date   2016-09-08
     * @param  [type]     $id [description]
     * @return [type]         [description]
     */
    public static function getCommentByTicket($id)
    {
        if (empty($id) || $id < 1) {
            return ErrorMessage::getMessage(10000);
        }
        return TicketFactory::getCommentByTicket($id);
    }

    /**
     * 用户添加评论
     * @author JokerLinly
     * @date   2016-09-08
     * @param  [type]     $input [description]
     */
    public static function addSuggestion($input)
    {
        return TicketFactory::addSuggestion($input);
    }

    /**
     * 用户催单信息发送
     * @author JokerLinly
     * @date   2016-09-09
     * @param  [type]     $input [description]
     */
    public static function addComment($input)
    {
        $ticket_data = TicketFactory::getTicketNeedById('id', $input['ticket_id'],['wcuser_id', 'pcer_id', 'pcadmin_id']);
        if (empty($ticket_data)) {
            return $ticket_data;
        }
        $input['wcuser_id'] = $ticket_data['wcuser_id'];
        //增加评论
        $comment = TicketFactory::addComment($input);
        if (empty($comment)) {
            return $comment;
        } 

        if (empty($ticket_data['pcer_id'])) {
            if (empty($ticket_data['pcadmin_id'])) {
                return $comment;
            }
            $pcadmin = TicketFactory::getPcOpenIdById($ticket_data['pcadmin_id']);
            $pcer_openid = $pcadmin['pcer']['wcuser']['openid'];
            $send = TicketFactory::sendMessageToPC($pcer_openid,$ticket_data['pcadmin_id'],$input['text']);
        } else {
            $pcer = TicketFactory::getPcerOpenIdById($ticket_data['pcer_id']);
            $pcer_openid = $pcer['wcuser']['openid'];
            $send = TicketFactory::sendMessageToPC($pcer_openid,$ticket_data['pcadmin_id'],$input['text']);
        }

        if ($send['errmsg']=='ok') {
            $update_Commnet = TicketFactory::update_Commnet($comment['id']); 
        }
        
        $update_Commnet = TicketFactory::update_Commnet($comment['id']); 

        return $update_Commnet;
    }

    /**
     * 用户更新订单信息
     * @author JokerLinly
     * @date   2016-09-11
     * @param  [type]     $input [description]
     * @return [type]            [description]
     */
    public static function updateTicket($input)
    {
        unset($input['_token']);
        return TicketFactory::updateTicket($input);
    }

    /**
     * 用户删除订单
     * @author JokerLinly
     * @date   2016-09-16
     * @param  [type]     $id [description]
     * @return [type]         [description]
     */
    public static function deleteTicket($id)
    {
        return TicketFactory::deleteTicket($id);
    }

    /**
     * PC仔获取订单
     * @author JokerLinly
     * @date   2016-09-16
     * @param  [type]     $wcuser_id [description]
     * @param  [type]     $state     [description]
     * @return [type]                [description]
     */
    public static function getPcerTicketList($pcer_id, $state)
    {
        return TicketFactory::getPcerTicketList($pcer_id, $state);
    }
}