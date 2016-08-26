<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use EasyWeChat\Foundation\Application;
use Redirect,Input, Auth;
use App\Model\Wcuser;
use App\Model\Rely;
use App\Model\Chat;
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
            return "嗨！{$nickname}！你好！感谢关注中大南方PC志愿者服务队微信公众号！";
        }
    }

    /**
     * 微信报修平台入口
     * @author JokerLinly
     * @date   2016-08-19
     * @param  [type]     $openid [description]
     * @param  [type]     $state  [description]
     * @return [type]             [description]
     */
    public function repairEnter($openid,$state)
    {
        if ($state == 0) {
            //这是普通用户
            $news1 = new News([
                'title'       => 'PC服务队微信报修平台',
                'description' => 'PC服务队微信报修平台',
                'url'         => 'http://pc.nfu.edu.cn/pchelp/'.$openid.'/ticket',
                'image'       => 'https://mmbiz.qlogo.cn/mmbiz/OEpqnOUyYjMcqqpJBRh2bhFDWTXUL3fdT54e7HTLTzEyEfzXk8XTUJQsrFx5pHvC7v6eSDNLicse62Hvpwt4o0A/0',
            ]);
            $news2 = new News([
                'title'       => '我的报修单',
                'description' => '报修订单查询',
                'url'         => 'http://pc.nfu.edu.cn/mytickets/'.$openid.'/ticketList',
                'image'       => 'http://wx.qlogo.cn/mmopen/VXPOibDJU4Qg7s8rEbwvIsTwK4eibCyjsa6BNOaMP21shibm7C2DTOds9Fq3Uwgf7DUYnacITRF9JuxCPVBN81TEn6icBfgibW7bC/0',
            ]);
            return [$news1, $news2];
        }elseif ($state == 1) {
            //"这是PC队员";
            $news1 = new News([
                'title'       => '我的修机单',
                'description' => 'PC服务队队员修机单',
                'url'         => 'http://pc.nfu.edu.cn/pcertickets/'.$openid.'/main',
                'image'       => 'https://mmbiz.qlogo.cn/mmbiz/OEpqnOUyYjMcqqpJBRh2bhFDWTXUL3fdT54e7HTLTzEyEfzXk8XTUJQsrFx5pHvC7v6eSDNLicse62Hvpwt4o0A/0',
            ]);
            $news2 = new News([
                'title'       => '我的修机shi',
                'description' => '我的修机shi',
                'url'         => 'http://pc.nfu.edu.cn/pcertickets/'.$openid.'/listory',
                'image'       => 'http://wx.qlogo.cn/mmopen/VXPOibDJU4Qg7s8rEbwvIsTwK4eibCyjsa6BNOaMP21shibm7C2DTOds9Fq3Uwgf7DUYnacITRF9JuxCPVBN81TEn6icBfgibW7bC/0',
            ]);
            $news3 = new News([
                'title'       => '我的个人信息',
                'description' => 'PC仔申请通道',
                'url'         => 'http://pc.nfu.edu.cn/pcer/'.$openid.'/index',
                'image'       => 'http://wx.qlogo.cn/mmopen/VXPOibDJU4Qg7s8rEbwvIsTwK4eibCyjsa6BNOaMP21shibm7C2DTOds9Fq3Uwgf7DUYnacITRF9JuxCPVBN81TEn6icBfgibW7bC/0',
            ]);
            return [$news1, $news2,$news3];
        }elseif ($state == 2) {
            //return "这是PC管理员";
             $news1 = new News([
                'title'       => '我的修机单',
                'description' => '我的修机单',
                'url'         => 'http://pc.nfu.edu.cn/pcertickets/'.$openid.'/main',
                'image'       => 'https://mmbiz.qlogo.cn/mmbiz/OEpqnOUyYjMcqqpJBRh2bhFDWTXUL3fdT54e7HTLTzEyEfzXk8XTUJQsrFx5pHvC7v6eSDNLicse62Hvpwt4o0A/0',
            ]);
            $news2 = new News([
                'title'       => '管理员未完成订单',
                'description' => '报修订单查询',
                'url'         => 'http://pc.nfu.edu.cn/pcadminwc/'.$openid.'/main',
                'image'       => 'http://wx.qlogo.cn/mmopen/VXPOibDJU4Qg7s8rEbwvIsTwK4eibCyjsa6BNOaMP21shibm7C2DTOds9Fq3Uwgf7DUYnacITRF9JuxCPVBN81TEn6icBfgibW7bC/0',
            ]);
            $news3 = new News([
                'title'       => '修机shi',
                'description' => '报修订单查询',
                'url'         => 'http://pc.nfu.edu.cn/pcertickets/'.$openid.'/listory',
                'image'       => 'http://wx.qlogo.cn/mmopen/VXPOibDJU4Qg7s8rEbwvIsTwK4eibCyjsa6BNOaMP21shibm7C2DTOds9Fq3Uwgf7DUYnacITRF9JuxCPVBN81TEn6icBfgibW7bC/0',
            ]);
            $news4 = new News([
                'title'       => '分配shi',
                'description' => '报修订单查询',
                'url'         => 'http://pc.nfu.edu.cn/pcadminwc/'.$openid.'/listory',
                'image'       => 'http://wx.qlogo.cn/mmopen/VXPOibDJU4Qg7s8rEbwvIsTwK4eibCyjsa6BNOaMP21shibm7C2DTOds9Fq3Uwgf7DUYnacITRF9JuxCPVBN81TEn6icBfgibW7bC/0',
            ]);
            $news5 = new News([
                'title'       => '我的个人信息',
                'description' => 'PC仔申请通道',
                'url'         => 'http://pc.nfu.edu.cn/pcer/'.$openid.'/index',
                'image'       => 'http://wx.qlogo.cn/mmopen/VXPOibDJU4Qg7s8rEbwvIsTwK4eibCyjsa6BNOaMP21shibm7C2DTOds9Fq3Uwgf7DUYnacITRF9JuxCPVBN81TEn6icBfgibW7bC/0',
            ]);
            return [$news1, $news2,$news3,$news4,$news5];

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
        }elseif ($content=='骏哥哥好帅') {
            $news = new News([
                'title'       => '我的个人信息',
                'description' => 'PC仔申请通道',
                'url'         => 'http://pc.nfu.edu.cn/pcer/'.$openid.'/index',
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
    /**
     * 网页授权登录进入报修页面
     * @author JokerLinly
     * @date   2016-08-26
     * @param  Application $app     [description]
     * @param  Request     $request [description]
     * @return [type]               [description]
     */
    public function index(Application $app,Request $request)
    {
        $oauth = $app->oauth;
        // 未登录
        if (empty($_SESSION['wechat_user']) && !$request->has('code')) {
          return $oauth->redirect();
        }

        $user = $oauth->user();
        $openid = $user->getId();
        $_SESSION['wechat_user'] = $user->toArray();
                
        return Redirect::action('Ticket\HomeController@index',array('openid'=>$openid));
    }


}
