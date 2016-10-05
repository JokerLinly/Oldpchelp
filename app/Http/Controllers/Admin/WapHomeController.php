<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Redirect;
use Validator;
use Session;
use \View;
use App\Http\Requests;
use App\modules\module\PcerModule;
use App\modules\module\TicketModule;
use App\modules\module\WcuserModule;
use App\Http\Controllers\Controller;

class WapHomeController extends Controller
{
    /**
     * 首页
     * @author JokerLinly
     * @date   2016-09-27
     * @return [type]     [description]
     */
    public function index()
    {
        $wcuser_id = session('wcuser_id');
        $pcer = PcerModule::getPcerByWcuserId($wcuser_id, ['id', 'created_at','name']);
        $finish_ticket = TicketModule::getPcerFinishTicketList($pcer['id']);
        $good_Ticket = TicketModule::getPcerGoodTicketList($pcer['id']);
        if ($good_Ticket) {
            $first_goodTicket_time = $good_Ticket[0]['differ_time'];
        }else{
            $first_goodTicket_time = null;
        }
        $finish_ticket_count = count($finish_ticket);
        $good_Ticket_count = count($good_Ticket);
        $betime = date('Y-m-d', strtotime($pcer['created_at']));
        $differ_time = $pcer['differ_time'];
        $name = $pcer['name'];
        $assign_list = TicketModule::getFinishTickets($wcuser_id);
        $assign_list_count = count($assign_list);
        return view('WapAdmin.index', compact('name', 'betime', 'differ_time', 'finish_ticket_count', 'good_Ticket_count', 'first_goodTicket_time', 'assign_list_count'));
    }

    /**
     * PC叻仔查看单个订单
     * @author JokerLinly
     * @date   2016-09-20
     * @param  Request    $request   [description]
     * @param  [type]     $ticket_id [description]
     * @return [type]                [description]
     */
    public function showSingleTicket(Request $request, $ticket_id)
    {
        $wcuser_id = session('wcuser_id');
        $wcuser = WcuserModule::getWcuserById(['state'], $wcuser_id);
        if (!empty($wcuser) && $wcuser['state'] == 2) {
            $pcadmin = WcuserModule::getPcAdminIdByWcuserId($wcuser_id);
            if (!empty($pcadmin)) {
                $ticket = TicketModule::getPcAdminSingleTicket($ticket_id);
                if (empty($ticket) && !is_array($ticket) && (!empty($ticket['pcadmin_id']) && $ticket['pcadmin_id']!=$pcadmin)) {
                    return view('jurisdiction');
                }
                $pcers = PcerModule::getDatePcer(date('w'));
                $comments = TicketModule::getCommentByTicket($ticket_id);
                $pcer_ots = PcerModule::getPcerOT();
                $pcer_change = array_merge($pcers, $pcer_ots);
                return view('WapAdmin.ticketData', ['ticket'=>$ticket,'comments'=>$comments, 'pcers'=>$pcers, 'pcer_change'=>$pcer_change]);
            } else {
                return view('error');
            }
        } else {
            return view('jurisdiction');
        }
    }
    /**
     * PC叻仔查看被锁定的单个订单
     * @author JokerLinly
     * @date   2016-09-20
     * @param  Request    $request   [description]
     * @param  [type]     $ticket_id [description]
     * @return [type]                [description]
     */
    public function lockSingleTicket(Request $request, $ticket_id)
    {
        $wcuser_id = session('wcuser_id');
        $wcuser = WcuserModule::getWcuserById(['state'], $wcuser_id);
        if (!empty($wcuser) && $wcuser['state'] == 2) {
            $pcadmin = WcuserModule::getPcAdminIdByWcuserId($wcuser_id);
            if (!empty($pcadmin)) {
                $ticket = TicketModule::getPcAdminSingleTicket($ticket_id);
                if (empty($ticket) && !is_array($ticket) && (!empty($ticket['pcadmin_id']) && $ticket['pcadmin_id']!=$pcadmin)) {
                    return view('jurisdiction');
                }
                $pcers = PcerModule::getDatePcer(date('w'));
                $pcer_ots = PcerModule::getPcerOT();
                $pcer_change = array_merge($pcers, $pcer_ots);
                $comments = TicketModule::getCommentByTicket($ticket_id);
                return view('WapAdmin.ticketLockData', ['ticket'=>$ticket,'comments'=>$comments, 'pcers'=>$pcer_change]);
            } else {
                return view('error');
            }
        } else {
            return view('jurisdiction');
        }
    }
    /**
     * PC叻仔分配订单
     * @author JokerLinly
     * @date   2016-09-28
     * @param  Request    $request [description]
     * @return [type]              [description]
     */
    public function assignTicket(Request $request)
    {
        $pcer_id = $request->pcer_id;
        $ticket_id = $request->ticket_id;
        if (empty($pcer_id) && empty($ticket_id) && $ticket_id < 1 && $pcer_id < 1) {
            return Redirect::back()->withMessage('数据异常！');
        }
        $wcuser_id = session('wcuser_id');
        $pcadmin = WcuserModule::getPcAdminIdByWcuserId($wcuser_id);
        $update = ['pcer_id'=>$pcer_id, 'pcadmin_id'=>$pcadmin, 'id'=>$ticket_id, 'state'=>1];
        $res = TicketModule::updateTicket($update);
        if (!$res) {
            return Redirect::back()->withMessage('网络异常！');
        }
        
        $send = TicketModule::assignTicketMessage($ticket_id);
        if ($send['errmsg']!='ok') {
            return Redirect::back()->withMessage($send['errmsg']);
        }
        $comment['wcuser_id'] = $wcuser_id;
        $comment['from'] = 4;
        $comment['text'] = "我给你分配了订单,请尽快处理,辛苦啦！么么哒！";
        $comment['ticket_id'] = $ticket_id;
        $res = TicketModule::justAddComment($comment);
        if (!$res) {
            return Redirect::back()->withMessage('网络异常！');
        }
        return Redirect::back()->withMessage('分配成功，系统已经为您发送消息提醒PC仔了！');
    }

