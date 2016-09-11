<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PC仔营地</title>
    <meta name="keywords" content="pchelp">
    <meta name="description" content="中山大学南方学院PC微信报修平台之PC仔营地">
    <link rel="stylesheet" type="text/css" href="{{asset('css/reset.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/global.css')}}">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="//cdn.bootcss.com/html5shiv/r29/html5.min.js"></script>
      <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css" media="screen">
        body { padding-bottom: 50px; }
        .footer{width: 100%;background-color: #333;color: #fff;}
    </style>
  </head>
<body>
    @if (Session::has('message'))
      <div>
        <div class="prop_box">
            <div class="title">系统提示</div>
            <div class="content">{{ Session::get('message') }}</div>
            <div class="btn_box">
                <a href="javascript:;" onclick="jQuery('.prop_box').hide()" class="close" style="color: #337ab7">确认</a>
            </div>
        </div>
      </div>
    @endif
    @yield('main')

<div class="row-fluid">
    <div class="span12 navbar-fixed-bottom footer" >
      <p class="text-center" >
        © 2016 中大南方PC服务队 | Powered by JokerLinly
      </p>
    </div>
</div>
</body>
<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
</html>