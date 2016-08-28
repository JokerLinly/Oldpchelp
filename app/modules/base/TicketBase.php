<?php
namespace App\modules\base;

use App\modules\Model\Ticket;
use App\modules\Model\Comment;

/**
* 订单的基础类
*/
class TicketBase
{
    /**
     * 订单模型
     * @author JokerLinly
     * @date   2016-08-28
     */
    public static function TicketModel()
    {
        return new Ticket();
    }

    /**
     * 订单会话模型
     * @author JokerLinly
     * @date   2016-08-28
     */
    public static function CommentModel()
    {
        return new Comment();
    }
}