    /**
     * PC叻仔锁定票单
     * @author JokerLinly
     * @date   2016-09-28
     * @param  Request    $request [description]
     * @return [type]              [description]
     */
    public function lockTicket(Request $request)
    {
        $wcuser_id = session('wcuser_id');
        $ticket_id = $request->ticket_id;
        if (empty($ticket_id) && $ticket_id < 1) {
            return Redirect::back()->withMessage('数据异常！');
        }
        $pcadmin = WcuserModule::getPcAdminIdByWcuserId($wcuser_id);

        $update = ['id'=>$ticket_id, 'pcadmin_id'=>$pcadmin, 'state'=>1];
        $res = TicketModule::updateTicket($update);
        if (!$res) {
            return Redirect::back()->withMessage('网络异常！');
        }
        return Redirect::back()->withMessage('锁定成功，可移步到我锁定的列表查看');
    }

    /**
     * PC叻仔关闭票单
     * @author JokerLinly
     * @date   2016-09-28
     * @param  Request    $request [description]
     * @return [type]              [description]
     */
    public function pcAdminCloseTicket(Request $request)
    {
        $ticket_id = $request->ticket_id;
        $wcuser_id = session('wcuser_id');
        $pcadmin = WcuserModule::getPcAdminIdByWcuserId($wcuser_id);
        if (empty($ticket_id) && $ticket_id < 1) {
            return Redirect::back()->withMessage('数据异常！');
        }

        if (empty($pcadmin) || $pcadmin < 1) {
            return Redirect::back()->withMessage('数据异常！');
        }

        $result = TicketModule::pcadminCloseTicket($pcadmin, $ticket_id);
        if (!$result) {
            return Redirect::back()->withMessage('网络异常！');
        }
        $text = "您发起的报修订单已经完成，如果您满意本次服务，请点击详情给个好评吧！";
        $input = ['ticket_id'=>$ticket_id, 'from'=> 3, 'text'=>$text, 'wcuser_id'=>$wcuser_id];
        $res = TicketModule::pcadminAddComment($input);
        if (!$res) {
            return Redirect::back()->withMessage('网络异常！');
        }
        return Redirect::back();
    }

