@extends('body')
@section('main')

    <section class="padLR1r">
        <!--头像-->
        <span class="headIco"><img src="<?php echo $headimgurl;?>" class="img-circle img-responsive center-block" alt=""></span>

        <!--填写内容-->
        <form method="POST" style="display: inline;">
        <input type="hidden" name="wcuser_id" value="{{$wcuser_id}}" >
        <!--姓名-->
        <div class="marTBd8r borderB">
            <p class="color2f font14">姓名</p>
            <input type="text" name="name" class="inputText marTBd8r" placeholder="姓名"/>
        </div>
        <!--联系方式-->
        <div class="marTBd8r borderB">
            <p class="color2f font14">联系方式（短号最好）</p>
            <input type="text" name="number" class="inputText marTBd8r" placeholder="联系方式"/>
        </div>
        <!--地址-->
        <div class="marTBd8r borderB">
            <p class="color2f font14">院区</p>
            <div class="marTBd8r font13 pr">
                <select class="selectDown" name="area">
                    <option value="0">东区</option>
                    <option value="1">西区</option>
                </select>
                <span class="downBtn"></span>
            </div>
        </div>
        <div class="marTBd8r borderB">
            <p class="color2f font14">宿舍号</p>
            <input type="text" name="address" class="inputText marTBd8r" placeholder="宿舍号"/>
        </div>


        <div class="marTBd8r borderB font13 clearfix">
            <p class="color2f font14">空闲时间</p>
            <div class="dateDiv pr">
                <div class="marTBd8r in_block font13 pr selectDate" style="width: 48%;">
                    <select class="selectDown" name="date">
                        <option value="1">星期一</option>
                        <option value="2">星期二</option>
                        <option value="3">星期三</option>
                        <option value="4">星期四</option>
                        <option value="5">星期五</option>
                    </select>
                    <span class="downBtn"></span>
                </div>
                <div class="marTBd8r in_block font13 pr selectDate" style="width: 48%;">
                    <select class="selectDown" name="hour">
                        <option value="6点后">6点后</option>
                        <option value="6点半后">6点半后</option>
                        <option value="7点后">7点后</option>
                        <option value="7点前">7点前</option>
                        <option value="8点后">8点后</option>
                        <option value="9点后">9点后</option>
                        <option value="整晚都可以">整晚都可以</option>
                    </select>
                    <span class="downBtn"></span>
                </div>
                
            </div>
        </div>
        <!--报修内容-->
        <div class="marTBd8r borderB">
            <p class="color2f font14">报修内容</p>
            <textarea rows="5" name="problem" class="multiInput marTBd8r font13" placeholder="请输入报修内容"></textarea>
        </div>
        <input type="submit" class="mainBtn marTBd8r font14 color2f">
        </form>
    </section>

@stop