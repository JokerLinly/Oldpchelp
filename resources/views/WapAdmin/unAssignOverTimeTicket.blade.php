@extends('WapAdmin.ticketListLayout')
@section('title')

<div class="row-fluid color">
    <div class="span12 ">
        <p class="text-center" style="font-size: 2rem;font-family: 幼圆">
            一共有{{count($tickets)}}台机过期
        </p>
        <div class="title_tag">
            <a href="{{action('Admin\WapHomeController@getTodayTackTicket')}}"><button type="button" class="btn btn-secondary">只看今天</button></a>
            <a href="{{action('Admin\WapHomeController@getOverTimeTackTicket')}}"><button type="button" class="btn btn-mint">过期订单</button></a>
            <a href="{{action('Admin\WapHomeController@getAllTackTicket')}}"><button type="button" class="btn btn-secondary" >全部</button></a>
        </div>
    </div>
</div>
@stop