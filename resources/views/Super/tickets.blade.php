@extends('layout')
@section('main')
        <h4>目前收到{{$tickets->count()}}张报修单，其中：</h4>

<div>
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#nohandle" aria-controls="nohandle" role="tab" data-toggle="tab">未处理&nbsp;<span class="badge" > 
    {{ App\Ticket::where('state',0)->count() }}</span></a></li>
    <li role="presentation"><a href="#nocompleted" aria-controls="nocompleted" role="tab" data-toggle="tab">未完成&nbsp;<span class="badge">{{ App\Ticket::where('state',1)->count() }}</span></a></li>
    <li role="presentation"><a href="#completed" aria-controls="completed" role="tab" data-toggle="tab">已完成&nbsp;<span class="badge">{{ App\Ticket::where('state',2)->count() }}</span></a></li>
    <li role="presentation"><a href="#good" aria-controls="good" role="tab" data-toggle="tab">好评单&nbsp;<span class="badge">{{ App\Ticket::where('assess',1)->count() }}</span></a></li>
    <li role="presentation"><a href="#well" aria-controls="well" role="tab" data-toggle="tab">中评单&nbsp;<span class="badge">{{ App\Ticket::where('assess',2)->count() }}</span></a></li>
    <li role="presentation"><a href="#bad" aria-controls="bad" role="tab" data-toggle="tab">差评单&nbsp;<span class="badge">{{ App\Ticket::where('assess',3)->count() }}</span></a></li>
  </ul>

  <!-- Tab panes -->
  
  <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="nohandle">      
            <div class="col-md-12">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>编号</th>
                    <th>机主</th>
                    <th>问题</th>
                    <th style="width: 10%">宿舍</th>
                    <th style="width: 12%">上门时间</th>
                    <th style="width: 10%">订单创建至今</th>
                    <th>detail</th>
                    <th style="width: 7%;">订单会话</th>
                  </tr>
                </thead>
                @foreach ($tickets as $ticket)
                @if ($ticket->state==0)
                <tbody >
                  <tr>
                    <td>{{$ticket->id}}</td>
                    <td>{{$ticket->name}}</td>
                    <td>{{$ticket->problem}}</td>
                    <td>@if(($ticket->area)==0){{'东区'}}
                            @elseif (($ticket->area)==1){{'西区'}}
                            @endif {{ $ticket->address }}</td>
                    <td>
                        @if(($ticket->date)==1){{'星期一'}}
                        @elseif (($ticket->date)==2){{'星期二'}}
                        @elseif (($ticket->date)==3){{'星期三'}}
                        @elseif (($ticket->date)==4){{'星期四'}}
                        @elseif (($ticket->date)==5){{'星期五'}}
                        @endif
                      {{$ticket->hour}}
                    @if($ticket->date1)
                        &nbsp;或&nbsp;
                        @if(($ticket->date1)==1){{'星期一'}}
                        @elseif (($ticket->date1)==2){{'星期二'}}
                        @elseif (($ticket->date1)==3){{'星期三'}}
                        @elseif (($ticket->date1)==4){{'星期四'}}
                        @elseif (($ticket->date1)==5){{'星期五'}}
                        @endif
                    {{$ticket->hour1}}
                    @endif
                    </td>
                    <td>{{$ticket->differ_time}}<br>{{$ticket->created_time}}</td>
                    <td ><a href="nohandle" data-toggle="modal" data-target="#nohandle{{$ticket->id}}" data-original-title title><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a></td>
                    <td style="text-align:center">
                        @if($ticket->comment->count())
                          <a href="nohandle" data-toggle="modal" data-target="#nohandle{{$ticket->id}}home" data-original-title title><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></a>
                        @else <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
                        @endif
                    </td>
                  </tr>
                </tbody>
                @endif
                @endforeach
              </table>
            </div>
            
        </div>
        <div role="tabpanel" class="tab-pane" id="nocompleted">
            <div class="col-md-12">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>编号</th>
                    <th>机主</th>
                    <th>问题</th>
                    <th>PC仔</th>
                    <th>PC保姆</th>
                    <th style="width: 12%">上门时间</th>
                    <th>报修至今</th>
                    <th>处理至今</th>
                    <th>detail</th>
                    <th style="width: 7%;">订单会话</th>
                  </tr>
                </thead>
                @foreach ($tickets as $ticket)
                @if ($ticket->state==1)
                <tbody >
                  <tr>
                    <td>{{$ticket->id}}</td>
                    <td>{{$ticket->name}}</td>
                    <td>{{$ticket->problem}}</td>
                    <td>{{$ticket->pcer->name}}
                    </td>
                    <td>@if($ticket->pcadmin_id)
                            @if ($ticket->pcadmin){{$ticket->pcadmin->pcer->name}}
                            @endif
                        @else 
                        @endif
                    </td>
                    <td>
                        @if(($ticket->date)==1){{'星期一'}}
                        @elseif (($ticket->date)==2){{'星期二'}}
                        @elseif (($ticket->date)==3){{'星期三'}}
                        @elseif (($ticket->date)==4){{'星期四'}}
                        @elseif (($ticket->date)==5){{'星期五'}}
                        @endif
                      {{$ticket->hour}}
                    @if($ticket->date1)
                        &nbsp;或&nbsp;
                        @if(($ticket->date1)==1){{'星期一'}}
                        @elseif (($ticket->date1)==2){{'星期二'}}
                        @elseif (($ticket->date1)==3){{'星期三'}}
                        @elseif (($ticket->date1)==4){{'星期四'}}
                        @elseif (($ticket->date1)==5){{'星期五'}}
                        @endif
                    {{$ticket->hour1}}
                    @endif
                    </td>
                    <td>{{$ticket->differ_time}}<br>{{$ticket->created_time}}</td>
                    <td>{{$ticket->differ_hendle}}</td>
                    <td ><a href="nocompleted" data-toggle="modal" data-target="#nocompleted{{$ticket->id}}" data-original-title title><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a></td>
                    <td style="text-align:center">
                        @if($ticket->comment->count())
                          <a href="nocompleted" data-toggle="modal" data-target="#nocompleted{{$ticket->id}}home" data-original-title title><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></a>
                        @else <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
                        @endif
                    </td>
                  </tr>
                </tbody>
                @endif
                @endforeach
              </table>
            </div>     </div>
        <div role="tabpanel" class="tab-pane" id="completed">
            <div class="col-md-12">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>编号</th>
                    <th>机主</th>
                    <th>问题</th>
                    <th>PC仔</th>
                    <th>PC保姆</th>
                    <th>机主评价</th>
                    <th>评价内容</th>
                    <th>用时</th>
                    <th>detail</th>
                    <th style="width: 7%;">订单会话</th>
                  </tr>
                </thead>
                @foreach ($tickets as $ticket)
                @if ($ticket->state==2)
                <tbody >
                  <tr>
                    <td>{{$ticket->id}}</td>
                    <td>{{$ticket->name}}</td>
                    <td>{{$ticket->problem}}</td>
                    <td>{{$ticket->pcer->name}}
                    </td>
                    <td>@if($ticket->pcadmin_id)
                            @if ($ticket->pcadmin){{$ticket->pcadmin->pcer->name}}
                            @endif
                        @else 
                        @endif
                    </td>
                    <td>@if($ticket->assess)
                            @if (($ticket->assess)==1)好评
                            @elseif (($ticket->assess)==2)中评
                            @else 差评
                            @endif
                        @endif
                    </td>
                    <td>@if($ticket->suggestion){{$ticket->suggestion}}@endif</td>
                    <td>{{$ticket->use_time}}</td>
                    <td style="text-align:center"><a href="completed" data-toggle="modal" data-target="#completed{{$ticket->id}}" data-original-title title><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a></td>
                    <td style="text-align:center">
                        @if($ticket->comment->count())
                          <a href="completed" data-toggle="modal" data-target="#completed{{$ticket->id}}home" data-original-title title><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></a>
                        @else <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
                        @endif
                    </td>
                  </tr>
                </tbody>
                @endif
                @endforeach
              </table>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="good">
            <div class="col-md-12">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>编号</th>
                    <th>机主</th>
                    <th>问题</th>
                    <th>PC仔</th>
                    <th>PC保姆</th>
                    <th>机主评价</th>
                    <th>评价内容</th>
                    <th>用时</th>
                    <th>detail</th>
                    <th style="width: 7%;">订单会话</th>
                  </tr>
                </thead>
                @foreach ($tickets as $ticket)
                @if ($ticket->assess==1)
                <tbody >
                  <tr>
                    <td>{{$ticket->id}}</td>
                    <td>{{$ticket->name}}</td>
                    <td>{{$ticket->problem}}</td>
                    <td>{{$ticket->pcer->name}}
                    </td>
                    <td>@if($ticket->pcadmin_id)
                            @if ($ticket->pcadmin){{$ticket->pcadmin->pcer->name}}
                            @endif
                        @else 
                        @endif
                    </td>
                    <td>@if($ticket->assess)
                            @if (($ticket->assess)==1)好评
                            @elseif (($ticket->assess)==2)中评
                            @else 差评
                            @endif
                        @endif
                    </td>
                    <td>@if($ticket->suggestion){{$ticket->suggestion}}@endif</td>
                    <td>{{$ticket->use_time}}</td>
                    <td ><a href="good" data-toggle="modal" data-target="#good{{$ticket->id}}" data-original-title title><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a></td>
                    <td style="text-align:center">
                        @if($ticket->comment->count())
                          <a href="good" data-toggle="modal" data-target="#good{{$ticket->id}}home" data-original-title title><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></a>
                        @else <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
                        @endif
                    </td>
                  </tr>
                </tbody>
                @endif
                @endforeach
              </table>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="well">
            <div class="col-md-12">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>编号</th>
                    <th>机主</th>
                    <th>问题</th>
                    <th>PC仔</th>
                    <th>PC保姆</th>
                    <th>机主评价</th>
                    <th>评价内容</th>
                    <th>用时</th>
                    <th>detail</th>
                    <th style="width: 7%;">订单会话</th>
                  </tr>
                </thead>
                @foreach ($tickets as $ticket)
                @if ($ticket->assess==2)
                <tbody >
                  <tr>
                    <td>{{$ticket->id}}</td>
                    <td>{{$ticket->name}}</td>
                    <td>{{$ticket->problem}}</td>
                    <td>{{$ticket->pcer->name}}
                    </td>
                    <td>@if($ticket->pcadmin_id)
                            @if ($ticket->pcadmin){{$ticket->pcadmin->pcer->name}}
                            @endif
                        @else 
                        @endif
                    </td>
                    <td>@if($ticket->assess)
                            @if (($ticket->assess)==1)好评
                            @elseif (($ticket->assess)==2)中评
                            @else 差评
                            @endif
                        @endif
                    </td>
                    <td>@if($ticket->suggestion){{$ticket->suggestion}}@endif</td>
                    <td>{{$ticket->use_time}}</td>
                    <td ><a href="well" data-toggle="modal" data-target="#well{{$ticket->id}}" data-original-title title><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a></td>
                    <td style="text-align:center">
                        @if($ticket->comment->count())
                          <a href="well" data-toggle="modal" data-target="#well{{$ticket->id}}home" data-original-title title><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></a>
                        @else <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
                        @endif
                    </td>
                  </tr>
                </tbody>
                @endif
                @endforeach
              </table>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="bad">
            <div class="col-md-12">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>编号</th>
                    <th>机主</th>
                    <th>问题</th>
                    <th>PC仔</th>
                    <th>PC保姆</th>
                    <th>机主评价</th>
                    <th>评价内容</th>
                    <th>用时</th>
                    <th>detail</th>
                    <th style="width: 7%;">订单会话</th>
                  </tr>
                </thead>
                @foreach ($tickets as $ticket)
                @if ($ticket->assess==3)
                <tbody >
                  <tr>
                    <td>{{$ticket->id}}</td>
                    <td>{{$ticket->name}}</td>
                    <td>{{$ticket->problem}}</td>
                    <td>{{$ticket->pcer->name}}
                    </td>
                    <td>@if($ticket->pcadmin_id)
                            @if ($ticket->pcadmin){{$ticket->pcadmin->pcer->name}}
                            @endif
                        @else 
                        @endif
                    </td>
                    <td>@if($ticket->assess)
                            @if (($ticket->assess)==1)好评
                            @elseif (($ticket->assess)==2)中评
                            @else 差评
                            @endif
                        @endif
                    </td>
                    <td>@if($ticket->suggestion){{$ticket->suggestion}}@endif</td>
                    <td>{{$ticket->use_time}}</td>
                    <td ><a href="bad" data-toggle="modal" data-target="#bad{{$ticket->id}}" data-original-title title><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a></td>
                    <td style="text-align:center">
                        @if($ticket->comment->count())
                          <a href="bad" data-toggle="modal" data-target="#bad{{$ticket->id}}home" data-original-title title><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></a>
                        @else <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
                        @endif
                    </td>
                  </tr>
                </tbody>
                @endif
                @endforeach
              </table>
            </div>
        </div>
  
  </div>

