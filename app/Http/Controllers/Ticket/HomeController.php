<?php

namespace App\Http\Controllers\Ticket;
use DB;
use Redirect, Input;
use \View;
use Illuminate\Http\Request;
use App\Wcuser;
use App\Ticket;
use App\Pcer;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use EasyWeChat;

class HomeController extends Controller
{
    /**
     * 创建维修订单的界面
     *
     * @return \Illuminate\Http\Response
     */
    public function index($openid)
    {
        $userService  = EasyWeChat::user(); 
        $wechatUser = $userService->get($openid);

        $wcuser = DB::table('wcusers')->where('openid', $openid)->first();
        if ($wcuser) {
            if ($wcuser->state==0) {
                if ($wcuser) {
                    $headimgurl = $wechatUser->headimgurl;
                    if (!$headimgurl) {
                        $headimgurl = "https://mmbiz.qlogo.cn/mmbiz/OEpqnOUyYjON3G1QjyWTMv6QI4M1fibw3rPIQUEhdb4PkJicibpiaCONRWg8aJw3VW6SWSZibkWCP6EyhiaGMa9wl76Q/0?wx_fmt=jpeg";
                    } 
                } else {
                    return view('welcome');
                }

                return View::make('Ticket.home',['headimgurl'=>$headimgurl,'wcuser_id'=>$wcuser->id,'openid'=>$wcuser->openid]);
            } else {
                return "该链接无效。";
            }
            
        } else {
            return "请回复微信报修";
        }
        
        
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
    public function store()
    {
        $validation = Validator::make(Input::all(),[
                'name' => 'required',
                'number' => 'required',
                'address' => 'required',
                'problem' => 'required',
            ]);
        if ($validation->fails()) {
         return Redirect::back()->withInput()->withErrors('亲(づ￣3￣)づ╭❤～内容要填写喔！');
        }
        $ticket = new Ticket;
        $ticket->wcuser_id = Input::get('wcuser_id');
        $ticket->name = Input::get('name');
        $ticket->number = Input::get('number');
        $ticket->shortnum = Input::get('shortnum');
        $ticket->area = Input::get('area');
        $ticket->address = Input::get('address');
        $ticket->date = Input::get('date');
        $ticket->hour = Input::get('hour');
        $ticket->problem = Input::get('problem');
        if (Input::get('date1')) {
            $ticket->date1 = Input::get('date1');
            $ticket->hour1 = Input::get('hour1');
        }        

        $result = $ticket->save();

        if ($result) {
            return Redirect::to('pchelp/'.Input::get('wcuser_id').'/ticket/show')->with(Input::get('wcuser_id'));
        } else {
             return Redirect::back()->withInput()->with('errors', '报修失败，请重新报修');
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
