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
                @if($ticket['pcer_id'])
                <p>PC仔：{{$ticket['pcer']['name']}}</p>
                @endif
                @if($ticket['pcadmin_id'])
                <p>PC管理员：{{ $ticket['pcadmin']['pcer']['name']}}</p>
                @endif
            </div>
        </div>
        {{-- 订单互动内容 --}}
        @if ($ticket['status'] != 1)
            <div class="borderd8 bsd2 marB1r">
                <p class="orderTitle clearfix borderTd8">
                    <span class="fl">订单动态</span>
                    <span class="fr">状态：
                    @if(($ticket['state'])==1) 已受理
                    @elseif(($ticket['state'])==0) 已发送
                    @elseif(($ticket['state'])>=2) 已完成
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
                           @else {{$comment['senter_name']}}
                           @endif
                        说：{{$comment['text']}} </p> 
                        @elseif(($comment['from'])==3)
                        <p class="tac font1">{{$comment['created_time']}}</p>
                        <p>PC管理员{{$comment['senter_name']}}说：{{$comment['text']}} </p> 
                        @endif
                    @endforeach
                @endif
                </div>
            </div>
        @endif
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
                        <p>{{$comment['senter_name']}}说：{{$comment['text']}} </p> 
                    
                        @elseif(($comment['from'])==1)
                        <p class="tac font1">{{$comment['created_time']}}</p>
                        <p>
                        @if($ticket['pcer']['wcuser_id'] == $comment['wcuser_id'])
                        <strong>你</strong>
                        @else {{$comment['senter_name']}}
                        @endif
                        说：{{$comment['text']}} </p> 
                        @endif
                    
                    @endforeach
                @endif
                    
                </div>
            </div>

            {{-- 发送消息 --}}
            @if ( $ticket['state']==1)
            
            <div class="borderd8 bsd2 marB1r Bg_ee clearfix">
                <p class="orderTitle clearfix borderTd8">
                    发送消息
                </p>
            {!! Form::open(['action' => 'Member\TicketController@pcerAddComment', 'style'=>'display: inline;']) !!}
                <div class="mar1r font13 pr Bg_ee borderBd8">
                    <select class="selectDown" name="from">
                        @if ($ticket['status'] != 1)
                        <option value="2">发给机主</option>
                        @endif
                        <option value="1">发给管理员</option>
                    </select>
                    <span class="downBtn"></span>
                </div>
                <div class="pad1r Bg_ee color60 font13 borderBd8">
                    <textarea name="text" rows="5" required="required" class="multiInput font13" placeholder="1、你的言论代表了整个PC服务队，编辑文字时，请注意节操！ 2、发送给管理员的信息会通过服务号提醒，无非必要事件如：机主填错电话、或者一整晚都打不通电话造成你无法顺利完成订单时，不要给管理员发送消息。"></textarea>
                </div>
            </div>
             <input type="hidden" name="ticket_id" value="{{$ticket['id']}}" >
            <input type="submit" class="mainBtn marTB1r font14 color2f">
            {!! Form::close() !!}
            <br>
            <p style="color: red;">PS：当任务完成时，才能结束。记得提醒机主给个好评哟！</p>

        <input type="submit" value="结束订单" class="mainBtn1 marTB1r font14 color2f" data-toggle="modal" data-target="#delModal">

        <!-- Modal -->
        <div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog" style="margin-top: 40%;">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <font class="modal-title" id="myModalLabel" style="font-size: 2rem;font-family: 幼圆">备注</font>
              </div>
            {!! Form::open(['action' => 'Member\TicketController@pcerDelTicket', 'style'=>'display: inline;']) !!}
              
                <div class="pad1r Bg_ee color60 font13 borderBd8">
                    <textarea name="text" rows="2" required="required" class="multiInput font13" placeholder="辛苦啦！请填写备注，比如已完成或者机主说不用修了。"></textarea>
                </div>
                <input type="hidden" name="ticket_id" value="{{$ticket['id']}}" >
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="submit" class="btn btn-primary">提交</button>
              </div>
            {!! Form::close() !!}
            </div>
          </div>
        </div>
        @endif

        {{-- 订单评价 --}}
            @if (($ticket['state'])==2 && $ticket['status'] !=1)
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

  <div class="row-fluid">
    <div class="span12">
      <p class="text-center" style="padding-bottom:50px;">
        © 2016 中大南方PC服务队 | Powered by JokerLinly
      </p>
    </div>
  </div>


@stop

