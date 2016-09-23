<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use EasyWeChat\Foundation\Application;
use Redirect,Input, Auth;
use EasyWeChat;
use App\modules\module\WcuserModule;
use App\Http\Controllers\WechatController;

class TestController extends Controller {

    public function index()
   {

        return Redirect::action('Member\TicketController@pcerTicketList');
    }

}
