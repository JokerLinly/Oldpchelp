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
        dd($openid);
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

        $messages = [
            'name.required' => '姓名要填写喔！',
            'number.required' => '手机长号要填写喔！',
            'number.digits' => '手机号码的格式不对呢！',
        ];

        $rules = [
            'name' => 'required',
            'number' => 'required|digits:11',
            'address' => 'required',
            'problem' => 'required',
        ];

        $validation = Validator::make($request->all(), $rules, $messages);

        if ($validation->fails()) {
            return Redirect::back()->withInput($request->all())->withMessage($messages);
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
            return Redirect::to('mytickets/'.$openid.'/ticketList')->with(Input::get('wcuser_id'));
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

}
