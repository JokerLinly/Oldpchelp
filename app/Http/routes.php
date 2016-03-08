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

Route::resource('/pchelp/{openid}/ticket','Ticket\HomeController');

/*用户的订单*/

Route::get('/mytickets/{openid}/ticketList','Ticket\TicketController@index');
Route::get('/mytickets/{id}/show','Ticket\TicketController@show');
Route::post('/mytickets/{id}/edit','Ticket\TicketController@edit');
Route::post('/mytickets/{id}/update','Ticket\TicketController@update');
Route::delete('/mytickets/{id}/delticket','Ticket\TicketController@delticket');

/*PC仔*/
Route::get('/pcer/{openid}/index','Member\HomeController@index');
Route::post('/pcer/{openid}/sign','Member\HomeController@sign');
Route::post('/pcer/{openid}/edit','Member\HomeController@edit');
Route::get('/pcer/{openid}/show','Member\HomeController@show');
Route::post('/pcer/{openid}/nickname','Member\HomeController@nickname');
Route::post('/pcer/{openid}/addIdle','Member\HomeController@addIdle');
Route::delete('/pcer/{openid}/delIdle','Member\HomeController@delIdle');

/*PC仔的订单*/
Route::get('/pcertickets/{openid}/index','Member\TicketController@index');
Route::get('/pcertickets/{id}/show','Member\TicketController@show');
Route::post('/pcertickets/{id}/edit','Member\TicketController@edit');
Route::post('/pcertickets/{id}/update','Member\TicketController@update');

/*PC管理员Web后台*/
Route::get('/pcadminweb','Admin\HomeController@index');

/*PC管理员订单*/

/*骏哥哥后台*/
Route::get('/super','Super\HomeController@index');
Route::post('/super/login','Super\HomeController@login');
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
