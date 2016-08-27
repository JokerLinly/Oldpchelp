<?php
namespace App\modules\base;

use App\modules\Model\Ticket;

/**
* 订单的基础类
*/
class TicketBase
{
    public static function TicketModel()
    {
        return new Ticket();
    }
}