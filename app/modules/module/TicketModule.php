<?php
namespace  App\modules\module;

use App\modules\factory\TicketFactory;

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
        return TicketFactory::getTicketById($id);
    }

    public static function getCommentByTicket($id)
    {
        return TicketFactory::getCommentByTicket($id);
    }
}