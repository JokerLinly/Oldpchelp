<?php

namespace App\Http\Controllers\Ticket;
use DB;
use Redirect, Input;
use \View;
use Illuminate\Http\Request;
use App\Wcuser;
use App\Ticket;
use App\Condition;
use App\Pcer;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * 创建维修订单的界面
     *
     * @return \Illuminate\Http\Response
     */
    public function index($openid)
    {
        $wcuser = DB::table('wcusers')->where('openid', $openid)->first();
        if ($wcuser) {
            $headimgurl = $wcuser->headimgurl;
            if (!$headimgurl) {
                $headimgurl = "https://mmbiz.qlogo.cn/mmbiz/OEpqnOUyYjON3G1QjyWTMv6QI4M1fibw3rPIQUEhdb4PkJicibpiaCONRWg8aJw3VW6SWSZibkWCP6EyhiaGMa9wl76Q/0?wx_fmt=jpeg";
            } 
        } else {
            $headimgurl = "https://mmbiz.qlogo.cn/mmbiz/OEpqnOUyYjON3G1QjyWTMv6QI4M1fibw3rPIQUEhdb4PkJicibpiaCONRWg8aJw3VW6SWSZibkWCP6EyhiaGMa9wl76Q/0?wx_fmt=jpeg";
            // return view('welcome');
        }
   
        return View::make('Ticket.home',['headimgurl'=>$headimgurl,'wcuser_id'=>$wcuser->id,'openid'=>$wcuser->openid]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *创建订单
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
   
        $ticket = new Ticket;
        $ticket->wcuser_id = $request->wcuser_id;
        $ticket->name = $request->name;
        $ticket->number = $request->number;
        $ticket->area = $request->area;
        $ticket->address = $request->address;
        $ticket->date = $request->date;
        $ticket->hour = $request->hour;
        $ticket->problem = $request->problem;
        $result = $ticket->save();

        if ($result) {
            $condition = new Condition;
            $condition->ticket_id = $ticket->id;
            $condition->wcuser_id = $request->wcuser_id;
            $res = $condition->save();
            if ($res) {
                return Redirect::to('pchelp/'.$request->wcuser_id.'/ticket/show')->with($request->wcuser_id);
                // $tickets = Ticket::where('wcuser_id',$request->wcuser_id)
                //               ->with('pcer')->get();

                // return view('Ticket.ticketList',compact('tickets'));
            } 
            
        } else {
             return Redirect::back()->withInput()->with('message', '报修失败，请重新报修');
        }     
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id 订单列表
     * @return \Illuminate\Http\Response
     */
    public function show($openid)
    {
        $tickets = Ticket::where('wcuser_id',$openid)
                              ->with('pcer')
                              ->get();
        return view('Ticket.ticketList',compact('tickets'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id 订单详情
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
