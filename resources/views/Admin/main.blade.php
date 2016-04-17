@extends('alayout')
@section('main')
<div>
  <h4>目前未处理订单：{{$tickets->count()}}&nbsp;&nbsp;&nbsp;<em>另外你有{{ App\Ticket::where('pcadmin_id',$pcadmin_id)->where('state',0)->orWhere('state',1)->count()}}张未完成订单 <span class="glyphicon glyphicon-hand-up"></span>详情查看我的订单</em></h4>
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab" onClick="reload();">今日需处理</a></li>
    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab" onClick="reload();">全部未处理</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">

    <div role="tabpanel" class="tab-pane active" id="home">

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
                    <th style="width: 5%;">锁定</th>
                    <th style="width: 11%;">今晚值班人员</th>
                    <th style="width: 5%;">
                    </th>
                  </tr>
                </thead>
                @foreach($tickets as $ticket)
                @if ($ticket->pcer_id)
                @else
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
                      <td>{{$ticket->differ_time}}</td>
                      <td>
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
                      <td>
                          @if($ticket->pcadmin_id)
                          <a class="ticketlock" href="javascript:void(0);" data-url="{{ URL('pcadmin/ticketlock/'.$ticket->id)}}" data-original-title title><span class="glyphicon glyphicon-star" style="color: red;" aria-hidden="true"></span></a>
                          @else
                          <a class="ticketlock" href="javascript:void(0);" data-url="{{ URL('pcadmin/ticketlock/'.$ticket->id)}}" data-original-title title><span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span></a>
                          @endif
                      </td>
                      <form action="ticketpcer" method="POST" style="display: inline;">
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
                            <button type="submit" class="btn btn-primary btn-xs" style="width: 60px;" >锁定</button>       
                      </td>
                      </form>
                    </tr>
                  </tbody>
                  @endif 
                @endif
                @endforeach
              </table>
            </div>
        @else 暂无新订单
        @endif

    </div>

    <div role="tabpanel" class="tab-pane" id="profile">
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
                    <th style="width: 5%;">锁定</th>
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
                      <td>
                          @if($ticket->pcadmin_id)
                          <a class="ticketlock" href="javascript:void(0);" data-url="{{ URL('pcadmin/ticketlock/'.$ticket->id)}}" data-original-title title><span class="glyphicon glyphicon-star" style="color: red;" aria-hidden="true"></span></a>
                          @else
                          <a class="ticketlock" href="javascript:void(0);" data-url="{{ URL('pcadmin/ticketlock/'.$ticket->id)}}" data-original-title title><span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span></a>
                          @endif
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
  </div>

</div>



<!-- 管理员锁定订单控制 -->
<script type="text/javascript">
$(document).ready(function () {
  $('.ticketlock').click(function () {
      var _this = $(this);
      $.ajax({
         type: "GET",
         url: $(this).data('url'),
         success:function(data){
          if (data == 'lock') {
            _this.find('span').removeClass('glyphicon-star-empty').addClass('glyphicon-star').attr('style','color: red;');
          } else if(data == 'unlock'){
            _this.find('span').removeClass('glyphicon-star').addClass('glyphicon-star-empty').attr('style',null);
          } else{
            alert(data);
          }
         }
      });
      return false;
  });
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