    /**
     * PC叻仔发送消息
     * @author JokerLinly
     * @date   2016-09-28
     * @param  Request    $request [description]
     * @return [type]              [description]
     */
    public function pcadminSentComment(Request $request)
    {
        $wcuser_id = session('wcuser_id');
        $validator_rule = [
            'text' => 'required',
            'from' => 'required'
        ];

        $validator = Validator::make($request->Input(), $validator_rule);
        if ($validator->fails()) {
            return Redirect::back()->withMessage('要填写才能提交喔！');
        }
        $input = $request->Input();
        $input['wcuser_id'] = $wcuser_id;
        $res = TicketModule::pcadminAddComment($input);

        if (!$res) {
            return Redirect::back()->withMessage('网络问题，提交失败，请重新提交(づ￣ 3￣)づ');
        }

        return Redirect::back()->withMessage('发送成功！');
    }

    /**
     * pc仔报修的订单列表
     * @author JokerLinly
     * @date   2016-08-28
     * @param  [type]     $wcuser_id [description]
     * @return [type]                [description]
     */
    public function showTickets(Request $request)
    {
        $wcuser_id = session('wcuser_id');

        $tickets = TicketModule::searchTicket($wcuser_id);

        return view('WapAdmin.MyticketList', compact('tickets'));
    }

    /**
     * 进入分机单-全部未分配
     * @author JokerLinly
     * @date   2016-09-27
     * @return [type]     [description]
     */
    public function getAllTackTicket()
    {
        $wcuser_id = session('wcuser_id');
        $pcer = PcerModule::getPcer('wcuser_id', $wcuser_id, ['id']);
        if (!empty($pcer) && $pcer['wcuser']['state'] == 2) {
            $ticket_list = TicketModule::getUnAssignTickets();
            return view('WapAdmin.unAssignAllTicket', ['tickets'=>$ticket_list]);
        } else {
            return view('jurisdiction');
        }
    }

    /**
     * 进入分机单-过期未分配
     * @author JokerLinly
     * @date   2016-09-27
     * @return [type]     [description]
     */
    public function getOverTimeTackTicket()
    {
        $wcuser_id = session('wcuser_id');
        $pcer = PcerModule::getPcer('wcuser_id', $wcuser_id, ['id']);
        if (!empty($pcer) && $pcer['wcuser']['state'] == 2) {
            $ticket_list = TicketModule::getUnAssignOverTimeTickets();
            return view('WapAdmin.unAssignOverTimeTicket', ['tickets'=>$ticket_list]);
        } else {
            return view('jurisdiction');
        }
    }

    /**
     * 进入分机单-今天未分配
     * @author JokerLinly
     * @date   2016-09-27
     * @return [type]     [description]
     */
    public function getTodayTackTicket()
    {
        $wcuser_id = session('wcuser_id');
        $pcer = PcerModule::getPcer('wcuser_id', $wcuser_id, ['id']);
        if (!empty($pcer) && $pcer['wcuser']['state'] == 2) {
            $ticket_list = TicketModule::getUnAssignTodayTickets();
            return view('WapAdmin.unAssignTodayTicket', ['tickets'=>$ticket_list]);
        } else {
            return view('jurisdiction');
        }
    }
    /**
     * 进入分机单-锁定
     * @author JokerLinly
     * @date   2016-09-29
     * @return [type]     [description]
     */
    public function getLockTack()
    {
        $wcuser_id = session('wcuser_id');
        $pcer = PcerModule::getPcer('wcuser_id', $wcuser_id, ['id']);
        if (!empty($pcer) && $pcer['wcuser']['state'] == 2) {
            $ticket_list = TicketModule::getLockTickets($wcuser_id);
            return view('WapAdmin.LockTackTicket', ['tickets'=>$ticket_list]);
        } else {
            return view('jurisdiction');
        }
    }

