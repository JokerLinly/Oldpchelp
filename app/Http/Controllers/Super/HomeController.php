<?php

namespace App\Http\Controllers\Super;
use DB,Redirect, Input,Validator,Session;
use Illuminate\Http\Request;
use \View;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view::make('Super.index');
    }

    public function login()
    {
        // dd(Input::all());
        $user_name = Input::get('user_name');
        $password = Input::get('password');    
        $pw = date("Ymd");
        if($user_name == 'pchelp' ){
          if($password == $pw) {
            Session::put('super_login', true);
            return View::make('Super.main');
          } else {
            return Redirect::back()->with('message', '密码错误！');
          }
        } else {
          return Redirect::back()->with('message', '用户不存在！');
        }
    }
}
