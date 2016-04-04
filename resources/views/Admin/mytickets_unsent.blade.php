@extends('alayout')
@section('main')
<em style="font-size: 25px;font-family: youyuan;margin-left:20px;margin-bottom: 10px; ">未发送订单</em>
@if($tickets->count())
<div class="table-responsive">
  <table class="table table-hover">
    <thead>
      <tr>
        <th style="width: 1%;">#</th>
        <th>问题</th>
        <th style="width: 11%;">上门时间</th>
        <th style="width: 9%;">订单创建至今</th>
        <th style="width: 8%;text-align:center">负责队员</th>
        <th style="width: 5%;">解锁</th>
        <th style="width: 7%;">
            <form action="mytickets/sentall" method="GET" style="display: inline;">
            <button type="submit" class="btn btn-primary btn-xs" style="width: 60px;" >全部发送</button>
            </form>
        </th>
      </tr>
    </thead>
    @foreach ($tickets as $ticket) 
    <tbody>
      <tr>
        <td style="text-align:center">{{$ticket->id}}</td>
        <td>{{$ticket->problem}}</td>
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
        <td style="text-align:center">{{$ticket->differ_time}}</td>
        <td class="member" style="text-align:center">{{$ticket->pcer->name}}</td>
        <form action="mytickets/unlock" method="POST" style="display: inline;">
        <td>
            <input type="hidden" name="id" id="id" value="{{$ticket->id}}" >
            <button type="submit" class="btn btn-info btn-xs" style="width: 60px;" >解锁</button>
        </td>
        </form>
        <form action="mytickets/sent" method="POST" style="display: inline;">
        <td>
            <input type="hidden" name="id" id="id" value="{{$ticket->id}}" >
            <button type="submit" class="btn btn-success btn-xs" style="width: 60px;" >发送</button>      
        </td>
        </form>
      </tr>
    </tbody>
    @endforeach
  </table>
</div>
@else <br>你没有任何未发送的订单喔
@endif

@stop