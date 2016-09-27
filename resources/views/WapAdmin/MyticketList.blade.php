@extends('WapAdmin.layout')
@section('main')
<div class="row-fluid color">
    <div class="span12 ">
     <p class="text-center" style="font-size: 2rem;font-family: 幼圆">
        我报修了{{count($tickets)}}台机
      </p>
    </div>
</div>

@if(count($tickets)>0)
<section class="mainContain">

    @foreach ($tickets as $ticket)
    
        <a href="{{action('Ticket\HomeController@showSingleTicket',array('id'=>$ticket['id']))}}" class="block pad1r lh2 borderB pr" style="background: #fff;">
            <p class="clearfix color2f">
                <span class="fl font14" style="width: 70%;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;">{{$ticket['problem']}}</span>
                <span class="fr font13 marR3r">
                  @if(($ticket['state'])==0)<td>{{'已发送'}}</td>
                  @elseif (($ticket['state'])==1)<td>{{'处理中'}}</td>
                  @elseif (($ticket['state'])==2)<td>{{'已完成'}}</td>
                  @elseif (($ticket['state'])==3)<td>{{'已评价'}}</td>
                  @endif

                </span>
                
            </p>
            <span class="glyphicon glyphicon-chevron-right" style="float: right;position: absolute;right: 1rem;top: 40%;" aria-hidden="true"></span>
            <p class="clearfix color60">
                <span class="fl font12" style="width: 55%;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;">时间：{{ $ticket['created_time'] }}</span>
                <span class="fr font12 marR3r">维修员：
                @if($ticket['pcer']) {{ $ticket['pcer']['name']}}
                @else 暂无
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
<p class="font_center">亲(づ￣3￣)づ╭❤～ 你还没有报修过喔！点击下方按钮开始报修！</p>

<a href="{{action('WechatController@pchelp')}}" class="font_center" style="padding-bottom: 13%;"><button type="button" class="btn btn-success" style="margin-left: 20%;width: 65%;margin-top: 5%;">点我报修</button></a>
<p class="text-center wap_foot_center">
© 2016 中大南方PC服务队 | Powered by JokerLinly
</p>    
@endif

@stop