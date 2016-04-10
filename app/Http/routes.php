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
Route::any('/test', 'TestController@index');
Route::get('/', function () {
    return view('welcome');
});

Route::any('/wechat', 'WechatController@serve');

/*微信报修链接*/

Route::resource('/pchelp/{openid}/ticket','Ticket\HomeController');

/*用户的订单*/

Route::get('/mytickets/{openid}/ticketList','Ticket\TicketController@index');
Route::controller('/mytickets/{id}','Ticket\TicketController');

/*PC仔*/
Route::controller('/pcer/{openid}','Member\HomeController');


/*PC仔的订单*/
Route::get('/pcertickets/{openid}/index','Member\TicketController@index');
Route::controller('/pcertickets/{id}','Member\TicketController');

/*PC管理员微信订单*/
Route::get('/pcadmin/{openid}/ticketslist','Admin\TicketController@ticketslist');


/*PC管理员Web后台*/
$router->group(['namespace'=>'Admin','prefix'=>'pcadmin'], function() {
    Route::get('','HomeController@index');
    Route::post('/login','HomeController@login');
    
});

$router->group(['namespace'=>'Admin','prefix'=>'pcadmin','middleware'=>'pcadmin_login'], function() {
   
    Route::get('ticketlock/{id}','TicketController@ticketlock');
    Route::post('ticketpcer','TicketController@pcersingle');
    Route::post('ticketspcer','TicketController@pcerall');
    /*首页订单end*/

    Route::get('mytickets/unset','TicketController@ticketsunset');
    Route::post('mytickets/unset/beforeset','TicketController@beforeset');
    Route::controller('mytickets','TicketController');
     /*首页订单*/
    Route::controller('','HomeController');
});

/*骏哥哥后台*/

$router->group(['namespace'=>'Super','prefix'=>'super'], function() {
    Route::get('','HomeController@index');
    Route::post('/login','HomeController@login');
    
});

$router->group(['namespace'=>'Super','prefix'=>'super','middleware'=>'login_session'], function() {
    /*PC队员 start*/
    Route::get('pcer','PcerController@index');
    Route::get('pcerset/{id}','PcerController@set');
    Route::get('pcadminset/{id}','PcadminController@set');
    Route::get('pcset','PcerController@levelset');
    Route::post('pcset/leveladd','PcerController@leveladd');
    Route::post('pcset/leveldel','PcerController@leveldel');
    Route::get('pcset/levelshow/{id}','PcerController@show');
    /*PC队员 end*/


    /*订单管理 start*/
    Route::get('tickets','TicketController@index');
    /*订单管理 end*/

    /*首页*/
    Route::controller('','HomeController');
    /*首页end*/

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
