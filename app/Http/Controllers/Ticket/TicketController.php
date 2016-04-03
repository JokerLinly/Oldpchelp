<?php

namespace App\Http\Controllers\Ticket;

use Illuminate\Http\Request;
use DB;
use Redirect, Input,Session;
use \View;
use App\Ticket;
use App\Wcuser;
use App\Comment;
use App\Pcer;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;

class TicketController extends Controller
{
    public function index($openid){

        $wcuser_id = Wcuser::where('openid',$openid)->first()->id;
        $tickets = Ticket::where('wcuser_id',$wcuser_id)
                              ->with('pcer')->orderBy('created_at','DESC')->get();
        return view('Ticket.ticketList',compact('tickets'));
    }


    public function show($id)
    {

        $ticket = Ticket::where('id',$id)
                              ->with('pcer')->first();

        $comments = Comment::where('ticket_id',$id)
                        ->with(['wcuser'=>function($query){
                            $query->with('pcer');
                        }])->get();
            
    
        return view('Ticket.ticketData',compact('ticket','comments'));
    }

    public function edit()
    {
        Input::flash();
        $ticket_id = Input::get('ticket_id');
        $temp_url = "http://120.27.104.83/mytickets/{$ticket_id}/show";
        $validation = Validator::make(Input::all(),[
                'text' => 'required',
            ]);
        if ($validation->fails()) {
         return Redirect::to($temp_url)->withInput(Input::all())->withMessage('亲(づ￣3￣)づ╭❤～内容要填写喔！');
        }
            $comment = new Comment;
            $comment->ticket_id = Input::get('ticket_id');
            $comment->from = Input::get('from');
            $comment->wcuser_id = Input::get('wcuser_id');
            $comment->text = Input::get('text');
            $res = $comment->save();
            if ($res) {
                return Redirect::to($temp_url);
            } else {
                return Redirect::to($temp_url)->withInput(Input::all())->withMessage(['test'=>'网络问题，提交失败，请重新提交(づ￣ 3￣)づ']);
            }  
    }

    public function update()
    {

        $res = Ticket::where('id',Input::get('ticket_id'))
              ->update(['assess'=>Input::get('assess'),'suggestion'=>Input::get('suggestion')]);

        if ($res) {
            return Redirect::back();
        } else {
             return Redirect::back()->withInput()->withMessage('网络问题，提交失败，请重新提交(づ￣ 3￣)づ');
        }
        
    }

    public function delticket($id)
    {
        $openid = Wcuser::where('id',Input::get('wcuser_id'))->first()->openid;
        $res = Ticket::where('id',$id)->delete();
        if ($res) {
            return Redirect::to('mytickets/'.$openid.'/ticketList');
        } else {
            return Redirect::back()->withInput()->withMessage('网络问题，提交失败，请重新提交(づ￣ 3￣)づ');
        }
    }

}
