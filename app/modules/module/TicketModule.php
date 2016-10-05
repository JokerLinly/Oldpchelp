<?php
namespace  App\modules\module;

use App\modules\factory\TicketFactory;
use App\modules\factory\PcerFactory;
use App\modules\factory\WcuserFactory;
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
        $wcuser = WcuserFactory::getWcuserById(['id', 'state'], $ticket['wcuser_id']);
        if (!empty($wcuser) && $wcuser['state'] !=0) {
            $ticket['status'] = 1;
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
        return TicketFactory::searchTicket($wcuser_id);
    }

    public static function getPcerSingleTicket($pcer_id, $ticket_id)
    {
        return TicketFactory::getPcerSingleTicket($pcer_id, $ticket_id);
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
        return TicketFactory::getTicketById($id, $wcuser_id);
    }

    /**
     * 验证是否有权限
     * @author JokerLinly
     * @date   2016-10-01
     * @param  [type]     $pcer_id   [description]
     * @param  [type]     $ticket_id [description]
     * @return [type]                [description]
     */
    public static function verifyPcerSingleTicket($pcer_id, $ticket_id)
    {
        return TicketFactory::verifyPcerSingleTicket($pcer_id, $ticket_id);
    }

    public static function verifyUserSingleTicket($wcuser_id, $ticket_id)
    {
        return TicketFactory::verifyUserSingleTicket($wcuser_id, $ticket_id);
    }

    public static function verifyAdminSingleTicket($pcadmin_id, $ticket_id)
    {
        return TicketFactory::verifyAdminSingleTicket($pcadmin_id, $ticket_id);
    }
    /**
     * 获取订单会话
     * @author JokerLinly
     * @date   2016-09-08
     * @param  [type]     $id [description]
     * @return [type]         [description]
     */
    public static function getCommentByTicket($id)
    {
        return TicketFactory::getCommentByTicket($id);
    }

    /**
     * 用户添加评论
     * @author JokerLinly
     * @date   2016-09-08
     * @param  [type]     $input [description]
     */
    public static function addSuggestion($input)
    {
        return TicketFactory::addSuggestion($input);
    }

    /**
     * [justAddComment description]
     * @author JokerLinly
     * @date   2016-10-06
     * @param  [type]     $comment [description]
     * @return [type]              [description]
     */
    public static function justAddComment($comment)
    {
        return TicketFactory::addComment($comment);
    }

    /**
     * 用户催单信息发送
     * @author JokerLinly
     * @date   2016-09-09
     * @param  [type]     $input [description]
     */
    public static function addComment($input)
    {
        $ticket_data = TicketFactory::getTicketNeedById('id', $input['ticket_id'], ['wcuser_id', 'pcer_id', 'pcadmin_id']);
        if (empty($ticket_data)) {
            return $ticket_data;
        }
        $input['wcuser_id'] = $ticket_data['wcuser_id'];
        //增加评论
        $comment = TicketFactory::addComment($input);
        if (empty($comment)) {
            return $comment;
        }

        if (empty($ticket_data['pcer_id'])) {
            if (empty($ticket_data['pcadmin_id'])) {
                return $comment;
            }
            $pcadmin = TicketFactory::getPcOpenIdById($ticket_data['pcadmin_id']);
            $pcer_openid = $pcadmin['pcer']['wcuser']['openid'];
            $send = TicketFactory::sendMessageClassify($input['ticket_id'], $pcer_openid, $input['text'], 5);
        } else {
            $pcer = TicketFactory::getPcerOpenIdById($ticket_data['pcer_id']);
            $pcer_openid = $pcer['wcuser']['openid'];
            $send = TicketFactory::sendMessageClassify($input['ticket_id'], $pcer_openid, $input['text'], 0);
        }

        if ($send['errmsg']!='ok') {
            return $comment;
        }
        
        $update_Commnet = TicketFactory::updateCommnet($comment['id']);
        return $update_Comment;
    }

    /**
     * 用户更新订单信息
     * @author JokerLinly
     * @date   2016-09-11
     * @param  [type]     $input [description]
     * @return [type]            [description]
     */
    public static function updateTicket($input)
    {
        if (isset($input['_token'])) {
            unset($input['_token']);
        }
        return TicketFactory::updateTicket($input);
    }

    /**
     * 用户删除订单
     * @author JokerLinly
     * @date   2016-09-16
     * @param  [type]     $id [description]
     * @return [type]         [description]
     */
    public static function deleteTicket($id)
    {
        return TicketFactory::deleteTicket($id);
    }

    /**
     * PC仔获取订单
     * @author JokerLinly
     * @date   2016-09-16
     * @param  [type]     $wcuser_id [description]
     * @param  [type]     $state     [description]
     * @return [type]                [description]
     */
    public static function getPcerTicketList($pcer_id)
    {
        return TicketFactory::getPcerTicketList($pcer_id);
    }

    /**
     * PC叻仔获取单个订单
     * @author JokerLinly
     * @date   2016-09-28
     * @param  [type]     $ticket_id [description]
     * @return [type]                [description]
     */
    public static function getPcAdminSingleTicket($ticket_id)
    {
        return TicketFactory::getPcAdminSingleTicket($ticket_id);
    }

    /**
     * PC仔获取已完成订单
     * @author JokerLinly
     * @date   2016-09-16
     * @param  [type]     $wcuser_id [description]
     * @param  [type]     $state     [description]
     * @return [type]                [description]
     */
    public static function getPcerFinishTicketList($pcer_id)
    {
        return TicketFactory::getPcerFinishTicketList($pcer_id);
    }

    /**
     * PC仔获取好评单
     * @author JokerLinly
     * @date   2016-10-01
     * @param  [type]     $pcer_id [description]
     * @return [type]              [description]
     */
    public static function getPcerGoodTicketList($pcer_id)
    {
        return TicketFactory::getPcerGoodTicketList($pcer_id);
    }

    /**
     * PC仔发送消息
     * @author JokerLinly
     * @date   2016-09-23
     * @param  [type]     $input [description]
     * @return [type]            [description]
     */
    public static function pcerAddComment($input)
    {
        $ticket_data = TicketFactory::getTicketNeedById('id', $input['ticket_id'], ['wcuser_id', 'pcer_id', 'pcadmin_id']);
        if (empty($ticket_data)) {
            return $ticket_data;
        }
        //增加评论
        $comment = TicketFactory::addComment($input);
        if ($input['from'] == 1 && !empty($ticket_data['pcadmin_id'])) {
            //发给管理员
            $pcadmin = TicketFactory::getPcOpenIdById($ticket_data['pcadmin_id']);
            $pcadmin_openid = $pcadmin['pcer']['wcuser']['openid'];
            $send = TicketFactory::sendMessageClassify($input['ticket_id'], $pcadmin_openid, $input['text'], $input['from']);
            if ($send['errmsg']!='ok') {
                return $comment;
            }
            $update_Comment = TicketFactory::updateCommnet($comment['id']);
            return $update_Comment;
        } else {
            return $comment;
        }
    }

    public static function assignTicketMessage($ticket_id)
    {
        $ticket = TicketFactory::sendMessageNeedTicket($ticket_id);
        /*
        发送给用户的模板消息        
        */
        if (date("w") == $ticket['date']) {
            $hour = $ticket['hour'];
        } elseif(date("w") == $ticket['date1']) {
            $hour = $ticket['hour1'];
        }else{
            $hour = "待定";
        }
        $wcuser_openid = $ticket['wcuser']['openid'];
        $templateId_user = 'NSVoIDTtDGr5a2ECkWLZzkjHs6EiqDKsYC-vyB5N3BI';
        $url_user = action('Ticket\HomeController@showSingleTicket', array('id'=>$ticket_id));
        $data_user = array(
            "first" => "PC管理员已经为你的订单分配了一个PC仔！",
            "keyword1" => $ticket_id."的订单内容为  ".$ticket['problem'],
            "keyword2" => "具体上门时间是今晚".$hour,
            "remark"  => "您有一个PC仔尚未认领！速速带它回家！",
          );
        $sent_user = TicketFactory::sendMessageToWechat($templateId_user, $url_user, $data_user, $wcuser_openid);

        /*
            发送给PC队员的模板消息        
           */
        if ($ticket['shortnum']) {
            $shortnum = $ticket['shortnum'];
        } else {
            $shortnum = "无";
        }
        if ($ticket['area'] == 0) {
            $area = "东区";
        }elseif ($ticket['area'] == 1) {
            $area = "西区";
        } else {
            $area = "";
        }

        $pcer_openid = $ticket['pcer']['wcuser']['openid'];
        $templateId_pcer = 'aCZbEi9-JZbkR4otY8tkeFFV2zwf-lUFKFbos49h1Qc';
        $url_pcer = action('Member\TicketController@showSingleTicket', array('id'=>$ticket_id));
        $data_pcer = array(
        "first"   => "PC叻仔给你分配了订单!请尽快跟进！辛苦了！",
        "keynote1" => $ticket['problem'],
        "keynote2" => $area.$ticket['address'].",".$hour,
        "remark"  => "长号：".$ticket['number'].";短号：".$ticket['shortnum'],
        );
        $sent_pcer = TicketFactory::sendMessageToWechat($templateId_pcer, $url_pcer, $data_pcer, $pcer_openid);

        if ($sent_pcer['errmsg']!='ok') {
            $message =  ['errmsg'=>"发送模板消息给PC仔失败！"];
        } elseif ($sent_user['errmsg']!='ok') {
            $message =  ['errmsg'=>"发送模板消息给机主失败！"];
        } else {
            $message = ['errmsg'=>"ok"];
        }

        return $message;
    }

    /**
     * PC管理员发送消息
     * @author JokerLinly
     * @date   2016-10-06
     * @param  [type]     $input [description]
     * @return [type]            [description]
     */
    public static function pcadminAddComment($input)
    {
        $ticket_data = TicketFactory::getTicketNeedById('id', $input['ticket_id'], ['wcuser_id', 'pcer_id']);
        if (empty($ticket_data)) {
            return null;
        }
        $comment = TicketFactory::addComment($input);
        if ($input['from'] == 3 && !empty($ticket_data['wcuser_id'])) {
            //发给用户
            $wcuser = WcuserFactory::getWcuserById(['openid'], $ticket_data['wcuser_id']);
            $wcuser_openid = $wcuser['openid'];
            $send = TicketFactory::sendMessageClassify($input['ticket_id'], $wcuser_openid, $input['text'], $input['from']);
            if ($send['errmsg']!='ok') {
                return $comment;
            }
            $update_Comment = TicketFactory::updateCommnet($comment['id']);
            return $update_Comment;
        } elseif ($input['from'] == 4 && !empty($ticket_data['pcer_id'])) {
            $pcer = TicketFactory::getPcerOpenIdById($ticket_data['pcer_id']);
            $pcer_openid = $pcer['wcuser']['openid'];

            $send = TicketFactory::sendMessageClassify($input['ticket_id'], $pcer_openid, $input['text'], $input['from']);
            if ($send['errmsg']!='ok') {
                return $comment;
            }
            $update_Comment = TicketFactory::updateCommnet($comment['id']);
            return $update_Comment;
        }
    }

    /**
     * PC队员结束订单
     * @author JokerLinly
     * @date   2016-09-27
     * @param  [type]     $input [description]
     * @return [type]            [description]
     */
    public static function pcerDelTicket($input)
    {
        return TicketFactory::pcerDelTicket($input);
    }

    /**
     * PC叻仔关闭订单
     * @author JokerLinly
     * @date   2016-09-28
     * @param  [type]     $pcadmin_id [description]
     * @param  [type]     $ticket_id  [description]
     * @return [type]                 [description]
     */
    public static function pcadminCloseTicket($pcadmin_id, $ticket_id)
    {
        return TicketFactory::pcadminCloseTicket($pcadmin_id, $ticket_id);
    }
    /**
     * 获取所有未分配订单
     * @author JokerLinly
     * @date   2016-09-27
     * @param  string     $value [description]
     * @return [type]            [description]
     */
    public static function getUnAssignTickets()
    {
        return TicketFactory::getUnAssignTickets();
    }

    /**
     * 获取今天未分配的订单
     * @author JokerLinly
     * @date   2016-09-27
     * @return [type]     [description]
     */
    public static function getUnAssignTodayTickets()
    {
        return TicketFactory::getUnAssignTodayTickets();
    }

    /**
     * 获取过期未分配订单
     * @author JokerLinly
     * @date   2016-09-27
     * @return [type]     [description]
     */
    public static function getUnAssignOverTimeTickets()
    {
        return TicketFactory::getUnAssignOverTimeTickets();
    }

    /**
     * 获取锁定未分配订单
     * @author JokerLinly
     * @date   2016-09-29
     * @param  [type]     $wcuser_id [description]
     * @return [type]                [description]
     */
    public static function getUnAssignLockTickets($wcuser_id)
    {
        $pcadmin_id = WcuserFactory::getPcAdminIdByWcuserId($wcuser_id);
        if (!$pcadmin_id) {
            return "error";
        }
        return TicketFactory::getUnAssignLockTickets($pcadmin_id);
    }

    /**
     * 获取pc管理员锁定的订单
     * @author JokerLinly
     * @date   2016-09-29
     * @param  [type]     $wcuser_id [description]
     * @return [type]                [description]
     */
    public static function getLockTickets($wcuser_id)
    {
        $pcadmin_id = WcuserFactory::getPcAdminIdByWcuserId($wcuser_id);
        if (!$pcadmin_id) {
            return "error";
        }
        return TicketFactory::getLockTickets($pcadmin_id);
    }

    /**
     * 获取pc完成的锁定的订单
     * @author JokerLinly
     * @date   2016-09-29
     * @param  [type]     $wcuser_id [description]
     * @return [type]                [description]
     */
    public static function getFinishTickets($wcuser_id)
    {
        $pcadmin_id = WcuserFactory::getPcAdminIdByWcuserId($wcuser_id);
        if (!$pcadmin_id) {
            return "error";
        }
        return TicketFactory::getFinishTickets($pcadmin_id);
    }
}
