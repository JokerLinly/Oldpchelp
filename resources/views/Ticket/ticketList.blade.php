<style>
        footer{width: 100%;background-color: #333;color: #fff;}
        .footfixed{position: absolute;bottom: 0;left: 0;padding: 2%;}
    </style>
@extends('body')
@section('main')


<section class="mainContain">
@if ($tickets->count())
    @foreach ($tickets as $ticket)
    
        <a href="{{ URL('mytickets/'.$ticket->id.'/show/') }}" class="block pad1r lh2 borderB pr">
            <p class="clearfix color2f">
                <span class="fl font14">{{ $ticket->problem }}</span>
                <span class="fr font13 marR3r">
                    @if(($ticket->state)==0)<td>{{'已发送'}}</td>
                  @elseif (($ticket->state)==1)<td>{{'处理中'}}</td>
                  @elseif (($ticket->state)==2)<td>{{'已完成'}}</td>
                  @elseif (($ticket->state)==3)<td>{{'已评价'}}</td>
                  @endif

                </span>
            </p>
            <p class="clearfix color60">
                <span class="fl font12">时间：{{ $ticket->created_at }}</span>
                <span class="fr font12 marR3r">维修员：{{ $ticket->pcer_name }}</span>
            </p>
            <span class="rightBtn"></span>
        </a> 
    @endforeach
    @else
        <div class="container">
            <div class="content">
                <div class="title">亲(づ￣3￣)づ╭❤～ 你还没有报修过喔！</div>
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