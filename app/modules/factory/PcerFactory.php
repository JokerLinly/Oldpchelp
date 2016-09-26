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
        if (!in_array('pcerlevel_id', $need)) {
            array_push($need, 'pcerlevel_id');
        }
        $pcer = self::PcerModel()->where($condition, $data)->select($need)->first()->setAppends(['level_name']);
        if ($pcer) {
            return $pcer->toArray();
        }
        return $pcer;
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
        $pcer->sex = $input['sex'];
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
        $result = self::PcerModel()->where('wcuser_id', $input['wcuser_id'])->update($input);
        return $result;
    }

    /**
     * 获取值班时间
     * @author JokerLinly
     * @date   2016-09-26
     * @param  [type]     $id [description]
     * @return [type]         [description]
     */
    public static function getIdleToPcer($id)
    {
        $pcer = self::PcerModel()->where('wcuser_id', $id)
            ->select('id', 'nickname')
            ->with(['idle'=>function ($query) {
                $query->select('id', 'pcer_id', 'date')
                ->orderBy('date', 'ASC')
                ->get()
                ->each(function ($item) {
                    $item->setAppends(['chain_date']);
                });
            }])
            ->first();
        if ($pcer) {
            return $pcer->toArray();
        }
        return $pcer;
    }

    /**
     * 查询是否存在该值班时间
     * @author JokerLinly
     * @date   2016-09-26
     * @param  [type]     $wcuser_id [description]
     * @param  [type]     $date      [description]
     * @return [type]                [description]
     */
    public static function searchIdle($wcuser_id, $date)
    {
        $pcer = self::PcerModel()->where('wcuser_id', $wcuser_id)
            ->select('id')
            ->whereHas('idle', function ($query) use ($date) {
                $query->where('date', 'like', $date);
            })
            ->first();
        if ($pcer) {
            return true;
        }
        return false;
    }

    /**
     * 增加值班时间
     * @author JokerLinly
     * @date   2016-09-26
     * @param  [type]     $pcer_id [description]
     * @param  [type]     $date    [description]
     */
    public static function addIdle($pcer_id, $date)
    {
        $idle = self::IdleModel();
        $idle->pcer_id = $pcer_id;
        $idle->date = $date;
        $idle->save();
        return $idle;
    }

    public static function delIdle($pcer_id, $idle_id)
    {
        $res = self::IdleModel()
            ->where('id',$idle_id)
            ->where('pcer_id',$pcer_id)
            ->delete();
        return $res;
    }
}
