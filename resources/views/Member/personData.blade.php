@extends('Member.layout')
@section('main')
<p  style="font-size: 2rem;font-family: 幼圆" class="text-center">PC仔个人信息修改</p>

<section class="padLR1r">

        <!--年级-->
        <div class="marTBd8r borderB">
            <p class="color2f font14">夜晚值班时间</p>
            @if(count($pcer['idle']) > 0)
                @foreach ($pcer['idle'] as $idle)
                    {!! Form::open(['action' => 'Member\HomeController@delIdle', 'style'=>'display: inline;']) !!}
                    <input type="hidden" name="idle_id" value="{{$idle['id']}}" >
                    <p style="font-size: 23px;">{{$idle['chain_date']}}<button type="submit" class="btn btn-danger" href="#" style="float:right;width: 20%;">删除</button></p><br>
                    {!! Form::close() !!}
                @endforeach
            @else 暂时没有设置空闲时间
            @endif
        </div>

        @if(count($pcer['idle']) < 5)
        <div class="marTBd8r borderB font13 clearfix">
            <p class="color2f font14">增加空闲时间</p>
            {!! Form::open(['action' => 'Member\HomeController@addIdle', 'style'=>'display: inline;']) !!}
            <div class="dateDiv pr">
                <div class="marTBd8r in_block font13 pr selectDate" style="width: 50%;">
                    <select class="selectDown" name="date">
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
            {!! Form::close() !!}
        </div>
        @endif
    </div>

    </form>

</section>

@stop