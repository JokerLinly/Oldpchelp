@extends('alayout')
@section('main')


<h3>未处理：{{$tickets->count()}}&nbsp;&nbsp;&nbsp;未完成：{{ App\Ticket::where('state',1)->where('pcadmin_id',$pcadmin_id)->count()}}&nbsp;</h3>
<div>
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">今日需处理</a></li>
    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">全部未处理</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="home">
        @if($tickets->count())
            <div class="col-md-12">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>问题</th>
                    <th>宿舍</th>
                    <th>上门时间</th>
                    <th>锁定</th>
                    <th>今晚值班人员</th>
                    <th>
                    <button type="button" class="btn btn-primary btn-xs" data-toggle="button" aria-pressed="false" autocomplete="off">
                          全部锁定
                    </button>
                    </th>
                  </tr>
                </thead>
                @foreach($tickets as $ticket)
                @if ($ticket->date ==date("w")||$ticket->date1==date("w"))               
                <tbody>
                  <tr>
                    <td>{{$ticket->id}}</td>
                    <td>{{$ticket->problem}}</td>
                    <td>
                        @if(($ticket->area)==0){{'东区'}}
                        @elseif (($ticket->area)==1){{'西区'}}
                        @endif{{$ticket->address}}
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
                    <td>
                        @if($ticket->pcadmin_id)
                        <a class="pcadminset" href="javascript:void(0);" data-url="" data-original-title title><span class="glyphicon glyphicon-star" style="color: red;" aria-hidden="true"></span></a>
                        @else
                        <a class="pcadminset" href="javascript:void(0);" data-url="" data-original-title title><span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span></a>
                        @endif
                    </td>
                    <td>
                        @if($tpcers)
                        <select name="pcer_id">
                        <option></option>
                        @foreach ($tpcers as $tpcer)
                            <option value="{{$tpcer->pcer->id}}">
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
                        <button type="button" class="btn btn-primary btn-xs" data-toggle="button" style="width: 65%;" aria-pressed="false" autocomplete="off">
                          锁定
                        </button>
                    </td>
                  </tr>
                </tbody>
                @endif 
                @endforeach
              </table>
            </div>
        @else 暂无新订单
        @endif
    </div>
    <div role="tabpanel" class="tab-pane" id="profile">...</div>
  </div>

</div>



<script>
  $('#myButton').on('click', function () {
    var $btn = $(this).button('loading')
    // business logic...
    $btn.button('reset')
  })
</script>

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