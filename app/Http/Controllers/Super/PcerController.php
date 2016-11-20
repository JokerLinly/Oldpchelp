<?php

namespace App\Http\Controllers\Super;

use Illuminate\Http\Request;
use Redirect,Input,Validator;
use \View;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\modules\module\PcerModule;

class PcerController extends Controller
{
    /**
     * pc仔管理界面
     * @author JokerLinly
     * @date   2016-11-19
     * @return [type]     [description]
     */
    public function getIndex()
    {
        $pcerLevels = PcerModule::getLevel(); 
        $pcers = PcerModule::getPcerToSuper();
        return view::make('Super.pcer',['pcers'=>$pcers,'pcerLevels'=>$pcerLevels]);
    }

    /**
     * PC仔权限设置
     * @author JokerLinly
     * @date   2016-11-20
     * @param  [type]     $id [description]
     * @return [type]         [description]
     */
    public function getPcerset($id)
    {
        $result = PcerModule::getPcerSet($id);
        return $result;
    }

    /**
     * PC仔值班设置
     * @author JokerLinly
     * @date   2016-11-20
     * @param  [type]     $id [description]
     * @return [type]         [description]
     */
    public function getIsWorkSet($id)
    {
        $result = PcerModule::getIsWorkSet($id);
        return $result;
    }

    /**
     * PC年级设置
     * @author JokerLinly
     * @date   2016-11-20
     * @return [type]     [description]
     */
    public function getLevelSet()
    {
        $pcerlevels = PcerModule::getLevelSet();
        return view::make('Super.pcerset',['pcerlevels'=>$pcerlevels]);
    }

    /**
     * 年级显示
     * @author JokerLinly
     * @date   2016-11-20
     * @param  [type]     $id [description]
     * @return [type]         [description]
     */
    public function getLevelshow($id)
    {
        $result = PcerModule::getLevelshow($id);
        return $result;
    }

    /**
     * 增加年级
     * @author JokerLinly
     * @date   2016-11-20
     * @return [type]     [description]
     */
    public function leveladd()
    {
        Input::flash();
        $validation = Validator::make(Input::all(),[
                'level_name' => 'required',
            ]);
        if ($validation->fails()) {
         return Redirect::back()->withInput(Input::all())->withMessage('亲(づ￣3￣)づ╭❤～内容要填写喔！');
        }

        $result = PcerModule::addLevel(Input::get('level_name'));
        if (!$result) {
            return Redirect::back()->withInput(Input::all())->with('message', '提交失败，请重新提交');
        }

        return Redirect::back();
    }

}
