@extends('body')
@section('main')


<section>
    @foreach ($tickets as $ticket)
    @if ($tickets->count())
        <a href="orderDetail.html" class="block pad1r lh2 borderB pr">
            <p class="clearfix color2f">
                <span class="fl font14">{{ $ticket->problem }}</span>
                <span class="fr font13 marR3r">已受理</span>
            </p>
            <p class="clearfix color60">
                <span class="fl font12">时间：{{ $ticket->created_at }}</span>
                <span class="fr font12 marR3r">报修人：{{ $ticket->pcer_name }}</span>
            </p>
            <span class="rightBtn"></span>
        </a>
    @else
        亲(づ￣3￣)づ╭❤～ 你还没有报修过喔！
    @endif
    @endforeach

</section>
@stop