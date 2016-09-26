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
        if (in_array('status', $ticket)) {
            $tickets->status = $ticket['status'];
        }
        if (in_array('date1', $ticket)) {
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
        $res = self::TicketModel()->where('id', $input['id'])->update($input);
        return $res;
    }

    /**
     * 删除订单
     * @author JokerLinly
     * @date   2016-09-16
     * @param  [type]     $id [description]
     * @return [type]         [description]
     */
    public static function deleteTicket($id)
    {
        return self::TicketModel()->where('id', $id)->delete();
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
        $tickets = self::TicketModel()->where('wcuser_id', $wcuser_id)
            ->with(['pcer'=>function ($query) {
                $query->select('id', 'name');
            }])
            ->orderBy('created_at', 'DESC')
            ->get(['id', 'state', 'problem', 'pcer_id', 'created_at'])
            ->each(function ($item) {
                $item->setAppends(['created_time']);
            });
        if (!$tickets) {
            return $tickets;
        }
        return $tickets->toArray();
    }

    /**
     * 用户获取单个订单信息
     * @author JokerLinly
     * @date   2016-08-28
     * @param  [type]     $id [description]
     * @return [type]         [description]
     */
    public static function getTicketById($id, $wcuser_id)
    {
        $ticket = self::TicketModel()->where('id', $id)
            ->where('wcuser_id', $wcuser_id)
            ->select('id', 'name', 'created_at', 'area', 'address', 'number', 'shortnum', 'date', 'date1', 'hour', 'hour1', 'problem', 'pcer_id', 'state', 'assess', 'suggestion', 'wcuser_id', 'status')
            ->with(['pcer'=>function ($query) {
                $query->select('id', 'name', 'nickname');
            }])
            ->first()
            ->setAppends(['assess_slogan', 'created_time', 'chain_date', 'chain_date1']);
        if (!$ticket) {
            return $ticket;
        }
        return $ticket->toArray();
    }

    public static function getPcerSingleTicket($pcer_id, $ticket_id)
    {
        $ticket = self::TicketModel()->where('id', $ticket_id)->where('pcer_id', $pcer_id)
            ->select('id', 'name', 'created_at', 'area', 'address', 'number', 'shortnum', 'date', 'date1', 'hour', 'hour1', 'problem', 'pcer_id', 'state', 'assess', 'suggestion', 'wcuser_id', 'pcadmin_id', 'status')
            ->with(['pcer'=>function ($query) {
                $query->select('id', 'name', 'nickname', 'wcuser_id')->with(['wcuser'=>function ($query) {
                    $query->select('id');
                }]);
            }])
            ->with(['pcadmin'=>function ($query) {
                $query->select('id', 'pcer_id')
                ->with(['pcer'=>function ($query) {
                    $query->select('id', 'name');
                }]);
            }])
            ->first()
            ->setAppends(['assess_slogan', 'created_time', 'chain_date', 'chain_date1']);
        if ($ticket) {
            return $ticket->toArray();
        }
        return $ticket;
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
        $ticket = self::TicketModel()->where($name, $value)
            ->select($need)->first();
        if (!$ticket) {
            return $ticket;
        }
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
        $comments = self::CommentModel()->where('ticket_id', $id)
            ->with(['wcuser'=>function ($query) {
                $query->select('id')
                    ->with(['pcer'=>function ($query) {
                        $query->select('wcuser_id', 'name', 'nickname');
                    }]);
            }])
            ->get(['id', 'ticket_id', 'from', 'wcuser_id', 'created_at', 'text'])
            ->each(function ($item) {
                $item->setAppends(['created_time']);
            });
        if (!$comments) {
            return $comments;
        }
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
        $res = self::TicketModel()->where('id', $input['ticket_id'])
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
        if (!$comment) {
            return $comment;
        }
        return $comment->toArray();
    }

    /**
     * PC仔的订单
     * @author JokerLinly
     * @date   2016-09-23
     * @param  [type]     $pcer_id [description]
     * @param  [type]     $state   [description]
     * @return [type]              [description]
     */
    public static function getPcerTicketList($pcer_id)
    {
        $tickets = self::TicketModel()->where('pcer_id', $pcer_id)
            ->where('state', 1)->whereNotNull('pcadmin_id')
            ->get()
            ->each(function ($item) {
                $item->setAppends(['assess_slogan', 'created_time', 'chain_date', 'chain_date1']);
            });
        if ($tickets) {
            return $tickets->toArray();
        }
        return $tickets;
    }
    
    /**
     * PC仔已完成订单
     * @author JokerLinly
     * @date   2016-09-23
     * @param  [type]     $pcer_id [description]
     * @param  [type]     $state   [description]
     * @return [type]              [description]
     */
    public static function getPcerFinishTicketList($pcer_id)
    {
        $tickets = self::TicketModel()->where('pcer_id', $pcer_id)
            ->where('state', '>', 1)->whereNotNull('pcadmin_id')
            ->get()
            ->each(function ($item) {
                $item->setAppends(['assess_slogan', 'created_time', 'chain_date', 'chain_date1']);
            });
        if ($tickets) {
            return $tickets->toArray();
        }
        return $tickets;
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
        $pcadmin = self::PcadminModel()->where('id', $id)
            ->select('pcer_id')
            ->with(['pcer'=>function ($query) {
                $query->select('id', 'wcuser_id')
                    ->with(['wcuser'=>function ($query) {
                        $query->select('id', 'openid');
                    }]);
            }])
            ->first();
        if (!$pcadmin) {
            return $pcadmin;
        }
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
        $pcer = self::PcerModel()->where('id', $id)
            ->select('wcuser_id')
            ->with(['wcuser'=>function ($query) {
                $query->select('id', 'openid');
            }])
            ->first();
        if (!$pcer) {
            return $pcer;
        }
        return $pcer->toArray();
    }

    /**
     * 发送模板消息信息分类
     * @author JokerLinly
     * @date   2016-09-23
     * @param  [type]     $ticket_id    [description]
     * @param  [type]     $openid       [description]
     * @param  [type]     $comment_text [description]
     * @param  [type]     $from         [description]
     * @return [type]                   [description]
     */
    public static function sendMessageClassify($ticket_id, $openid, $comment_text, $from)
    {
        $openid = 'od2TLjpXQWy8OnA5Ij4XPW0h5Iig';
        $templateId = 'W4zoiwQV-aptax34QSuJWH61HbsQlB752sAxjejH-LQ';
        //模板id
        // $templateId = 'aCZbEi9-JZbkR4otY8tkeFFV2zwf-lUFKFbos49h1Qc';
        // $color_pcer = '#FF0000';
        switch ($from) {
            case '0': //用户发送给PC仔或者管理员
                $first = "机主给你发来消息！";
                $url = action('Ticket\HomeController@showSingleTicket', array('id'=>$ticket_id));
                break;
            case '1':
                $first = "你分配的订单有异常！";
                $url = action('Member\TicketController@showSingleTicket', array('id'=>$ticket_id));
                break;
            default:
                $first = "系统消息！";
                break;
        }
        $data = array(
            "first"    => $first,
            "keynote1" => $comment_text,
            "keynote2" => date("Y-m-d H:i"),
            "remark"   => "点击查看详情！请尽快处理！么么哒(づ￣ 3￣)づ",
        );
        return self::sendMessageToWechat($templateId, $url, $data, $openid);
    }

    /**
     * 发送模板消息
     * @author JokerLinly
     * @date   2016-09-23
     * @param  [type]     $templateId [description]
     * @param  [type]     $url        [description]
     * @param  [type]     $data       [description]
     * @param  [type]     $openid     [description]
     * @return [type]                 [description]
     */
    public static function sendMessageToWechat($templateId, $url, $data, $openid)
    {
        $notice_pcer = EasyWeChat::notice();
        $messageId = $notice_pcer->uses($templateId)->withUrl($url)->andData($data)->andReceiver($openid)->send();
        return $messageId->toArray();
    }

    /**
     * 消息发送成功标识
     * @author JokerLinly
     * @date   2016-09-08
     * @param  [type]     $id [description]
     * @return [type]         [description]
     */
    public static function updateCommnet($id)
    {
        $res = self::CommentModel()->where('id', $id)->update(['state'=>1]);
        return $res;
    }

    /**
     * PC仔结束订单
     * @author JokerLinly
     * @date   2016-09-23
     * @param  [type]     $input [description]
     * @return [type]            [description]
     */
    public static function pcerDelTicket($input)
    {
        $res = self::TicketModel()
            ->where('id', $input['ticket_id'])
            ->where('pcer_id', $input['pcer_id'])
            ->update(['state'=> 2]);
        return $res;
    }

    /**
     * PC管理员结束订单
     * @author JokerLinly
     * @date   2016-09-23
     * @param  [type]     $input [description]
     * @return [type]            [description]
     */
    public static function pcAdminDelTicket($input)
    {
        $res = self::TicketModel()
            ->where('id', $input['ticket_id'])
            ->where('pcer_id', $input['pcer_id'])
            ->update(['state'=> 4]);
        return $res;
    }

    /**
     * Super结束订单
     * @author JokerLinly
     * @date   2016-09-23
     * @param  [type]     $input [description]
     * @return [type]            [description]
     */
    public static function superDelTicket($id)
    {
        $res = self::TicketModel()
            ->where('id', $input['ticket_id'])
            ->update(['state'=> 5]);
        return $res;
    }
}
