<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use EasyWeChat\Foundation\Application;
use Redirect,Input, Auth;

use EasyWeChat;

class TestController extends Controller {

    public function index(Application $app)
   {
      dd($_POST);
      $user = $app->user; 

      dd($user);
    	//dd( $userService);
    }
}
