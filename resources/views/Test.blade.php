<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <link rel="stylesheet" href="">
</head>
<body>
    <div class="menu">
    <ul>
        {!! HTML::menu_active('/','Home') !!}
        {!! HTML::menu_active('page/about','About') !!}
        {!! HTML::menu_active('page/contacts','Contacts') !!}
        {!! HTML::menu_active('page/service','Service') !!}
    </ul>

</div>
</body>
</html>