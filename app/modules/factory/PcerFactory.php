<?php 
namespace App\modules\factory;

use App\modules\base\PcerBase;

/**
* PC仔工厂类
*/
class PcerFactory extends PcerBase{

    /**
     * 获取PC年级信息
     * @author JokerLinly
     * @date   2016-09-13
     * @return [type]     [description]
     */
    public static function getPcerlevel()
    {
        $pcerlevel = self::PcerlevelModel()->get(['id', 'level_name']);
        if (!$pcerlevel) {
            return $pcerlevel;
        }
        return $pcerlevel->toArray();
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
    public static function getPcer($condition, $data, $need)
    {
        $pcer = self::PcerModel()->where($condition,$data)->select($need)->first();
        if (!$pcer) {
            return $pcer;
        }
        return $pcer->toArray();
    }

    /**
     * 增加PC仔
     * @author JokerLinly
     * @date   2016-09-14
     * @param  [type]     $input [description]
     */
    public static function addPcer($input)
    {
        $pcer = self::PcerModel();
        $pcer->wcuser_id = $input['wcuser_id'];
        $pcer->name = $input['name'];
        $pcer->school_id = $input['school_id'];
        $pcer->pcerlevel_id = $input['pcerlevel_id'];
        $pcer->long_number = $input['long_number'];
        if ($input['number']) {
            $pcer->number = $input['number'];
        } 
        $pcer->department = $input['sex'];
        $pcer->department = $input['department'];
        $pcer->major = $input['major'];
        $pcer->clazz = $input['clazz'];
        $pcer->address = $input['address'];
        $pcer->area = $input['area'];
        $result = $pcer->save();
        if (!$result) {
            return $pcer;
        }
        return $pcer->toArray();
    }

    /**
     * 更新PC仔信息
     * @author JokerLinly
     * @date   2016-09-14
     * @param  [type]     $input [description]
     * @return [type]            [description]
     */
    public static function updatePcer($input)
    {
        $result = self::PcerModel()->where('wcuser_id',$input['wcuser_id'])->update($input);
        return $result;
    }
}