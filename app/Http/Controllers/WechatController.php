<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use EasyWeChat\Foundation\Application;
use EasyWeChat\Message\Text;
use Redirect, Input, Auth;
use App\Wcuser;
use App\Rely;
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
            $result = Wcuser::where('openid', $fromUser->openid)->first();//判断是否存在用户
            $SubscribeRely = Rely::where('state',0);
            $AlltextRely = Rely::where('state',1);
            if ($message->MsgType == 'event') {
                switch ($message->Event) {
                    case 'subscribe':
                        if ($result) {
                            Wcuser::where('openid',$fromUser->openid)->update(['subscribe'=>$fromUser->subscribe],['nickname'=>$fromUser->nickname]);//找出存在用户的数据
                            
                                return $SubscribeRely->answer;
                           
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
                                return $SubscribeRely->answer;
                            } else {
                                return "夸我一下嘛！";
                            }                    
                        }             
                        break;
                    case 'unsubscribe':
                        Wcuser::where('openid',$fromUser->openid)->update(['subscribe'=> 0]);                    
                        break;
                    default:
                        # code...
                        break;
                }
            }elseif ($message->MsgType == 'text') {
                
                if ($result) {
                    return $AlltextRely->answer;
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
                        return $AlltextRely->answer;
                    } else {
                        return "你说什么？";
                    }                    
                }
            }
        });

        $response = $server->serve();

        return  $response;
    }
}
