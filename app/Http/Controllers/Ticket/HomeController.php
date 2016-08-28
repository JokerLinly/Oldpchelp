<?php

namespace App\Http\Controllers\Ticket;


use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Redirect;
use \View;
use EasyWeChat\Foundation\Application;
use Validator;
use EasyWeChat;
use ErrorMessage;
use App\modules\module\WcuserModule;
use App\modules\module\TicketModule;

class HomeController extends Controller
{
    /**
     * 进入报修订单页面
     * @author JokerLinly
     * @date   2016-08-26
     * @param  Request    $request [description]
     * @return [type]              [description]
     */
    public function index(Request $request,Application $app)
    {
        $openid = $request->openid;
        if (empty($openid)) {
            return ErrorMessage::getMessage(10000);
        }

        $userService = $app->user;
        $wechatUser = $userService->get($openid);
        $wcuser = WcuserModule::getWcuser('*',$openid);
        if (!empty($wcuser)) {
            $headimgurl = $wechatUser->headimgurl;
            if (!$headimgurl) {
                $headimgurl = "https://mmbiz.qlogo.cn/mmbiz/OEpqnOUyYjON3G1QjyWTMv6QI4M1fibw3rPIQUEhdb4PkJicibpiaCONRWg8aJw3VW6SWSZibkWCP6EyhiaGMa9wl76Q/0?wx_fmt=jpeg";
            } 
            return View::make('Ticket.home',['headimgurl'=>$headimgurl,'wcuser_id'=>$wcuser->id,'openid'=>$wcuser->openid]);
        } else {
            return view('welcome');
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
    public function store(Request $request)
    {
        $request->flash();

        $rules = [
            'name' => 'required',
            'number' => 'required|digits:11',
            'address' => 'required',
            'problem' => 'required',
        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return Redirect::back()->withInput($request->all())->withMessage('请检查您填入数据的内容！');
        }

        $ticket = array();
        $ticket['wcuser_id'] = $request->input('wcuser_id');
        $ticket['name']      = $request->input('name');
        $ticket['number']    = $request->input('number');
        $ticket['shortnum']  = $request->input('shortnum');
        $ticket['area']      = $request->input('area');
        $ticket['address']   = $request->input('address');
        $ticket['date']      = $request->input('date');
        $ticket['hour']      = $request->input('hour');
        $ticket['problem']   = $request->input('problem');
        if ($request->input('date1')) {
            $ticket['date1'] = $request->input('date1');
            $ticket['hour1'] = $request->input('hour1');
        }
        $result = TicketModule::addTicket($ticket);
        if (!is_array($result) && empty($result['err_code'])) {
/*             发送模板消息            
            $notice = EasyWeChat::notice();
            $templateId = 'PWy2hjgvT5g6mOfB8i1iPy02zkz1O7e7Q70dTtRahdc';
            $url = "http://120.27.104.83/mytickets/{$ticket->id}/show";
            $color = '#FF0000';
            $data = array(
                "problem" => $ticket->problem,
                "remark"  => "点击查看详情",
            );
            $messageId = $notice->uses($templateId)->withUrl($url)->andData($data)->andReceiver($openid)->send();*/
            return Redirect::action('Ticket\HomeController@show',array('wcuser_id'=>$request->input('wcuser_id')));
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

    public function show($wcuser_id)
    {
        dd($wcuser_id);
        $tickets = Ticket::where('wcuser_id',$wcuser_id)
                              ->with('pcer')
                              ->get();
        return view('Ticket.ticketList',compact('tickets'));
    }

}
