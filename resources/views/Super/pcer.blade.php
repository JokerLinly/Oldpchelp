@extends('Super.layout')
@section('main')

<div class="col-md-12">
    <h4> 一共{{ $pcers->count() }}个PC仔，其中：</h4>
    <div>
@if (count($pcerLevels) > 0)
      <!-- Nav tabs -->
      @if ($pcers)
      <ul class="nav nav-tabs" role="tablist">
        <!-- 分年级循环 -->
        @foreach ($pcerLevels as $pcerLevel)
        <li role="presentation"><a  href="#Levels{{$pcerLevel['id']}}" aria-controls="Levels{{$pcerLevel['id']}}" role="tab" data-toggle="tab">{{$pcerLevel['level_name']}}</a></li>
        @endforeach
        <!-- 分年级循环 ！-->
      </ul>
      
      <!-- Tab panes -->
      <div class="tab-content" style="font-family: SimSun;font-size: 17px;">
        <!-- 分年级循环 -->
        @foreach ($pcerLevels as $pcerLevel)
        <div role="tabpanel" class="tab-pane" id="Levels{{$pcerLevel['id']}}">
          <div class="col-md-12">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th></span>编号</th>
                    <th>姓名</th>
                    <th>昵称</th>
                    <th>值班时间</th>
                    <th>是否认证</th>
                    <th>是否值班</th>
                    <th>是否管理员</th>
                    <th>详情</th>
                  </tr>
                </thead>
                @foreach ($pcers as $pcer)
                @if ($pcer->pcerlevel_id==$pcerLevel['id'])
                <tbody >
                  <tr>
                    <td>{{$pcer->id}}</td>
                    <td>{{$pcer->name}}</td>
                    <td>{{$pcer->nickname}}</td>
                    <td>
                    @if ($pcer->idle->count())
                            @foreach ($pcer->idle as $pceridle)
                              <span class="label label-primary">
                                  @if (($pceridle->date)==1)星期一
                                  @elseif (($pceridle->date)==2)星期二
                                  @elseif (($pceridle->date)==3)星期三
                                  @elseif (($pceridle->date)==4)星期四
                                  @elseif (($pceridle->date)==5)星期五
                                  @endif
                              </span>&nbsp;
                              
                            @endforeach
                          @else 未设置
                          @endif
                    </td>
                    {{-- 是否认证 --}}
                    <td style="text-align:center;">@if($pcer->wcuser->state==0)
                      <a class="pcerset" href="javascript:void(0);" data-url="{{ URL('super/pcerset/'.$pcer->wcuser_id)}}" data-original-title title><span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span></a>
                      @else 
                      <a class="pcerset" href="javascript:void(0);" data-url="{{ URL('super/pcerset/'.$pcer->wcuser_id)}}" data-original-title title><span class="glyphicon glyphicon-star" style="color: red;" aria-hidden="true"></span></a>
                      @endif
                    </td>
                    {{-- 是否认证 --}}
                    {{-- 是否值班 --}}
                    <td style="text-align:center;">
                      @if($pcer->wcuser->state != 0 && $pcer->state == 0)
                      <a class="workset" href="javascript:void(0);" data-url="{{ URL('super/pcworkset/'.$pcer->id)}}" data-original-title title><span class="glyphicon glyphicon-star" style="color: red;" aria-hidden="true"></span></a>
                      @else
                      <a class="workset" href="javascript:void(0);" data-url="{{ URL('super/pcworkset/'.$pcer->id)}}" data-original-title title><span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span></a>
                      @endif
                    </td>
                    {{-- 是否值班 --}}
                    {{-- 是否管理员 --}}
                    <td style="text-align:center;">
                      @if($pcer->pcadmin && $pcer->pcadmin->is_work == 1)
                      <a class="pcadminset" href="javascript:void(0);" data-url="{{ URL('super/pcadminset/'.$pcer->id)}}" data-original-title title><span class="glyphicon glyphicon-star" style="color: red;" aria-hidden="true"></span></a>
                      @else
                      <a class="pcadminset" href="javascript:void(0);" data-url="{{ URL('super/pcadminset/'.$pcer->id)}}" data-original-title title><span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span></a>
                      @endif
                    </td>
                    {{-- 是否管理员 --}}
                    <td style="text-align:center;">
                      <a href="Levels{{$pcerLevel['id']}}" data-toggle="modal" data-target="#Levels{{$pcerLevel['id']}}{{$pcer->id}}" data-original-title title><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>
                    </td>
                  </tr>
                </tbody>
                @endif
                @endforeach
              </table>
              
              @foreach ($pcers as $pcer)
              <!-- Modal -->
              <div class="modal fade" id="Levels{{$pcerLevel['id']}}{{$pcer->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
               <div class="modal-dialog" role="document">
                  <div class="modal-content" style="margin-top: 10%">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="myModalLabel">详细信息</h4>
                    </div>
                    <div class="modal-body">
                      <p>姓名：{{$pcer->name}}</p>
                      <p>长号: {{$pcer->long_number}}</p>
                      <p>短号: @if($pcer->number){{$pcer->number}}
                              @else 暂无
                                @endif</p>
                      <p>住址：
                        @if($pcer->area==0)东区
                        @else 西区 
                        @endif
                        {{$pcer->address}}
                      </p>
                      <p>学号：{{$pcer->school_id}}</p>
                      <p>年级: {{$pcer->pcerlevel->level_name}}</p>
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
                    console.log(data);
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

  $('.workset').click(function () {
      var _this = $(this);
      $.ajax({
         type: "GET",
         url: $(this).data('url'),
         success:function(data){
          if (data == 0) {
            _this.find('span').removeClass('glyphicon-star-empty').addClass('glyphicon-star').attr('style','color: red;');
          } else if(data == 1){
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