</div>

<!-- 未处理订单detail -->
@foreach ($tickets as $ticket)
  <!-- Modal -->
  <div class="modal fade" id="nohandle{{$ticket->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document" style="width: 55%">
      <div class="modal-content" style="margin-top: 10%">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h3 class="modal-title" id="myModalLabel">详细信息</h3>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <center><h4>机主信息</h4></center> 
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th style="width: 25%;">姓名</th>
                        <td>{{$ticket->name}}</td>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th>宿舍</th>
                        <td>@if(($ticket->area)==0){{'东区'}}
                            @elseif (($ticket->area)==1){{'西区'}}
                            @endif {{ $ticket->address }}</td>
                      </tr>
                      <tr>
                        <th>联系方式</th>
                        <td>{{ $ticket->number }}@if($ticket->shortnum)/{{ $ticket->shortnum }}@endif</td>
                      </tr>
                      <tr>
                        <th>问题</th>
                        <td>{{$ticket->problem}}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>

            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
@endforeach
<!-- 未完成订单detail -->
@foreach ($tickets as $ticket)
  <!-- Modal -->
  <div class="modal fade" id="nocompleted{{$ticket->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document" style="width: 55%">
      <div class="modal-content" style="margin-top: 10%">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h3 class="modal-title" id="myModalLabel">详细信息</h3>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <center><h4>机主信息</h4></center> 
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th style="width: 25%;">姓名</th>
                        <td>{{$ticket->name}}</td>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th>宿舍</th>
                        <td>@if(($ticket->area)==0){{'东区'}}
                            @elseif (($ticket->area)==1){{'西区'}}
                            @endif {{ $ticket->address }}</td>
                      </tr>
                      <tr>
                        <th>联系方式</th>
                        <td>{{ $ticket->number }}@if($ticket->shortnum)/{{ $ticket->shortnum }}@endif</td>
                      </tr>
                      <tr>
                        <th>问题</th>
                        <td>{{$ticket->problem}}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>

                <div class="col-md-6">
                    <center><h4>队员信息</h4></center> 
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>PC仔</th>
                        <td>@if ($ticket->pcer_id){{$ticket->pcer->name}}
                            @endif
                        </td>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th style="width: 25%;">联系方式</th>
                        <td>@if ($ticket->pcer_id)
                                {{$ticket->pcer->long_number}}@if($ticket->pcer->number)/{{ $ticket->pcer->number }}@endif
                            @endif
                        </td>
                      </tr>
                      <tr>
                          <th>宿舍</th>
                          <td>
                              @if ($ticket->pcer_id)
                                @if(($ticket->pcer->area)==0){{'东区'}}
                                @elseif (($ticket->pcer->area)==1){{'西区'}}
                                @endif {{ $ticket->pcer->address }}
                              @endif
                          </td>
                      </tr>
                      @if ($ticket->pcadmin_id)
                      <tr>
                        <th>PC保姆</th>
                        <td>
                            {{$ticket->pcadmin->pcer->name}}
                        </td>
                      </tr>
                      <tr>
                        <th>联系方式</th>
                        <td>{{$ticket->pcadmin->pcer->long_number}}@if($ticket->pcadmin->pcer->number)/{{ $ticket->pcadmin->pcer->number }}@endif</td>
                      </tr>
                      @else <tr><th colspan="2">此单为队员自愿抢单</th></tr>
                      @endif 
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
@endforeach

