@extends('body')
@section('main')

     

    <section class="pad1r">
        <div class="borderd8 bsd2 marB1r">
     
            <p class="orderTitle clearfix borderTd8">
                <span class="fl">申报内容</span>
                <span class="fr">{{$ticket->created_at}}</span>
            </p>
            <div class="padTB1rLR2r Bg_ee color60 font13 borderBd8">
                <p>报修人: {{$ticket->name}}</p>
                <p>院区：
                  @if(($ticket->area)==0){{'东区'}}
                  @elseif (($ticket->area)==1){{'西区'}}
                  @endif
                </p>
                <p>宿舍号：{{ $ticket->address }}</p>
                <p>手机：{{ $ticket->number }}</p>
                @if($ticket->shortnum)
                <p>短号：{{ $ticket->shortnum }}</p>
                @endif
                <p>上门时间：
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
                <p>
                <p>报修内容：{{ $ticket->problem }}</p>
                @if($ticket->pcer)
                <p>维修员：@if($ticket->pcer->nickname){{$ticket->pcer->nickname}}
                           @else {{$ticket->pcer->name}}
                           @endif </p>
                @endif
            </div>
        </div>
        {{-- 订单互动内容 --}}
        
            <div class="borderd8 bsd2 marB1r">
              
                <p class="orderTitle clearfix borderTd8">
                    <span class="fl">订单动态</span>
                    <span class="fr">状态：
                    @if(($ticket->state)==1) 已受理
                    @elseif(($ticket->state)==0) 已发送
                    @elseif(($ticket->state)==2) 已完成
                    @endif
                    </span>
                </p>
                <div class="padTB1rLR2r Bg_ee color60 font13 borderBd8">
                 @if ($comments->count())
                   @foreach ($comments as $comment)
                    <p class="tac font1">{{$comment->created_time}}</p> 
                    <p>@if(($comment->from)==0)<strong>你</strong>说：{{$comment->text}} </p> 
                       @elseif(($comment->from)==2)PC维修队员{{$comment->wcuser->pcer->name}}
                       说：{{$comment->text}} </p> 
                       @elseif(($comment->from)==3)PC管理员{{$comment->wcuser->pcer->name}}
                       说：{{$comment->text}} </p> 
                       @endif
                    
                    @endforeach
                    @else
                    暂无动态
                    @endif
                    
                </div>
            </div>

            {{-- 订单完成时出现 --}}
            @if(($ticket->state)==2)
                @if($ticket->assess)
            <div class="borderd8 bsd2 marB1r">
                <p class="orderTitle clearfix borderTd8">
                    <span class="fl">评价详情</span>
                    <span class="fr">评价等级：
                    @if(($ticket->assess)==1) 好评
                    @elseif(($ticket->assess)==2) 中评
                    @elseif(($ticket->assess)==3) 差评
                    @endif
                    </span>
                </p>
                <div class="padTB1rLR2r Bg_ee color60 font13 borderBd8">
                 
                    @if ($ticket->suggestion)
                    <p>{{$ticket->suggestion}}</p> 
                    @else
                    ╮(╯_╰)╭亲你没留下任何评价喔！
                    @endif
              
                </div>
            </div>
                @else
            <div class="borderd8 bsd2 marB1r Bg_ee clearfix">
                <p class="orderTitle clearfix borderTd8">
                    处理状态
                </p>
             <form action="update"  method="POST" style="display: inline;">
             <input type="hidden" name="ticket_id" value="{{$ticket->id}}" >
                <div class="mar1r font13 pr Bg_ee borderBd8">
                    <select class="selectDown" name="assess">
                        <option>请选择！</option>
                        <option value="1">好评</option>
                        <option value="2">中评</option>
                        <option value="3">差评</option>
                    </select>
                    <span class="downBtn"></span>
                </div>
            </div>
            
             <div class="borderd8 bsd2 marB1r Bg_ee clearfix">
                <p class="orderTitle clearfix borderTd8">
                    说点什么
                </p>
                <div class="pad1r Bg_ee color60 font13 borderBd8">
                    <textarea name="suggestion" rows="5" required="required" class="multiInput font13" placeholder="亲(づ￣3￣)づ╭❤～给差评或者中评时要填写喔！我们在努力做得更好呢！"></textarea>
                </div>
            </div>

            <input type="submit" class="mainBtn marTB1r font14 color2f">
            </form>
                @endif 
            @endif  

            {{-- 订单未完成时，用户都可以发送消息 --}}
            @if(($ticket->state)!=2)
            <div class="borderd8 bsd2 marB1r Bg_ee clearfix">
                <p class="orderTitle clearfix borderTd8">
                    意见栏
                </p>
                 <form action="edit"  method="POST" style="display: inline;">
                 <input type="hidden" name="wcuser_id" value="{{$ticket->wcuser_id}}" >
                 <input type="hidden" name="ticket_id" value="{{$ticket->id}}" >
                 <input type="hidden" name="from" value="0" >
                <div class="pad1r Bg_ee color60 font13 borderBd8">
                    <textarea name="text" rows="5" required="required" class="multiInput font13" placeholder="催单？表白？吐槽？都可以O(∩_∩)O哈哈~"></textarea>
                </div>
            </div>
            <input type="submit" class="mainBtn marTB1r font14 color2f">
            </form>
                
            @endif 

            @if($ticket->pcer_id)
            @else 
            <p>PS：删除订单之后无法恢复</p>
            <form action="delticket"  method="POST" style="display: inline;">
            <input type="hidden" name="wcuser_id" value="{{$ticket->wcuser_id}}" >
            <input name="_method" type="hidden" value="DELETE">
            <input type="submit" value="删除订单" class="mainBtn1 marTB1r font14 color2f">
            </form>
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
