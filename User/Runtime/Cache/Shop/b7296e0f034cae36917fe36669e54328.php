<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link type="text/css" rel="stylesheet" href="/Public/web/css/lib.css?2">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1, minimum-scale=1.0"/>
    <title>立即购买</title>
    <script src="/Public/web/js/jquery-1.8.3.min.js"></script>
    <link rel="stylesheet" href="/Public/web/css/weui.min.css"/>
    <link rel="stylesheet" href="/Public/web/css/jquery-weui.min.css">
    <script src="/Public/web/js/layer.js"></script>
    <link href="/Public/web/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
<div style="position: fixed;z-index: -1000;width: 100%;height: 100vh;top:0;left: 0;"><img src="/Public/web/img/body_bg.jpg" style="width:100%;height: 100vh"></div>
<header class="header">
    <span class="header_l" style="padding-left: 0"><a href="javascript:history.go(-1);"><img src="/Public/web/img/back.png" style="display: inline-block;height: 40px"></a></span>
    <span class="header_c">购买</span>
	<span style="position: absolute;right: 40px;top: 0px;text-align:center;width:70px;white-space:nowrap; overflow:hidden; text-overflow:ellipsis;font-size: 12px; "><?php echo ($userData['ue_truename']); ?></span>
    <span class="header_r"><a href="/index.php/Home/Index/index"><i class="fa fa-user"></i></a></span>
</header>
<div class="height40"></div>
<!--顶部结束-->
<div style="width:100%;">
	<h1 class="goods_title" style="text-align:center;font-size:1.2em;font-weight: bold;width:100%;padding:10px 0;background: transparent;color: #fff"><?php echo ($name); ?></h1>
	<div class="tao hu_title"style="min-height:250px;width:100%;margin-top:10px;overflow:hidden;background: transparent;border: 0">
	<span>商品详情：</span>
	<p style="width:90%;margin-left:5%">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo ($content); ?></p>

	</div>

	<div style="padding:10px 0;margin:20px 0;background:transparent;width:100%">
		<!--<input class="weui_input" type="text" disabled="true" value= style="width:100%;color: #000;text-align: center"/>-->
        <span id="money" style="text-align: left;color: #02d2f5;font-size: 25px;padding-left: 15px"><?php echo ($price); ?> <small style="font-size: 14px;color: rgba(255,255,255,.7)">GEC</small></span>
	</div>
	<div class="goods_gm"style="width: 90%;margin-left: 5%;border-radius: 5px">
		<a id="buy" href="/index.php//Shop/index/confirmproject?id=<?php echo ($id); ?>" class="weui_btn weui_btn_warn"style="background-color:#02d2f5;color: #fff">立即购买</a>
	</div>
</div>
<script src="/Public/web/js/jquery-weui.min.js"></script>
<script>
    function pay(){
        $.ajax({
        type:'post',
        url:'/tixian.html',
        data:"money="+$("#buy").val(),
        dataType:'json',
        success:function(msg){
        alert(msg.msg);
            console.log('money');
        location.reload();
        }
     });
    }
</script>
</body>
</html>