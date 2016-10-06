@extends('WapAdmin.layout')
@section('main')

<div class="row-fluid color">
    <div class="span12 ">
        <p class="text-center" style="font-size: 2rem;font-family: 幼圆">
            你锁定的鸡有{{count($tickets)}}台
        </p>
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
                <span class="fl font12" style="width: 70%;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;">上门时间：{{$ticket['chain_date']}}{{$ticket['hour']}}
                @if($ticket['date1'])
                    &nbsp;或&nbsp;
                {{$ticket['chain_date1']}}{{$ticket['hour1']}}
                @endif
                </span>
                <span class="fr font12 marR3r">
                    @if($ticket['state']==1 && !empty($ticket['pcer_id']))
                        @if($ticket['pcer']){{$ticket['pcer']['name']}}
                        @else 已分配
                        @endif
                    @elseif($ticket['state']==1) <font style="color:red;">只锁定</font>
                    @elseif($ticket['state']==0) 未处理
                    @elseif($ticket['state']==2) 机主关
                    @elseif($ticket['state']==3) PC仔关
                    @elseif($ticket['state']==4) 已结束
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