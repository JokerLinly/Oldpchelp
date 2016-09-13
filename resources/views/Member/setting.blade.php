@extends('Member.layout')
@section('main')

<section class="padLR1r">

    @if($issigns)
            <div class="borderd8 bsd2 marB1r">

            <p class="orderTitle clearfix borderTd8">

                <span class="fl">PC仔个人资料</span>

            </p>
            <div class="padTB1rLR2r Bg_ee color60 font13 borderBd8">
                <p>姓名: {{$issigns->name}}</p>
                <p>昵称: @if($issigns->nickname){{$issigns->nickname}}
                         @else 暂无
                         @endif
                </p>
                <p>职务: 
                    @if($issigns->state==0)PC仔
                    @elseif($issigns->state==1)PC保姆
                    @endif
                </p>

                <p>夜晚空闲时间: 
                    @if($issigns->idle)
                    @foreach ($issigns->idle as $idle)
                        @if($idle->date==1)星期一
                        @elseif($idle->date==2)星期二
                        @elseif($idle->date==3)星期三
                        @elseif($idle->date==4)星期四
                        @elseif($idle->date==5)星期五
                        @endif
                    @endforeach
                    @endif
                </p>
                <p>年级: {{$issigns->pcerlevel->level_name}}</p>
                <p>学号: {{$issigns->school_id}}</p>
                <p>长号: {{$issigns->long_number}}</p>
                <p>短号: @if ($issigns->number){{$issigns->number}}
                         @else 暂无
                         @endif
                </p>
                <p>学系: {{$issigns->department}}</p>
                <p>专业: {{$issigns->major}}</p>
                <p>班级: {{$issigns->clazz}}</p>

                <p>宿舍: @if($issigns->area==0)东区
                         @elseif($issigns->area==1)西区
                         @endif                        
                         {{$issigns->address}}</p>              
            </div>

        </div>
        <form action="show"  style="display: inline;">
        <input type="submit" value="编辑" class="mainBtn marTBd8r font14 color2f">
        <input type="hidden" name="pcer_id" value="{{$issigns->id}}" >
         </form>
    @else
    <div class="marTBd8r borderB font13 clearfix">
        <p class="color2f font14">来来来，设置下空闲时间</p>
        <form action="edit" method="POST" style="display: inline;">
        <input type="hidden" name="pcer_id" value="{{$issigns->id}}" >
        <div class="dateDiv pr">
            <div class="marTBd8r in_block font13 pr selectDate" style="width: 70%;">
                <select class="selectDown" name="date[]">
                    <option value="1">星期一</option>
                    <option value="2">星期二</option>
                    <option value="3">星期三</option>
                    <option value="4">星期四</option>
                    <option value="5">星期五</option>
                </select>
                <span class="downBtn"></span>
            </div>

            <span class="addBtn">+</span>
        </div>
    </div>
    <input type="submit" class="mainBtn marTBd8r font14 color2f">
    </form>
    @endif
</section>

<script type="text/javascript" charset="utf-8">
    var dateHtml = '<div class="dateDiv pr"><div class="marTBd8r in_block font13 pr selectDate" style="width: 70%;"><select class="selectDown" name="date[]"><option value="1">星期一</option><option value="2">星期二</option><option value="3">星期三</option><option value="4">星期四</option><option value="5">星期五</option></select><span class="downBtn"></span></div><span class="deleteBtn" onclick="deleteDate(this)">-</span></div>'
    $('.addBtn').bind('click',function(){ 
        $(this).parent().after(dateHtml);
    });
    function deleteDate(obj){ 
        $(obj).parent().remove();
    }
</script>

@stop