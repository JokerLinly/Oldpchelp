@extends('WapAdmin.layout')
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
    @if ($ticket['over_time'])
    <p style="color: red;font-size: 2rem;font-family: 幼圆;margin-left:3%">该订单超时!!!发送消息提醒机主更新订单内容！</p>
    @elseif ($ticket['status'] !=1) 
        {{-- 订单互动内容 --}}
            <div class="borderd8 bsd2 marB1r">
                <p class="orderTitle clearfix borderTd8">
                    <span class="fl">订单动态</span>
                    <span class="fr">状态：
                    @if($ticket['state']==1 && !empty($ticket['pcer_id']))已分配
                    @elseif($ticket['state']==1) 只锁定
                    @elseif($ticket['state']==0) 未处理
                    @elseif($ticket['state']>=2) 已完成
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
                        <p>PC仔{{$comment['senter_name']}}说：{{$comment['text']}} </p> 
                        @elseif(($comment['from'])==3)
                        <p class="tac font1">{{$comment['created_time']}}</p>
                        <p>PC管理员{{$comment['senter_name']}}说：{{$comment['text']}} </p> 
                        @endif
                    @endforeach
                @endif
                </div>
            </div>
@endif
    {{-- 与PC仔私聊的内容 --}}
    @if(!empty($ticket['pcer_id']))
        <div class="borderd8 bsd2 marB1r">
            <p class="orderTitle clearfix borderTd8">
                <span class="fl">
                与PC仔私聊的内容
                </span>
            </p>
            <div class="padTB1rLR2r Bg_ee color60 font13 borderBd8">
            @if (count($comments)==0)
            暂无动态
            @else
                @foreach ($comments as $comment)
                    @if(($comment['from'])==4)
                    <p class="tac font1">{{$comment['created_time']}}</p>
                    <p><strong>你</strong>说：{{$comment['text']}} </p> 
                
                    @elseif(($comment['from'])==1)
                    <p class="tac font1">{{$comment['created_time']}}</p>
                    <p>{{$comment['senter_name']}}说：{{$comment['text']}} </p> 
                    @endif
                
                @endforeach
            @endif   
            </div>
        </div>
    @endif
    
@if ($ticket['state'] < 2 )
    @if ($ticket['status'] ==1)
    <p style="color: red;">PS: 这个订单是由我们队员报修的，所以不能给机主发送消息</p>
    @endif
    @if(empty($ticket['pcer_id']))
    <p style="color: red;">PS: 该订单还没分配，没有可以发消息的PC仔</p>
        @if(count($pcers)==0)
        <p style="color: red;">PS: 今天也没有PC仔值班，想分机先锁定。</p>
        @else 
    {!! Form::open(['action' => 'Admin\WapHomeController@assignTicket', 'style'=>'display: inline;']) !!}
        <div class="marTBd8r borderB">
            <p class="color2f font14 text-primary">今天值班的PC仔</p>
            <div class="marTBd8r font13 pr">
                <select class="selectDown" name="pcer_id">
                    @foreach ($pcers as $pcer)
                    <option value="{{$pcer['id']}}">{{$pcer['name']}}</option>
                    @endforeach
                </select>
                <span class="downBtn"></span>
            </div>
        </div>
        <input type="button" value="直接分配" class="mainBtn3 marTB1r font14 color2f btn btn-info" data-toggle="modal" data-target="#AssignModal">

        <!-- Modal -->
        <div class="modal fade" id="AssignModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog" style="margin-top: 40%;">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <font class="modal-title" id="myModalLabel" style="font-size: 2rem;font-family: 幼圆">备注</font>
              </div>
                <p style="color: red;font-size: 2rem;font-family: 幼圆;margin-left:10%">确定分配？</p>
                <input type="hidden" name="ticket_id" value="{{$ticket['id']}}" >
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="submit" class="btn btn-primary">确定</button>
              </div>
            </div>
          </div>
        </div>
    @endif
    {!! Form::close() !!}
    @elseif(!empty($ticket['pcer_id']) && $ticket['state']==1)
        @if(count($pcer_change)==0)
        <p style="color: red;">PS:没有可以改派订单的PC仔</p>
        @else 
    {!! Form::open(['action' => 'Admin\WapHomeController@assignTicket', 'style'=>'display: inline;']) !!}
        <div class="marTBd8r borderB">
            <p class="color2f font14 text-primary">可以改派订单的PC仔</p>
            <div class="marTBd8r font13 pr">
                <select class="selectDown" name="pcer_id">
                    @foreach ($pcer_change as $pcer)
                    <option value="{{$pcer['id']}}">{{$pcer['name']}}</option>
                    @endforeach
                </select>
                <span class="downBtn"></span>
            </div>
        </div>
        <input type="button" value="直接改派" class="mainBtn3 marTB1r font14 color2f btn btn-info" data-toggle="modal" data-target="#AssignModal">

        <!-- Modal -->
        <div class="modal fade" id="AssignModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog" style="margin-top: 40%;">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <font class="modal-title" id="myModalLabel" style="font-size: 2rem;font-family: 幼圆">备注</font>
              </div>
                <p style="color: red;font-size: 2rem;font-family: 幼圆;margin-left:10%">确定分配？</p>
                <input type="hidden" name="ticket_id" value="{{$ticket['id']}}" >
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="submit" class="btn btn-primary">确定</button>
              </div>
            </div>
          </div>
        </div>
        @endif
    {!! Form::close() !!}
    @endif
    @if(empty($ticket['pcadmin_id']))
    <p style="color: red;">PS: 如果想分配该订单给不是今天值班的PC仔，可以先锁定，再从我锁定的订单页面进入进行分配</p>
    {!! Form::open(['action' => 'Admin\WapHomeController@lockTicket', 'style'=>'display: inline;']) !!}
    <input type="hidden" name="ticket_id" value="{{$ticket['id']}}" >
    <input type="submit" value="先锁定再分配" class="mainBtn3 marTB1r font14 color2f btn btn-mint">
    {!! Form::close() !!}
    @endif
