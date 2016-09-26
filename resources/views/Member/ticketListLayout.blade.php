@extends('Member.layout')
@section('main')

@yield('title')

<section class="mainContain">
@if (!empty($tickets))
    @foreach ($tickets as $ticket)
    
        <a href="{{action('Member\TicketController@showSingleTicket',array('id'=>$ticket['id']))}}" class="block pad1r lh2 borderB pr" style="background: #fff;">
            <p class="clearfix color2f">
                <span class="fl font14" style="width: 70%;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;">{{ $ticket['problem'] }}</span>  
                @if (($ticket['state'])==1) <span class="fr font13 marR3r"  style="color: red"><td>{{'处理中'}}</td></span>
                @elseif(($ticket['state'])==2)<span class="fr font13 marR3r" ><td>{{'已完成'}}</td></span>
                @endif
            </p>
            <span class="glyphicon glyphicon-chevron-right" style="float: right;position: absolute;right: 1rem;top: 40%;" aria-hidden="true"></span>         

            <p class="clearfix color60">
                <span class="fl font12" style="width: 90%;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;">上门时间：{{$ticket['chain_date']}}{{$ticket['hour']}}
                @if($ticket['date1'])
                    &nbsp;或&nbsp;
                {{$ticket['chain_date1']}}{{$ticket['hour1']}}
                @endif
                </span>
                @if($ticket['assess'])
                <span class="fr font12 marR3r">
                机主评价：{{$ticket['assess_slogan']}}
                </span>
                @endif
                </p>
        </a> 
    @endforeach
</section>
@if(count($tickets) > 8)
<div class="row-fluid">
    <div class="span12 ">
        <p class="text-center">
        © 2016 中大南方PC服务队 | Powered by JokerLinly
        </p>
    </div>
</div>
@endif
@else
<div class="container">
    <div class="content" >
        <div class="title">亲(づ￣3￣)づ╭❤～ 暂时没有任务了呢！趁现在好好休息吧！</div>
    </div>
</div>
        
@endif
@stop