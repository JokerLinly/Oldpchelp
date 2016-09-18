<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<title>无标题文档</title> 
<style> 
body{margin:0px;padding:0px} 
#div1{background:#F00;color: #FFF; display:none;position:absolute;} 
#div2{background:#333333;color: #FFF;width:400px;display:none; position:absolute;} 
</style> 
<Script type="text/javascript" src="http://jt.875.cn/js/jquery.js"></script> 
//浏览器窗口垂直居中 
<!-- 
<Script type="text/javascript"> 
function popup(popupName){ 
var _scrollHeight = $(document).scrollTop(),//获取当前窗口距离页面顶部高度 
_windowHeight = $(window).height(),//获取当前窗口高度 
_windowWidth = $(window).width(),//获取当前窗口宽度 
_popupHeight = popupName.height(),//获取弹出层高度 
_popupWeight = popupName.width();//获取弹出层宽度 
_posiTop = (_windowHeight - _popupHeight)/2 + _scrollHeight; 
_posiLeft = (_windowWidth - _popupWeight)/2; 
popupName.css({"left": _posiLeft + "px","top":_posiTop + "px","display":"block"});//设置position 
} 
$(function(){ 
$(".btn1").click(function(){ 
popup($("#div1")); 
}); 
$(".btn2").click(function(){ 
popup($("#div2")); 
}); 
}); 
</script> 
--> 
//当前窗口垂直居中 
<Script type="text/javascript"> 
function popup(popupName){ 
_windowHeight = $(".wrap").height(),//获取当前窗口高度 
_windowWidth = $(".wrap").width(),//获取当前窗口宽度 
_popupHeight = popupName.height(),//获取弹出层高度 
_popupWeight = popupName.width();//获取弹出层宽度 
_posiTop = (_windowHeight - _popupHeight)/2; 
_posiLeft = (_windowWidth - _popupWeight)/2; 
popupName.css({"left": _posiLeft + "px","top":_posiTop + "px","display":"block"});//设置position 
} 
$(function(){ 
$(".btn1").click(function(){ 
popup($("#div1")); 
}); 
$(".btn2").click(function(){ 
popup($("#div2")); 
}); 
}); 
</script> 
</head> 
<body > 
<div > 
<input class="btn1" type="button" value="1"/></div> 
<input class="btn2" type="button" value="2"/></div> 
<div style="width:500px; background:#ccc; position:relative; top:100px; left:200px;" class="wrap"> 
我是当前窗口啊我是当前窗口啊我是当前窗口啊我是当前窗口啊我是当前窗口啊我是当前窗口啊<br>我是当前窗口啊我是当前窗口啊我是当前窗口啊<br>我是当前窗口啊我是当前窗口啊我是当前窗口啊<br>我是当前窗口啊我是当前窗口啊我是当前窗口啊<br>我是当前窗口啊我是当前窗口啊我是当前窗口啊 
<br>我是当前窗口啊我是当前窗口啊我是当前窗口啊我是当前窗口啊 
<div id="div1">我是弹出窗口1111啊<br>我是弹出窗口1111啊<br>我是弹出窗口1111啊<br>我是弹出窗口1111啊<br>我是弹出窗口1111啊<br>我是弹出窗口1111啊<br>我是弹出窗口1111啊</div> 
<div id="div2">我是弹出窗口2222啊<br>我是弹出窗口2222啊<br>我是弹出窗口2222啊<br>我是弹出窗口2222啊<br>我是弹出窗口2222啊</div> 
</div> 
</body> 
</html> 