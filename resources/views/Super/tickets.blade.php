@extends('layout')
@section('main')
<div>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#nohandle" style="color: red;" aria-controls="nohandle" role="tab" data-toggle="tab">未处理&nbsp;<span class="badge" >421</span></a></li>
    <li role="presentation"><a href="#nocompleted" aria-controls="nocompleted" role="tab" data-toggle="tab">未完成&nbsp;<span class="badge">42</span></a></li>
    <li role="presentation"><a href="#completed" aria-controls="completed" role="tab" data-toggle="tab">已完成</a></li>
    <li role="presentation"><a href="#good" aria-controls="good" role="tab" data-toggle="tab">好评单</a></li>
    <li role="presentation"><a href="#well" aria-controls="well" role="tab" data-toggle="tab">中评单</a></li>
    <li role="presentation"><a href="#bad" aria-controls="bad" role="tab" data-toggle="tab">差评单</a></li>
  </ul>

  <!-- Tab panes -->
  
  <div class="tab-content">
   
        <div role="tabpanel" class="tab-pane active" id="nohandle">
            
            <div class="col-md-12">
              <table class="table">
                <thead>
                  <tr>
                    <th>编号</th>
                    <th>机主</th>
                    <th>问题</th>
                    <th>PC仔</th>
                    <th>PC保姆</th>
                    <th>订单评价</th>
                    <th>订单创建时间</th>
                    <th>至今</th>
                  </tr>
                </thead>
                @foreach ($tickets as $ticket)
                @if ($ticket->state==0)
                <tbody>
                  <tr>
                    <td>{{$ticket->id}}</td>
                    <td>{{$ticket->name}}</td>
                    <td>{{$ticket->problem}}</td>
                    <td>@if($ticket->pcer_id){{$ticket->pcer->name}}
                        @else 暂无
                        @endif
                    </td>
                    <td>@if($ticket->pcadmin_id){{$ticket->pcadmin->pcer->name}}
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
                    <td>dateDiff({{$ticket->created_at}})</td>
                  </tr>
                </tbody>
                @endif
                @endforeach
              </table>
            </div>
            
        </div>
        <div role="tabpanel" class="tab-pane" id="nocompleted">
            <div class="col-md-12">
              <table class="table">
                <thead>
                  <tr>
                    <th>编号</th>
                    <th>机主</th>
                    <th>问题</th>
                    <th>PC仔</th>
                    <th>PC保姆</th>
                    <th>订单评价</th>
                    <th>订单创建时间</th>
                    <th>至今</th>
                  </tr>
                </thead>
                @foreach ($tickets as $ticket)
                @if ($ticket->state==1)
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
                    <td>dateDiff({{$ticket->created_at}})</td>
                  </tr>
                </tbody>
                @endif
                @endforeach
              </table>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="completed">
            <div class="col-md-12">
              <table class="table">
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
                @if ($ticket->state==2)
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
        <div role="tabpanel" class="tab-pane" id="good">
            <div class="col-md-12">
              <table class="table">
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
              <table class="table">
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
              <table class="table">
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

<script type="text/javascript">
    var dateDiff = function (date) {
    var sysDate = new Date(), timeSpan;
    timeSpan = sysDate - Date.parse(date);
    var days = Math.floor(timeSpan / (24 * 3600 * 1000)); 
   
    //计算出小时数  
  
    var leave1 = timeSpan % (24 * 3600 * 1000);    //计算天数后剩余的毫秒数  
    var hours = Math.floor(leave1 / (3600 * 1000));  
    //计算相差分钟数  
    var leave2 = leave1 % (3600 * 1000);        //计算小时数后剩余的毫秒数  
    var minutes = Math.floor(leave2 / (60 * 1000));  
    //计算相差秒数  
    var leave3 = leave2 % (60 * 1000);      //计算分钟数后剩余的毫秒数  
    var seconds = Math.round(leave3 / 1000);

    if (days > 0)
        return days + '天前';
    else if (hours > 0)
        return hours + '小时前';
    else if (minutes > 0)
        return minutes + '分钟前';
    else
        return seconds + '秒前';
};

</script>
@stop 