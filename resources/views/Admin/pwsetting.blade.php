@extends('alayout')
@section('main')


  <div class="modal-dialog" style="margin-top: 10%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
        <h4 class="modal-title">修改密码</h4>
      </div>
      <form action="pwchange" method="POST" style="display: inline;">
         <input type="hidden" name="id" value="{{$id}}" >
      <div class="modal-body">
        <p>为保证机主和队员的个人资料安全，请修改密码！</p>
        <br>

        <input type="password" name="pw" value="" style="width: 50%" class="form-control" required="required" placeholder="密码不少于6位！">
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->


@stop