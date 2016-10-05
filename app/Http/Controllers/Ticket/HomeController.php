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
    public function index()
    {
        return View::make('Ticket.home');
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
        $ticket = TicketModule::getTicketById($id, session('wcuser_id'));
        if (empty($ticket) && !is_array($ticket)) {
            return view('jurisdiction');
        }

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
        $wcuser_id = session('wcuser_id');

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
        $wcuser_id = session('wcuser_id');
        if (empty($ticket_id)||$ticket_id < 1) {
            return Redirect::back()->withMessage('参数异常！');
        }
        $is_exist = TicketModule::verifyUserSingleTicket($wcuser_id, $ticket_id);
        if (empty($is_exist)) {
            return view('jurisdiction');
        }
        $ticket = TicketModule::getTicketById($ticket_id, $wcuser_id);
        if (empty($ticket) && !is_array($ticket)) {
            return view('jurisdiction');
        }

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
