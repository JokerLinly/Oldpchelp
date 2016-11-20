<?php

namespace App\Http\Controllers\Super;

use Illuminate\Http\Request;
use Redirect,Input;
use \View;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\modules\module\PcAdminModule;

class PcadminController extends Controller
{
    /**
     * PC叻仔权限设置
     * @author JokerLinly
     * @date   2016-11-20
     * @param  string     $value [description]
     * @return [type]            [description]
     */
    public function getAdminSet($id)
    {
        $result = PcAdminModule::getAdminSet($id);
        return $result;
    }

}
