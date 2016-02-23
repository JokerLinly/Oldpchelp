<?php
use App\Wcuser;
/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::any('/wechat', 'WechatController@serve');

/*微信报修链接*/
Route::get('/panduan/{openid}', function ($openid) {
    $result = Wcuser::where('openid',$openid)->first();
    if ($result->state == 0) {
        return "这是普通用户";
    }elseif ($result->state == 1) {
        return "这是PC队员";
    }elseif ($result->state == 2) {
        return "这是PC管理员";
    }elseif ($result->state == 3) {
        return "这是骏哥哥";
    } else {
        return "你是什么鬼";
    }
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});
