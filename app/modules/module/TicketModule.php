<?php
namespace  App\modules\module;

use App\modules\factory\TicketFactory;

/**
* 订单模块
*/
class TicketModule 
{
    public static function addTicket(array $ticket)
    {
        return TicketFactory::addTicket($ticket);
    }
}