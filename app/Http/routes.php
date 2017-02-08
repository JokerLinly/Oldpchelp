<?php
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

Route::get('/test', 'TestController@index');

/*基础信息配置入口*/
Route::any('/wechat', 'WechatController@serve');

/*必须要登录的微信用户才能进入*/
/*微信报修链接*/
Route::get('/pchelp', 'WechatController@pchelp');
/*用户的订单链接*/
Route::get('/mytickets', 'WechatController@mytickets');
/*PC仔的信息登记*/
Route::get('/comeon', 'WechatController@pcer');
Route::get('/user_single', 'WechatController@userSingleTicket');
Route::get('/member_single', 'WechatController@memberSingleTicket');
Route::get('/admin_single', 'WechatController@adminSingleTicket');

Route::group(['namespace'=>'Ticket','prefix'=>'ticket', 'middleware'=>'user_single_ticket'], function () {
    Route::get('showSingleTicket/{id}', 'HomeController@showSingleTicket');//查看单个订单
});
Route::group(['namespace'=>'Member','prefix'=>'myticket', 'middleware'=>'member_single_ticket'], function () {
    Route::get('showSingleTicket/{id}', 'TicketController@showSingleTicket');//查看单个订单
});
Route::group(['namespace'=>'Admin','prefix'=>'myholdticket', 'middleware'=>'admin_single_ticket'], function () {
    Route::get('showSingleTicket/{id}', 'WapHomeController@showSingleTicket');//查看单个订单
});

/*微信用户报修*/
Route::group(['namespace'=>'Ticket','prefix'=>'ticket', 'middleware'=>'wechat_login'], function () {
    Route::get('', 'HomeController@index');//报修页面
    Route::post('create', 'HomeController@create');//创建订单
    Route::get('showTickets', 'HomeController@showTickets');//查看订单列表
    Route::post('addComment', 'TicketController@addComment');//发送会话
    Route::get('updateShow/{id}', 'HomeController@updateShow');//更新订单
    Route::post('update', 'HomeController@update');
    Route::post('deleteTicket', 'HomeController@deleteTicket');//用户删除订单
    Route::post('addSuggestion', 'TicketController@addSuggestion');//增加评论
});

/*微信用户操作*/
Route::group(['prefix'=>'myticket','middleware'=>'wechat_ticket'], function () {
    Route::get('', 'Ticket\TicketController@index');//区分用户
});
/*PC仔的信息登记*/
Route::group(['namespace'=>'Member', 'middleware'=>'pcer_comeon'], function () {
    Route::get('pcer', 'HomeController@getAddPcer');
    Route::post('addPcer', 'HomeController@addPcer');
    Route::get('showPcer', 'HomeController@showPcer');
    Route::post('updatePcer', 'HomeController@updatePcer');
});
/*PC仔的订单操作*/
Route::group(['namespace'=>'Member','prefix'=>'myticket', 'middleware'=>'wechat_ticket'], function () {
    Route::get('index', 'HomeController@index');
    Route::get('showTickets', 'HomeController@showTickets');//查看订单列表
    Route::get('task_ticket', 'TicketController@pcerTicketList');//任务订单页
    Route::get('task_ticket_finish', 'TicketController@pcerFinishTicketList');
    Route::post('pcerAddComment', 'TicketController@pcerAddComment');//发送消息
    Route::post('pcerDelTicket', 'TicketController@pcerDelTicket');
    Route::get('getIdle', 'HomeController@getIdle');//获取值班时间
    Route::post('delIdle', 'HomeController@delIdle');
    Route::post('addIdle', 'HomeController@addIdle');
    Route::get('person', 'HomeController@getPerson');//查看个人资料
    Route::post('change_ot', 'HomeController@changeOTstate');
});
/*PC叻仔的分机操作*/
Route::group(['namespace'=>'Admin', 'prefix'=>'myholdticket', 'middleware'=>'wechat_ticket'], function () {
    Route::get('main', 'WapHomeController@index');
    Route::get('showTickets', 'WapHomeController@showTickets');//查看订单列表
    Route::get('get_all_tack', 'WapHomeController@getAllTackTicket');//全部未分配订单
    Route::get('get_today_tack', 'WapHomeController@getTodayTackTicket');//今天未分配订单
    Route::get('get_overtime_tack', 'WapHomeController@getOverTimeTackTicket');//过期未分配订单
    Route::get('get_lock_tack', 'WapHomeController@getLockTackTickets');//被锁定未完成的订单
    Route::get('get_lock_ticket', 'WapHomeController@getLockTack');//被锁定的订单
    Route::get('get_finish_tack', 'WapHomeController@getFinishTackTicket');//已完成的订单
    Route::get('getIdle', 'WapHomeController@getIdle');//获取值班时间
    Route::get('person', 'WapHomeController@getPerson');
    Route::get('task_ticket', 'WapHomeController@pcerTicketList');//任务订单页
    Route::get('task_ticket_finish', 'WapHomeController@pcerFinishTicketList');
    Route::post('closeTicket', 'WapHomeController@pcAdminCloseTicket');//关闭订单
    Route::post('unlockTicket', 'WapHomeController@pcAdminUnLockTicket');//解锁订单
    Route::post('pcAdminAddComment', 'WapHomeController@pcadminSentComment');//发送消息模板
    Route::post('assignTicket', 'WapHomeController@assignTicket');//分配当天订单
    Route::post('lock', 'WapHomeController@lockTicket');//锁定票单
    Route::get('lockTicket/{id}', 'WapHomeController@lockSingleTicket');//锁定订单
});

/*超级管理员*/
Route::get('super', 'Super\HomeController@getIndex');
Route::post('super', 'Super\HomeController@postSuperLogin');
Route::group(['namespace'=>'Super', 'prefix'=>'super', 'middleware'=>'login_session'], function () {
    Route::get('main', 'HomeController@postMain');
    Route::get('logout', 'HomeController@getLogout');
    Route::get('pcer', 'PcerController@getIndex');
    Route::get('pcset', 'PcerController@getLevelSet');
    Route::get('pcset/levelshow/{id}', 'PcerController@getLevelshow');
    Route::post('pcset/leveladd', 'PcerController@leveladd');
    Route::get('pcerset/{id}', 'PcerController@getPcerset');
    Route::get('pcadminset/{id}', 'PcadminController@getAdminSet');
    Route::get('pcworkset/{id}', 'PcerController@getIsWorkSet');
    
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
