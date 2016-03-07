<style>
    footer{width: 100%;background-color: #333;color: #fff;}
    .footfixed{position: absolute;bottom: 0;left: 0;padding: 2%;}
</style>
@extends('body')
@section('main')

<section class="mainContain">
@if ($tickets)
    @foreach ($tickets as $ticket)
    
        <a href="{{ URL('mytickets/'.$ticket->id.'/show/') }}" class="block pad1r lh2 borderB pr">
            <p class="clearfix color2f">
                <span class="fl font14">{{ $ticket->problem }}</span>
            </p>
            <p class="clearfix color60">
                <span class="fl font12">上门时间：
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
                </p>
            <span class="rightBtn"></span>
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

<footer class="footfixed">
        <p class="text-center">
        © 2016 中大南方PC服务队 | Powered by JokerLinly
      </p>
    </footer>
    <script type="text/javascript" charset="utf-8">
        var mainHeight = $('.mainContain').height();
        var bodyHeight = $(window).height();
        if(mainHeight>bodyHeight){ 
            $('footer').removeClass('footfixed');
        }
    </script>
@stop