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
                        
                        return "hh";
                        break;
                    case 'unsubscribe':
                        # code...
                        break;
                    default:
                        # code...
                        break;
                }
            }elseif ($message->MsgType == 'text') {
                	
                        return "关注标识：{$fromUser->subscribe}  用户的昵称：{$fromUser->nickname}
                        用户的标识：{$fromUser->openid}
                        用户的性别：{$fromUser->sex}
                        用户头像：{$fromUser->headimgurl}
                        用户关注时间：{$fromUser->subscribe_time}
                        备注：{$fromUser->remark}
                        分组ID：{$fromUser->groupid}";

            }
        });

        $response = $server->serve();

        echo $response;

        return  $result;
    }
}
