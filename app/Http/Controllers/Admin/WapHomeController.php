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
     * 进入分机单-全部未分配
     * @author JokerLinly
     * @date   2016-09-27
     * @return [type]     [description]
     */
    public function getAllTackTicket()
    {
        // $wcuser_id = session('wcuser_id');
        $wcuser_id = 2;
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
        // $wcuser_id = session('wcuser_id');
        $wcuser_id = 2;
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
        // $wcuser_id = session('wcuser_id');
        $wcuser_id = 2;
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
        // $wcuser_id = session('wcuser_id');
        $wcuser_id = 2;
        $pcer = PcerModule::getPcer('wcuser_id', $wcuser_id, ['id']);
        if (!empty($pcer) && $pcer['wcuser']['state'] == 2) {
            $ticket_list = TicketModule::getUnAssignLockTickets($wcuser_id);
            return view('WapAdmin.unAssignLockTicket', ['tickets'=>$ticket_list]);
        } else {
            return view('jurisdiction');
        }
    }


}
