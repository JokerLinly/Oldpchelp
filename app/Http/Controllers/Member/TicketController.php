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
            return view('welcome');
        }
        
    }
}