<!doctype html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>只有管理员大大才能登陆</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/slim-min.css')}}" media="screen">
    <link rel="stylesheet" href="{{asset('css/signin.css')}}">
    <script src="{{asset('js/ie-emulation-modes-warning.js')}}"></script>
    <script src="{{asset('js/ie10-viewport-bug-workaround.js')}}"></script>
    <style type="text/css">
      .flash{
        color: red;
      }
    </style>
  </head>

  <body>

    <div class="container">

      <div class="form-signin">
      {!! Form::open(['action' => 'Super\HomeController@postSuperLogin', 'style'=>'display: inline;']) !!}
        <h2 class="form-signin-heading">管理员大大请登陆</h2>
        <div class="container form-signin">
            @if (Session::has('message'))
              <div class="flash">
                <p>{{ Session::get('message') }}</p>
              </div>
            @endif
        </div>
        <input type="text" id="user_name" name="user_name" class="form-control" placeholder="用户名" required autofocus>
        <input type="password" id="password" name="password" class="form-control" placeholder="密码" required>
 

        <button class="btn btn-lg btn-primary btn-block" type="submit">登录</button>
    {!! Form::close() !!}
</div>


    </div> <!-- /container -->

  </body>
</html>
