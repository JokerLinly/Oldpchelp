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

            if ($message->MsgType == 'event') {
                switch ($message->Event) {
                    case 'subscribe':
                        if ($result) {
                            Wcuser::where('openid',$fromUser->openid)->update(['subscribe'=>$fromUser->subscribe],['nickname'=>$fromUser->nickname]);//找出存在用户的数据
                
                                return "更新失败";
                           
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
