@extends('Super.layout')
@section('main')
<link href="{{asset('css/foundation.min.css')}}" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="http://www.jq22.com/jquery/font-awesome.4.6.0.css">
<link href="{{asset('css/foundation-datepicker.min.css')}}" rel="stylesheet" type="text/css">
<script src="{{asset('js/foundation-datepicker.min.js')}}"></script>
<script src="{{asset('js/foundation-datepicker.zh-CN.js')}}"></script>
<!-- 时间选择 -->
{!! Form::open(['action' => 'Super\HomeController@postMain', 'style'=>'display: inline;']) !!}
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <span id="two-inputs">
                    <input type="text"  id="date-range200" size="20" value="" placeholder="统计开始时间"> to 
                </span>
            </div>
            <div class="col-md-3">
                <input type="text"  id="date-range201" size="20" value="" placeholder="统计结束时间">
            </div>
            <div class="col-md-2">
                <input class="btn btn-info btn-block" type="submit" value="统计">
            </div>
        </div>
    </div>
{!! Form::close() !!}


<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">.col-md-6</div>
        <div class="col-md-6">.col-md-6</div>
    </div>
</div>

@stop 