<!-- 已完成订单detail -->
@foreach ($tickets as $ticket)
  <!-- Modal -->
  <div class="modal fade" id="completed{{$ticket->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document" style="width: 55%">
      <div class="modal-content" style="margin-top: 10%">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h3 class="modal-title" id="myModalLabel">详细信息</h3>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <center><h4>机主信息</h4></center> 
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th style="width: 25%;">姓名</th>
                        <td>{{$ticket->name}}</td>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th>宿舍</th>
                        <td>@if(($ticket->area)==0){{'东区'}}
                            @elseif (($ticket->area)==1){{'西区'}}
                            @endif {{ $ticket->address }}</td>
                      </tr>
                      <tr>
                        <th>联系方式</th>
                        <td>{{ $ticket->number }}@if($ticket->shortnum)/{{ $ticket->shortnum }}@endif</td>
                      </tr>
                      <tr>
                        <th>问题</th>
                        <td>{{$ticket->problem}}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>

                <div class="col-md-6">
                    <center><h4>队员信息</h4></center> 
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>PC仔</th>
                        <td>@if ($ticket->pcer_id){{$ticket->pcer->name}}
                            @endif
                        </td>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th style="width: 25%;">联系方式</th>
                        <td>@if ($ticket->pcer_id)
                                {{$ticket->pcer->long_number}}@if($ticket->pcer->number)/{{ $ticket->pcer->number }}@endif
                            @endif
                        </td>
                      </tr>
                      <tr>
                          <th>宿舍</th>
                          <td>
                              @if ($ticket->pcer_id)
                                @if(($ticket->pcer->area)==0){{'东区'}}
                                @elseif (($ticket->pcer->area)==1){{'西区'}}
                                @endif {{ $ticket->pcer->address }}
                              @endif
                          </td>
                      </tr>
                      @if ($ticket->pcadmin_id)
                      <tr>
                        <th>PC保姆</th>
                        <td>
                            {{$ticket->pcadmin->pcer->name}}
                        </td>
                      </tr>
                      <tr>
                        <th>联系方式</th>
                        <td>{{$ticket->pcadmin->pcer->long_number}}@if($ticket->pcadmin->pcer->number)/{{ $ticket->pcadmin->pcer->number }}@endif</td>
                      </tr>
                      @else <tr><th colspan="2">此单为队员自愿抢单</th></tr>
                      @endif 
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
@endforeach

