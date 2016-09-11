@extends('body')
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
                @if($ticket['pcer'])
                <p>维修员：@if($ticket['pcer']['nickname']){{$ticket['pcer']['nickname']}}
                           @else {{$ticket['pcer']['name']}}
                           @endif </p>
                @endif
            </div>
        </div>
        {{-- 订单互动内容 --}}
        
            <div class="borderd8 bsd2 marB1r">
              
                <p class="orderTitle clearfix borderTd8">
                    <span class="fl">订单动态</span>
                    <span class="fr">状态：
                    @if($ticket['state']==1) 已受理
                    @elseif($ticket['state']==0) 已发送
                    @elseif($ticket['state']>=2) 已完成
                    @endif
                    </span>
                </p>
                <div class="padTB1rLR2r Bg_ee color60 font13 borderBd8">
                @if (count($comments) > 0)
                   @foreach ($comments as $comment)
                    
                    @if($comment['from']==0)
                        <p class="tac font1">{{$comment['created_time']}}</p> 
                        <p><strong>你</strong>说：{{$comment['text']}} </p> 
                    @elseif($comment['from']==2)
                        <p class="tac font1">{{$comment['created_time']}}</p> 
                        <p>PC仔@if ($comment['wcuser']['pcer']['nickname']){{$comment['wcuser']['pcer']['nickname']}}
                           @else {{$comment['wcuser']['pcer']['name']}}@endif说：{{$comment['text']}}</p> 
                    @elseif($comment['from']==3)
                        <p class="tac font1">{{$comment['created_time']}}</p>
                        <p>PC管理员 @if($comment['wcuser']['pcer']['nickname']){{$comment['wcuser']['pcer']['nickname']}}
                           @else {{$comment['wcuser']['pcer']['name']}}@endif说：{{$comment['text']}}</p> 
                    @endif
                    
                    @endforeach
                @else
                暂无动态
                @endif
                    
                </div>
            </div>

            {{-- 订单完成时出现 --}}
            @if($ticket['state'] >= 2)
                @if($ticket['assess'])
            <div class="borderd8 bsd2 marB1r">
                <p class="orderTitle clearfix borderTd8">
                    <span class="fl">评价详情</span>
                    <span class="fr">评价内容：{{$ticket['assess_slogan']}}
                        
                    </span>
                    
                </p>
                <div class="padTB1rLR2r Bg_ee color60 font13 borderBd8">
                @if ($ticket['suggestion'])
                    <p>{{$ticket['suggestion']}}</p> 
                @endif
                </div>
            </div>
                @else
            <div class="borderd8 bsd2 marB1r Bg_ee clearfix">
                <p class="orderTitle clearfix borderTd8">
                    评价一下吧~
                </p>
              {!! Form::open(['action' => 'Ticket\TicketController@addSuggestion']) !!}
             <input type="hidden" name="ticket_id" value="{{$ticket['id']}}" >
                <div class="mar1r font13 pr Bg_ee borderBd8">
                    <select class="selectDown" name="assess">
                        <option value="1">赞赞哒！</option>
                        <option value="2">一般般吧！</option>
                        <option value="3">简直垃圾！</option>
                    </select>
                    <span class="downBtn"></span>
                </div>
            </div>
            
             <div class="borderd8 bsd2 marB1r Bg_ee clearfix">
                <p class="orderTitle clearfix borderTd8">
                    说点什么
                </p>
                <div class="pad1r Bg_ee color60 font13 borderBd8">
                    <textarea name="suggestion" rows="5" class="multiInput font13" placeholder="亲(づ￣3￣)づ╭❤～填写意见可能会有惊喜喔！我们在努力做得更好呢！"></textarea>
                </div>
            </div>

            <input type="submit" class="mainBtn marTB1r font14 color2f">
            {!! Form::close() !!}
                @endif 
            @endif  

            {{-- 订单未完成时，用户都可以发送消息 --}}
            @if($ticket['state'] < 2)
            {!! Form::open(['action' => 'Ticket\TicketController@addComment']) !!}
            <div class="borderd8 bsd2 marB1r Bg_ee clearfix">
                <p class="orderTitle clearfix borderTd8">
                    意见栏
                </p>
                 <input type="hidden" name="ticket_id" value="{{$ticket['id']}}" >
                 <input type="hidden" name="from" value="0" >
                <div class="pad1r Bg_ee color60 font13 borderBd8">
                    <textarea name="text" rows="5" required="required" class="multiInput font13" placeholder="催单？表白？吐槽？都可以O(∩_∩)O哈哈~"></textarea>
                </div>
            </div>
            <input type="submit" value="提交" class="mainBtn marTB1r font14 color2f">
            {!! Form::close() !!}
                
            @endif 

            @if(!$ticket['pcer_id'])
            <p>PS：删除订单之后无法恢复</p>
            {!! Form::open(['action' => 'Ticket\HomeController@deleteTicket', 'style'=>'display: inline;']) !!}
                <input type="hidden" name="id" value="{{$ticket['id']}}" >
                <input type="submit" value="删除订单" class="mainBtn1 marTB1r font14 color2f" style="width: 45%">
            {!! Form::close() !!}

            {!! Form::open(['action' => ['Ticket\HomeController@updateShow',$ticket['id']],'method' => 'get','style'=>'display: inline;']) !!}
                <input type="submit" value="修改订单" class="mainBtn2 marTB1r font14 color2f" style="width: 45%;float: right;">
            {!! Form::close() !!}
            @endif
            
    </section>
  <div class="row-fluid">
    <div class="span12">
      <p class="text-center">
        © 2016 中大南方PC服务队 | Powered by JokerLinly
      </p>
    </div>
  </div>
@stop
