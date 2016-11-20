<?php

namespace App\Http\Controllers\Super;

use Redirect;
use Validator;
use Session;
use Input;
use \View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * 超级管理员
 */
class HomeController extends Controller
{
    /**
     * 登录页
     * @author JokerLinly
     * @date   2016-11-09
     * @return [type]     [description]
     */
    public function getIndex()
    {
        return view::make('Super.index');
    }

    /**
     * 登录验证
     * @author JokerLinly
     * @date   2016-11-09
     * @return [type]     [description]
     */
    public function postSuperLogin()
    {
        $user_name = Input::get('user_name');
        $password = Input::get('password');
        $pw = date("Ymd");
        if ($user_name != 'pchelp') {
            return Redirect::back()->with('message', '用户不存在！');
        }

        if($password != $pw) {
            return Redirect::back()->with('message', '密码错误！');
        }
        Session::put('super_login', true);
        return Redirect::action('Super\HomeController@getMain');
    }

    /**
     * 主页
     * @author JokerLinly
     * @date   2016-11-09
     * @return [type]     [description]
     */
    public function getMain()
    {
        return Redirect::action('Super\PcerController@getIndex');
        // return view::make('Super.main');
    }

    /**
     * 退出
     * @author JokerLinly
     * @date   2016-11-09
     * @return [type]     [description]
     */
    public function getLogout()
    {
        Session::forget('super_login');
        return Redirect::action('Super\HomeController@getIndex')->with('message', '登出成功！');
    }


    // public function reply()
    // {
    //    return view::make('Super.rely');
    // }
}
