<?php 
namespace App\modules\factory;

use App\modules\base\TicketBase;
use EasyWeChat;

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
     * 更新订单
     * @author JokerLinly
     * @date   2016-09-11
     * @param  [type]     $input [description]
     * @return [type]            [description]
     */
    public static function updateTicket($input)
    {
        $res = self::TicketModel()->where('id',$input['id'])->update($input);
        return $res;
    }

    public static function deleteTicket($id)
    {
        return self::TicketModel()->where('id',$id)->delete();
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
            ->select('id', 'name', 'created_at', 'area', 'address', 'number', 'shortnum', 'date', 'date1', 'hour', 'hour1', 'problem', 'pcer_id', 'state', 'assess', 'suggestion','wcuser_id')
            ->with(['pcer'=>function($query){
                $query->select('id','name','nickname');
            }])
            ->first()
            ->setAppends(['assess_slogan', 'created_time', 'chain_date', 'chain_date1']);

        return $ticket->toArray();
    }

    /**
     * 订单信息查询
     * @author JokerLinly
     * @date   2016-09-08
     * @param  [type]     $id   [description]
     * @param  [type]     $need [description]
     * @return [type]           [description]
     */
    public static function getTicketNeedById($name, $value, $need)
    {
        $ticket = self::TicketModel()->where($name,$value)
            ->select($need)->first();
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
            ->with(['wcuser'=>function($query){
                $query->select('id')
                    ->with(['pcer'=>function($query){
                        $query->select('wcuser_id', 'name','nickname');
                    }]);
            }])
            ->get(['id', 'ticket_id', 'from', 'wcuser_id', 'created_at', 'text'])
            ->each(function ($item) {
                $item->setAppends(['created_time']);
            });
        return $comments->toArray();
    }

    /**
     * 用户增加订单评价
     * @author JokerLinly
     * @date   2016-09-08
     * @param  [type]     $input [description]
     */
    public static function addSuggestion($input)
    {
        $res = self::TicketModel()->where('id',$input['ticket_id'])
              ->update(['assess'=>$input['assess'],'suggestion'=>$input['suggestion']]);

        return $res;
    }

    /**
     * 增加会话
     * @author JokerLinly
     * @date   2016-09-08
     * @param  [type]     $input [description]
     */
    public static function addComment($input)
    {
        $comment = self::CommentModel();
        $comment->ticket_id = $input['ticket_id'];
        $comment->from      = $input['from'];
        $comment->wcuser_id = $input['wcuser_id'];
        $comment->text      = $input['text'];
        $comment->save();
        return $comment->toArray();
    }

    /**
     * 根据id获取pc管理员的openid
     * @author JokerLinly
     * @date   2016-09-09
     * @param  [type]     $id [description]
     * @return [type]         [description]
     */
    public static function getPcOpenIdById($id)
    {
        $pcadmin = self::PcadminModel()->where('id',$id)
            ->select('pcer_id')
            ->with(['pcer'=>function($query){
                $query->select('id', 'wcuser_id')
                    ->with(['wcuser'=>function($query){
                        $query->select('id','openid');
                    }]);
            }])
            ->first();

        return $pcadmin->toArray();
    }

    /**
     * 根据id获取pc队员的openid
     * @author JokerLinly
     * @date   2016-09-09
     * @param  [type]     $id [description]
     * @return [type]         [description]
     */
    public static function getPcerOpenIdById($id)
    {
        $pcer = self::PcerModel()->where('id',$id)
            ->select('wcuser_id')
            ->with(['wcuser'=>function($query){
                $query->select('id','openid');
            }])
            ->first();

        return $pcer->toArray();
    }

    /**
     * 用户发送模板消息
     * @author JokerLinly
     * @date   2016-09-08
     * @param  [type]     $ticket_id    [description]
     * @param  [type]     $pcer_openid  [description]
     * @param  [type]     $comment_text [description]
     * @return [type]                   [description]
     */
    public static function sendMessageToPC($ticket_id, $pcer_openid, $comment_text)
    {
        $pcer_openid = 'od2TLjpXQWy8OnA5Ij4XPW0h5Iig';
        $templateId_pcer = 'W4zoiwQV-aptax34QSuJWH61HbsQlB752sAxjejH-LQ';

        // $templateId_pcer = 'aCZbEi9-JZbkR4otY8tkeFFV2zwf-lUFKFbos49h1Qc';
        $url_pcer = "http://pc.nfu.edu.cn/pcertickets/{$pcer_openid}/{$ticket_id}/show";
        $color_pcer = '#FF0000';
        $data_pcer = array(
            "first"    => "机主给你发来消息！",
            "keynote1" => $comment_text,
            "keynote2" => "就是现在！",
            "remark"   => "请尽快处理！么么哒(づ￣ 3￣)づ",
            );

        $notice_pcer = EasyWeChat::notice();
        $messageId = $notice_pcer->uses($templateId_pcer)->withUrl($url_pcer)->andData($data_pcer)->andReceiver($pcer_openid)->send();
        return $messageId->toArray();
    }

    /**
     * 消息发送成功标识
     * @author JokerLinly
     * @date   2016-09-08
     * @param  [type]     $id [description]
     * @return [type]         [description]
     */
    public static function update_Commnet($id)
    {
        $res = self::CommentModel()->where('id',$id)->update(['state'=>1]);
        return $res;
    }
}