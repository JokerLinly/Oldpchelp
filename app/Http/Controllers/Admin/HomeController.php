<?php

namespace App\Http\Controllers\Admin;

use Redirect,Validator,Session,\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view::make('Admin.index');
    }

    public function login()
    {
        $school_id = Input::get('school_id');
        $pcer = Pcer::where('school_id',$school_id)->first();
        if ($pcer) {
            $pcadmin = Pcadmin::where('pcer_id',$pcer->id)->first();
            if ($pcadmin) {
                $salt = 'pchelpiloveandmiss679766';
                $spw = 'eddd3add34a7d4a8ee5286c499b2d773';
                $pw = md5(Input::get('password').$salt);
                if ($pcadmin->pw == $pw) {
                    Session::put('admin_login', true);
                    Session::put('pcadmin_id',$pcadmin->id);
                    if ($spw == $pw) {
                        return Redirect::to('pcadmin/pwset');
                    } else {
                        return Redirect::to('pcadmin/main');
                    }
                    
                } else {
                    return Redirect::back()->with('message', '密码错误！');
                }
                
            } else {
                return Redirect::back()->with('message', '对不起，你没有登录权限，请与骏哥哥联系！');
            }
            
        } else {
            return Redirect::back()->with('message', '用户不存在！');
        }
    }

    public function getMain()
    {        
        $pcadmin_id = Session::get('pcadmin_id');
        $tickets = Ticket::where('state',0)->whereNull('pcadmin_id')
                    ->with(['comment'=>function($query){
                        $query->with(['wcuser'=>function($qu){
                            $qu->with('pcer');
                        }]);
                    }])->get();
        $tpcers = Idle::where('date',date("w"))->with('pcer')->get();
        return view::make('Admin.main',['tickets'=>$tickets,'pcadmin_id'=>$pcadmin_id,'tpcers'=>$tpcers]);
    }

    public function getLogout()
    {
        Session::forget('admin_login');
        return Redirect::to('pcadmin/main')->with('message', '登出成功！');
    }

    public function getPwset()
    {
        $pcadmin_id = Session::get('pcadmin_id');
        $id = Pcadmin::find($pcadmin_id)->pcer_id;
        return view::make('Admin.pwsetting',['id'=>$id ]);
    }

    public function postPwchange()
    {
        $validation = Validator::make(Input::all(),[
                'pw' => 'required|min:6',
            ]);
        if ($validation->fails()) {
            return Redirect::back()->withMessage('密码不少于6位！');
        }

        $salt = 'pchelpiloveandmiss679766';
        $pw = md5(Input::get('pw').$salt);
        $res = Pcadmin::where('pcer_id',Input::get('id'))->update(['pw'=>$pw]);
        if ($res) {
            return Redirect::to('pcadmin/main')->withMessage('修改成功');
        } else {
            return Redirect::back()->withMessage('网络异常');
        }
    }

    public function getPersondeatil()
    {
        $pcadmin_id = Session::get('pcadmin_id');
        $persondeatil = Pcer::with(['pcadmin'=>function($query)use($pcadmin_id){
                    $query->find($pcadmin_id);
                }])->first();
        return view::make('Admin.persondeatil',['persondeatil'=>$persondeatil ]);
    }

}
