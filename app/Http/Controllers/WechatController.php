<?php namespace App\Http\Controllers;

use EasyWeChat\Foundation\Application;
use EasyWeChat\Message\Text;
use Log;

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
        
        $server->setMessageHandler(function($message)use ($user) {
            $fromUser = $user->get($message->FromUserName);

            if ($message->MsgType == 'event') {
                # code...
                switch ($message->Event) {
                    case 'subscribe':
                        
                        return " {$fromUser->nickname}您好！欢迎关注 overtrue!";
                        break;
                    case 'unsubscribe':
                        # code...
                        break;
                    default:
                        # code...
                        break;
                }
            }elseif ($message->MsgType == 'text') {
                # code...
            }
        });

        $response = $server->serve();

        echo $response;

        return  $result;
    }
}