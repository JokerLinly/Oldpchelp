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
    <!-- <div data-role="widget" data-widget="nav4" class="nav4">
      <nav>
        <div id="nav4_ul" class="nav_4">
          <ul class="box">
                <li>
                    <a href="" class=""><span class="glyphicon glyphicon-home">首页</span></a>
                </li>
                <li>
                    <a href="javascript:;" class=""><span class="glyphicon glyphicon-home">我的订单</span></a>
                    <dl>
                        <dd>
                            <a href="{{action('Member\TicketController@pcerTicketList')}}"><span>修鸡修鸡</span></a>
                        </dd>
                        <dd>
                            <a href="{{action('Ticket\HomeController@showTickets')}}"><span>我报修的</span></a>
                        </dd>
                        <dd>
                            <a href="{{action('Member\TicketController@pcerFinishTicketList')}}"><span>修完的</span></a>
                        </dd>
                    </dl>
                </li>
                <li>
                    <a href="javascript:;" class="on"><span class="glyphicon glyphicon-cog">设置</span></a>
                    <dl>
                        <dd>
                            <a href="#"><span>值班时间</span></a>
                        </dd>
                        <dd>
                            <a href="#"><span>个人资料</span></a>
                        </dd>
                    </dl>
                </li>
          </ul>
        </div>
      </nav>
    <div id="nav4_masklayer" class="masklayer_div on"> </div> -->

    <ul class="foot-menu">
        <li class="menu-item">
            <a href="{{action('Member\HomeController@index')}}" class=""><span class="glyphicon glyphicon-home"></span><span style="font-size: 1.5rem;font-family: 幼圆">首页</span></a>
        </li>
        <li class="menu-item">
            <a href="javascript:;" class=""><span class="glyphicon glyphicon-fire"></span><span style="font-size: 1.5rem;font-family: 幼圆">我的订单</span></a>
            <ul class="sub-menu">
                <li><a href="{{action('Member\TicketController@pcerTicketList')}}"><span>修鸡修鸡</span></a></li>
                <li><a href="{{action('Ticket\HomeController@showTickets')}}"><span>我报修的</span></a></li>
                <li><a href="{{action('Member\TicketController@pcerFinishTicketList')}}"><span>修完的</span></a></li>
            </ul>
        </li>
        <li class="menu-item">
            <a href="javascript:;" class="on"><span class="glyphicon glyphicon-cog"></span><span style="font-size: 1.5rem;font-family: 幼圆">设置</span></a>
            <ul class="sub-menu">
                <li><a href="{{action('Member\HomeController@getPerson')}}">个人资料</a></li>
                <li><a href="{{action('Member\HomeController@getIdle')}}">值班时间</a></li>
            </ul>
        </li>
    </ul>

</body>
<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
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