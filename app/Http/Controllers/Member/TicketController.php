<?php

namespace App\Http\Controllers\Member;

use Redirect,Validator,Session,\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\modules\module\TicketModule;
use App\modules\module\WcuserModule;
use App\modules\module\PcerModule;

class TicketController extends Controller
{
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
            return view('Member.unfinishTicket', ['tickets'=>$ticket_list]);
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
            return view('Member.finishTicket', ['tickets'=>$ticket_list]);
        } else {
            return view('jurisdiction');
        }
    }

    /**
     * PC仔查看单个订单
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
        if (!empty($wcuser) && $wcuser['state'] != 0) {
            $pcer = PcerModule::getPcer('wcuser_id', $wcuser_id, ['id']);
            if (!empty($pcer)) {
                $comments = TicketModule::getCommentByTicket($ticket_id);
                if ($wcuser['state'] == 1) {
                    $ticket = TicketModule::getPcerSingleTicket($pcer['id'], $ticket_id);
                    if (empty($ticket) && !is_array($ticket)) {
                        return view('jurisdiction');
                    }
                    return view('Member.ticketData', ['ticket'=>$ticket,'comments'=>$comments]);
                } else {
                    return view('Admin.ticketData', ['ticket'=>$ticket,'comments'=>$comments]);
                }
            } else {
                return view('jurisdiction');
            }
        } else {
            return view('jurisdiction');
        }
    }

    /**
     * PC仔发送模板消息
     * @author JokerLinly
     * @date   2016-09-23
     * @param  Request    $request [description]
     * @return [type]              [description]
     */
    public function pcerAddComment(Request $request)
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

        $res = TicketModule::pcerAddComment($request->Input());

        if (!$res) {
            return Redirect::back()->withMessage('网络问题，提交失败，请重新提交(づ￣ 3￣)づ');
        }

        return Redirect::back()->withMessage('发送成功！');
    }

    /**
     * PC仔结束订单
     * @author JokerLinly
     * @date   2016-09-23
     * @param  Request    $request [description]
     * @return [type]              [description]
     */
    public function pcerDelTicket(Request $request)
    {
        $wcuser_id = session('wcuser_id');
        $wcuser = WcuserModule::getPcerIdByWcuserId($wcuser_id);
        $input = $request->Input();
        $input['pcer_id'] = $wcuser['pcer']['id'];
        if (empty($input['ticket_id']) || $input['ticket_id'] < 1) {
            return Redirect::back()->withMessage('数据异常！');
        }
        $result = TicketModule::pcerDelTicket($input);
        if (!$result) {
            return Redirect::back()->withMessage('删除失败！');
        }
        return Redirect::action('Member\TicketController@pcerTicketList');
    }

    // public function listory($openid)
    // {
    //     $pcer = Wcuser::where('openid',$openid)->with('pcer')->first();
    //     if ($pcer) {
    //         if ($pcer->state==1||$pcer->state==2) {
    //         $tickets = Ticket::where('pcer_id',$pcer->pcer->id)
    //                         ->where('state',2)->whereNotNull('pcadmin_id')->orderBy('state','ASC')->get();
    //             return view('Member.ticketList',['tickets'=>$tickets,'openid'=>$openid]);
    //         }else {
    //             return view('jurisdiction');
    //         }
    //     } else {
    //         return view('jurisdiction');
    //     }
    // }
}
