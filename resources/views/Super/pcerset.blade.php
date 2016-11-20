@extends('Super.layout')
@section('main')


<div class="col-sm-3">
    <div class="panel panel-info">
        <div class="panel-heading">
            <a href="" data-toggle="modal" data-target="#addModal" data-original-title title><span class="glyphicon glyphicon-plus" aria-hidden="true" style="float: right;"></span></a>
          <span><h3 class="panel-title">年级设置</h3></span>

        </div>
        <div class="panel-body">
            <table class="table table-condensed" >
                <thead>
                  <tr>
                    <th>年级</th>
                    <th>显示</th>
                  </tr>
                </thead>
                <tbody>
                @if ($pcerlevels)
                @foreach ($pcerlevels as $pcerlevel)
                  <tr >
                    <td>{{$pcerlevel->level_name}}</td>
                    <td>
                    @if ($pcerlevel->state == 0)
                    <a class="show" href="javascript:void(0);" data-url="{{ URL('super/pcset/levelshow/'.$pcerlevel->id)}}" data-original-title title><span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span></a>
                    @else
                    <a class="show" href="javascript:void(0);" data-url="{{ URL('super/pcset/levelshow/'.$pcerlevel->id)}}" data-original-title title><span class="glyphicon glyphicon-star" style="color: red;" aria-hidden="true"></span></a>
                    @endif
                    </td>
                  </tr>
                </tbody>

                @endforeach
                @endif
            </table>
        </div>
    </div>
</div>


<div class="col-sm-3">
    <div class="panel panel-info">
        <div class="panel-heading">
            <a href="" data-original-title title><span class="glyphicon glyphicon-plus" aria-hidden="true" style="float: right;"></span></a>
          <span><h3 class="panel-title">只</h3></span>

        </div>
        <div class="panel-body">
           <p>想</p>
           <p>它</p>
           <p>太</p>
        </div>
    </div>
</div>

<div class="col-sm-3">
    <div class="panel panel-info">
        <div class="panel-heading">
            <a href="" data-original-title title><span class="glyphicon glyphicon-plus" aria-hidden="true" style="float: right;"></span></a>
          <span><h3 class="panel-title">是</h3></span>

        </div>
        <div class="panel-body">
           <p>只</p>
           <p>一</p>
           <p>寂</p>
        </div>
    </div>
</div>

<div class="col-sm-3">
    <div class="panel panel-info">
        <div class="panel-heading">
            <a href="" data-original-title title><span class="glyphicon glyphicon-plus" aria-hidden="true" style="float: right;"></span></a>
          <span><h3 class="panel-title">不</h3></span>

        </div>
        <div class="panel-body">
           <p>有</p>
           <p>个</p>
           <p>寞</p>
        </div>
    </div>
</div>


<!-- 增加年级的Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content" style="margin-top: 30%">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">增加年级</h4>
          </div>
          <form action="pcset/leveladd" method="POST"  style="display: inline;">
              <div class="modal-body">
                <input type="text" name="level_name" class="form-control" required="required" placeholder="请注意格式，例如：2012级" value="{{Input::old('level_name')}}"/>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">增加</button>
              </div>
          </form>
        </div>
      </div>
    </div>



<!-- 年级显示控制 -->
<script type="text/javascript">
$(document).ready(function () {
  $('.show').click(function () {
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
@stop 