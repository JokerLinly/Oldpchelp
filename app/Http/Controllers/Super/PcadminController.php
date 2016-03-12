<?php

namespace App\Http\Controllers\Super;

use Illuminate\Http\Request;
use Redirect,Input;
use \View;
use App\Pcadmin;
use App\Wcuser;
use App\Pcer;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class PcadminController extends Controller
{
    public function set($id)
    {
        $pcadmin = Pcadmin::withTrashed()->where('pcer_id',$id)->first(); //判断pcadmin是否存在
        $wcuser_id = Pcer::find($id)->first()->wcuser_id; //查找他的wcuser_id
        $state = Wcuser::where('id',$wcuser_id)->first()->state;//判断他之前的状态
        

        if ($pcadmin) {
            if ($pcadmin->deleted_at) {
                if( $state == 1){//如果认证成功
                    $res = $pcadmin->restore();
                    $ret = Wcuser::where('id',$wcuser_id)->update(['state'=>2]);
                }elseif ($state == 0) {
                    return "该队员尚未认证，请先认证！";
                }else{
                    return "该用户身份异常，请通知骏哥哥！";
                }
            } else {
                $res = Pcadmin::where('pcer_id',$id)->delete(); //如果存在就删除
                if ($state==2) { //如果是管理员，那么正常的状态应该是2
                    $ret = Wcuser::where('id',$wcuser_id)->update(['state'=>1]);//更改状态为 1
                } else {
                    return "该用户身份异常，请通知骏哥哥！";
                }
            }
            

            
        } else{ 
            //如果不存在先判断该成员是否认证成功，认证成功就可以创建
            if( $state == 1){//如果认证成功
                $pcadmins = new Pcadmin;
                $pcadmins->pcer_id = $id;
                $res = $pcadmins->save();
                $ret = Wcuser::where('id',$wcuser_id)->update(['state'=>2]);
            }elseif ($state == 0) {
                return "该队员尚未认证，请先认证！";
            }else{
                return "该用户身份异常，请通知骏哥哥！";
            }
            
        }
        

        if (Pcadmin::where('pcer_id',$id)->first()) {
            $state = 1;
        } else {
            $state = 0;
        }
        
        /*$res 是对pcadmin的操作 $ret是对wcuser的操作*/
        if ($res && $ret ) {
            return $state;
        } else {
            return "error";
        }
    }
}
