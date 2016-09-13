<?php
namespace App\modules\base;

use App\modules\Model\Ticket;
use App\modules\Model\Comment;
use App\modules\Model\Pcer;
use App\modules\Model\Idle;
use App\modules\Model\Pcerlevel;

/**
* 订单的基础类
*/
class PcerBase{
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
}