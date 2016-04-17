<?php

namespace App\Http\Controllers\Member;
use DB,Redirect, Input,Validator;
use Illuminate\Http\Request;
use \View;
use EasyWeChat;
use App\Wcuser;
use App\Ticket;
use App\Pcer;
use App\Pcadmin;
use App\Idle;
use App\Comment;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class TicketController extends Controller
{
    public function main($openid)
    {
        $pcer = Wcuser::where('openid',$openid)->with('pcer')->first();
        if ($pcer) {
            if ($pcer->state==1||$pcer->state==2) {
            $tickets = Ticket::where('pcer_id',$pcer->pcer->id)
                            ->where('state',1)->whereNotNull('pcadmin_id')->get();
                return view('Member.ticketList',['tickets'=>$tickets,'openid'=>$openid]);
            }else {
                return view('jurisdiction');
            }
        } else {
            return view('jurisdiction');
        }    
    }

    public function getShow($openid,$id)
    {
        $pcer = Wcuser::where('openid',$openid)->with('pcer')->first()->pcer->id;
        $ticket = Ticket::where('id',$id)
                           ->with('comment','pcer')->with(['pcadmin'=>function($query){
                                $query->withTrashed()->with('pcer');
                           }])->first();
        if ($ticket) {
            if ($pcer==$ticket->pcer_id) {
               return view('Member.ticketData',['ticket'=>$ticket]);
            } else {
               return view('error');
            }
        } else {
            return view('error');
        }
    }

    public function postEdit($openid,$id)
    {
        $validation = Validator::make(Input::all(),[
                'text' => 'required',
            ]);
        if ($validation->fails()) {
         return Redirect::back()->withMessage('亲(づ￣3￣)づ╭❤～内容要填写喔！');
        }
        $comment = new Comment;
        $comment->ticket_id = $id;
        $comment->from = Input::get('from');
        $comment->text = Input::get('text');
        $comment->wcuser_id = Input::get('wcuser_id');
        $res = $comment->save();
        if ($res) {
            if (Input::get('from')==1){
            $ticket = Ticket::where('id',$id)->with('pcer','wcuser','pcadmin')->first();
            $pcer_id = Pcer::with(['pcadmin'=>function($query)use($ticket){
                $query->where('id',$ticket->pcadmin_id);
            }])->first()->id;
            /*
              发送给管理员的模板消息        
             */
            $notice_user = EasyWeChat::notice();
            /*获取订单用户的openid*/
            $wcuser_openid = Wcuser::with(['pcer'=>function($query)use($pcer_id){
                $query->where('id',$pcer_id);
            }])->first()->openid;
            $templateId_user = 'tRUGFri43dacM_pRAcpZuJiP86K5B9y2eCFq3jUnItk';
              $url_user = "http://pc.nfu.edu.cn/pcadminwc/{$wcuser_openid}/{$ticket->id}/show";
              $color = '#FF0000';
              $data_user = array(
                "first"    => $ticket->pcer->name."给你发来消息！",
                "keynote1" => $comment->text,
                "keynote2" => "就是现在！",
                "remark"  => "请尽快处理！么么哒(づ￣ 3￣)づ",
              );

            $messageId = $notice_user->uses($templateId_user)->withUrl($url_user)->andData($data_user)->andReceiver($wcuser_openid)->send();
            } 
            
            return Redirect::back();
        } else {
            return Redirect::back()->with('message', '提交失败，请重新提交');
        }
    }

    public function postUpdate($openid,$id)
    {
        $openid = Wcuser::where('id',Input::get('wcuser_id'))->first()->openid;
        $res = Ticket::where('id',$id)->update(['state'=>2]);
        
        if ($res) {
            return Redirect::to('pcertickets/'.$openid.'/index');
        } else {
            return Redirect::back()->with('message', '提交失败，请重新提交');
        }
        
    }

    public function listory($openid)
    {
        $pcer = Wcuser::where('openid',$openid)->with('pcer')->first();
        if ($pcer) {
            if ($pcer->state==1||$pcer->state==2) {
            $tickets = Ticket::where('pcer_id',$pcer->pcer->id)
                            ->where('state',2)->whereNotNull('pcadmin_id')->get();
                return view('Member.ticketList',['tickets'=>$tickets,'openid'=>$openid]);
            }else {
                return view('jurisdiction');
            }
        } else {
            return view('jurisdiction');
        }
    }
}