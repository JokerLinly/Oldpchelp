@extends('layout')
@section('main')

{{--  {{ App\Pcer::find($comment->page_id)->title }} --}}

<div class="col-md-12">
    <div>
      @if ($pcerLevels->count())
      <!-- Nav tabs -->
      @if ($pcers)
      <ul class="nav nav-tabs" role="tablist">
      
        <li role="presentation" class="active"><a  href="#home"  aria-controls="home" role="tab" data-toggle="tab">{{$pcers->count()}}个PC仔</a></li>
        <!-- 分年级循环 -->
        @foreach ($pcerLevels as $pcerLevel)
        <li role="presentation"><a  href="#Levels{{$pcerLevel->id}}" aria-controls="Levels{{$pcerLevel->id}}" role="tab" data-toggle="tab">{{$pcerLevel->level_name}}</a></li>
        @endforeach
        <!-- 分年级循环 ！-->
      </ul>
      
      <!-- Tab panes -->
      <div class="tab-content" style="font-family: SimSun;font-size: 17px;">

        <div role="tabpanel" class="tab-pane active" id="home">
            <div class="col-md-12">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th></span>编号</th>
                    <th>姓名</th>
                    <th>昵称</th>
                    <th>年级</th>
                    <th>长号</th>
                    <th>短号</th>
                    <th>宿舍号</th>
                    <th>是否认证</th>
                    <th>是否管理员</th>
                    <th>detail</th>
                  </tr>
                </thead>
                @foreach ($pcers as $pcer)
                <tbody >
                  <tr>
                    <td>{{$pcer->id}}</td>
                    <td>{{$pcer->name}}</td>
                    <td>{{$pcer->nickname}}</td>
                    <td>{{$pcer->pcerlevel->level_name}}</td>
                    <td>{{$pcer->long_number}}</td>
                    <td> 
                    @if($pcer->number){{$pcer->number}}
                    @else 暂无
                    @endif
                    </td>
                    <td>
                    @if($pcer->area==0)东区
                    @else 西区 
                    @endif
                    {{$pcer->address}}</td>
                    <td style="text-align:center;">@if($pcer->wcuser->state==0)
                    <a class="pcerset" href="javascript:void(0);" data-url="{{ URL('super/pcerset/'.$pcer->wcuser_id)}}" data-original-title title><span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span></a>
                    @else 
                    <a class="pcerset" href="javascript:void(0);" data-url="{{ URL('super/pcerset/'.$pcer->wcuser_id)}}" data-original-title title><span class="glyphicon glyphicon-star" style="color: red;" aria-hidden="true"></span></a>
                    @endif</td>
                    <td style="text-align:center;">
                    @if($pcer->pcadmin)
                    <a class="pcadminset" href="javascript:void(0);" data-url="{{ URL('super/pcadminset/'.$pcer->id)}}" data-original-title title><span class="glyphicon glyphicon-star" style="color: red;" aria-hidden="true"></span></a>
                    @else
                    <a class="pcadminset" href="javascript:void(0);" data-url="{{ URL('super/pcadminset/'.$pcer->id)}}" data-original-title title><span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span></a>
                    @endif
                    </td>
                    <td style="text-align:center;"><a href="" data-toggle="modal" data-target="#{{$pcer->id}}" data-original-title title><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a></td>
                  </tr>
                </tbody>
                @endforeach
              </table>
              
              @foreach ($pcers as $pcer)
              <!-- Modal -->
              <div class="modal fade" id="{{$pcer->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
               <div class="modal-dialog" role="document">
                  <div class="modal-content" style="margin-top: 20%">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="myModalLabel">详细信息</h4>
                    </div>
                    <div class="modal-body">
                      <p>姓名：{{$pcer->name}}</p>
                      <p>学号：{{$pcer->school_id}}</p>
                      <p>系别：{{$pcer->department}}</p>
                      <p>专业：{{$pcer->major}}</p>
                      <p>班级：{{$pcer->clazz}}</p>
                      <p>申请时间：{{$pcer->created_at}}</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
            </div>        
        </div>

        <!-- 分年级循环 -->
        @foreach ($pcerLevels as $pcerLevel)
        <div role="tabpanel" class="tab-pane" id="Levels{{$pcerLevel->id}}">
          <div class="col-md-12">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th></span>编号</th>
                    <th>姓名</th>
                    <th>昵称</th>
                    <th>年级</th>
                    <th>长号</th>
                    <th>短号</th>
                    <th>宿舍号</th>
                    <th>是否认证</th>
                    <th>是否管理员</th>
                    <th>detail</th>
                  </tr>
                </thead>
                @foreach ($pcers as $pcer)
                @if ($pcer->pcerlevel_id==$pcerLevel->id)
                <tbody >
                  <tr>
                    <td>{{$pcer->id}}</td>
                    <td>{{$pcer->name}}</td>
                    <td>{{$pcer->nickname}}</td>
                    <td>{{$pcer->pcerlevel->level_name}}</td>
                    <td>{{$pcer->long_number}}</td>
                    <td> 
                    @if($pcer->number){{$pcer->number}}
                    @else 暂无
                    @endif
                    </td>
                    <td>
                    @if($pcer->area==0)东区
                    @else 西区 
                    @endif
                    {{$pcer->address}}</td>
                    <td style="text-align:center;">@if($pcer->wcuser->state==0)
                    <a class="pcerset" href="javascript:void(0);" data-url="{{ URL('super/pcerset/'.$pcer->wcuser_id)}}" data-original-title title><span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span></a>
                    @else 
                    <a class="pcerset" href="javascript:void(0);" data-url="{{ URL('super/pcerset/'.$pcer->wcuser_id)}}" data-original-title title><span class="glyphicon glyphicon-star" style="color: red;" aria-hidden="true"></span></a>
                    @endif</td>
                    <td style="text-align:center;">
                    @if($pcer->pcadmin)
                    <a class="pcadminset" href="javascript:void(0);" data-url="{{ URL('super/pcadminset/'.$pcer->id)}}" data-original-title title><span class="glyphicon glyphicon-star" style="color: red;" aria-hidden="true"></span></a>
                    @else
                    <a class="pcadminset" href="javascript:void(0);" data-url="{{ URL('super/pcadminset/'.$pcer->id)}}" data-original-title title><span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span></a>
                    @endif
                    </td>
                    <td style="text-align:center;"><a href="" data-toggle="modal" data-target="#{{$pcer->id}}" data-original-title title><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a></td>
                  </tr>
                </tbody>
                @endif
                @endforeach
              </table>
              
              @foreach ($pcers as $pcer)
              <!-- Modal -->
              <div class="modal fade" id="{{$pcer->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
               <div class="modal-dialog" role="document">
                  <div class="modal-content" style="margin-top: 20%">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="myModalLabel">详细信息</h4>
                    </div>
                    <div class="modal-body">
                      <p>姓名：{{$pcer->name}}</p>
                      <p>学号：{{$pcer->school_id}}</p>
                      <p>系别：{{$pcer->department}}</p>
                      <p>专业：{{$pcer->major}}</p>
                      <p>班级：{{$pcer->clazz}}</p>
                      <p>申请时间：{{$pcer->created_at}}</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
        </div>
        @endforeach
        <!-- 分年级循环 -->
      </div>
 @endif        
@endif
    
</div>
<!-- pc仔和管理员控制 -->
<script type="text/javascript">
$(document).ready(function () {
  $('.pcerset').click(function () {
      var _this = $(this);
      $.ajax({
         type: "GET",
         url: $(this).data('url'),
         success:function(data){
          if (data == 1) {
            _this.find('span').removeClass('glyphicon-star-empty').addClass('glyphicon-star').attr('style','color: red;');
          } else if(data == 0){
            _this.find('span').removeClass('glyphicon-star').addClass('glyphicon-star-empty').attr('style',null);
          } else{
            alert(data);
          }
         
         }
      });
      return false;
  });

  $('.pcadminset').click(function () {
      var _this = $(this);
      $.ajax({
         type: "GET",
         url: $(this).data('url'),
         success:function(data){
          if(data == 1) {
            _this.find('span').removeClass('glyphicon-star-empty').addClass('glyphicon-star').attr('style','color: red;');
          }else if(data == 0){
            _this.find('span').removeClass('glyphicon-star').addClass('glyphicon-star-empty').attr('style',null);
          }else{
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