@endif
@if ($ticket['state'] != 4)
    {{-- 发送消息 --}}
    <div class="borderd8 bsd2 marB1r Bg_ee clearfix">
        <p class="orderTitle clearfix borderTd8">
            发送消息
        </p>
    {!! Form::open(['action' => 'Admin\WapHomeController@pcadminSentComment', 'style'=>'display: inline;']) !!}
        <div class="mar1r font13 pr Bg_ee borderBd8">
            <select class="selectDown" name="from">
                @if ($ticket['status'] != 1)
                <option value="3">发给机主</option>
                @endif
                @if(!empty($ticket['pcer_id']))
                <option value="4">发给PC仔</option>
                @endif
            </select>
            <span class="downBtn"></span>
        </div>
        <div class="pad1r Bg_ee color60 font13 borderBd8">
            <textarea name="text" rows="5" required="required" class="multiInput font13" placeholder="1、你的言论代表了整个PC服务队，编辑文字时，请注意节操！ 2、你发送的内容都会以模板消息的形式提醒给对方，未免因消息过多造成滋扰使得服务号被投诉，有什么遗言请尽量一次性说完~ 3、注意不要写太多病句，因为你代表了整个PC队的文化水平。"></textarea>
        </div>
    </div>
     <input type="hidden" name="ticket_id" value="{{$ticket['id']}}" >
    <input type="submit" value="提交" class="mainBtn marTB1r font14 color2f">
    {!! Form::close() !!}
@endif
            <br>
    @if ($ticket['state'] != 4)
    <p style="color: red;">PS：当确认任务可以结束时，要关闭订单。关闭订单时会以模板消息提醒机主</p>

    <input type="submit" value="确认关闭" class="mainBtn3 marTB1r font14 color2f btn btn-danger" data-toggle="modal" data-target="#delModal">

    <input type="submit" value="订单解锁" class="mainBtn3 marTB1r font14 color2f btn btn-danger" data-toggle="modal" data-target="#unlockModal">

    <!-- Modal -->
    <div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog" style="margin-top: 40%;">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <font class="modal-title" id="myModalLabel" style="font-size: 2rem;font-family: 幼圆">备注</font>
          </div>
        {!! Form::open(['action' => 'Admin\WapHomeController@pcAdminCloseTicket', 'style'=>'display: inline;']) !!}
            <div class="pad1r Bg_ee color60 font13 borderBd8">
                    <textarea name="text" rows="3" class="multiInput font13" placeholder="不填写该内容的话，默认是：您发起的报修订单已经完成，如果您满意本次服务，请点击详情给个好评吧！"></textarea>
            </div>
            <input type="hidden" name="ticket_id" value="{{$ticket['id']}}" >
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
            <button type="submit" class="btn btn-primary">确认</button>
          </div>
        {!! Form::close() !!}
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="unlockModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog" style="margin-top: 40%;">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <font class="modal-title" id="myModalLabel" style="font-size: 2rem;font-family: 幼圆">解锁备注</font>
          </div>
        {!! Form::open(['action' => 'Admin\WapHomeController@pcAdminUnLockTicket', 'style'=>'display: inline;']) !!}
            <div class="pad1r Bg_ee color60 font13 borderBd8">
                    <textarea name="text" rows="3" class="multiInput font13"></textarea>
            </div>
            <input type="hidden" name="ticket_id" value="{{$ticket['id']}}" >
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
            <button type="submit" class="btn btn-primary">确认</button>
          </div>
        {!! Form::close() !!}
        </div>
      </div>
    </div>

    @endif

    {{-- 订单评价 --}}
    @if (($ticket['state'])>=2 && $ticket['status'] !=1)
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