<!-- 好评订单detail -->
@foreach ($tickets as $ticket)
  <!-- Modal -->
  <div class="modal fade" id="good{{$ticket->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document" style="width: 55%">
      <div class="modal-content" style="margin-top: 10%">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h3 class="modal-title" id="myModalLabel">详细信息</h3>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <center><h4>机主信息</h4></center> 
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th style="width: 25%;">姓名</th>
                        <td>{{$ticket->name}}</td>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th>宿舍</th>
                        <td>@if(($ticket->area)==0){{'东区'}}
                            @elseif (($ticket->area)==1){{'西区'}}
                            @endif {{ $ticket->address }}</td>
                      </tr>
                      <tr>
                        <th>联系方式</th>
                        <td colspan="3">{{ $ticket->number }}@if($ticket->shortnum)/{{ $ticket->shortnum }}@endif</td>
                      </tr>
                      @if ($ticket->assess)
                        <tr>
                        <th>
                            @if (($ticket->assess)==1)好评
                            @elseif (($ticket->assess)==2)中评
                            @else 差评
                            @endif</th>
                        <td>@if($ticket->suggestion){{$ticket->suggestion}}@endif</td>
                      </tr>
                      <tr>
                        <th>问题</th>
                        <td>{{$ticket->problem}}</td>
                      </tr> 
                      @endif
                    </tbody>
                  </table>
                </div>

                <div class="col-md-6">
                    <center><h4>队员信息</h4></center> 
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>PC仔</th>
                        <td>@if ($ticket->pcer_id){{$ticket->pcer->name}}
                            @endif
                        </td>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th style="width: 25%;">联系方式</th>
                        <td>@if ($ticket->pcer_id)
                                {{$ticket->pcer->long_number}}@if($ticket->pcer->number)/{{ $ticket->pcer->number }}@endif
                            @endif
                        </td>
                      </tr>
                      <tr>
                          <th>宿舍</th>
                          <td>
                              @if ($ticket->pcer_id)
                                @if(($ticket->pcer->area)==0){{'东区'}}
                                @elseif (($ticket->pcer->area)==1){{'西区'}}
                                @endif {{ $ticket->pcer->address }}
                              @endif
                          </td>
                      </tr>
                      @if ($ticket->pcadmin_id)
                      <tr>
                        <th>PC保姆</th>
                        <td>
                            {{$ticket->pcadmin->pcer->name}}
                        </td>
                      </tr>
                      <tr>
                        <th>联系方式</th>
                        <td>{{$ticket->pcadmin->pcer->long_number}}@if($ticket->pcadmin->pcer->number)/{{ $ticket->pcadmin->pcer->number }}@endif</td>
                      </tr>
                      @else <tr><th colspan="2">此单为队员自愿抢单</th></tr>
                      @endif 
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
@endforeach

