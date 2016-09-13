<?php
namespace  App\modules\module;

use App\modules\factory\PcerFactory;
use App\modules\factory\WcuserFactory;
use ErrorMessage;

/**
* PC仔模块
*/
class PcerModule 
{
    /**
     * 获取年级信息
     * @author JokerLinly
     * @date   2016-09-13
     * @return [type]     [description]
     */
    public static function getLevel()
    {
        return PcerFactory::getPcerlevel();
    }

    /**
     * 增加PC仔
     * @author JokerLinly
     * @date   2016-09-13
     * @param  [type]     $input [description]
     */
    public static function addPcer($input)
    {
        return PcerFactory::addPcer($input);
    }

    public static function getPcer($condition, $data, $need)
    {
        return PcerFactory::getPcer($condition, $data, $need);
    }
}