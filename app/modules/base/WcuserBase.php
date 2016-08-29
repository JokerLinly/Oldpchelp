<?php
namespace App\modules\base;

use App\modules\Model\Wcuser;
use App\modules\Model\Ticket;

/**
* 微信用户的基础类
*/
class WcuserBase
{
    public static function WcuserModel()
    {
        return new Wcuser();
    }

    public static function TicketModel()
    {
        return new Ticket();
    }
}