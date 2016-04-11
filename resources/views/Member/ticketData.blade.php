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
                @if (($ticket->comment->count())==0)
                暂无动态
                @else
                    @foreach ($ticket->comment as $comment)
                        @if(($comment->from)==0)
                        <p class="tac font1">{{$comment->created_time}}</p>
                        <p>机主说：{{$comment->text}} </p> 

                        @elseif(($comment->from)==2)
                        <p class="tac font1">{{$comment->created_time}}</p>
                        <p><strong>你</strong>说：{{$comment->text}} </p> 

                        @elseif(($comment->from)==3)
                        <p class="tac font1">{{$comment->created_time}}</p>
                        <p>PC管理员{{ $ticket->pcadmin->pcer->name}}说：{{$comment->text}} </p> 
                        @endif
                    @endforeach
                @endif
                </div>
            </div>

    {{-- 与管理员私聊的内容 --}}
        <div class="borderd8 bsd2 marB1r">
              
                <p class="orderTitle clearfix borderTd8">
                    <span class="fl">
                    @if($ticket->pcadmin) {{ $ticket->pcadmin->pcer->name}}
                    @else 暂无
                    @endif 分配给你的订单</span>
                </p>
                <div class="padTB1rLR2r Bg_ee color60 font13 borderBd8">
                @if (($ticket->comment->count())==0)
                暂无动态
                @else
                    @foreach ($ticket->comment as $comment)
                        @if(($comment->from)==4)
                        <p class="tac font1">{{$comment->created_time}}</p>
                        <p>{{ $ticket->pcadmin->pcer->name}}说：{{$comment->text}} </p> 
                    
                        @elseif(($comment->from)==1)
                        <p class="tac font1">{{$comment->created_time}}</p>
                        <p><strong>你</strong>说：{{$comment->text}} </p> 
                        @endif
                    
                    @endforeach
                @endif
                    
                </div>
            </div>

            {{-- 发送消息 --}}
            @if (($ticket->state)==2)
            @else
            <div class="borderd8 bsd2 marB1r Bg_ee clearfix">
                <p class="orderTitle clearfix borderTd8">
                    发送消息
                </p>
                <form action="edit"  method="POST" style="display: inline;">
                <div class="mar1r font13 pr Bg_ee borderBd8">
                    <select class="selectDown" name="from">
                        <option value="2">发给机主</option>
                        <option value="1">发给管理员</option>
                    </select>
                    <span class="downBtn"></span>
                </div>
                 
                 <input type="hidden" name="wcuser_id" value="{{$ticket->pcer->wcuser_id}}" >
                <div class="pad1r Bg_ee color60 font13 borderBd8">
                    <textarea name="text" rows="5" required="required" class="multiInput font13" placeholder="你的言论代表了整个PC服务队，编辑文字时，请注意节操">
                    </textarea>
                </div>
            </div>
            <input type="submit" class="mainBtn marTB1r font14 color2f">
            </form>
            <br>
            <p>PS：当工作完成时，才能结束</p>
        <form action="update"  method="post" style="display: inline;"> 
        <input type="hidden" name="wcuser_id" value="{{$ticket->pcer->wcuser_id}}" >       
        <input type="submit" value="结束订单" class="mainBtn1 marTB1r font14 color2f">
        </form>
        @endif
            
    </section>
  <div class="row-fluid">
    <div class="span12 ">
      <p class="text-center">
        © 2016 中大南方PC服务队 | Powered by JokerLinly
      </p>
    </div>
  </div>
@stop
