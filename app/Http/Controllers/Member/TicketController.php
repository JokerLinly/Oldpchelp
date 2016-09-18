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
    public function PcerTicketList()
    {
        // $wcuser_id = session('wcuser_id');
        // if (empty($wcuser_id)) {
        //     return Redirect::action('Ticket\TicketController@index');
        // }
        $wcuser_id = 37;

        //判断是否存在用户以及有权限查看被分配的订单
        $wcuser = WcuserModule::getWcuserById(['state'],$wcuser_id);
        if (!empty($wcuser) && $wcuser['state'] != 0) {
            $pcer = PcerModule::getPcer('wcuser_id', $wcuser_id, ['id']);
            if (!empty($pcer)) {
                $ticket_list = TicketModule::getPcerTicketList($pcer['id'], 1);
                return view('Member.unfinishTicket',['tickets'=>$ticket_list]);
            } else {
                return view('jurisdiction');
            }
        } else {
            return view('jurisdiction');
        }
    }

    /**
     * PC仔已完成的任务列表
     * @author JokerLinly
     * @date   2016-09-18
     */
    public function PcerUnFinishTicketList()
    {
        // $wcuser_id = session('wcuser_id');
        // if (empty($wcuser_id)) {
        //     return Redirect::action('Ticket\TicketController@index');
        // }
        $wcuser_id = 37;
        //判断是否存在用户以及有权限查看被分配的订单
        $wcuser = WcuserModule::getWcuserById(['state'],$wcuser_id);
        if (!empty($wcuser) && $wcuser['state'] != 0) {
            $pcer = PcerModule::getPcer('wcuser_id', $wcuser_id, ['id']);
            if (!empty($pcer)) {
                $ticket_list = TicketModule::getPcerTicketList($pcer['id'], 2);
                return view('Member.finishTicket',['tickets'=>$ticket_list]);
            } else {
                return view('jurisdiction');
            }
        } else {
            return view('jurisdiction');
        }
    }

    public static function showSingleTicket(Request $request,$ticket_id)
    {
        // $wcuser_id = session('wcuser_id');
        // if (empty($wcuser_id)) {
        //     return Redirect::action('Ticket\TicketController@index');
        // }
        $wcuser_id = 37;
        $wcuser = WcuserModule::getWcuserById(['state'],$wcuser_id);
        if (!empty($wcuser) && $wcuser['state'] != 0) {
            $pcer = PcerModule::getPcer('wcuser_id', $wcuser_id, ['id']);
            if (!empty($pcer)) {
                $ticket = TicketModule::getPcerSingleTicket($pcer['id'],$ticket_id);
                $comments = TicketModule::getCommentByTicket($ticket_id);

                return view('Member.ticketData',['ticket'=>$ticket,'comments'=>$comments]);
            } else {
                return view('jurisdiction');
            }
        } else {
            return view('jurisdiction');
        }

    }

    // public function getShow($openid,$id)
    // {
    //     $pcer = Wcuser::where('openid',$openid)->with('pcer')->first()->pcer->id;
    //     $ticket = Ticket::where('id',$id)
    //                        ->with(['pcer'=>function($query){
    //                             $query->with('wcuser');
    //                        }])
    //                        ->with(['pcadmin'=>function($query){
    //                             $query->withTrashed()->with('pcer');
    //                        }])->first();
    //     if ($ticket) {
    //         if ($pcer==$ticket->pcer_id) {
    //             $comments = Comment::where('ticket_id',$id)
    //                 ->with(['wcuser'=>function($query){
    //                     $query->with('pcer');
    //                 }])->get();
    //             return view('Member.ticketData',['ticket'=>$ticket,'comments'=>$comments]);
    //         } else {
    //            return view('error');
    //         }
    //     } else {
    //         return view('error');
    //     }
    // }

    // public function postEdit($openid,$id)
    // {
    //     $validation = Validator::make(Input::all(),[
    //             'text' => 'required',
    //         ]);
    //     if ($validation->fails()) {
    //      return Redirect::back()->withMessage('亲(づ￣3￣)づ╭❤～内容要填写喔！');
    //     }
    //     $comment = new Comment;
    //     $comment->ticket_id = $id;
    //     $comment->from = Input::get('from');
    //     $comment->text = Input::get('text');
    //     $comment->wcuser_id = Input::get('wcuser_id');
    //     $res = $comment->save();
    //     if ($res) {
    //         if (Input::get('from')==1){
    //         $ticket = Ticket::where('id',$id)->with('pcer','wcuser','pcadmin')->first();
    //         $pcer_id = Pcer::with(['pcadmin'=>function($query)use($ticket){
    //             $query->where('id',$ticket->pcadmin_id);
    //         }])->first()->id;
    //         /*
    //           发送给管理员的模板消息        
    //          */
    //         $notice_user = EasyWeChat::notice();
    //         /*获取订单用户的openid*/
    //         $wcuser_openid = Wcuser::with(['pcer'=>function($query)use($pcer_id){
    //             $query->where('id',$pcer_id);
    //         }])->first()->openid;
    //         $templateId_user = 'tRUGFri43dacM_pRAcpZuJiP86K5B9y2eCFq3jUnItk';
    //           $url_user = "http://pc.nfu.edu.cn/pcadminwc/{$wcuser_openid}/{$ticket->id}/show";
    //           $color = '#FF0000';
    //           $data_user = array(
    //             "first"    => $ticket->pcer->name."给你发来消息！",
    //             "keynote1" => $comment->text,
    //             "keynote2" => "就是现在！",
    //             "remark"  => "请尽快处理！么么哒(づ￣ 3￣)づ",
    //           );

    //         $messageId = $notice_user->uses($templateId_user)->withUrl($url_user)->andData($data_user)->andReceiver($wcuser_openid)->send();
    //         } 
            
    //         return Redirect::back();
    //     } else {
    //         return Redirect::back()->with('message', '提交失败，请重新提交');
    //     }
    // }

    // public function postUpdate($openid,$id)
    // {
    //     $openid = Wcuser::where('id',Input::get('wcuser_id'))->first()->openid;
    //     $res = Ticket::where('id',$id)->update(['state'=>2]);
    //     $ticket = Ticket::where('id',$id)->with('wcuser')->first();
    //     if ($res) {
    //         /*
    //             发送给用户的模板消息        
    //         */
    //         $notice_user = EasyWeChat::notice();
    //         /*获取订单用户的openid*/
    //         $wcuser_openid = Ticket::where('id',$id)->with('wcuser')->first()->wcuser->openid;
    //         $templateId_user = 'F5l3jp_6XjS3R9tnh15-wHprHyrfXnHVl1QEdqNeIcE';
    //         $url_user = "http://pc.nfu.edu.cn/mytickets/{$wcuser_openid}/{$id}/show";
    //         $color = '#FF0000';
    //         $data_user = array(
    //             "first" => "亲，感谢您对PC服务队的支持!",
    //             "keynote1" => "PC仔已经结束订单",
    //             "keynote2" => $ticket->update_time,
    //             "remark"  => "点击详情可以对PC仔的服务进行评价喔！",
    //         );

    //         $messageId = $notice_user->uses($templateId_user)->withUrl($url_user)->andData($data_user)->andReceiver($wcuser_openid)->send();

    //         return Redirect::to('pcertickets/'.$openid.'/main');
    //     } else {
    //         return Redirect::back()->with('message', '提交失败，请重新提交');
    //     }
        
    // }

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