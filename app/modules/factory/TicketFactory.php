<?php 
namespace App\modules\factory;

use App\modules\base\TicketBase;

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
        $tickets = self::TicketModel()->where('wcuser_id',$wcuser_id)
            ->with(['pcer'=>function($query){
                $query->select('id', 'name');
            }])
            ->orderBy('created_at','DESC')
            ->get(['id', 'state', 'problem', 'pcer_id', 'created_at'])
            ->each(function ($item) {
                $item->setAppends(['created_time']);
            });

        return $tickets->toArray();
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
        $ticket = self::TicketModel()->where('id',$id)
            ->select('id', 'name', 'created_at', 'area', 'address', 'number', 'shortnum', 'date', 'date1', 'hour', 'hour1', 'problem', 'pcer_id', 'state', 'assess', 'suggestion')
            ->with(['pcer'=>function($query){
                $query->select('id','name','nickname');
            }])
            ->first()
            ->setAppends(['assess_slogan', 'created_time', 'chain_date', 'chain_date1']);

        return $ticket->toArray();
    }

    /**
     * 获取单个订单的会话
     * @author JokerLinly
     * @date   2016-08-28
     * @param  [type]     $id [description]
     * @return [type]         [description]
     */
    public static function getCommentByTicket($id)
    {
        $comments = self::CommentModel()->where('ticket_id',$id)
            ->select('id', 'ticket_id', 'from', 'wcuser_id', 'created_at')
            ->with(['wcuser'=>function($query){
                $query->select('id')
                    ->with(['pcer'=>function($query){
                        $query->select('wcuser_id', 'name','nickname');
                    }]);
            }])
            ->get();
        return $comments->toArray();
    }


}