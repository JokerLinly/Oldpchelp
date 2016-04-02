<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use EasyWeChat\Foundation\Application;
use Redirect,Input, Auth;

use EasyWeChat;

class TestController extends Controller {

    public function index()
   {
	//$userService  = EasyWeChat::user();
	//$userService->lists($nextOpenId = null); 
        $notice = EasyWeChat::notice();
       	$userId = 'od2TLjssFOknDLcsKzw0kSkqF5d8';
	$templateId = 'yzXYTlKj78bfMZIeHHRwkUx9acyLJjiKUg3h0uzWsE0';
	$url = 'http://120.27.104.83/';
	$color = '#FF0000';
	$data = array(
       		"comment"  => "这里是骏哥哥测试",
         	"remark" => "点击查看详情",
        );

	$messageId = $notice->uses($templateId)->withUrl($url)->andData($data)->andReceiver($userId)->send();

    	//dd( $userService);
    }
}
