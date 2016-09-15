<?php
namespace  App\modules\module;

use App\modules\factory\RelyFactory;
use ErrorMessage;

/**
* 模块
*/
class RelyModule 
{
    /**
     * 获取被添加自动回复、消息自动回复的内容
     * @author JokerLinly
     * @date   2016-09-15
     * @param  [type]     $state [description]
     * @return [type]            [description]
     */
    public static function getRely($state)
    {
        return RelyFactory::getRely($state);
    }

    /**
     * 精确搜索
     * @author JokerLinly
     * @date   2016-09-15
     * @param  [type]     $content [description]
     * @return [type]              [description]
     */
    public static function getFullMatch($content)
    {
        return RelyFactory::getFullMatch($content);
    }

    /**
     * 模糊搜索
     * @author JokerLinly
     * @date   2016-09-15
     * @param  [type]     $content [description]
     * @return [type]              [description]
     */
    public static function getHalfMatch($content)
    {
        $half_match = RelyFactory::getHalfMatch();
        if (is_array($half_match) && !empty($half_match)) {
            foreach ($half_match as $key => $value) {
                if (strstr($content,$value['question'])) {
                    return $value;
                }
            }
            return null;
        } else {
            return $half_match;
        }
    }
}