<style type="text/css" media="screen">
    body { padding-bottom: 50px; }
    .footer{width: 100%;background-color: #333;color: #fff;}
</style>
@extends('body')
@section('main')

@if($tickets->count())
<section class="mainContain">

    @foreach ($tickets as $ticket)
    
        <a href="{{ URL('pcadminwc/'.$openid.'/'.$ticket->id.'/show/') }}" class="block pad1r lh2 borderB pr" style="background: #fff;">
            <p class="clearfix color2f">
                <span class="fl font14" style="width: 70%;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;">{{$ticket->problem}}</span>
                <span class="fr font13 marR3r">
                  @if     (($ticket->state)==1)<td>{{'处理中'}}</td>
                  @endif

                </span>
                
            </p>
            <span class="glyphicon glyphicon-chevron-right" style="float: right;position: absolute;right: 1rem;top: 40%;" aria-hidden="true"></span>
            <p class="clearfix color60">
                <span class="fl font12" style="width: 55%;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;">报修至今：{{ $ticket->differ_time }}</span>
                <span class="fr font12 marR3r">负责人：
                @if($ticket->pcer) {{ $ticket->pcer->name}}
                @else 暂无
                @endif
                </span>
            </p>
        </a> 
    @endforeach

</section>
@else
    <div class="container">
        <div class="content">
            <div class="title">亲(づ￣3￣)づ╭❤～ 你还没有分配过订单喔！</div>
        </div>
    </div>
        
@endif

<div class="row-fluid">
    <div class="span12 navbar-fixed-bottom footer" >
      <p class="text-center" >
        © 2016 中大南方PC服务队 | Powered by JokerLinly
      </p>
    </div>
  </div>
@stop