<!-- 中评订单detail -->
@foreach ($tickets as $ticket)
  <!-- Modal -->
  <div class="modal fade" id="well{{$ticket->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document" style="width: 55%">
      <div class="modal-content" style="margin-top: 10%">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h3 class="modal-title" id="myModalLabel">详细信息</h3>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <center><h4>机主信息</h4></center> 
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th style="width: 25%;">姓名</th>
                        <td>{{$ticket->name}}</td>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th>宿舍</th>
                        <td>@if(($ticket->area)==0){{'东区'}}
                            @elseif (($ticket->area)==1){{'西区'}}
                            @endif {{ $ticket->address }}</td>
                      </tr>
                      <tr>
                        <th>联系方式</th>
                        <td colspan="3">{{ $ticket->number }}@if($ticket->shortnum)/{{ $ticket->shortnum }}@endif</td>
                      </tr>
                      @if ($ticket->assess)
                        <tr>
                        <th>
                            @if (($ticket->assess)==1)好评
                            @elseif (($ticket->assess)==2)中评
                            @else 差评
                            @endif</th>
                        <td>@if($ticket->suggestion){{$ticket->suggestion}}@endif</td>
                      </tr>
                      <tr>
                        <th>问题</th>
                        <td>{{$ticket->problem}}</td>
                      </tr> 
                      @endif
                    </tbody>
                  </table>
                </div>

                <div class="col-md-6">
                    <center><h4>队员信息</h4></center> 
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>PC仔</th>
                        <td>@if ($ticket->pcer_id){{$ticket->pcer->name}}
                            @endif
                        </td>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th style="width: 25%;">联系方式</th>
                        <td>@if ($ticket->pcer_id)
                                {{$ticket->pcer->long_number}}@if($ticket->pcer->number)/{{ $ticket->pcer->number }}@endif
                            @endif
                        </td>
                      </tr>
                      <tr>
                          <th>宿舍</th>
                          <td>
                              @if ($ticket->pcer_id)
                                @if(($ticket->pcer->area)==0){{'东区'}}
                                @elseif (($ticket->pcer->area)==1){{'西区'}}
                                @endif {{ $ticket->pcer->address }}
                              @endif
                          </td>
                      </tr>
                      @if ($ticket->pcadmin_id)
                      <tr>
                        <th>PC保姆</th>
                        <td>
                            {{$ticket->pcadmin->pcer->name}}
                        </td>
                      </tr>
                      <tr>
                        <th>联系方式</th>
                        <td>{{$ticket->pcadmin->pcer->long_number}}@if($ticket->pcadmin->pcer->number)/{{ $ticket->pcadmin->pcer->number }}@endif</td>
                      </tr>
                      @else <tr><th colspan="2">此单为队员自愿抢单</th></tr>
                      @endif 
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
@endforeach

