<?php
namespace App\modules\factory;

use App\modules\base\RelyBase;

/**
* 消息自动回复工厂类
*/
class RelyFactory extends RelyBase{

    /**
     * 获取被添加自动回复、消息自动回复的内容
     * @author JokerLinly
     * @date   2016-09-15
     * @param  [type]     $state [description]
     * @return [type]            [description]
     */
    public static function getRely($state)
    {
        $rely = self::RelyModel()->where('state',$state)->first();
        if (!$rely) {
            return $rely;
        }
        return $rely->toArray();
    }

    /**
     * 获取全匹配式关键词自动回复
     * @author JokerLinly
     * @date   2016-09-15
     * @param  [type]     $content [description]
     * @return [type]              [description]
     */
    public static function getFullMatch($content)
    {
        $rely = self::RelyModel()->where('state',2)
            ->where('question',$content)
            ->first();

        if (!$rely) {
            return $rely;
        }
        return $rely->toArray();
    }

    /**
     * 获取模糊匹配式关键词自动回复
     * @author JokerLinly
     * @date   2016-09-15
     * @return [type]     [description]
     */
    public static function getHalfMatch()
    {
        $rely = self::RelyModel()->where('state',3)
            ->select('question', 'answer', 'style')
            ->get();

        if (!$rely) {
            return $rely;
        }
        return $rely->toArray();
    }
}