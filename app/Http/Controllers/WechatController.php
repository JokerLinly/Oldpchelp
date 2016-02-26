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


        $server->setMessageHandler(function($message)use ($user,$wcuser,$chat) {
            $fromUser = $user->get($message->FromUserName);//获取用户信息

            $result = Wcuser::where('openid', $fromUser->openid)->first();//获取用户在数据库中的属性
            
            $SubscribeRely = Rely::where('state',0)->first();//获取关注时自动回复的内容
            
            $AlltextRely = Rely::where('state',1)->first();//获取用户发送消息时自动回复的内容
            
            /*判断用户是否存在数据库*/
            while (!$result) {
                $wcuser->openid = $fromUser->openid;
                $wcuser->nickname = $fromUser->nickname;
                $wcuser->remark = $fromUser->remark;
                $wcuser->groupid = $fromUser->groupid;
                $wcuser->headimgurl = $fromUser->headimgurl;
                $wcuser->sex = $fromUser->sex;
                $wcuser->subscribe = $fromUser->subscribe;     
                $wcuser->save();
                $result = Wcuser::where('openid', $fromUser->openid)->first();
            }

            while($result->subscribe ==0) {
                Wcuser::where('openid',$fromUser->openid)->update(['subscribe'=> 1]);
                $result = Wcuser::where('openid', $fromUser->openid)->first();
            }

            if ($message->MsgType == 'event') {
                switch ($message->Event) {

                    //判断是否设置了关注自动回复
                    case 'subscribe':
                        if ($SubscribeRely) {
                            return $SubscribeRely->answer;
                        } else {
                            return "嗨！{$fromUser->nickname}！你好！这里是傲娇骏测试号！请根据需求操作后截图给骏哥哥！谢谢帮忙！O(∩_∩)O哈哈~";
                        }
                        break;

                    //用户取消关注时
                    case 'unsubscribe':
                        Wcuser::where('openid',$fromUser->openid)->update(['subscribe'=> 0]);                   
                        break;
                    
                    default:
                        # code...
                        break;
                }
            }elseif ($message->MsgType == 'text') {
                $chat->wcuser_id = $result->id;
                $chat->content = $message->Content;
                $chat->save();
                switch ($message->Content) {
                    case '白痴':
                        return "笨蛋";
                        break;

                    case '哈哈':
                        return Redirect::route('admin.main');
                        break;

                    case '微信报修':

                        if ($result->state == 0) {
                            //这是普通用户
                            $news1 = new News([
                                'title'       => 'PC服务队微信报修平台',
                                'description' => 'PC服务队微信报修平台',
                                'url'         => 'http://120.27.104.83/pchelp/public/index.php/pchelp/'.$message->FromUserName.'/ticket',
                                'image'       => 'https://mmbiz.qlogo.cn/mmbiz/OEpqnOUyYjMcqqpJBRh2bhFDWTXUL3fdT54e7HTLTzEyEfzXk8XTUJQsrFx5pHvC7v6eSDNLicse62Hvpwt4o0A/0',
                            ]);
                            $news2 = new News([
                                'title'       => '报修订单',
                                'description' => '报修订单查询',
                                'url'         => 'http://120.27.104.83/pchelp/public/index.php/pchelp/'.$message->FromUserName.'/ticket'.$message->FromUserName,
                                'image'       => 'http://wx.qlogo.cn/mmopen/VXPOibDJU4Qg7s8rEbwvIsTwK4eibCyjsa6BNOaMP21shibm7C2DTOds9Fq3Uwgf7DUYnacITRF9JuxCPVBN81TEn6icBfgibW7bC/0',
                            ]);
                            return [$news1, $news2];
                        }elseif ($result->state == 1) {
                            //"这是PC队员";
                            $news1 = new News([
                                'title'       => 'PC服务队微信报修平台',
                                'description' => 'PC服务队微信报修平台',
                                'url'         => 'http://120.27.104.83/pchelp/public/index.php/pchelp/'.$message->FromUserName.'/ticket',
                                'image'       => 'https://mmbiz.qlogo.cn/mmbiz/OEpqnOUyYjMcqqpJBRh2bhFDWTXUL3fdT54e7HTLTzEyEfzXk8XTUJQsrFx5pHvC7v6eSDNLicse62Hvpwt4o0A/0',
                            ]);
                            $news2 = new News([
                                'title'       => '我的修机单',
                                'description' => '报修订单查询',
                                'url'         => 'http://120.27.104.83/pchelp/public/index.php/pchelp/'.$message->FromUserName,
                                'image'       => 'http://wx.qlogo.cn/mmopen/VXPOibDJU4Qg7s8rEbwvIsTwK4eibCyjsa6BNOaMP21shibm7C2DTOds9Fq3Uwgf7DUYnacITRF9JuxCPVBN81TEn6icBfgibW7bC/0',
                            ]);
                            return [$news1, $news2];
                        }elseif ($result->state == 2) {
                            //return "这是PC管理员";
                             $news1 = new News([
                                'title'       => 'PC管理员微信报修管理平台',
                                'description' => 'PC管理员微信报修管理平台',
                                'url'         => 'http://120.27.104.83/pchelp/public/index.php/pchelp/'.$message->FromUserName.'/ticket',
                                'image'       => 'https://mmbiz.qlogo.cn/mmbiz/OEpqnOUyYjMcqqpJBRh2bhFDWTXUL3fdT54e7HTLTzEyEfzXk8XTUJQsrFx5pHvC7v6eSDNLicse62Hvpwt4o0A/0',
                            ]);
                            $news2 = new News([
                                'title'       => '今日修机单完成情况',
                                'description' => '报修订单查询',
                                'url'         => 'http://120.27.104.83/pchelp/public/index.php/pchelp/'.$message->FromUserName,
                                'image'       => 'http://wx.qlogo.cn/mmopen/VXPOibDJU4Qg7s8rEbwvIsTwK4eibCyjsa6BNOaMP21shibm7C2DTOds9Fq3Uwgf7DUYnacITRF9JuxCPVBN81TEn6icBfgibW7bC/0',
                            ]);
                            $news3 = new News([
                                'title'       => '我要分机',
                                'description' => '报修订单查询',
                                'url'         => 'http://120.27.104.83/pchelp/public/index.php/pchelp/'.$message->FromUserName,
                                'image'       => 'http://wx.qlogo.cn/mmopen/VXPOibDJU4Qg7s8rEbwvIsTwK4eibCyjsa6BNOaMP21shibm7C2DTOds9Fq3Uwgf7DUYnacITRF9JuxCPVBN81TEn6icBfgibW7bC/0',
                            ]);
                            return [$news1, $news2,$news3];

                        }elseif ($result->state == 3) {
                            return "这是骏哥哥";
                        } else {
                            return "你是什么鬼";
                        }


                        break;
                     
                    default:
                       if ($AlltextRely) return $AlltextRely->answer;
                        break;
                 } 
            
            }
            
        });

        $response = $server->serve();

        return  $response;
    }
}
