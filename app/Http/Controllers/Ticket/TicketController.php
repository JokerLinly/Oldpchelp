<?php

namespace App\Http\Controllers\Ticket;

use Illuminate\Http\Request;
use DB;
use Redirect,Session;
use \View;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use EasyWeChat;
use App\modules\module\TicketModule;
use App\modules\module\WcuserModule;

class TicketController extends Controller
{
    /**
     * 订单列表
     * @author JokerLinly
     * @date   2016-08-28
     * @param  [type]     $wcuser_id [description]
     * @return [type]                [description]
     */
    public function index(Request $request)
    {
        if (!$request->session()->has('wcuser_id')) {
            $openid = $request->session()->get('wechat_user')['id'];
            $wcuser = WcuserModule::getWcuser('*',$openid);

            //如果不存在该用户
            if (empty($wcuser)) {
                $wcuser = WcuserModule::addWcuser($openid);
                if(!empty($wcuser)){
                    $request->session()->put('wcuser_id', $wcuser['id']);
                    return Redirect::action('Ticket\HomeController@showTickets'); 
                }
                return View::make('error');
            }

            $wcuser_id = $wcuser['id'];
            $request->session()->put('wcuser_id', $wcuser_id);
        } else {
            $wcuser_id = session('wcuser_id');
        }

        $result = WcuserModule::getWcuserById('state',$wcuser_id);
        if ($result['state'] == 1) {
            return dd('sdfdsfdsf');
        } elseif ($result['state'] ==2) {
            return dd('dsfffffffdsfdsfd');
        }

        return Redirect::action('Ticket\HomeController@showTickets');
    }

    /**
     * 增加评价
     * @author JokerLinly
     * @date   2016-09-08
     * @param  Request    $request [description]
     */
    public function addSuggestion(Request $request)
    {
        $validator_rule = [
            'ticket_id' => 'required|integer|min:1',
            'assess'    => 'required|integer|min:1',
        ];

        $validator = Validator::make($request->Input(), $validator_rule);
        if ($validator->fails()) {
            return Redirect::back()->withMessage('参数错误！');
        }

        $res = TicketModule::addSuggestion($request->Input());

        if (!$res) {
            return Redirect::back()->withMessage('网络问题，提交失败，请重新提交(づ￣ 3￣)づ');
        }
        
        return Redirect::back();
    }

    /**
     * 用户发送催单消息
     * @author JokerLinly
     * @date   2016-09-11
     * @param  Request    $request [description]
     */
    public function addComment(Request $request)
    {
        $validator_rule = [
            'text' => 'required',
        ];

        $validator = Validator::make($request->Input(), $validator_rule);
        if ($validator->fails()) {
            return Redirect::back()->withMessage('要填写才能提交喔！');
        }

        $res = TicketModule::addComment($request->Input());

        if (!$res) {
            return Redirect::back()->withMessage('网络问题，提交失败，请重新提交(づ￣ 3￣)づ');
        }

        return Redirect::back()->withMessage('发送成功！');

    }

}
