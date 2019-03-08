<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link type="text/css" rel="stylesheet" href="/Public/web/css/lib.css?2">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1, minimum-scale=1.0"/>
	<title>矿机商城</title>
	<script src="/Public/web/js/jquery-1.8.3.min.js"></script>
	<link rel="stylesheet" href="/Public/web/css/weui.min.css"/>
	<link rel="stylesheet" href="/Public/web/css/jquery-weui.min.css">
	<link href="/Public/web/css/font-awesome.min.css" rel="stylesheet">
	<link href="/Public/web/fonts/iconfont.css" rel="stylesheet">
	<script src="/Public/web/js/layer.js"></script>

</head>
<body>
	<div style="position: fixed;z-index: -1000;width: 100%;height: 100vh;top:0;left: 0;"><img src="/Public/web/img/body_bg.jpg" style="width:100%;height: 100vh"></div>
	<header class="header">
		<span class="header_l" style="padding-left: 0"><a href="javascript:history.go(-1);"><img src="/Public/web/img/back.png" style="display: inline-block;height: 40px"></a></span>
		<span class="header_c">矿机商城</span>
		<span style="position: absolute;right: 40px;top: 0px;text-align:center;width:70px;white-space:nowrap; overflow:hidden; text-overflow:ellipsis;font-size: 12px; "><?php echo ($userData['ue_truename']); ?></span>
		<span class="header_r"><a href="/index.php/Home/Index/index/"><i class="fa fa-user"></i></a></span>
	</header>
	<div class="height40"></div>
	<!--顶部结束-->
<style>
      .hh_btn{
          float: right !important;
          padding: 0 !important;
          display: block;
          height: 20px;
          margin: 5px;
          width: 60px;
          background-color: #FF6B00;
          border: 0;
          border-radius: 5px;
          color: #FFF;
      }
      .zz_btn{
          height: 20px;
          width: 150px;
          margin:5px;
          background-color: #FF6B00;
          border: 0;
          border-radius: 5px;
          color: #fff;
      }
      .level_btn{
          height: 20px;
          width: 40px;
          margin-left:5px;
          background-color: #23D66B;
          border: 0;
          border-radius: 5px;
          color: #fff;
      }
    #content{
        height: 100px;
        width: 200px;
        border:2px solid #FF6B4B;
    }
</style>
	<!--会员中心开始-->
		
		<ul class="dd_list"；style="margin-bottom:80px;">
			<?php if(is_array($list)): foreach($list as $key=>$v): ?><li style="position:relative;">
				<img src= <?php echo ($v["imagepath"]); ?> />                                                                                                                                               

				<div style="width:60%;display:inline-block;">
					<p><b><?php echo ($v["name"]); ?></b>&nbsp;&nbsp;&nbsp;价格：<?php echo ($v["price"]); ?>GEC</p>
					<P>产量/小时：<?php echo ($v["fjed"]); ?></P>
					<P>运行周期：<?php echo ($v["yxzq"]); ?>小时</P>
				</div>
					 <a href="/index.php//Shop/index/jiaoyi?id=<?php echo ($v["id"]); ?>" style="color: #fff;display:block;position:absolute;right:10px;top:50%;margin-top: -15px;font-size: 14px;padding: 2px 10px;background-color: #02d2f5;border: 0 solid #fff;border-radius: 4px;">购买</a>
			</li>
				<!-- <button style="position:absolute;right:10px;top:50%;margin-top: -15px;font-size: 1em;padding: 5px;background-color: #E64340;border: 0px solid #fff;border-radius: 4px;">
					 <a style="color: #fff;margin-top: 0px" href="/Shop/index/jiaoyi?id=<?php echo ($v["id"]); ?>">购买</a>

					 <a style="color: #fff;margin-top: 0px" href="/Shop/index/jiaoyi?id=<?php echo ($v["id"]); ?>">购买</a> -->
				</button><?php endforeach; endif; ?>
			<!-- <li style="position:relative;">
				<img src="http://wx.qlogo.cn/mmopen/PiajxSqBRaEJ2rDtkqjr2MibVIEVp19deqRPRbrE6KicuzSkuYkyQic6pXZjB6PBE3A9Hzcia4iaDxVfTne6SU1plpeA/0" alt="tx" />
				<div style="width:60%;display:inline-block;">
					<p><b>矿车一</b></p>
					<p>&nbsp;&nbsp;&nbsp;&nbsp;说明</p>
				</div>
				<button style="position:absolute;right:10px;top:50%;margin-top: -15px;font-size: 1em;padding: 5px;background-color: #d25555;border: 0px solid #fff;border-radius: 4px;">
					<a style="color: #fff;margin-top: 0px" href="jiaoyi.html?empID=342442">购买</a></button>
			</li> -->
		<!-- 	<li style="position:relative;">
				<img src="http://wx.qlogo.cn/mmopen/PiajxSqBRaEJ2rDtkqjr2MibVIEVp19deqRPRbrE6KicuzSkuYkyQic6pXZjB6PBE3A9Hzcia4iaDxVfTne6SU1plpeA/0" alt="tx" />
				<div style="width:60%;display:inline-block;">
					<p><b>矿车一</b></p>
					<p>&nbsp;&nbsp;&nbsp;&nbsp;说明</p>
				</div>
				<button style="position:absolute;right:10px;top:50%;margin-top: -15px;font-size: 1em;padding: 5px;background-color:#E64340;border: 0px solid #fff;border-radius: 4px;">
					<a style="color: #fff;margin-top: 0px" href="jiaoyi.html?empID=342442">购买</a></button>
			</li> -->
			<!-- <li style="position:relative;">
				<img src="http://wx.qlogo.cn/mmopen/PiajxSqBRaEJ2rDtkqjr2MibVIEVp19deqRPRbrE6KicuzSkuYkyQic6pXZjB6PBE3A9Hzcia4iaDxVfTne6SU1plpeA/0" alt="tx" />
				<div style="width:60%;display:inline-block;">
					<p><b>矿车一</b></p>
					<p>&nbsp;&nbsp;&nbsp;&nbsp;说明</p>
				</div>
				<button style="position:absolute;right:10px;top:50%;margin-top: -15px;font-size: 1em;padding: 5px;background-color: #E64340;border: 0px solid #fff;border-radius: 4px;">
					<a style="color: #fff;margin-top: 0px" href="jiaoyi.html?empID=342442">购买</a></button>
			</li> -->
				</ul>
	<!--会员中心结束-->

	<div class="height55"></div>
<!--底部开始-->
<style>
	.footer ul li{
		width: 25%;
	}
</style>
			<div class="footer">
      <ul>
        <li><a href="/index.php/Shop/Index/" class="block"><i class="iconfont">&#xe620;</i>矿机商城</a></li> <li><a href="/index.php/Home/Info/mykuangche/" class="block"><i class="iconfont">&#xe612;</i>我的矿机</a></li> <li><a href="/index.php/Home/Info/Index/" class="block"><i class="iconfont">&#xe61e;</i>交易中心</a></li>       <li><a href="/index.php/Home/Index/Index/" class="block"><i class="iconfont">&#xe619;</i>个人中心</a></li>
    </ul>
</div>
	<!--底部结束-->
	<script src="/Public/web/js/jquery-weui.min.js"></script>
</body>
</html>