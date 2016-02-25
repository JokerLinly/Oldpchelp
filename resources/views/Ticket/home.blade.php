@extends('body')
@section('main')

<div class="row-fluid">
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <img src="http://wx.qlogo.cn/mmopen/VXPOibDJU4Qg7s8rEbwvIsTwK4eibCyjsa6BNOaMP21shibm7C2DTOds9Fq3Uwgf7DUYnacITRF9JuxCPVBN81TEn6icBfgibW7bC/0" class="img-circle img-responsive center-block" style="max-width:150px;padding:20px;"/>
        </div>
        <div class="col-md-4"></div>
    </div>
    <div class="span12">
        <form>
            <div class="form-group">
                <label>姓名</label>
                <input type="text" class="form-control" id="name" placeholder="姓名">
            </div>
            <div class="form-group">
                <label >联系方式（短号最好）</label>
                <input type="number" class="form-control" id="number" placeholder="联系方式">
            </div>
            <div class="form-group">
                <label >空闲时间</label>
                <label >日期</label>
                <input type="date" class="form-control" id="date" >
                <input type="time" class="form-control" id="time" >
                <label >到</label>
                <input type="time" class="form-control" id="time" >
                <label >PS:当天报修未必能当天上门，请多选择一个可调度的空闲时间</label>
            </div>
            <div class="form-group">
                <label >联系方式（短号最好）</label>
                <input type="text" class="form-control" id="number" placeholder="联系方式">
            </div>
            
            <button type="submit" class="btn btn-default">Submit</button>
        </form>
    </div>
</div>


@stop