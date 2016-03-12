<?php

namespace App\Http\Controllers\Super;

use Illuminate\Http\Request;
use Redirect,Input,Validator;
use \View;
use App\Ticket;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with('pcer')
                        ->with(['pcadmin'=>function($query){
                            $query->with('pcer');
                        }])->get();
        return view::make('Super.tickets',['tickets'=>$tickets]);
    }
}
