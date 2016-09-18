@extends('Member.layout')
@section('main')
    <section class="pad1r">
        <div class="borderd8 bsd2 marB1r">
     
            <p class="orderTitle clearfix borderTd8">
                <span class="fl">申报内容</span>
                <span class="fr">{{$ticket['created_time']}}</span>
            </p>
            <div class="padTB1rLR2r Bg_ee color60 font13 borderBd8">
                <p>报修人: {{$ticket['name']}}</p>
                <p>院区：
                  @if(($ticket['area'])==0){{'东区'}}
                  @elseif (($ticket['area'])==1){{'西区'}}
                  @endif
                </p>
                <p>宿舍号：{{ $ticket['address'] }}</p>
                <p>手机：{{ $ticket['number'] }}</p>
                @if($ticket['shortnum'])
                <p>短号：{{ $ticket['shortnum'] }}</p>
                @endif
                <p>上门时间：{{$ticket['chain_date']}}{{$ticket['hour']}}
                @if($ticket['date1'])
                    &nbsp;或&nbsp;
                {{$ticket['chain_date1']}}{{$ticket['hour1']}}
                @endif
                <p>
                <p>报修内容：{{ $ticket['problem'] }}</p>

            </div>
        </div>
        {{-- 订单互动内容 --}}
        
            <div class="borderd8 bsd2 marB1r">
              
                <p class="orderTitle clearfix borderTd8">
                    <span class="fl">订单动态</span>
                    <span class="fr">状态：
                    @if(($ticket['state'])==1) 已受理
                    @elseif(($ticket['state'])==0) 已发送
                    @elseif(($ticket['state'])==2) 已完成
                    @endif
                    </span>
                </p>
                <div class="padTB1rLR2r Bg_ee color60 font13 borderBd8">
                @if (count($comments)==0)
                暂无动态
                @else
                    @foreach ($comments as $comment)
                        @if(($comment['from'])==0)
                        <p class="tac font1">{{$comment['created_time']}}</p>
                        <p>机主说：{{$comment['text']}} </p> 

                        @elseif(($comment['from'])==2)
                        <p class="tac font1">{{$comment['created_time']}}</p>
                        <p>@if($comment['wcuser_id']==$ticket['pcer']['wcuser']['id'])<strong>你</strong>
                           @else @if($comment['wcuser']['pcer'])PC仔{{$comment['wcuser']['pcer']['name']}} @else 其他PC仔 @endif
                           @endif
                        说：{{$comment['text']}} </p> 
                        @elseif(($comment['from'])==3)
                        <p class="tac font1">{{$comment['created_time']}}</p>
                        <p>PC管理员{{ $ticket['pcadmin']['pcer']['name']}}说：{{$comment['text']}} </p> 
                        @endif
                    @endforeach
                @endif
                </div>
            </div>

    {{-- 与管理员私聊的内容 --}}
        <div class="borderd8 bsd2 marB1r">
              
                <p class="orderTitle clearfix borderTd8">
                    <span class="fl">
                    @if($ticket['pcadmin']) {{ $ticket['pcadmin']['pcer']['name']}}
                    @else 你自己
                    @endif 分配给你的订单</span>
                </p>
                <div class="padTB1rLR2r Bg_ee color60 font13 borderBd8">
                @if (count($comments)==0)
                暂无动态
                @else
                    @foreach ($comments as $comment)
                        @if(($comment['from'])==4)
                        <p class="tac font1">{{$comment['created_time']}}</p>
                        <p>{{ $ticket['pcadmin']['pcer']['name']}}说：{{$comment['text']}} </p> 
                    
                        @elseif(($comment['from'])==1)
                        <p class="tac font1">{{$comment['created_time']}}</p>
                        <p><strong>你</strong>说：{{$comment['text']}} </p> 
                        @endif
                    
                    @endforeach
                @endif
                    
                </div>
            </div>

            {{-- 发送消息 --}}
            @if (($ticket['state'])==1)
            
            <div class="borderd8 bsd2 marB1r Bg_ee clearfix">
                <p class="orderTitle clearfix borderTd8">
                    发送消息
                </p>
            {!! Form::open(['action' => 'Member\TicketController@PcerAddComment', 'style'=>'display: inline;']) !!}
                <div class="mar1r font13 pr Bg_ee borderBd8">
                    <select class="selectDown" name="from">
                        <option value="2">发给机主</option>
                        <option value="1">发给管理员</option>
                    </select>
                    <span class="downBtn"></span>
                </div>
                 
                 <input type="hidden" name="wcuser_id" value="{{$ticket['pcer']['wcuser_id']}}" >
                <div class="pad1r Bg_ee color60 font13 borderBd8">
                    <textarea name="text" rows="5" required="required" class="multiInput font13" placeholder="1、你的言论代表了整个PC服务队，编辑文字时，请注意节操！ 2、发送给管理员的信息会通过服务号提醒，无非必要事件如：机主填错电话、或者一整晚都打不通电话造成你无法顺利完成订单时，不要给管理员发送消息。"></textarea>
                </div>
            </div>
            <input type="submit" class="mainBtn marTB1r font14 color2f">
            {!! Form::close() !!}
            <br>
            <p style="color: red;">PS：当任务完成时，才能结束。记得提醒机主给个好评哟！</p>

        <input type="submit" value="结束订单" class="mainBtn1 marTB1r font14 color2f">
        </form>
        @endif

        {{-- 订单评价 --}}
            @if (($ticket['state'])==2)
                @if($ticket['assess'])
                    <div class="borderd8 bsd2 marB1r">
                        <p class="orderTitle clearfix borderTd8">
                            <span class="fl">订单评价：
                            {{$ticket['assess_slogan']}}
                            </span>
                        </p>
                        <div class="padTB1rLR2r Bg_ee color60 font13 borderBd8">
                            <p>@if($ticket['suggestion']){{$ticket['suggestion']}}
                                @else 无
                                @endif
                            </p>
                        </div>
                    </div>
                @endif
            @endif
            
    </section>
<div class="tankuang">
    <div class="prop_box">
        <div class="title">系统提示</div>
        <div class="content">{{ Session::get('message') }}</div>
        <div class="btn_box">
            <a href="" class="close" style="color: #337ab7">确认</a>
            <a href="javascript:;" onclick="jQuery('.prop_box').hide()" class="close" style="color: #337ab7">取消</a>
        </div>
    </div>
</div>
  <div class="row-fluid">
    <div class="span12 ">
      <p class="text-center">
        © 2016 中大南方PC服务队 | Powered by JokerLinly
      </p>
    </div>
  </div>
@stop
