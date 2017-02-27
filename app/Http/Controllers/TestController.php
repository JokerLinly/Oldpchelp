<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use EasyWeChat\Foundation\Application;
use Redirect,Input, Auth;
use EasyWeChat;
use App\modules\module\TicketModule;
use App\Http\Controllers\WechatController;

class TestController extends Controller {

    public function index()
   {

        $user = Session::get('wechat_user');
        dd($user);
        // $options = [
        //     'debug'  => true,
        //     'app_id' => 'wx57c08bf5fe198eee',
        //     'secret' => '022d9164832f337b6e5edc00b0295bad',
        // ];
        // $app = new Application($options);
        // // 永久素材
        // $material = $app->material;
        // $result = $material->lists('news', 0, 10);
        // $resource = $material->get('wwN4y-7YUcdt_8QlYJpqtP2An84SBoV33lAE7PertUk');

        
        // return TicketModule::assignTicketMessage(9);
        // return Redirect::action('Admin\WapHomeController@index');
    }

}
