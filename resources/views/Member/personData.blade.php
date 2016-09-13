@extends('Member.layout')
@section('main')
<p style="font-size: 20px;" class="text-center">PC仔个人信息修改</p>

<section class="padLR1r">
        <!--姓名-->
        <form action="nickname" method="POST" style="display: inline;">
         <input type="hidden" name="id" value="{{$pcer->id}}" >
        <div class="marTBd8r borderB">
            <p class="color2f font14">昵称</p><span>
            <button type="submit" class="btn btn-success" style="float:right;margin-top:3%;width: 20%;">修改</button>
            </span>
            <input id="disabledInput" type="text" name="nickname" required="required" class="inputText marTBd8r " style="width:50%;" placeholder="@if($pcer->nickname){{$pcer->nickname}}@else 例如：PC骏 @endif" value="{{Input::old('nickname')}}"/>
            
        </div>
            
        </form>
        <!--年级-->
        <div class="marTBd8r borderB">
            <p class="color2f font14">夜晚空闲时间</p>
            @if($pcer->idle)
                    @foreach ($pcer->idle as $idle)

                        @if($idle->date==1)
                        <form action="delidle" method="POST" style="display: inline;">
                        <input name="_method" type="hidden" value="DELETE">
                        <input type="hidden" name="id" value="{{$idle->id}}" >
                        <p style="font-size: 23px;">星期一<button type="submit" class="btn btn-danger" href="#" style="float:right;width: 20%;">删除</button></p><br>
                        </form>  
                        @elseif($idle->date==2) 
                        <form action="delidle" method="POST" style="display: inline;">
                        <input name="_method" type="hidden" value="DELETE">
                        <input type="hidden" name="id" value="{{$idle->id}}" >
                        <p style="font-size: 23px;">星期二<button type="submit" class="btn btn-danger" href="#" style="float:right;width: 20%;">删除</button></p><br>
                        </form>
                        @elseif($idle->date==3) 
                        <form action="delidle" method="POST" style="display: inline;">
                        <input name="_method" type="hidden" value="DELETE">
                        <input type="hidden" name="id" value="{{$idle->id}}" >
                        <p style="font-size: 23px;">星期三<button type="submit" class="btn btn-danger" href="#" style="float:right;width: 20%;">删除</button></p><br>
                        </form>
                        @elseif($idle->date==4) 
                        <form action="delidle" method="POST" style="display: inline;">
                        <input name="_method" type="hidden" value="DELETE">
                        <input type="hidden" name="id" value="{{$idle->id}}" >
                        <p style="font-size: 23px;">星期四<button type="submit" class="btn btn-danger" href="#" style="float:right;width: 20%;">删除</button></p><br>
                        </form>
                        @elseif($idle->date==5) 
                        <form action="delidle" method="POST" style="display: inline;">
                        <input name="_method" type="hidden" value="DELETE">
                        <input type="hidden" name="id" value="{{$idle->id}}" >
                        <p style="font-size: 23px;">星期五<button type="submit" class="btn btn-danger" href="#" style="float:right;width: 20%;">删除</button></p><br>
                        </form>
                        @endif
                    @endforeach
                    @endif
        </div>

        <div class="marTBd8r borderB font13 clearfix">
        <p class="color2f font14">增加空闲时间</p>
        <form action="addidle" method="POST" style="display: inline;">
        <input type="hidden" name="id" value="{{$pcer->id}}" >
        <div class="dateDiv pr">
            <div class="marTBd8r in_block font13 pr selectDate" style="width: 50%;">
                <select class="selectDown" name="date[]">
                    <option value="1">星期一</option>
                    <option value="2">星期二</option>
                    <option value="3">星期三</option>
                    <option value="4">星期四</option>
                    <option value="5">星期五</option>
                </select>

                <span class="downBtn"></span>
                
            </div>
        <span>
            <button type="submit" class="btn btn-success" style="float:right;margin-top:3%;width: 20%;">增加</button>
        </span>
           
        </div>
    </div>

    </form>

</section>

@stop