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
/**
 * 高亮当前菜单
 */
// Html::macro('menu_active', function($route,$name)
// {
//     if (Request::is($route . '/*') || Request::is($route)) {
//         $active ='<li class="active"><a href="'.URL::to($route).'">'.$name.'</a></li>';
//     } else {
//         $active ='<li><a href="'.URL::to($route).'">'.$name.'</a></li>';
//     }

//     return $active;
// });

Route::get('/test','TestController@index');

/*基础信息配置入口*/
Route::any('/wechat', 'WechatController@serve');

/*微信报修链接*/
Route::get('/pchelp', 'WechatController@pchelp');

/*用户的订单链接*/
Route::get('/mytickets', 'WechatController@mytickets');

/*必须要登录的微信用户才能进入*/

/*微信用户报修 ,'middleware'=>'wechat_login'*/
Route::group(['namespace'=>'Ticket','prefix'=>'ticket'],function(){
    //报修页面
    Route::get('','HomeController@index');
    //创建订单
    Route::post('create','HomeController@create');
    //查看订单列表    
    Route::get('showTickets','HomeController@showTickets');
    //查看单个订单
    Route::get('showSingleTicket/{id}','HomeController@showSingleTicket');
    //发送会话
    Route::post('addComment','TicketController@addComment');
    //更新订单
    Route::get('updateShow/{id}','HomeController@updateShow');
    Route::post('update','HomeController@update');
    //用户删除订单
    Route::post('deleteTicket','HomeController@deleteTicket');
    //增加评论
    Route::post('addSuggestion','TicketController@addSuggestion');
});

Route::group(['prefix'=>'myticket','middleware'=>'wechat_ticket'],function(){
    Route::post('','Ticket\TicketController@postComment');
    Route::resource('','Ticket\TicketController');
});


// /*PC仔*/
// Route::controller('/pcer/{openid}','Member\HomeController');


// /*PC仔的订单*/
// Route::get('/pcertickets/{openid}/main','Member\TicketController@main');
// Route::get('/pcertickets/{openid}/listory','Member\TicketController@listory');
// Route::controller('/pcertickets/{openid}/{id}','Member\TicketController');

// /*PC管理员微信订单*/
// Route::get('/pcadminwc/{openid}/listory','Admin\TicketController@listory');
// Route::controller('/pcadminwc/{openid}/{id}','Admin\TicketController');
// Route::controller('/pcadminwc/{openid}','Admin\TicketController');



// /*PC管理员Web后台*/
// $router->group(['namespace'=>'Admin','prefix'=>'pcadmin'], function() {
//     Route::get('','HomeController@index');
//     Route::post('/login','HomeController@login');
    
// });

// $router->group(['namespace'=>'Admin','prefix'=>'pcadmin','middleware'=>'pcadmin_login'], function() {
   
//     Route::get('ticketlock/{id}','TicketController@ticketlock');
//     Route::post('ticketpcer','TicketController@pcersingle');
//     Route::post('ticketspcer','TicketController@pcerall');
//     /*首页订单end*/

//     Route::get('mytickets/unset','TicketController@ticketsunset');
//     Route::post('mytickets/unset/beforeset','TicketController@beforeset');
//     Route::post('mytickets/sentMessage','TicketController@sentMessage');
//     Route::post('mytickets/overticket','TicketController@overticket');
//     Route::controller('mytickets','TicketController');
//      /*首页订单*/
//     Route::controller('','HomeController');
// });

// /*骏哥哥后台*/

// $router->group(['namespace'=>'Super','prefix'=>'super'], function() {
//     Route::get('','HomeController@index');
//     Route::post('/login','HomeController@login');
    
// });

// $router->group(['namespace'=>'Super','prefix'=>'super','middleware'=>'login_session'], function() {
//     /*PC队员 start*/
//     Route::get('pcer','PcerController@index');
//     Route::get('pcerset/{id}','PcerController@set');
//     Route::get('pcadminset/{id}','PcadminController@set');
//     Route::get('pcset','PcerController@levelset');
//     Route::post('pcset/leveladd','PcerController@leveladd');
//     Route::post('pcset/leveldel','PcerController@leveldel');
//     Route::get('pcset/levelshow/{id}','PcerController@show');
//     // Route::get('menu','WechatController@menuShow');
//     /*PC队员 end*/


//     /*订单管理 start*/
//     Route::get('tickets','TicketController@index');
//     /*订单管理 end*/

//     /*首页*/
//     Route::controller('','HomeController');
//     /*首页end*/

// });

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
