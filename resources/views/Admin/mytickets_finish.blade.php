@extends('alayout')
@section('main')
<em style="font-size: 25px;font-family: youyuan;margin-left:20px;margin-bottom: 10px; ">已完成订单</em>
@if($tickets->count())
            <div class="col-md-12">
              <table class="table table-hover">
              
                <thead>
                  <tr>
                    <th style="width: 1%;">#</th>
                    <th>问题</th>
                    <th style="width: 9%;">宿舍</th>
                    <th style="width: 9%;">报修至今</th>
                    <th style="width: 9%;">处理至今</th>
                    <th style="width: 7%;">负责队员</th>
                    <th style="width: 1%;">detail</th>
                    </th>
                  </tr>
                </thead>
                @foreach($tickets as $ticket)
      
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
                      <td>{{$ticket->differ_hendle}}</td>
                      <td>{{$ticket->pcer->name}}
                      <td style="text-align:center"><a href="nocompleted" data-toggle="modal" data-target="#nocompleted{{$ticket->id}}" data-original-title title><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a></td>

                    </tr>
                  </tbody>
                @endforeach
              </table>
            </div>
@else <br>你没有任何已完成的订单喔
@endif

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

@stop