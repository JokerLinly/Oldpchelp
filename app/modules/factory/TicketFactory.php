<?php 
namespace App\modules\factory;

use App\modules\base\TicketBase;
use ErrorMessage;

/**
* 订单工厂类
*/
class TicketFactory extends TicketBase
{

    public static function addTicket(array $ticket)
    {
        if (empty($ticket) || !is_array($ticket)) {
            return ErrorMessage::getMessage(10000);
        }

        $tickets = self::TicketModel();
        $tickets->wcuser_id = $ticket['wcuser_id'];
        $tickets->name      = $ticket['name'];
        $tickets->number    = $ticket['number'];
        $tickets->shortnum  = $ticket['shortnum'];
        $tickets->area      = $ticket['area'];
        $tickets->address   = $ticket['address'];
        $tickets->date      = $ticket['date'];
        $tickets->hour      = $ticket['hour'];
        $tickets->problem   = $ticket['problem'];
        if (in_array('date1',$ticket)) {
            $tickets->date1 = $ticket['date1'];
            $tickets->hour1 = $ticket['hour1'];
        }
        $tickets->save();

        return $tickets;
    }
}