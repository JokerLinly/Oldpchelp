<?php
namespace  App\modules\module;

use App\modules\factory\TicketFactory;
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

    /**
     * 获取单个订单信息
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

    public static function getCommentByTicket($id)
    {
        if (empty($id) || $id < 1) {
            return ErrorMessage::getMessage(10000);
        }
        return TicketFactory::getCommentByTicket($id);
    }
}