<?php

namespace App\Http\Controllers\Member;

use Redirect,Validator,Session,\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\modules\module\PcerModule;
use App\modules\module\WcuserModule;

class HomeController extends Controller
{
    /**
     * 进入PC仔首页
     * @author JokerLinly
     * @date   2016-09-11
     * @param  Request    $request [description]
     */
    public function Index(Request $request)
    {
        return view('Member.index');
    }

    /**
     * 进入PC仔信息登记页面
     * @author JokerLinly
     * @date   2016-09-13
     * @param  string     $value [description]
     * @return [type]            [description]
     */
    public function getAddPcer()
    {
        $openid = $request->session()->get('wechat_user')['id'];
        $wcuser = WcuserModule::getWcuser(['id', 'openid', 'state'],$openid);

        //如果不存在该用户
        if (empty($wcuser)) {
            $wcuser = WcuserModule::addWcuser($openid);
            if(empty($wcuser)){
                return View::make('error');
            }
            $request->session()->put('wcuser_id', $wcuser['id']);
        }else{
            $wcuser_id = $wcuser['id'];
            $request->session()->put('wcuser_id', $wcuser_id);
            if ($wcuser['state'] != 0) {
                return Redirect::action('Member\HomeController@showPcer');
            }            
        }
        
        $pcerlevel = PcerModule::getLevel();
        return view('Member.home',['pcerLevels'=>$pcerlevel]);
    }

    /**
     * PC仔查看注册信息
     * @author JokerLinly
     * @date   2016-09-13
     * @return [type]     [description]
     */
    public function showPcer()
    {
        $input['wcuser_id'] = session('wcuser_id');
        $pcer = PcerModule::getPcer('wcuser_id', $input['wcuser_id'], ['name', 'school_id', 'pcerlevel_id', 'long_number', 'number', 'department', 'major', 'clazz', 'address', 'area', 'state', 'sex']);
        $pcerlevel = PcerModule::getLevel();
        return view('Member.personDataChange',['pcer'=>$pcer, 'pcerLevels'=>$pcerlevel]);
    }

    /**
     * 增加PC队员
     * @author JokerLinly
     * @date   2016-09-13
     * @param  Request    $request [description]
     */
    public function addPcer(Request $request)
    {
        $request->flash();
        $input = $request->input();
        $validation = Validator::make($input,[
                'name' => 'required',
                'long_number' => 'required|digits:11',
                'school_id' => 'required|digits:9',
                'address' => 'required',
                'clazz' => 'required',
                'major' => 'required',
                'department' => 'required',
                'sex'=> 'required'
        ]);

        if ($validation->fails()) {
         return Redirect::back()->withInput($input)->withMessage('亲(づ￣3￣)づ╭❤～内容要正确填写喔！请仔细查看手机号码或者学号是否正确！另外年级和地址要重新填写喔！');
        }
        $input['wcuser_id'] = session('wcuser_id');
        $is_pcer = PcerModule::getPcer('wcuser_id', $input['wcuser_id'], ['id']);
        if (!empty($is_pcer)) {
            return Redirect::action('Member\HomeController@showPcer');
        }

        $pcer = PcerModule::addPcer($input);
        if (!is_array($result)) {
            return Redirect::action('Member\HomeController@showPcer');
        } else {
            return Redirect::back()->withInput($request->input())->with('message', '注册失败，请检查是否网络问题');
        }
    }

    /**
     * 更新
     * @author JokerLinly
     * @date   2016-09-13
     * @param  Request    $request [description]
     */
    public function UpdatePcer(Request $request)
    {
        $request->flash();
        $input = $request->input();
        $validation = Validator::make($input,[
                'name' => 'required',
                'long_number' => 'required|digits:11',
                'school_id' => 'required|digits:9',
                'address' => 'required',
                'clazz' => 'required',
                'major' => 'required',
                'department' => 'required',
                'sex'=> 'required'
        ]);

        if ($validation->fails()) {
         return Redirect::back()->withInput($input)->withMessage('亲(づ￣3￣)づ╭❤～内容要正确填写喔！请仔细查看手机号码或者学号是否正确！另外年级和地址要重新填写喔！');
        }
        // $input['wcuser_id'] = session('wcuser_id');
        $input['wcuser_id'] = 701;
        $pcer = PcerModule::updatePcer($input);
        if ($pcer) {
            return Redirect::back()->withInput($input)->with('message', '更新成功！');
        } else {
            return Redirect::back()->withInput($input)->with('message', '更新失败！请检查是否网络问题');
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
