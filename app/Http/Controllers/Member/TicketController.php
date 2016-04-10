<?php

namespace App\Http\Controllers\Member;
use DB,Redirect, Input,Validator;
use Illuminate\Http\Request;
use \View;
use EasyWeChat;
use App\Wcuser;
use App\Ticket;
use App\Pcer;
use App\Idle;
use App\Comment;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class TicketController extends Controller
{
    public function index($openid)
    {
        $pcer = Wcuser::where('openid',$openid)->with('pcer')->first();
        if ($pcer->state==1) {
            $tickets = Ticket::where('pcer_id',$pcer->pcer->id)
                            ->where('state',1)->get();
            // dd($tickets[0]->pcadmin->pcer->nickname);
            return view('Member.ticketList',['tickets'=>$tickets]);
        } else {
            return view('jurisdiction');
        }
        
    }

    public function getShow($id)
    {
        $ticket = Ticket::where('id',$id)
                           ->with('comment','pcer')->with(['pcadmin'=>function($query){
                                $query->withTrashed()->with('pcer');
                           }])->first();
        // dd($ticket->comment->count());
        return view('Member.ticketData',['ticket'=>$ticket]);

    }

    public function postEdit($id)
    {
        Input::flash();
        $validation = Validator::make(Input::all(),[
                'text' => 'required',
            ]);
        if ($validation->fails()) {
         return Redirect::back()->withInput(Input::all())->withMessage('亲(づ￣3￣)づ╭❤～内容要填写喔！');
        }
        $comment = new Comment;
        $comment->ticket_id = $id;
        $comment->from = Input::get('from');
        $comment->text = Input::get('text');
        $comment->wcuser_id = Input::get('wcuser_id');
        $res = $comment->save();
        if ($res) {
            return Redirect::back();
        } else {
            return Redirect::back()->withInput(Input::all())->with('message', '提交失败，请重新提交');
        }
    }

    public function postUpdate($id)
    {
        $openid = Wcuser::where('id',Input::get('wcuser_id'))->first()->openid;
        $res = Ticket::where('id',$id)->update(['state'=>2]);
        
        if ($res) {
            return Redirect::to('pcertickets/'.$openid.'/index');
        } else {
            return Redirect::back()->with('message', '提交失败，请重新提交');
        }
        
    }
}