@extends('WapAdmin.ticketListLayout')
@section('title')
<div class="row-fluid color">
    <div class="span12 ">
     <p class="text-center" style="font-size: 2rem;font-family: 幼圆">
        修完了{{count($tickets)}}台机
      </p>
    </div>
</div>
@stop