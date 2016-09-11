<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>中大南方PC微信报修平台</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/reset.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/global.css')}}">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <style>
        .prop_box{
            width:80%;
            background: #eee;
            border-radius: 15px;
            position: absolute;
            left: 10%;
            top: 30%;
        }
        .prop_box .title{
            padding-left: 15px;
            line-height:4rem;
            font-size: 1.5rem;
            border-bottom: 1px dashed #dedede;
        }
        .prop_box .content{
            padding: 1rem;
            font-size: 1.4rem;
            min-height: 50px;
            text-align: center;
        }  
        .prop_box .btn_box{
            height: 5rem;
            line-height: 3.2rem;
            border-top: 1px solid #e2e2e2;
            border-radius: 0 0 15px 15px;
            display: flex;
        }
        .prop_box .btn_box a{
            display: block;
            color: #333;
            position: relative;
            box-sizing: border-box;
            flex: 1;
            line-height: 55px;
            font-size: 3rem;
            text-align: center;
        }
        .prop_box .btn_box a:nth-child(2){
            borderLeft:1px solid #e2e2e2;
        }
    </style> 
  </head>
  <body>
  <div>
    <div class="prop_box">
        <div class="title">系统提示</div>
        <div class="content"></div>
        <div class="btn_box">
            <a href="javascript:;" onclick="jQuery('.prop_box').hide()" class="close" style="color: #337ab7">确认</a>
        </div>
    </div>
  </div>
@if (Session::has('message'))
  {{ Session::get('message') }}
@endif
    
    @yield('main')
  </body>
</html>