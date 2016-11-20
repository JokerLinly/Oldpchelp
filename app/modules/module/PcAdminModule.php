<?php
namespace  App\modules\module;

use App\modules\factory\PcAdminFactory;

/**
* PC叻仔模块
*/
class PcAdminModule
{
    public static function getAdminSet($id)
    {
        $result = PcAdminFactory::getAdminSet($id);
        return $result;
    }
}