    /**
     * 进入分机单-已完成
     * @author JokerLinly
     * @date   2016-09-29
     * @return [type]     [description]
     */
    public function getFinishTackTicket()
    {
        $wcuser_id = session('wcuser_id');
        $pcer = PcerModule::getPcer('wcuser_id', $wcuser_id, ['id']);
        if (!empty($pcer) && $pcer['wcuser']['state'] == 2) {
            $ticket_list = TicketModule::getFinishTickets($wcuser_id);
            return view('WapAdmin.FiinishTackTicket', ['tickets'=>$ticket_list]);
        } else {
            return view('jurisdiction');
        }
    }
    /**
     * 被锁定的订单
     * @author JokerLinly
     * @date   2016-09-27
     * @return [type]     [description]
     */
    public function getLockTackTickets()
    {
        $wcuser_id = session('wcuser_id');
        $pcer = PcerModule::getPcer('wcuser_id', $wcuser_id, ['id']);
        if (!empty($pcer) && $pcer['wcuser']['state'] == 2) {
            $ticket_list = TicketModule::getUnAssignLockTickets($wcuser_id);
            return view('WapAdmin.unAssignLockTicket', ['tickets'=>$ticket_list]);
        } else {
            return view('jurisdiction');
        }
    }


    /**
     * 获取值班时间
     * @author JokerLinly
     * @date   2016-09-26
     * @param  Request    $request [description]
     * @return [type]              [description]
     */
    public function getIdle(Request $request)
    {
        $pcer = PcerModule::getIdleToPcer(session('wcuser_id'));
        return View::make('WapAdmin.personData', ['pcer'=>$pcer]);
    }
    /**
     * 编辑注册信息
     * @author JokerLinly
     * @date   2016-09-26
     * @param  Request    $request [description]
     * @return [type]              [description]
     */
    public function getPerson(Request $request)
    {
        $pcer = PcerModule::getPcer('wcuser_id', session('wcuser_id'), ['name', 'school_id', 'pcerlevel_id', 'long_number', 'number', 'department', 'major', 'clazz', 'address', 'area', 'sex', 'nickname']);
        if (!is_array($pcer) && empty($pcer)) {
            return View::make('error');
        }
        $pcerlevel = PcerModule::getLevel();
        if (!is_array($pcerlevel) && empty($pcerlevel)) {
            return View::make('error');
        }
        return view('WapAdmin.setting', ['pcer'=>$pcer, 'pcerLevels'=>$pcerlevel]);
    }
    /**
     * PC仔未完成的任务列表
     * @author JokerLinly
     * @date   2016-09-16
     */
    public function pcerTicketList()
    {
        $wcuser_id = session('wcuser_id');

        $pcer = PcerModule::getPcerByWcuserId($wcuser_id, ['id']);
        if (!empty($pcer) && $pcer['wcuser']['state'] != 0) {
            $ticket_list = TicketModule::getPcerTicketList($pcer['id']);
            return view('WapAdmin.unfinishTicket', ['tickets'=>$ticket_list]);
        } else {
            return view('jurisdiction');
        }
    }
    /**
     * PC仔已完成的任务列表
     * @author JokerLinly
     * @date   2016-09-18
     */
    public function pcerFinishTicketList()
    {
        $wcuser_id = session('wcuser_id');
        $pcer = PcerModule::getPcerByWcuserId($wcuser_id, ['id']);
        if (!empty($pcer) && $pcer['wcuser']['state'] != 0) {
            $ticket_list = TicketModule::getPcerFinishTicketList($pcer['id']);
            return view('WapAdmin.finishTicket', ['tickets'=>$ticket_list]);
        } else {
            return view('jurisdiction');
        }
    }
}
