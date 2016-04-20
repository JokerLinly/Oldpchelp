@extends('alayout')
@section('main')
<em style="font-size: 25px;font-family: youyuan;margin-left:20px;margin-bottom: 10px; ">未分配订单</em>
@if($tickets->count())
            <div class="col-md-12">
              <table class="table table-hover">
              
                <thead>
                  <tr>
                    <th style="width: 1%;">#</th>
                    <th>问题</th>
                    <th style="width: 10%;">宿舍</th>
                    <th style="width: 9%;">报修至今</th>
                    <th style="width: 12%;">上门时间</th>
                    <th style="width: 7%;">订单会话</th>
                    <th style="width: 5%;text-align:center">解锁</th>
                    <th style="width: 11%;"><font style="color: red;">今晚</font>值班人员</th>
                    <th style="width: 5%;">
                    </th>
                  </tr>
                </thead>
                @foreach($tickets as $ticket)
                @if ($ticket->pcer_id)
                @else         
                  <tbody>
                    <tr>
                      <td>{{$ticket->id}}</td>
                      <td>{{$ticket->problem}}</td>
                      <td>
                          @if(($ticket->area)==0){{'东区'}}
                          @elseif (($ticket->area)==1){{'西区'}}
                          @endif{{$ticket->address}}
                      </td>
                      <td>{{$ticket->differ_time}}</td>
                      <td>
                            @if(($ticket->date)==1){{'星期一'}}
                              @elseif (($ticket->date)==2){{'星期二'}}
                              @elseif (($ticket->date)==3){{'星期三'}}
                              @elseif (($ticket->date)==4){{'星期四'}}
                              @elseif (($ticket->date)==5){{'星期五'}}
                              @elseif (($ticket->date)==6){{'星期六'}}
                              @elseif (($ticket->date)==0){{'星期日'}}
                              @endif
                            {{$ticket->hour}}
                          @if($ticket->date1)
                              &nbsp;或&nbsp;
                              @if(($ticket->date1)==1){{'星期一'}}
                              @elseif (($ticket->date1)==2){{'星期二'}}
                              @elseif (($ticket->date1)==3){{'星期三'}}
                              @elseif (($ticket->date1)==4){{'星期四'}}
                              @elseif (($ticket->date1)==5){{'星期五'}}
                              @elseif (($ticket->date1)==6){{'星期六'}}
                              @elseif (($ticket->date1)==0){{'星期日'}}
                              @endif
                          {{$ticket->hour1}}
                          @endif
                      </td>
                      <td style="text-align:center">
                        @if($ticket->comment->count())
                          <a href="home" data-toggle="modal" data-target="#home{{$ticket->id}}" data-original-title title><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></a>
                        @else <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
                        @endif
                      </td>
                        <form action="unlock" method="POST" style="display: inline;">
                        <td>
                            <input type="hidden" name="id" id="id" value="{{$ticket->id}}" >
                            <button type="submit" class="btn btn-info btn-xs" style="width: 60px;" >解锁</button>
                        </td>
                        </form>
                      <form action="unset/beforeset" method="POST" style="display: inline;">
                      <td>
                          @if($tpcers)
                          <select name="pcer_id" id="pcer_id">
                          <option></option>
                          @foreach ($tpcers as $tpcer)
                              <option  value="{{$tpcer->pcer->id}}">
                              @if(($tpcer->pcer->area)==0){{'东区'}}
                              @elseif (($tpcer->pcer->area)==1){{'西区'}}
                              @endif
                              {{$tpcer->pcer->name}}
                              </option>
                          @endforeach   
                          </select>
                          @endif
                      </td>
                      <td>
                            <input type="hidden" name="id" id="id" value="{{$ticket->id}}" >
                            <button type="submit" class="btn btn-primary btn-xs" style="width: 60px;" >发送</button>       
                      </td>
                      </form>
                    </tr>
                  </tbody>
                @endif
                @endforeach
              </table>
            </div>
@else <br>你没有任何未分配的订单喔
@endif

@foreach ($tickets as $ticket)
<!-- Modal -->
<div class="modal fade" id="home{{$ticket->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">订单会话</h4>
      </div>
      <div class="modal-body">
        <h4><strong>公开会话</strong></h4>
        @foreach ($ticket->comment as $comment)
            @if(($comment->from)==0)
            <p style="float: right">{{$comment->created_time}}</p>
            <p>机主说：{{$comment->text}} </p> 

            @elseif(($comment->from)==2)
            <p style="float: right">{{$comment->created_time}}</p>
            <p>PC仔{{$comment->wcuser->pcer->name}}说：{{$comment->text}} </p> 
            @elseif(($comment->from)==3)
            <p style="float: right">{{$comment->created_time}}</p>
            <p> @if($comment->wcuser->pcer)PC管理员{{$comment->wcuser->pcer->name}} @else 其他PC管理员 @endif
            说：{{$comment->text}} </p> 
            @endif
        @endforeach
        <hr>

        <h4><strong>队内私聊</strong></h4>
          @foreach ($ticket->comment as $comment)
            @if(($comment->from)==4)
            <p style="float: right">{{$comment->created_time}}</p>
            <p>@if($comment->wcuser->pcer)PC管理员{{$comment->wcuser->pcer->name}} @endif 说：{{$comment->text}} </p> 
        
            @elseif(($comment->from)==1)
            <p style="float: right">{{$comment->created_time}}</p>
            <p>PC仔{{$comment->wcuser->pcer->name}}说：{{$comment->text}} </p> 
            @endif
          @endforeach
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@endforeach
@stop