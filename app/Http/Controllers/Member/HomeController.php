<?php

namespace App\Http\Controllers\Member;

use Redirect;
use Validator;
use Session;
use \View;
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
    public function index(Request $request)
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
    public function getAddPcer(Request $request)
    {
        $id = session('wcuser_id');
        $wcuser = WcuserModule::getWcuserById(['id', 'state'], $id);

        if ($wcuser['state'] != 0) {
            return Redirect::action('Member\HomeController@showPcer');
        }

        $pcer = PcerModule::getPcerByWcuserId($wcuser['id'], ['id']);
        if (is_array($pcer) && !empty($pcer)) {
            return Redirect::action('Member\HomeController@showPcer');
        }
        
        $pcerlevel = PcerModule::getLevel();
        if (!is_array($pcerlevel) && empty($pcerlevel)) {
            return View::make('error');
        }
        return view('Member.home', ['pcerLevels'=>$pcerlevel]);
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

        $pcer = PcerModule::getPcer('wcuser_id', $input['wcuser_id'], ['name', 'school_id', 'pcerlevel_id', 'long_number', 'number', 'department', 'major', 'clazz', 'address', 'area', 'sex']);
        if (!is_array($pcer) && empty($pcer)) {
            return View::make('error');
        }

        $pcerlevel = PcerModule::getLevel();
        if (!is_array($pcerlevel) && empty($pcerlevel)) {
            return View::make('error');
        }
        return view('Member.personDataChange', ['pcer'=>$pcer, 'pcerLevels'=>$pcerlevel]);
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
        $validation = Validator::make($input, [
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
        $is_pcer = PcerModule::getPcerByWcuserId($input['wcuser_id'], ['id']);
        if (!empty($is_pcer)) {
            return Redirect::action('Member\HomeController@showPcer');
        }

        $pcer = PcerModule::addPcer($input);
        if (!is_array($pcer) && empty($pcer)) {
            return Redirect::back()->withInput($input)->with('message', '注册失败，请检查是否网络问题');
        } else {
            return Redirect::action('Member\HomeController@showPcer');
        }
    }

    /**
     * 更新
     * @author JokerLinly
     * @date   2016-09-13
     * @param  Request    $request [description]
     */
    public function updatePcer(Request $request)
    {
        $request->flash();
        $input = $request->input();
        $validation = Validator::make($input, [
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
        $pcer = PcerModule::updatePcer($input);
        if ($pcer) {
            return Redirect::back()->withInput($input)->with('message', '更新成功！');
        } else {
            return Redirect::back()->withInput($input)->with('message', '更新失败！请检查是否网络问题');
        }
    }
    
    /**
     * 获取值班时间
     * @author JokerLinly
     * @date   2016-09-26
     * @param  Request    $request [description]
     * @return [type]              [description]
     */
    public function getIdle(Request $request)
    {
        $pcer = PcerModule::getIdleToPcer(session('wcuser_id'));
        return View::make('Member.personData', ['pcer'=>$pcer]);
    }

    /**
     * 增加值班时间
     * @author JokerLinly
     * @date   2016-09-26
     * @param  Request    $request [description]
     */
    public function addIdle(Request $request)
    {
        $date = $request->input()['date'][0];
        if (empty($date)) {
            return Redirect::back()->withMessage('参数有误');
        }
        $is_exist = PcerModule::searchIdle(session('wcuser_id'), $date);
        if ($is_exist) {
            return Redirect::back()->withMessage('该时间段已经存在！');
        }
        $res = PcerModule::addIdle(session('wcuser_id'), $date);
        if ($res) {
            return Redirect::back()->withMessage('增加成功！');
        } else {
            return Redirect::back()->withMessage('网络异常！');
        }
    }

    /**
     * 删除空闲时间
     * @author JokerLinly
     * @date   2016-09-26
     * @param  Request    $request [description]
     * @return [type]              [description]
     */
    public function delIdle(Request $request)
    {
        $idle_id = $request->input()['idle_id'];
        if (empty($idle_id)) {
            return Redirect::back()->withMessage('参数有误');
        }
        
        $res = PcerModule::delIdle(session('wcuser_id'), $idle_id);
        if ($res) {
            return Redirect::back()->withMessage('删除成功！');
        } else {
            return Redirect::back()->withMessage('网络异常！');
        }
    }

    /**
     * 编辑注册信息
     * @author JokerLinly
     * @date   2016-09-26
     * @param  Request    $request [description]
     * @return [type]              [description]
     */
    public function getPerson(Request $request)
    {
        $pcer = PcerModule::getPcer('wcuser_id', session('wcuser_id'), ['name', 'school_id', 'pcerlevel_id', 'long_number', 'number', 'department', 'major', 'clazz', 'address', 'area', 'sex', 'nickname']);
        if (!is_array($pcer) && empty($pcer)) {
            return View::make('error');
        }
        $pcerlevel = PcerModule::getLevel();
        if (!is_array($pcerlevel) && empty($pcerlevel)) {
            return View::make('error');
        }
        return view('Member.setting', ['pcer'=>$pcer, 'pcerLevels'=>$pcerlevel]);
    }
}
