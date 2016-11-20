<?php
namespace App\modules\base;

use App\modules\Model\Ticket;
use App\modules\Model\Comment;
use App\modules\Model\Pcer;
use App\modules\Model\Idle;
use App\modules\Model\Pcerlevel;
use App\modules\Model\Wcuser;
use App\modules\Model\Pcadmin;

/**
* PC管理员的基础类
*/
class PcAdminBase{

    public static function PcAdminModel()
    {
        return new Pcadmin();
    }
    /**
     * 订单模型
     * @author JokerLinly
     * @date   2016-09-13
     */
    public static function TicketModel()
    {
        return new Ticket();
    }

    /**
     * 年级信息模型
     * @author JokerLinly
     * @date   2016-09-13
     */
    public static function PcerlevelModel()
    {
        return new Pcerlevel();
    }

    /**
     * PC仔模型
     * @author JokerLinly
     * @date   2016-09-13
     */
    public static function PcerModel()
    {
        return new Pcer();
    }

    /**
     * 值班模型
     * @author JokerLinly
     * @date   2016-11-20
     */
    public static function IdleModel()
    {
        return new Idle();
    }

    /**
     * 微信用户模型
     * @author JokerLinly
     * @date   2016-11-20
     */
    public static function WcuserModel()
    {
        return new Wcuser();
    }
}