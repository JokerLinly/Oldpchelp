<?php

namespace App\Http\Controllers\Member;
use DB,Redirect, Input,Validator;
use Illuminate\Http\Request;
use \View;
use EasyWeChat;
use App\Wcuser;
use App\Pcer;
use App\Idle;
use App\Pcerlevel;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
     public function getIndex($openid)
    {
        $userService  = EasyWeChat::user();
        $wechatUser = $userService->get($openid);
        $wcuser = DB::table('wcusers')->where('openid', $openid)->first();
        $pcerLevels = Pcerlevel::orderBy('level_name','DESC')->get(); 
        if ($wcuser) {

            $issign = Pcer::where('wcuser_id',$wcuser->id)->with('idle','pcerlevel')->first();
            
            if ($issign) {
                if ($wcuser->state==1||$wcuser->state==2) {
                    $pcer = Pcer::where('wcuser_id',$wcuser->id)->with('idle')->first();
                    return View::make('Member.personData',['pcer'=>$pcer]);
                } else {
                    $pcerLevel = $pcerLevels->toArray();
                    $pcerLevelo = array_column($pcerLevel, 'level_name', 'id');
                    return View::make('Member.personDataChange',['detail'=>$issign,'pcerLevel'=>$pcerLevelo,'pcerLevels'=>$pcerLevels]);
                }
                
            } else {
                $headimgurl = $wechatUser->headimgurl;
                if (!$headimgurl) {
                    $headimgurl = "https://mmbiz.qlogo.cn/mmbiz/OEpqnOUyYjON3G1QjyWTMv6QI4M1fibw3rPIQUEhdb4PkJicibpiaCONRWg8aJw3VW6SWSZibkWCP6EyhiaGMa9wl76Q/0?wx_fmt=jpeg";
                }
                return View::make('Member.home',['headimgurl'=>$headimgurl,'wcuser_id'=>$wcuser->id,'openid'=>$wcuser->openid,'pcerLevels'=>$pcerLevels]);
            }
        } else {
            return view('welcome');
        }
    }

    public function postSign()
    {
        Input::flash();
        $openid = Wcuser::find(Input::get('wcuser_id'))->first()->openid;
        $validation = Validator::make(Input::all(),[
                'name' => 'required',
                'long_number' => 'required|digits:11',
                'school_id' => 'required|digits:9',
                'address' => 'required',
                'clazz' => 'required',
                'major' => 'required',
                'department' => 'required',
        ]);
        if ($validation->fails()) {
         return Redirect::back()->withInput(Input::all())->withMessage('亲(づ￣3￣)づ╭❤～内容要正确填写喔！请仔细查看手机号码或者学号是否正确！另外年级和地址要重新填写喔！');
        }

        $ispcer = DB::table('pcers')->where('wcuser_id',Input::get('wcuser_id'))->first();
        if (!$ispcer) {
            $pcer = new Pcer;
            $pcer->wcuser_id = Input::get('wcuser_id');
            $pcer->name = Input::get('name');
            $pcer->school_id = Input::get('school_id');
            $pcer->pcerlevel_id = Input::get('pcerlevel_id');
            $pcer->long_number = Input::get('long_number');
            if (Input::get('number')) {
                $pcer->number = Input::get('number');
            } 
            
            $pcer->department = Input::get('department');
            $pcer->major = Input::get('major');
            $pcer->clazz = Input::get('clazz');
            $pcer->address = Input::get('address');
            $pcer->area = Input::get('area');

            $result = $pcer->save();
            if ($result) {
                return "请静候佳音↖(^ω^)↗";
            } else {
                return Redirect::back()->withInput(Input::all())->with('message', '报修失败，请重新报修');
            }
        }
    }

    public function postEdit()
    {
        for($i=0;$i<count(Input::get('date'));$i++){
            $idles = DB::table('idles')->where('pcer_id',Input::get('pcer_id'))
                                   ->where('date',Input::get('date')[$i])->first();
            if (!$idles) {
                $idle = new Idle;
                $idle->date = Input::get('date')[$i]; 
                $idle->pcer_id = Input::get('pcer_id');
                $res = $idle->save();
            } 
            return Redirect::back();
            
        }
    }

    public function getShow()
    {
        $pcer = Pcer::where('id',Input::get('pcer_id'))->with('idle')->first();
        return View::make('Member.personData',['pcer'=>$pcer]);
    }

    public function postNickname()
    {
        Input::flash();
        $validation = Validator::make(Input::all(),[
                'nickname' => 'required',
        ]);
        if ($validation->fails()) {
         return Redirect::back()->withInput(Input::all())->withMessage('亲(づ￣3￣)づ╭❤～内容要填写喔！');
        }
        $res = Pcer::where('id',Input::get('id'))->update(['nickname'=>Input::get('nickname')]);

        if ($res) {
            return "更新成功↖(^ω^)↗";
        } else {
            return Redirect::back()->withInput(Input::all())->with('message', '提交失败，请重新提交');
        }
        
    }

    public function postChangesign()
    {
        $validation = Validator::make(Input::all(),[
                'name' => 'required',
                'long_number' => 'required|digits:11',
                'school_id' => 'required|digits:9',
                'address' => 'required',
                'clazz' => 'required',
                'major' => 'required',
                'department' => 'required',
        ]);
        if ($validation->fails()) {
         return Redirect::back()->withInput(Input::all())->withMessage('亲(づ￣3￣)づ╭❤～内容要填写喔！');
        }

        $name = Input::get('name');
        $school_id = Input::get('school_id');
        $pcerlevel_id = Input::get('pcerlevel_id');
        $long_number = Input::get('long_number');
        if (Input::get('number')) {
            $number = Input::get('number');
        }else {
            $number = NULL;
        }
        
        $department = Input::get('department');
        $major = Input::get('major');
        $clazz = Input::get('clazz');
        $address = Input::get('address');
        $area = Input::get('area');
        $res = Pcer::where('id',Input::get('id'))->update(['name'=>$name,'school_id'=>$school_id,'pcerlevel_id'=>$pcerlevel_id,'long_number'=>$long_number,'number'=>$number,'department'=>$department,'major'=>$major,'clazz'=>$clazz,'address'=>$address,'area'=>$area]);
        if ($res) {
            return Redirect::back();
        } else {
            return Redirect::back()->withInput(Input::all())->with('message', '提交失败，请重新提交');
        }

    }

    public function deleteDelidle()
    {
        $res = Idle::find(Input::get('id'))->delete();
        if ($res) {
            return Redirect::back();
        } else {
            return Redirect::back()->withInput()->with('message', '删除失败，请重新删除');
        }
    
    }

    public function postAddidle()
    {  
        $idles = Idle::where('pcer_id',Input::get('id'))
                     ->where('date',Input::get('date')[0])->first();
        if (!$idles) {
            $idle = new Idle;
            $idle->date = Input::get('date')[0]; 
            $idle->pcer_id = Input::get('id');
            $res = $idle->save();
        } 
        return Redirect::back();
    }
}
