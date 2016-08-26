<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use EasyWeChat\Foundation\Application;
use Redirect,Input, Auth;
use App\Http\Controllers\Ticket;
use EasyWeChat;

class TestController extends Controller {

    public function index(Application $app,Request $request)
   {
        $oauth = $app->oauth;
        // 未登录
        if (empty($_SESSION['wechat_user']) && !$request->has('code')) {
          return $oauth->redirect();
        }

        $user = $oauth->user();
        $openid = $user->getId();
        $_SESSION['wechat_user'] = $user->toArray();
                
        return Redirect::action('Ticket\HomeController@index',array('openid'=>$openid));
    }

}
