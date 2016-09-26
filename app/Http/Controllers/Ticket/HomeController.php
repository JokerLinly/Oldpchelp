<?php

namespace App\Http\Controllers\Ticket;

use Redirect;
use Validator;
use Session;
use \View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use EasyWeChat;
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
        $openid = $request->session()->get('wechat_user')['id'];

        if (!$request->session()->has('wcuser_id')) {
            return Redirect::action('Ticket\HomeController@getWcuserId');
        } else {
            return View::make('Ticket.home');
        }
    }

    /**
     * 获取wcuserid
     * @author JokerLinly
     * @date   2016-09-26
     * @return [type]     [description]
     */
    public function getWcuserId()
    {
        $openid = $request->session()->get('wechat_user')['id'];
    
        $wcuser = WcuserModule::getWcuser('*', $openid);
        if (!empty($wcuser)) {
            $request->session()->put('wcuser_id', $wcuser['id']);
            return Redirect::back();
        } else {
            //在数据库中添加这个用户
            $wcuser = WcuserModule::addWcuser($openid);
            if (!empty($wcuser)) {
                $request->session()->put('wcuser_id', $wcuser['id']);
                return Redirect::back();
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
            return Redirect::action('Ticket\HomeController@getWcuserId');
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

    /**
     * 进入订单更新页
     * @author JokerLinly
     * @date   2016-09-11
     * @param  [type]     $id [description]
     * @return [type]         [description]
     */
    public function updateShow($id)
    {
        $ticket = TicketModule::getTicketById($id);

        return view('Ticket.ticketChange', compact('ticket'));
    }

    /**
     * 用户更新订单内容
     * @author JokerLinly
     * @date   2016-09-11
     * @param  Request    $request [description]
     * @return [type]              [description]
     */
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

        $result = TicketModule::updateTicket($input);
        
        if (!$result) {
            return Redirect::back()->with($input)->withMessage('更新失败！');
        }
        return Redirect::action('Ticket\HomeController@showSingleTicket', array('id' => $input['id']))->withMessage('更新成功！');
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

        $wcuser_id = session('wcuser_id');

        if (empty($wcuser_id) || $wcuser_id < 1) {
            return Redirect::action('Ticket\HomeController@getWcuserId');
        }

        $tickets = TicketModule::searchTicket($wcuser_id);

        return view('Ticket.ticketList', compact('tickets'));
    }

    /**
     * 用户查看单个订单
     * @author JokerLinly
     * @date   2016-08-28
     * @param  [type]     $openid [description]
     * @param  [type]     $id     [description]
     * @return [type]             [description]
     */
    public function showSingleTicket(Request $request, $ticket_id)
    {
        $openid = $request->session()->get('wechat_user')['id'];
        if (empty($openid)) {
            return view('welcome');
        }

        if (empty($ticket_id)||$ticket_id < 1) {
            return Redirect::back()->withMessage('参数异常！');
        }
        //验证用户是否有权限
        $Validates = WcuserModule::checkValidatesByTicket($openid, $ticket_id);
        if (!$Validates) {
            return view('jurisdiction');
        }

        $ticket = TicketModule::getTicketById($ticket_id);

        $comments = TicketModule::getCommentByTicket($ticket_id);
        
        return view('Ticket.ticketData', compact('ticket', 'comments'));
    }

    /**
     * 用户删除订单
     * @author JokerLinly
     * @date   2016-09-23
     * @param  Request    $request [description]
     * @return [type]              [description]
     */
    public function deleteTicket(Request $request)
    {
        $id = $request->id;
        $result = TicketModule::deleteTicket($id);
        if (!$result) {
            return Redirect::back()->withMessage('删除失败！');
        }
        return Redirect::action('Ticket\HomeController@showTickets');
    }
}
