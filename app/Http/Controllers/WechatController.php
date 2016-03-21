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
use EasyWeChat;
use EasyWeChat\Message\Raw;

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
        $chat = new Chat;
        $server->setMessageHandler(function($message)use ($user,$chat) {

            $result = Wcuser::where('openid', $message->FromUserName)->first();

            /*如果数据库中没有这个用户就添加*/
            while (!$result) {
                $wcuser = new Wcuser;
                $wcuser->openid = $message->FromUserName;
                $userService  = EasyWeChat::user(); 
                $subscribe = $userService->get($message->FromUserName)->subscribe;

                $wcuser->subscribe = $subscribe;     
                $wcuser->save();
                $result = Wcuser::where('openid', $message->FromUserName)->first();
            }

            /*如果数据库中有这个用户，但是他之前取消关注过*/
            while($result->subscribe ==0){
                Wcuser::where('openid',$message->FromUserName)->update(['subscribe'=> 1]);
                $result = Wcuser::where('openid', $message->FromUserName)->first();
            }

            /*判断事件类型*/
            if ($message->MsgType == 'event') {

                if ($message->Event=='subscribe') {//关注事件
                    return $this->subscribe($message->FromUserName);
                }elseif ($message->Event=='unsubscribe') {//取消关注事件
                    Wcuser::where('openid',$message->FromUserName)->update(['subscribe'=> 0]); 
                }elseif ($message->Event=='CLICK') {//菜单点击事件
                    if ($message->EventKey=='ILOVEPCHELP') {
                         return $this->repairEnter($message->FromUserName,$result->state);
                    }
                }
            }elseif ($message->MsgType == 'text') {
                $chats = new Chat;
                $chats->wcuser_id = $result->id;
                $chats->content = $message->Content;
                $chats->save();
                return $this->text($message->Content,$message->FromUserName,$result->state);
            }

        });


        $response = $server->serve();

        return  $response;
    }


    /*
        关注自动回复
     */
    public function subscribe($openid)
    {
        $userService  = EasyWeChat::user(); 
        $nickname = $userService->get($openid)->nickname;

        $SubscribeRely = Rely::where('state',0)->first();//获取关注时自动回复的内容
        if ($SubscribeRely) {
            return $SubscribeRely->answer;
        } else {
            return "嗨！{$nickname}！你好！这里是傲娇骏测试号！请根据需求操作后截图给骏哥哥！谢谢帮忙！O(∩_∩)O哈哈~";
        }
    }

    /*
        微信报修平台入口
     */
    public function repairEnter($openid,$state)
    {
        if ($state == 0) {
            //这是普通用户
            $news1 = new News([
                'title'       => 'PC服务队微信报修平台',
                'description' => 'PC服务队微信报修平台',
                'url'         => 'http://120.27.104.83/pchelp/'.$openid.'/ticket',
                'image'       => 'https://mmbiz.qlogo.cn/mmbiz/OEpqnOUyYjMcqqpJBRh2bhFDWTXUL3fdT54e7HTLTzEyEfzXk8XTUJQsrFx5pHvC7v6eSDNLicse62Hvpwt4o0A/0',
            ]);
            $news2 = new News([
                'title'       => '我的报修单',
                'description' => '报修订单查询',
                'url'         => 'http://120.27.104.83/mytickets/'.$openid.'/ticketList',
                'image'       => 'http://wx.qlogo.cn/mmopen/VXPOibDJU4Qg7s8rEbwvIsTwK4eibCyjsa6BNOaMP21shibm7C2DTOds9Fq3Uwgf7DUYnacITRF9JuxCPVBN81TEn6icBfgibW7bC/0',
            ]);
            return [$news1, $news2];
        }elseif ($state == 1) {
            //"这是PC队员";
            $news1 = new News([
                'title'       => '我的修机单',
                'description' => 'PC服务队队员修机单',
                'url'         => 'http://120.27.104.83/pcertickets/'.$openid.'/index',
                'image'       => 'https://mmbiz.qlogo.cn/mmbiz/OEpqnOUyYjMcqqpJBRh2bhFDWTXUL3fdT54e7HTLTzEyEfzXk8XTUJQsrFx5pHvC7v6eSDNLicse62Hvpwt4o0A/0',
            ]);
            $news2 = new News([
                'title'       => '我的个人信息',
                'description' => 'PC仔申请通道',
                'url'         => 'http://120.27.104.83/pcer/'.$openid.'/index',
                'image'       => 'http://wx.qlogo.cn/mmopen/VXPOibDJU4Qg7s8rEbwvIsTwK4eibCyjsa6BNOaMP21shibm7C2DTOds9Fq3Uwgf7DUYnacITRF9JuxCPVBN81TEn6icBfgibW7bC/0',
            ]);
            return [$news1, $news2];
        }elseif ($state == 2) {
            //return "这是PC管理员";
             $news1 = new News([
                'title'       => 'PC管理员微信报修管理平台',
                'description' => 'PC管理员微信报修管理平台',
                'url'         => 'http://120.27.104.83/pchelp/'.$openid.'/ticket',
                'image'       => 'https://mmbiz.qlogo.cn/mmbiz/OEpqnOUyYjMcqqpJBRh2bhFDWTXUL3fdT54e7HTLTzEyEfzXk8XTUJQsrFx5pHvC7v6eSDNLicse62Hvpwt4o0A/0',
            ]);
            $news2 = new News([
                'title'       => '今日修机单完成情况',
                'description' => '报修订单查询',
                'url'         => 'http://120.27.104.83/pchelp/'.$openid,
                'image'       => 'http://wx.qlogo.cn/mmopen/VXPOibDJU4Qg7s8rEbwvIsTwK4eibCyjsa6BNOaMP21shibm7C2DTOds9Fq3Uwgf7DUYnacITRF9JuxCPVBN81TEn6icBfgibW7bC/0',
            ]);
            $news3 = new News([
                'title'       => '我要分机',
                'description' => '报修订单查询',
                'url'         => 'http://120.27.104.83/pchelp/'.$openid,
                'image'       => 'http://wx.qlogo.cn/mmopen/VXPOibDJU4Qg7s8rEbwvIsTwK4eibCyjsa6BNOaMP21shibm7C2DTOds9Fq3Uwgf7DUYnacITRF9JuxCPVBN81TEn6icBfgibW7bC/0',
            ]);
            return [$news1, $news2,$news3];

        }elseif ($state == 3) {
            return "这是骏哥哥";
        } else {
            return "你是什么鬼";
        }  
    }

    /*
        微信消息回复
     */
    public function text($content,$openid,$state)
    {
        $AlltextRely = Rely::where('state',1)->first();//获取用户发送消息时自动回复的内容
        if ($AlltextRely) {
           return $AlltextRely->answer;
        }elseif ($content=='微信报修') {
            return $this->repairEnter($openid,$state);
        }elseif ($content=='微信') {
            $text = new Text();
            $text->content = '您好！overtrue。';
            return $text;
        }elseif ($content=='骏哥哥好帅') {
            $news = new News([
                'title'       => '我的个人信息',
                'description' => 'PC仔申请通道',
                'url'         => 'http://120.27.104.83/pcer/'.$openid.'/index',
                'image'       => 'https://mmbiz.qlogo.cn/mmbiz/OEpqnOUyYjMcqqpJBRh2bhFDWTXUL3fdT54e7HTLTzEyEfzXk8XTUJQsrFx5pHvC7v6eSDNLicse62Hvpwt4o0A/0',
            ]);
            return $news;
        }else {
           $res = Rely::where('state',2)->where('question',$content)->first();
           if ($res) {
               return $res->answer;
           } 
        }
        
    }

}
