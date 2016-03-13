<?php

namespace App\Http\Controllers\Super;

use Illuminate\Http\Request;
use Redirect,Input,Validator;
use \View;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Pcer;
use App\Wcuser;
use App\Pcerlevel;
class PcerController extends Controller
{
    public function index()
    {
        $pcerLevels = Pcerlevel::orderBy('level_name','DESC')->get(); 
        $pcers = Pcer::with('pcerlevel','wcuser','pcadmin')->orderBy('created_at','DESC')->get();
        return view::make('Super.pcer',['pcers'=>$pcers,'pcerLevels'=>$pcerLevels]);
    }

    public function levelset()
    {
        $pcerlevels = Pcerlevel::withTrashed()->orderBy('level_name','DESC')->get();
        return view::make('Super.pcerset',['pcerlevels'=>$pcerlevels]);
    }

    public function leveladd()
    {
        Input::flash();
        $validation = Validator::make(Input::all(),[
                'level_name' => 'required',
            ]);
        if ($validation->fails()) {
         return Redirect::back()->withInput(Input::all())->withMessage('亲(づ￣3￣)づ╭❤～内容要填写喔！');
        }

        $pcerLevel = new Pcerlevel;
        $pcerLevel->level_name = Input::get('level_name');
        $res = $pcerLevel->save();
        if ($res) {
            return Redirect::back();
        } else {
            return Redirect::back()->withInput(Input::all())->with('message', '提交失败，请重新提交');
        }
    }

    public function leveldel()
    {
        
        $res = Pcerlevel::find(Input::get('id'))->forceDelete();
        if ($res) {
            return Redirect::back()->with('message', '网络异常');
        } else {
            
            return Redirect::back();
        }
        
    }

    public function set($id)
    {
        $states = Wcuser::find($id)->state;
        if ($states==1) {
            $res = Wcuser::where('id',$id)->update(['state'=>0]);
        } elseif($states==0) {
            $res = Wcuser::where('id',$id)->update(['state'=>1]);
        }elseif ($states==2) {
            return "该用户是管理员，请先取消管理员身份！";
        }else{
            return "该用户身份异常，请通知骏哥哥！";
        }
        
        $state = Wcuser::find($id)->state;
        if ($res) {
            return $state;
        } else {
            return "error";
        }
    }

    public function show($id)
    {
        $is = Pcerlevel::withTrashed()->find($id)->deleted_at;
        if ($is) {
            $res = Pcerlevel::withTrashed()->find($id)->restore();
        } else {
            $res = Pcerlevel::withTrashed()->find($id)->delete();
        }
        
        if ($res) {
            $isagain = Pcerlevel::withTrashed()->find($id)->deleted_at;
            if ($isagain) {
                return "0";
            } else {
                return "1";
            }
        } else {
            return "网络异常";
        }
    }
}
