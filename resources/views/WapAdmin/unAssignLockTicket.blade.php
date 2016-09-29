@extends('Member.layout')
@section('main')

<div class="row-fluid color">
    <div class="span12 ">
        <p class="text-center" style="font-size: 2rem;font-family: 幼圆">
            你锁定了{{count($tickets)}}台机未分配
        </p>
        <div class="title_tag">
            <a href="{{action('Admin\WapHomeController@getTodayTackTicket')}}"><button type="button" class="btn btn-secondary">只看今天</button></a>
            <a href="{{action('Admin\WapHomeController@getOverTimeTackTicket')}}"><button type="button" class="btn btn-secondary">过期订单</button></a>
            <a href="{{action('Admin\WapHomeController@getLockTackTickets')}}"><button type="button" class="btn btn-mint">我锁定的</button></a>
            <a href="{{action('Admin\WapHomeController@getAllTackTicket')}}"><button type="button" class="btn btn-secondary" >全部</button></a>
        </div>
    </div>
</div>

<section class="mainContain">
@if (!empty($tickets))
    @foreach ($tickets as $ticket)
    
        <a href="{{action('Admin\WapHomeController@lockSingleTicket',array('id'=>$ticket['id']))}}" class="block pad1r lh2 borderB pr" style="background: #fff;">
            <p class="clearfix color2f">
                <span class="fl font14" style="width: 70%;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;">{{ $ticket['problem'] }}</span>  
                <span class="fr font12 marR3r" style="color:blue;">{{$ticket['friend_time']}}</span>
            </p>
            <span class="glyphicon glyphicon-chevron-right" style="float: right;position: absolute;right: 1rem;top: 40%;" aria-hidden="true"></span>         

            <p class="clearfix color60">
                <span class="fl font12" style="width: 90%;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;">上门时间：{{$ticket['chain_date']}}{{$ticket['hour']}}
                @if($ticket['date1'])
                    &nbsp;或&nbsp;
                {{$ticket['chain_date1']}}{{$ticket['hour1']}}
                @endif
                </span>
                <span class="fr font12 marR3r">
                    @if($ticket['state']==1) 只锁定
                    @elseif($ticket['state']==1 && !empty($ticket['pcer_id']))已分配
                    @elseif($ticket['state']==0) 未处理
                    @elseif($ticket['state']>=2) 已完成
                    @endif
                </span>
            </p>
        </a> 
    @endforeach
</section>
@if(count($tickets) > 8)
<div class="row-fluid">
    <div class="span12 ">
        <p class="text-center" style="padding-bottom:50px;">
        © 2016 中大南方PC服务队 | Powered by JokerLinly
        </p>
    </div>
</div>
@endif
@else
<img src="{{asset('img/pis2.png')}}" class="img-responsive img_center" alt="Responsive image" >
<p class="font_center">亲(づ￣3￣)づ╭❤～ 暂时没有任务了呢！趁现在好好休息吧！</p>
 <p class="text-center wap_foot_center">
© 2016 中大南方PC服务队 | Powered by JokerLinly
</p>       
@endif
@stop

