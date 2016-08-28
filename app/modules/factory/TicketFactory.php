<?php 
namespace App\modules\factory;

use App\modules\base\TicketBase;
use ErrorMessage;

/**
* 订单工厂类
*/
class TicketFactory extends TicketBase
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
    /**
     * 用户获取自己创建的订单
     * @author JokerLinly
     * @date   2016-08-28
     * @param  [type]     $wcuser_id [description]
     * @return [type]                [description]
     */
    public static function searchTicket($wcuser_id)
    {
        if (empty($wcuser_id) || $wcuser_id < 1)) {
            return ErrorMessage::getMessage(10000);
        }
        $tickets = self::TicketModel()->where('wcuser_id',$wcuser_id)
                    ->with('pcer')->with('pcadmin')->orderBy('created_at','DESC')->get();
        return $tickets;
    }
}