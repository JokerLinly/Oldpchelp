<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use EasyWeChat\Foundation\Application;
use Redirect,Input, Auth;
use App\Wcuser;
use App\Rely;
use App\Chat;
use Log;
use EasyWeChat\Message\Text;
use EasyWeChat\Message\News;

class WechatController extends Controller {

    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function serve(Application $app)
    {
        $server = $app->server;
        $user = $app->user;

        $wcuser = new Wcuser;

        $chat = new Chat;

        $server->setMessageHandler(function($message){
            return "欢迎关注 overtrue！";
        });


        $response = $server->serve();

        return  $response;
    }
}
