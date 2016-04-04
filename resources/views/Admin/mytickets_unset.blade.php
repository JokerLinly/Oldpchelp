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
                    <th style="width: 9%;">宿舍</th>
                    <th style="width: 9%;">报修至今</th>
                    <th style="width: 12%;">上门时间</th>
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

@stop