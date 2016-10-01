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
     * 通过wcuserid查询pcer
     * @author JokerLinly
     * @date   2016-09-26
     * @param  [type]     $wcuser_id [description]
     * @param  [type]     $need      [description]
     * @return [type]                [description]
     */
    public static function getPcerByWcuserId($wcuser_id, $need)
    {
        if (!isset($need['wcuser_id'])) {
            array_push($need, 'wcuser_id');
        }
        if (!isset($need['created_at'])) {
            array_push($need, 'created_at');
        }
        $pcer = self::PcerModel()->where('wcuser_id', $wcuser_id)
            ->with(['wcuser'=>function ($query) {
                $query->select('id', 'state');
            }])
            ->select($need)->first()
            ->setAppends(['differ_time']);;
        if ($pcer) {
            return $pcer->toArray();
        }
        return $pcer;
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
        if (!in_array('wcuser_id', $need)) {
            array_push($need, 'wcuser_id');
        }
        $pcer = self::PcerModel()->where($condition, $data)
            ->select($need)
            ->with(['wcuser'=>function ($query) {
                $query->select('id', 'state');
            }])
            ->first()
            ->setAppends(['level_name']);
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
            ->select('id', 'nickname', 'ot')
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

    /**
     * 删除值班时间
     * @author JokerLinly
     * @date   2016-09-28
     * @param  [type]     $pcer_id [description]
     * @param  [type]     $idle_id [description]
     * @return [type]              [description]
     */
    public static function delIdle($pcer_id, $idle_id)
    {
        $res = self::IdleModel()
            ->where('id', $idle_id)
            ->where('pcer_id', $pcer_id)
            ->delete();
        return $res;
    }

    public static function getDatePcer($date)
    {
        $pcers = self::PcerModel()
                ->where('state', 0)
                ->whereHas('idle', function ($query) use ($date) {
                    $query->where('date', 'like', $date);
                })
                ->get(['id', 'name']);
        if ($pcers) {
            return $pcers->toArray();
        }
        return $pcers;
    }

    public static function getPcerOT()
    {
        $pcers = self::PcerModel()
            ->where('ot', 1)
            ->where('state', 0)
            ->whereDoesntHave('idle', function ($query) {
                $query->where('date', 'like', date('w'));
            })
            ->get(['id', 'name']);
        if ($pcers) {
            return $pcers->toArray();
        }
        return $pcers;
    }

    public static function changeStateOT($id)
    {
        $pcer = self::PcerModel()
            ->where('id', $id)
            ->select('ot')
            ->first();
        if ($pcer->ot == 0) {
            $res = self::PcerModel()
                ->where('id', $id)
                ->update(['ot'=>1]);
        } elseif ($pcer->ot == 1) {
            $res = self::PcerModel()
                ->where('id', $id)
                ->update(['ot'=>0]);
        }
        return $res;
    }
}