<!-- 差评订单detail -->
@foreach ($tickets as $ticket)
  <!-- Modal -->
  <div class="modal fade" id="bad{{$ticket->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document" style="width: 55%">
      <div class="modal-content" style="margin-top: 10%">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h3 class="modal-title" id="myModalLabel">详细信息</h3>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <center><h4>机主信息</h4></center> 
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th style="width: 25%;">姓名</th>
                        <td>{{$ticket->name}}</td>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th>宿舍</th>
                        <td>@if(($ticket->area)==0){{'东区'}}
                            @elseif (($ticket->area)==1){{'西区'}}
                            @endif {{ $ticket->address }}</td>
                      </tr>
                      <tr>
                        <th>联系方式</th>
                        <td colspan="3">{{ $ticket->number }}@if($ticket->shortnum)/{{ $ticket->shortnum }}@endif</td>
                      </tr>
                      @if ($ticket->assess)
                        <tr>
                        <th>
                            @if (($ticket->assess)==1)好评
                            @elseif (($ticket->assess)==2)中评
                            @else 差评
                            @endif</th>
                        <td>@if($ticket->suggestion){{$ticket->suggestion}}@endif</td>
                      </tr>
                      <tr>
                        <th>问题</th>
                        <td>{{$ticket->problem}}</td>
                      </tr> 
                      @endif
                    </tbody>
                  </table>
                </div>

                <div class="col-md-6">
                    <center><h4>队员信息</h4></center> 
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>PC仔</th>
                        <td>@if ($ticket->pcer_id){{$ticket->pcer->name}}
                            @endif
                        </td>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th style="width: 25%;">联系方式</th>
                        <td>@if ($ticket->pcer_id)
                                {{$ticket->pcer->long_number}}@if($ticket->pcer->number)/{{ $ticket->pcer->number }}@endif
                            @endif
                        </td>
                      </tr>
                      <tr>
                          <th>宿舍</th>
                          <td>
                              @if ($ticket->pcer_id)
                                @if(($ticket->pcer->area)==0){{'东区'}}
                                @elseif (($ticket->pcer->area)==1){{'西区'}}
                                @endif {{ $ticket->pcer->address }}
                              @endif
                          </td>
                      </tr>
                      @if ($ticket->pcadmin_id)
                      <tr>
                        <th>PC保姆</th>
                        <td>
                            {{$ticket->pcadmin->pcer->name}}
                        </td>
                      </tr>
                      <tr>
                        <th>联系方式</th>
                        <td>{{$ticket->pcadmin->pcer->long_number}}@if($ticket->pcadmin->pcer->number)/{{ $ticket->pcadmin->pcer->number }}@endif</td>
                      </tr>
                      @else <tr><th colspan="2">此单为队员自愿抢单</th></tr>
                      @endif 
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
@endforeach

@foreach ($tickets as $ticket)
<!-- Modal -->
<div class="modal fade" id="nohandle{{$ticket->id}}home" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
<!-- Modal -->
<div class="modal fade" id="nocompleted{{$ticket->id}}home" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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

<!-- Modal -->
<div class="modal fade" id="completed{{$ticket->id}}home" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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

<!-- Modal -->
<div class="modal fade" id="good{{$ticket->id}}home" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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

<!-- Modal -->
<div class="modal fade" id="well{{$ticket->id}}home" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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

<!-- Modal -->
<div class="modal fade" id="bad{{$ticket->id}}home" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
<!-- 点击tab刷新页面 -->
<script type="text/javascript">
  function reload(){
    window.location.reload();
}
</script>

<!-- 刷新页面，tab页选中不改变 -->
<script>
$(document).ready(function() {
  if(location.hash) {
    $('a[href=' + location.hash + ']').tab('show');
  }

  $(document.body).on("click", "a[data-toggle]", function(event) {
    location.hash = this.getAttribute("href");
  });

});

$(window).on('popstate', function() {
  var anchor = location.hash || $("a[data-toggle=tab]").first().attr("href");
  $('a[href=' + anchor + ']').tab('show');
});
</script>

@stop 