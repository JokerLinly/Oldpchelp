<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use EasyWeChat\Foundation\Application;
use Redirect,Input, Auth;
use EasyWeChat;
use EasyWeChat\Message\Image;
use App\modules\module\RelyModule;
use App\Http\Controllers\WechatController;

class TestController extends Controller {

    public function index()
   {

        $options = [
            'debug'  => true,
            'app_id'  => env('WECHAT_APPID'),
            'secret'  => env('WECHAT_SECRET'),
            'token'   => env('WECHAT_TOKEN'),
            'aes_key' => env('WECHAT_AES_KEY'),
        ];
        $app = new Application($options);
        $userService = $app->user;
        // dd($userService->toArray());
        // $app = new Application($options);
        // // 永久素材
        // $material = $app->material;
        // $result = $material->lists('news', 0, 10);
        // $resource = $material->get('wwN4y-7YUcdt_8QlYJpqtP2An84SBoV33lAE7PertUk');
        $AlltextRely = RelyModule::getRely(1);//获取用户发送消息时自动回复的内容
        if ($AlltextRely['style'] == 2) {
            $img = new Image(['media_id' => $AlltextRely['answer']]);
            return $img;
        }

        // return TicketModule::assignTicketMessage(9);
        // return Redirect::action('Admin\WapHomeController@index');
    }

}
