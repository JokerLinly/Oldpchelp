<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use EasyWeChat\Foundation\Application;
use Redirect,Input, Auth;

use EasyWeChat;

class TestController extends Controller {

    public function index(Application $app,Request $request)
   {
        $oauth = $app->oauth;
        // 未登录
        if (empty($_SESSION['wechat_user']) && !$request->has('code')) {
          return $oauth->redirect();
          // 这里不一定是return，如果你的框架action不是返回内容的话你就得使用
          // $oauth->redirect()->send();
        }

        $user = $oauth->user();
        dd($user->toArray());

        $openid = $user->getId();
        $_SESSION['wechat_user'] = $user->toArray();
        

        // 已经登录过
        $user = $_SESSION['wechat_user'];
        dd($openid);
    }

}
