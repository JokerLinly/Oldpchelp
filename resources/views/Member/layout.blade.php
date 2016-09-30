<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PC仔营地</title>
    <meta name="keywords" content="pchelp">
    <meta name="description" content="中山大学南方学院PC微信报修平台之PC仔营地">

    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/slim-min.css')}}" media="screen">
    <link rel="stylesheet" href="{{asset('css/ionicons.css')}}" media="screen">
    <link rel="stylesheet" type="text/css" href="{{asset('css/reset.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/global.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/menu.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/swiper.min.css')}}">
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="//cdn.bootcss.com/html5shiv/r29/html5.min.js"></script>
      <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>
<body>
    @if (Session::has('message'))
        <div class="prop_box">
            <div class="title">系统提示</div>
            <div class="content">{{ Session::get('message') }}</div>
            <div class="btn_box">
                <a href="javascript:;" onclick="jQuery('.prop_box').hide()" class="close" style="color: #337ab7">确认</a>
            </div>
        </div>
    @endif
    @yield('main')

    <ul class="foot-menu">
        <li class="menu-item">
            <a href="{{action('Member\HomeController@index')}}" class=""><span class="ion-home"></span><span style="font-size: 1.5rem;font-family: 幼圆">首页</span></a>
        </li>
        <li class="menu-item">
            <a href="javascript:;" class=""><span class="ion-medkit"></span><span style="font-size: 1.5rem;font-family: 幼圆">我的订单</span></a>
            <ul class="sub-menu">
                <li><a href="{{action('Member\TicketController@pcerTicketList')}}"><span class="ion-flag">修鸡修鸡</span></a></li>
                <li><a href="{{action('Member\HomeController@showTickets')}}"><span class="ion-paper-airplane">我报修的</span></a></li>
                <li><a href="{{action('Member\TicketController@pcerFinishTicketList')}}"><span class="ion-checkmark-circled">修完的</span></a></li>
            </ul>
        </li>
        <li class="menu-item">
            <a href="javascript:;" class="on"><span class="ion-ios-paw"></span><span style="font-size: 1.5rem;font-family: 幼圆">设置</span></a>
            <ul class="sub-menu">
                <li><a href="{{action('Member\HomeController@getPerson')}}"><span class="ion-person">个人资料</span></a></li>
                <li><a href="{{action('Member\HomeController@getIdle')}}"><span class="ion-ios-clock">值班时间</span></a></li>
            </ul>
        </li>
    </ul>

</body>
<script>
    $('.menu-item').click(function(){
        var $subMenu = $(this).children('.sub-menu');
        if($subMenu.is(':hidden')){
            $('.foot-menu').after('<div class="transMask"></div>');
            $subMenu.slideDown(200);
            $(this).siblings().find('.sub-menu').slideUp(200);
        }else{
            $subMenu.slideUp(200);
            $('.transMask').remove();
        }
        $('.transMask').on('click',function(){
            $(this).remove();
            $('.sub-menu').slideUp(200);
        });
    });
</script>
</html>