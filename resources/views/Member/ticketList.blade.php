<style type="text/css" media="screen">
    body { padding-bottom: 50px; }
    .footer{width: 100%;background-color: #333;color: #fff;}
</style>
@extends('body')
@section('main')

<section class="mainContain">
@if ($tickets->count())
    @foreach ($tickets as $ticket)
    
        <a href="{{ URL('pcertickets/'.$openid.'/'.$ticket->id.'/show/') }}" class="block pad1r lh2 borderB pr" style="background: #fff;">
            <p class="clearfix color2f">
                <span class="fl font14" style="width: 70%;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;">{{ $ticket->problem }}</span>
               <span class="fr font13 marR3r"  style="color: red">
                  @if     (($ticket->state)==1)<td>{{'处理中'}}</td>
                  @elseif     (($ticket->state)==2)<td>{{'已完成'}}</td>
                  @endif
                </span>
            </p>
            <span class="glyphicon glyphicon-chevron-right" style="float: right;position: absolute;right: 1rem;top: 40%;" aria-hidden="true"></span>         

            <p class="clearfix color60">
                <span class="fl font12" style="width: 55%;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;">上门时间：
                @if(($ticket->date)==1){{'星期一'}}
                    @elseif (($ticket->date)==2){{'星期二'}}
                    @elseif (($ticket->date)==3){{'星期三'}}
                    @elseif (($ticket->date)==4){{'星期四'}}
                    @elseif (($ticket->date)==5){{'星期五'}}
                    @endif
                  {{$ticket->hour}}
                @if($ticket->date1)
                    &nbsp;或&nbsp;
                    @if(($ticket->date1)==1){{'星期一'}}
                    @elseif (($ticket->date1)==2){{'星期二'}}
                    @elseif (($ticket->date1)==3){{'星期三'}}
                    @elseif (($ticket->date1)==4){{'星期四'}}
                    @elseif (($ticket->date1)==5){{'星期五'}}
                    @endif
                {{$ticket->hour1}}
                @endif
                </span>
                @if($ticket->assess)
                <span class="fr font12 marR3r">
                机主评价：
                @if($ticket->assess== 1) 好评
                @elseif($ticket->assess== 2) 中评
                @elseif($ticket->assess== 3) 差评
                @endif
                </span>
                @endif
                

                </p>

        
        </a> 
    @endforeach
    @else
        <div class="container">
            <div class="content">
                <div class="title">亲(づ￣3￣)づ╭❤～ 你还没有未处理订单喔！</div>
            </div>
        </div>
        
@endif
</section>

<div class="row-fluid">
    <div class="span12 navbar-fixed-bottom footer" >
      <p class="text-center" >
        © 2016 中大南方PC服务队 | Powered by JokerLinly
      </p>
    </div>
  </div>
@stop