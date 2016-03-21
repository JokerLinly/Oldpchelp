<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use DB,Redirect, Input,Validator,Session;
use \View;
use App\Ticket;
use App\Pcadmin;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class TicketController extends Controller
{
    public function ticketlock($id)
    {
       $pcadmin_id = Session::get('pcadmin_id');
       $ispcadmin = Ticket::find($id)->pcadmin_id;
       if ($ispcadmin) {
           $res = Ticket::where('id',$id)->update(['pcadmin_id' => '']);
           if ($res) {
               return "unlock";
           } else {
               return "网络异常！";
           }          
       }else{ 
           $res = Ticket::where('id',$id)->update(['pcadmin_id' => $pcadmin_id]);
           if ($res) {
               return "lock";
           } else {
               return "网络异常！";
           }
           
       }
    }

    public function pcersingle()
    {
        $pcadmin_id = Session::get('pcadmin_id');
        if (Input::get('pcer_id')) {
            $res = Ticket::where('id',Input::get('id'))->update(['pcer_id'=>Input::get('pcer_id'),'pcadmin_id'=>$pcadmin_id]);
            if ($res) {
                return Redirect::back();
            } else {
                return Redirect::back()->with('message', '网络异常');
            }
            
        } else {
            return Redirect::back();
        }
        
    }

    public function myticket()
    {
      $pcadmin_id = Session::get('pcadmin_id');
      dd($pcadmin_id);
      return view::make('Admin.mytickets');
    }
}
