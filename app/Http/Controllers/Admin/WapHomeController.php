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
        return view('WapAdmin.index');
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
        // $wcuser_id = session('wcuser_id');
        $wcuser_id = 2;
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
                return view('WapAdmin.ticketData', ['ticket'=>$ticket,'comments'=>$comments, 'pcers'=>$pcers]);
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
        //拿到pc仔的信息，注册进去票单里面
        //发送消息模板提醒pc仔
        
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
        //把该管理员的id注册进票单里面
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
        //把state改成4 然后发送模板消息给机主
        $ticket_id = $request->ticket_id;
        // $wcuser_id = session('wcuser_id');
        $wcuser_id = 2;
        $pcadmin = WcuserModule::getPcAdminIdByWcuserId($wcuser_id);
        if (empty($ticket_id) || $ticket_id < 1) {
            return Redirect::back()->withMessage('数据异常！');
        }

        if (empty($pcadmin) || $pcadmin < 1) {
            return Redirect::back()->withMessage('数据异常！');
        }

        $result = TicketModule::pcadminCloseTicket($pcadmin, $ticket_id);
        if (!$result) {
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
    public function pcadminAddComment(Request $request)
    {
        //跟pc仔发送消息差不多
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
