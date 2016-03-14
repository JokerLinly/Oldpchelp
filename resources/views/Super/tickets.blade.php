@extends('layout')
@section('main')
        <h4>目前收到{{$tickets->count()}}张报修单，其中：</h4>

<div>
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#nohandle" style="color: red;" aria-controls="nohandle" role="tab" data-toggle="tab">未处理&nbsp;<span class="badge" > 
    {{ App\Ticket::where('state',0)->count() }}</span></a></li>
    <li role="presentation"><a href="#nocompleted" aria-controls="nocompleted" role="tab" data-toggle="tab">未完成&nbsp;<span class="badge">{{ App\Ticket::where('state',1)->count() }}</span></a></li>
    <li role="presentation"><a href="#completed" aria-controls="completed" role="tab" data-toggle="tab">已完成</a></li>
    <li role="presentation"><a href="#good" aria-controls="good" role="tab" data-toggle="tab">好评单</a></li>
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
                    <th style="width: 20%;">问题</th>
                    <th>PC仔</th>
                    <th>PC保姆</th>
                    <th style="width: 12%">上门时间</th>
                    <th>订单创建至今</th>
                    <th>detail</th>
                  </tr>
                </thead>
                @foreach ($tickets as $ticket)
                @if ($ticket->state==0)
                <tbody >
                  <tr>
                    <td>{{$ticket->id}}</td>
                    <td>{{$ticket->name}}</td>
                    <td>{{$ticket->problem}}</td>
                    <td>@if($ticket->pcer_id){{$ticket->pcer->name}}
                        @else 
                        @endif
                    </td>
                    <td>@if($ticket->pcadmin_id){{$ticket->pcadmin->pcer->name}}
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
                    <td>{{$ticket->differ_time}}</td>
                    <td ><a href="" data-toggle="modal" data-target="#{{$ticket->id}}" data-original-title title><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a></td>
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
                    <th>订单创建至今</th>
                    <th>detail</th>
                  </tr>
                </thead>
                @foreach ($tickets as $ticket)
                @if ($ticket->state==1)
                <tbody >
                  <tr>
                    <td>{{$ticket->id}}</td>
                    <td>{{$ticket->name}}</td>
                    <td>{{$ticket->problem}}</td>
                    <td>@if($ticket->pcer_id){{$ticket->pcer->name}}
                        @else 
                        @endif
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
                    <td>{{$ticket->differ_time}}</td>
                    <td ><a href="" data-toggle="modal" data-target="#{{$ticket->id}}" data-original-title title><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a></td>
                  </tr>
                </tbody>
                @endif
                @endforeach
              </table>
            </div>
        </div>
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
                    <th style="width: 12%">上门时间</th>
                    <th>订单创建至今</th>
                    <th>detail</th>
                  </tr>
                </thead>
                @foreach ($tickets as $ticket)
                @if ($ticket->assess==1)
                <tbody >
                  <tr>
                    <td>{{$ticket->id}}</td>
                    <td>{{$ticket->name}}</td>
                    <td>{{$ticket->problem}}</td>
                    <td>@if($ticket->pcer_id){{$ticket->pcer->name}}
                        @else 
                        @endif
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
                    <td>{{$ticket->differ_time}}</td>
                    <td ><a href="" data-toggle="modal" data-target="#{{$ticket->id}}" data-original-title title><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a></td>
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
                    <th>订单评价</th>
                    <th>订单创建时间</th>
                  </tr>
                </thead>
                @foreach ($tickets as $ticket)
                @if ($ticket->assess==1)
                <tbody>
                  <tr>
                    <td>{{$ticket->id}}</td>
                    <td>{{$ticket->name}}</td>
                    <td>{{$ticket->problem}}</td>
                    <td>@if($ticket->pcer_id){{$ticket->pcer->name}}
                        @else 暂无
                        @endif
                    </td>
                    <td>@if($ticket->pcadmin){{$ticket->pcadmin->pcer->name}}
                        @else 暂无
                        @endif
                    </td>
                    <td>@if($ticket->assess)
                            @if($ticket->assess==1)好评  
                            @elseif ($ticket->assess==2)
                            @elseif ($ticket->assess==3)
                            @endif
                            @if($ticket->suggestion){{$ticket->suggestion}}
                            @endif  
                        @else 暂无
                        @endif
                    </td>
                    <td>{{$ticket->created_time}}</td>
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
                    <th>订单评价</th>
                    <th>订单创建时间</th>
                  </tr>
                </thead>
                @foreach ($tickets as $ticket)
                @if ($ticket->assess==2)
                <tbody>
                  <tr>
                    <td>{{$ticket->id}}</td>
                    <td>{{$ticket->name}}</td>
                    <td>{{$ticket->problem}}</td>
                    <td>@if($ticket->pcer_id){{$ticket->pcer->name}}
                        @else 暂无
                        @endif
                    </td>
                    <td>@if($ticket->pcadmin){{$ticket->pcadmin->pcer->name}}
                        @else 暂无
                        @endif
                    </td>
                    <td>@if($ticket->assess)
                            @if($ticket->assess==1)好评  
                            @elseif ($ticket->assess==2)
                            @elseif ($ticket->assess==3)
                            @endif
                            @if($ticket->suggestion){{$ticket->suggestion}}
                            @endif  
                        @else 暂无
                        @endif
                    </td>
                    <td>{{$ticket->created_time}}</td>
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
                    <th>订单评价</th>
                    <th>订单创建时间</th>
                  </tr>
                </thead>
                @foreach ($tickets as $ticket)
                @if ($ticket->assess==3)
                <tbody>
                  <tr>
                    <td>{{$ticket->id}}</td>
                    <td>{{$ticket->name}}</td>
                    <td>{{$ticket->problem}}</td>
                    <td>@if($ticket->pcer_id){{$ticket->pcer->name}}
                        @else 暂无
                        @endif
                    </td>
                    <td>@if($ticket->pcadmin){{$ticket->pcadmin->pcer->name}}
                        @else 暂无
                        @endif
                    </td>
                    <td>@if($ticket->assess)
                            @if($ticket->assess==1)好评  
                            @elseif ($ticket->assess==2)
                            @elseif ($ticket->assess==3)
                            @endif
                            @if($ticket->suggestion){{$ticket->suggestion}}
                            @endif  
                        @else 暂无
                        @endif
                    </td>
                    <td>{{$ticket->created_time}}</td>
                  </tr>
                </tbody>
                @endif
                @endforeach
              </table>
            </div>
        </div>
  
  </div>

</div>

@foreach ($tickets as $ticket)
  <!-- Modal -->
  <div class="modal fade" id="{{$ticket->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document">
      <div class="modal-content" style="margin-top: 20%">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">详细信息</h4>
        </div>
        <div class="modal-body">
          <p>姓名：{{$ticket->name}}</p>
       

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