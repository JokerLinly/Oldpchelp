<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use EasyWeChat\Foundation\Application;
use EasyWeChat\Message\Text;
use Redirect, Input, Auth;
use App\Wcuser;
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

        $wcuser = new Wcuser;
        // $result = Wcuser::where('openid', "od2TLjpXQWy8OnA5Ij4XPW0h5Iig")->first();
        // echo $result->nickname;
        $server->setMessageHandler(function($message)use ($user,$wcuser) {
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
                $result = Wcuser::where('openid', $fromUser->openid)->first();
                if ($result) {
                    return "{$result->nickname}已存在用户";
                } else {
                    $wcuser->openid = $fromUser->openid;
                    $wcuser->nickname = $fromUser->nickname;
                    $wcuser->remark = $fromUser->remark;
                    $wcuser->groupid = $fromUser->groupid;
                    $wcuser->headimgurl = $fromUser->headimgurl;
                    $wcuser->sex = $fromUser->sex;
                    $wcuser->subscribe = $fromUser->subscribe;     
                    $jieguo = $wcuser->save();
                    if ($jieguo) {
                        return "添加成功";
                    } else {
                        return "添加失败";
                    }                    
                }
            }
        });

        $response = $server->serve();

        return  $response;
    }
}
