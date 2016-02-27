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

/*我的订单*/
// Route::controller('mytickets', 'Ticket\TicketController');
Route::get('/mytickets/{openid}/ticketList','Ticket\TicketController@index');
Route::get('/mytickets/{id}/show','Ticket\TicketController@show');
Route::any('/mytickets/{id}/edit','Ticket\TicketController@edit');
Route::any('/mytickets/{id}/update','Ticket\TicketController@update');

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
