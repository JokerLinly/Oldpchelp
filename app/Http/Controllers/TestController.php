<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use EasyWeChat\Foundation\Application;
use Redirect,Input, Auth;
use EasyWeChat;
use App\modules\module\WcuserModule;

class TestController extends Controller {

    public function index()
   {
        $ticket = \App\modules\module\TicketModule::getTicketById(102);
        if (is_array($ticket) && !empty($ticket['err_code'])) {
            return ErrorMessage::getMessage(10000);
        }

        $comments = \App\modules\module\TicketModule::getCommentByTicket(102);
        
        if (is_array($comments) && !empty($comments['err_code'])) {
            return ErrorMessage::getMessage(10000);
        }
        
        return view('Ticket.ticketData',compact('ticket','comments'));

    }

}
