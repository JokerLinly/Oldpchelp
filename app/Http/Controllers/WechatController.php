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
            $SubscribeRely = Rely::where('state',0)->first();
            $AlltextRely = Rely::where('state',1)->first();
            if ($message->MsgType == 'event') {
                switch ($message->Event) {
                    case 'subscribe':
                        if ($result) {
                            Wcuser::where('openid',$fromUser->openid)->update(['subscribe'=>$fromUser->subscribe],['nickname'=>$fromUser->nickname],['remark'=>$fromUser->remark],['groupid'=>$fromUser->remark],['sex'=>$fromUser->sex],['headimgurl'=>$fromUser->headimgurl]);//找出存在用户的数据
                            if ($SubscribeRely) {
                                return $SubscribeRely->answer;
                            } else {
                                return "嗨！{$fromUser->nickname}！你好！这里是傲娇骏测试号！请根据需求操作后截图给骏哥哥！谢谢帮忙！O(∩_∩)O哈哈~";
                            }
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
                                if ($SubscribeRely) {
                                    return $SubscribeRely->answer;
                                } else {
                                    return "嗨！{$fromUser->nickname}！你好！这里是傲娇骏测试号！请根据需求操作后截图给骏哥哥！谢谢帮忙！O(∩_∩)O哈哈~";
                                }
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
                switch ($message->Content) {
                    case '白痴':
                        return "笨蛋";

                        break;

                    default:
                        if ($result) {
                            if ($AlltextRely) return $AlltextRely->answer;
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
                                if ($AlltextRely) return $AlltextRely->answer;
                            } else {
                                return "你说什么？";
                            }                    
                        }
                        break;
                }
            }
        });

        $response = $server->serve();

        return  $response;
    }
}
