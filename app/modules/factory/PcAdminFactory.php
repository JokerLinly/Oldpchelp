<?php 
namespace App\modules\factory;

use App\modules\base\PcAdminBase;

/**
* PC仔工厂类
*/
class PcAdminFactory extends PcAdminBase{

    public static function getAdminSet($id)
    {
        $pcadmin = self::PcAdminModel()->where('pcer_id', $id)->first(); //判断pcadmin是否存在
        $wcuser_id = self::PcerModel()->find($id)->wcuser_id; //查找他的wcuser_id
        $wcuser = self::WcuserModel()->where('id', $wcuser_id)->first();//判断他之前的状态
        if ($pcadmin) {
            if ($pcadmin->is_work == 1 && $wcuser->state == 2) { //是管理员身份
                $pcadmin->is_work = 0;
                $wcuser->state = 1;
            } elseif ($pcadmin->is_work == 0 && $wcuser->state == 1) { //不是管理员身份
                $pcadmin->is_work = 1;
                $wcuser->state = 2;
            } else {
                return "用户身份异常，请通知骏哥哥！";
            }
        } else{ 
            //如果不存在先判断该成员是否认证成功，认证成功就可以创建
            if($wcuser->state == 1){//如果认证成功
                $pcadmin = self::PcAdminModel();
                $pcadmin->pcer_id = $id;
                $pcadmin->is_work = 1;
                $wcuser->state = 2;
            }elseif ($wcuser->state == 0) {
                return "该队员尚未认证，请先认证！";
            }else{
                return "该用户身份异常，请通知骏哥哥！";
            }
            
        }
        $res = $pcadmin->save();
        $ret = $wcuser->save();         
        
        /*$res 是对pcadmin的操作 $ret是对wcuser的操作*/
        if ($res && $ret ) {
            return $pcadmin->is_work;
        } else {
            return "error";
        }
    }
}