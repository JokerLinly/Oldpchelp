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

    /**
     * 自定义条件查询PC仔
     * @author JokerLinly
     * @date   2016-09-14
     * @param  [type]     $condition [description]
     * @param  [type]     $data      [description]
     * @param  [type]     $need      [description]
     * @return [type]                [description]
     */
    public static function getPcer($condition, $data, array $need)
    {
        return PcerFactory::getPcer($condition, $data, $need);
    }

    public static function updatePcer($input)
    {
        unset($input['_token']);
        return PcerFactory::updatePcer($input);
    }
}