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
        $data = $request->session()->all();
        // 未登录
        if (empty($_SESSION['wechat_user'])) {

          $_SESSION['target_url'] = 'test';

          // return $oauth->redirect();
          // 这里不一定是return，如果你的框架action不是返回内容的话你就得使用
          $oauth->redirect()->send();
        }

        dd($_SESSION['wechat_user']);
        // 已经登录过
        $user = $_SESSION['wechat_user'];

    }

    public function redirectBack(Application $app){
        $oauth = $app->oauth;

        // 获取 OAuth 授权结果用户信息
        $user = $oauth->user();
        $_SESSION['wechat_user'] = $user->toArray();

        $targetUrl = empty($_SESSION['target_url']) ? '/test' : $_SESSION['target_url'];
        header('location:'. $targetUrl); // 跳转到 user/profile
    }


}
