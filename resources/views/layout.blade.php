<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>中大南方PC微信报修平台</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/layout.css')}}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="http://apps.bdimg.com/libs/html5shiv/3.7/html5shiv.min.js"></script>
      <script src="http://apps.bdimg.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/echarts.min.js')}}"></script>
    <style type="text/css" media="screen">
    body { padding-bottom: 50px; }
    .footer{width: 100%;background-color: #BCBCBC;color: #fff;}
</style>
  </head>
  <body>
    <div>
        <nav class="navbar navbar-default container-fluid" role="navigation" style="font-family: KaiTi;font-size: 16px;">
            <div class="container">
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                  <a class="navbar-brand" href="#">微笑服务，满分PC</a>
                </div>
                <div class="collapse navbar-collapse" id="navbar">
                    <ul class="nav navbar-nav">
                        <li class="menu-item menu-item-type-custom menu-item-object-custom">
                            <a href="{{ URL('super/main/')}}" data-original-title title>
                                <span class="glyphicon glyphicon-home" aria-hidden="true"></span>
                                <span>首页</span>
                            </a>
                        </li>
                        <li class="menu-item menu-item-type-custom menu-item-object-custom">
                            <a href="{{ URL('super/tickets/')}}" data-original-title title>
                                <span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>
                                <span >订单</span>
                            </a>
                        </li>
                        <li class="menu-item menu-item-type-custom menu-item-object-custom">
                            <a href="" data-toggle="dropdown" class="dropdown-toggle" data-original-title title>
                                <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                <span >PC队员</span><span class="caret"></span>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuDivider">
                                    <li>
                                        <a href="{{ URL('super/pcer/')}}" data-original-title title>
                                            <span class="glyphicon glyphicon-plane" aria-hidden="true"></span>
                                            <span >PC仔</span>
                                        </a>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li>
                                        <a href="{{ URL('super/pcset/')}}" data-original-title title>
                                            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                                            <span >设置</span>
                                        </a>
                                    </li>
                                   
                                </ul>
                            </a>
                        </li>
                        <li class="menu-item menu-item-type-custom menu-item-object-custom dropdown">
                            <a href="" class="dropdown-toggle" data-toggle="dropdown" data-original-title title>
                                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                                <span >公众号设置</span><span class="caret"></span>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuDivider">
                                    <li>
                                        <a href="#" data-original-title title>
                                            <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
                                            <span >自动回复设置</span>
                                        </a>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li>
                                        <a href="#" data-original-title title>
                                            <span class="glyphicon glyphicon-book" aria-hidden="true"></span>
                                            <span >自定义菜单设置</span>
                                        </a>
                                    </li>
                                   
                                </ul>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right hidden-sm">
                        <li>
                            <a href="{{ URL('super/logout/')}}" data-original-title title>
                                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                                <span >退出</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

<div class="container" role="main">
    {{-- error --}}
        @if (Session::has('message'))
        <div class="alert alert-danger" role="alert">
        <strong>{{ Session::get('message') }}</strong>
        </div>
        @endif

    @yield('main')
<div class="row-fluid">
    <div class="span12 navbar-fixed-bottom footer" >
      <p class="text-center" style="margin-top: 10px;">
        © 2016 中大南方PC服务队 | Powered by JokerLinly
      </p>
    </div>
  </div>
</div>
  </body>
</html>