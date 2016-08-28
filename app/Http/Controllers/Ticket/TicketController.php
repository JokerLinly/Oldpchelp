<?php

namespace App\Http\Controllers\Ticket;

use Illuminate\Http\Request;
use DB;
use Redirect,Session;
use \View;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use EasyWeChat;
use App\modules\module\TicketModule;
use App\modules\module\WcuserModule;
use ErrorMessage;

class TicketController extends Controller
{
    /**
     * 用户查看订单
     * @author JokerLinly
     * @date   2016-08-28
     * @param  Request    $request [description]
     * @return [type]              [description]
     */
    public function index(Request $request){
        $wcuser_id = $request->wcuser_id;
        if (empty($wcuser_id)||$wcuser_id < 1 ) {
            return ErrorMessage::getMessage(10000);
        }
        $tickets = TicketModule::searchTicket($wcuser_id);
        return view('Ticket.ticketList',compact('tickets'));
    }

    /**
     * 用户查看单个订单
     * @author JokerLinly
     * @date   2016-08-28
     * @param  [type]     $openid [description]
     * @param  [type]     $id     [description]
     * @return [type]             [description]
     */
    public function getShow($ticket_id)
    {
        if (empty($ticket_id)||$ticket_id < 1 ) {
            return ErrorMessage::getMessage(10000);
        }

        $ticket = TicketModule::getTicketById($ticket_id);

        if (is_array($ticket) && !empty($ticket['err_code'])) {
            return ErrorMessage::getMessage(10000);
        }
        dd($ticket->created_at);
        $comments = TicketModule::getCommentByTicket($ticket_id);
        
        if (is_array($comments) && !empty($comments['err_code'])) {
            return ErrorMessage::getMessage(10000);
        }
        return view('Ticket.ticketData',compact('ticket','comments'));
        
    }

    public function postEdit()
    {
        $ticket_id = Input::get('ticket_id');
        $validation = Validator::make(Input::all(),[
                'text' => 'required',
            ]);
        if ($validation->fails()) {
         return Redirect::bacn()->withMessage('亲(づ￣3￣)づ╭❤～内容要填写喔！');
        }
            $comment = new Comment;
            $comment->ticket_id = Input::get('ticket_id');
            $comment->from = Input::get('from');
            $comment->wcuser_id = Input::get('wcuser_id');
            $comment->text = Input::get('text');

            $res = $comment->save();

            if ($res) {
                $ticket = Ticket::where('id',$ticket_id)
                                ->with(['pcer'=>function($query){
                                    $query->with('wcuser');
                                }])->first();
                $comments  = Comment::where('wcuser_id',Input::get('wcuser_id'))->where('from',0)->where('created_at','>=',$ticket->updated_at)->get();
                if ($comments->count()==1) {
                    if ($ticket->pcer_id) {
                    /*获取PC队员的openid*/
                      $pcer_openid = $ticket->pcer->wcuser->openid;
                      $notice_pcer = EasyWeChat::notice();
                      $templateId_pcer = 'aCZbEi9-JZbkR4otY8tkeFFV2zwf-lUFKFbos49h1Qc';
                      $url_pcer = "http://pc.nfu.edu.cn/pcertickets/{$pcer_openid}/{$ticket->id}/show";
                      $color_pcer = '#FF0000';
                      $data_pcer = array(
                        "first"    => "机主给你发来消息！",
                        "keynote1" => $comment->text,
                        "keynote2" => "就是现在！",
                        "remark"   => "请尽快处理！么么哒(づ￣ 3￣)づ",
                      );
                      $messageId = $notice_pcer->uses($templateId_pcer)->withUrl($url_pcer)->andData($data_pcer)->andReceiver($pcer_openid)->send();
                    }
                }
                return Redirect::back();
            } else {
                return Redirect::back()->withMessage('网络问题，提交失败，请重新提交(づ￣ 3￣)づ');
            }  
    }

    public function postUpdate()
    {

        $res = Ticket::where('id',Input::get('ticket_id'))
              ->update(['assess'=>Input::get('assess'),'suggestion'=>Input::get('suggestion')]);

        if ($res) {
            return Redirect::back();
        } else {
             return Redirect::back()->withMessage('网络问题，提交失败，请重新提交(づ￣ 3￣)づ');
        }
        
    }

    public function deleteDelticket($openid,$id)
    {
        $openid = Wcuser::where('id',Input::get('wcuser_id'))->first()->openid;
        $res = Ticket::where('id',$id)->delete();
        if ($res) {
            return Redirect::to('mytickets/'.$openid.'/ticketList');
        } else {
            return Redirect::back()->withInput()->withMessage('网络问题，提交失败，请重新提交(づ￣ 3￣)づ');
        }
    }

    public function getCreate($openid,$id)
    {
        $ticket = Ticket::where('id',$id)->first();
        return View::make('Ticket.ticketChange',['ticket'=>$ticket]);
    }

    public function postTicketchange($openid,$id)
    {
        $validation = Validator::make(Input::all(),[
                'name' => 'required',
                'number' => 'required|digits:11',
                'address' => 'required',
                'problem' => 'required',
            ]);
        if ($validation->fails()) {
         return Redirect::back()->withInput(Input::all())->withMessage('亲(づ￣3￣)づ╭❤～内容都要填写喔！检查下手机号码是否写正确了，另外地址要重新核对喔！');
        }

        $name = Input::get('name');
        $number = Input::get('number');
        $shortnum = Input::get('shortnum');
        $area = Input::get('area');
        $address = Input::get('address');
        $date = Input::get('date');
        $hour = Input::get('hour');
        $problem = Input::get('problem');
        $hour1 = Input::get('hour1');
        $date1 = Input::get('date1');   

        $res = Ticket::where('id',$id)->update(['name'=>$name,'number'=>$number,'shortnum'=>$shortnum,'area'=>$area,'address'=>$address,'date'=>$date,'hour'=>$hour,'problem'=>$problem,'date1'=>$date1,'hour1'=>$hour1]);
        if ($res) {
            return Redirect::to('mytickets/'.$openid.'/'.$id.'/show')->withMessage('亲(づ￣3￣)づ╭❤～修改成功');
        } else {
            return Redirect::back()->withMessage('亲(づ￣3￣)づ╭❤～内容都要填写喔！');
        }
        
    }

}
