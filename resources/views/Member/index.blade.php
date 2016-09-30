@extends('Member.layout')
@section('main')
<section class="pr">
        <!-- 轮播 -->
        <div class="swiper-container index-swiper-wrap">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><a href=""><img src="{{asset('img/test3.jpg')}}" alt="" style="width:100%;height:100%"></a></div>
                <div class="swiper-slide"><a href=""><img src="{{asset('img/test2.jpg')}}" alt="" style="width:100%;height:100%"></a></div>
                <div class="swiper-slide"><a href=""><img src="{{asset('img/test1.png')}}" alt="" style="width:100%;height:100%"></a></div>
            </div>
            <!-- Add Pagination -->
            <div class="swiper-pagination"></div>
        </div>
        <!-- 日期展示 -->
        <div class="clearfix date-warp">
            <i class="fl pc-icon"></i>
            <div class="fl">
                <p class="font15 color-69">成为PC仔已经</p>
                <p class="color-cc">从2012-1-10至今</p>
            </div>
            <div class="fr">
                <span class="fz-2d5 color-blue fw-bold">1364</span>
                <span class="color-69">天</span>
            </div>
        </div>
        <ul class="date-line-wrap">
            <li class="clearfix">
                <p class="data-line-box clearfix fr"><span class="fl date-line-left">帮别人修好的机子已经有</span><span class="fl date-line-right"><i>1364</i><i>台</i></span></p>
                <i class="circle"></i>
            </li>
            <li class="clearfix">
                <p class="data-line-box clearfix fr"><span class="fl date-line-left">获得好评已经有</span><span class="fl date-line-right"><i>1364</i><i>个</i></span></p>
                <i class="circle"></i>
            </li>
            <li class="clearfix">
                <p class="data-line-box clearfix fr"><span class="fl date-line-left">距离获得第一个好评已经</span><span class="fl date-line-right"><i>1364</i><i>天</i></span></p>
                <i class="circle"></i>
            </li>
        </ul>
    </section>

    <script src="{{asset('js/swiper.min.js')}}"></script>
    <script>
        //轮播
        var swiper = new Swiper('.swiper-container', {
            pagination: '.swiper-pagination',
            paginationClickable: true
        });
    </script>
@stop