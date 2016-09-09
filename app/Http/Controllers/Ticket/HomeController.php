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
    public function index(Request $request)
    {
        $openid = $request->openid;
        if (empty($openid)) {
            return ErrorMessage::getMessage(10000);
        }

        $wcuser = WcuserModule::getWcuser('*',$openid);
        if (!empty($wcuser)) {
            $request->session()->put('wcuser_id', $wcuser['id']);
            return View::make('Ticket.home');
        } else {
            //在数据库中添加这个用户
            $wcuser = WcuserModule::addWcuser($openid);
            if(!empty($wcuser)){
                $request->session()->put('wcuser_id', $wcuser['id']);
                return View::make('Ticket.home');    
            }
            return View::make('error');
        }
    }

    /**
     * 创建订单
     * @author JokerLinly
     * @date   2016-08-29
     * @param  Request    $request [description]
     * @return [type]              [description]
     */
    public function create(Request $request)
    {
        $request->flash();
        if (!$request->session()->has('wcuser_id')) {
            return view('error');
        }
        $input = $request->all();

        $rules = [
            'name' => 'required',
            'number' => 'required|digits:11',
            'address' => 'required',
            'problem' => 'required',
        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return Redirect::back()->withInput($input)->withMessage('请检查您填入数据的内容！');
        }
        $input['wcuser_id'] = session('wcuser_id');
        $result = TicketModule::addTicket($input);
        if (!is_array($result)) {
            return Redirect::action('Ticket\HomeController@showTickets');
        } else {
            return Redirect::back()->withInput()->with('message', '报修失败，请重新报修');
        }     
    }

    public function updateShow($id)
    {
        $ticket = TicketModule::getTicketById($id);

        return view('Ticket.ticketChange',compact('ticket'));
    }

    public function update(Request $request)
    {
        $input = $request->input();
        $rules = [
            'name' => 'required',
            'number' => 'required|digits:11',
            'address' => 'required',
            'problem' => 'required',
        ];

        $validation = Validator::make($input, $rules);

        if ($validation->fails()) {
            return Redirect::back()->with($input)->withMessage('请检查您填入数据的内容！');
        }
        // $input['wcuser_id'] = session('wcuser_id');
        $result = TicketModule::updateTicket($input);
        


    }
    /**
     * 订单列表
     * @author JokerLinly
     * @date   2016-08-28
     * @param  [type]     $wcuser_id [description]
     * @return [type]                [description]
     */
    public function showTickets(Request $request)
    {
        $openid = $request->session()->get('wechat_user')['id'];
        if (empty($openid)) {
            return view('welcome');
        }

        if (!$request->session()->has('wcuser_id')) {
            return view('error');
        }

        $wcuser_id = session('wcuser_id');

        if (empty($wcuser_id) || $wcuser_id < 1) {
            return ErrorMessage::getMessage(10000);
        }
        //验证用户是否有权限
        $Validates = WcuserModule::checkValidates($openid,$wcuser_id);
        if (!$Validates) {
            return view('jurisdiction');
        }

        $tickets = TicketModule::searchTicket($wcuser_id);

        return view('Ticket.ticketList',compact('tickets'));
    }

    /**
     * 用户查看单个订单
     * @author JokerLinly
     * @date   2016-08-28
     * @param  [type]     $openid [description]
     * @param  [type]     $id     [description]
     * @return [type]             [description]
     */
    public function showSingleTicket(Request $request,$ticket_id)
    {
        $openid = $request->session()->get('wechat_user')['id'];
        if (empty($openid)) {
            return view('welcome');
        }

        if (empty($ticket_id)||$ticket_id < 1 ) {
            return Redirect::back()->withMessage('参数异常！');
        }
        //验证用户是否有权限
        $Validates = WcuserModule::checkValidatesByTicket($openid,$ticket_id);
        if (!$Validates) {
            return view('jurisdiction');
        }

        $ticket = TicketModule::getTicketById($ticket_id);

        $comments = TicketModule::getCommentByTicket($ticket_id);
        
        return view('Ticket.ticketData',compact('ticket','comments'));
        
    }

}
