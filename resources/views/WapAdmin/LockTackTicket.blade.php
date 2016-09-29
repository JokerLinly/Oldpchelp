@extends('WapAdmin.ticketListLayout')
@section('title')

<div class="row-fluid color">
    <div class="span12 ">
        <p class="text-center" style="font-size: 2rem;font-family: 幼圆">
            你锁定的鸡有{{count($tickets)}}台
        </p>
    </div>
</div>
@stop