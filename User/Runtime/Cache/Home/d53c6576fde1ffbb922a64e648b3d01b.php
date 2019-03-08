<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link type="text/css" rel="stylesheet" href="/Public/web/css/lib.css?2">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1, minimum-scale=1.0"/>
	<meta content="telephone=no" name="format-detection">
	<title>个人中心</title>
    <script src="/Public/web/js/jquery-1.8.3.min.js"></script>
    <link rel="stylesheet" href="/Public/web/css/weui.min.css"/>
	<link rel="stylesheet" href="/Public/web/css/jquery-weui.min.css">
	<link href="/Public/web/css/font-awesome.min.css" rel="stylesheet">
	<link href="/Public/web/fonts/iconfont.css" rel="stylesheet">
	<script src="/Public/web/js/layer.js"></script>
</head>
<!--背景图片-->
<div style="position: fixed;z-index: -1000;width: 100%;height: 100vh;top:0;left: 0;"><img src="/Public/web/img/body_bg.jpg" style="width:100%;height: 100vh"></div>
<!--背景图片-->
<body>
	<div style="position: fixed;z-index: -1000;width: 100%;height: 100vh;top:0;left: 0;"><img src="/Public/web/img/body_bg.jpg" style="width:100%;height: 100vh"></div>
	<div class="header" style="border-bottom: 1px solid rgb(28, 141, 199);">
		<span class="header_l" style="padding-left: 0"><a href="javascript:history.go(-1);"><img src="/Public/web/img/back.png" style="display: inline-block;height: 40px"></a></span>
		<span class="header_c">个人中心</span>
		<span style="position: absolute;right: 10%;top: 0px;text-align:center;width:20%;white-space:nowrap; overflow:hidden; text-overflow:ellipsis;font-size: 12px; "><?php echo ($nickname); ?></span>
		<span class="header_r"><a href="javascript:void(0)"><i class="fa fa-user"></i></a></span>
	</div>
	<div class="height40"></div>
	<!--顶部结束-->
<style>
	.user-tab{
		background: url("/Public/web/img/tab_bg.png") no-repeat center center;
		background-size: contain;
		text-align: center;
		width: 70px;
		height: 70px;
		display: flex;
		align-items: center;
		justify-content: center;
	}
	.user-tab img{
		display: inline-block;
		width: 30px;
		height: 30px;
	}
	.weui_grid_label{
		color: #fff;
	}
	.weui_grid:before,.weui_grid:after,.weui_grids:before,.weui_grids:after{
		border:0;
	}
	.user_sy li{
		width: 33.3%;
	}
</style>
	<!--<div style="background-color: #06C1AE ;padding: 20px 0px;  width: 95%;overflow: hidden;color: #FFFFFF;font-size:1.5em;padding-right:5%">-->
	<div style="margin: 20px 5% 0 5%;width: 90%;overflow: hidden;color: #FFFFFF;font-size:1.5em;background:url('/Public/web/img/geren_bg.png') no-repeat;background-size:100% auto;padding: 20px 0;">
			<a href="<?php echo U('/index.php/Home/Login/logout');?>" style="position:absolute;top: 85px;left: 30px;width: 70px;height: 28px;line-height: 28px;text-align: center;color: #fff;font-size: 12px;border: 1px solid #fff;border-radius: 7px;">安全退出</a>
			<div style="width: 95%;float: right;text-align: center;overflow: hidden;text-align:right;padding-right: 15px"><p style="font-size:12px">可用GEC:</p><p style="overflow: hidden;text-overflow: ellipsis;white-space: nowrap;font-size:30px"><?php echo ($kymoney); ?></p></div>
			<div style="width:95%;float: right;text-align: center;overflow: hidden;text-align:right;padding-right: 15px"><p style="float:right"><span style="font-size:12px;display:inline-block;">冻结GEC:</span><span style="overflow: hidden;text-overflow: ellipsis;white-space: nowrap;float:right;font-size:1em"><?php echo ($djmoney); ?></span></p></div>
	</div>
<div class="weui_grids" style="background-color: transparent">
	<a href="/index.php/Home/Info/mykuangche/" class="weui_grid js_grid" data-id="toast">
		<div class="weui_grid_icon user-tab">
			<img src="/Public/web/img/t1.png">
		</div>
		<p class="weui_grid_label" style="margin-top: 12px">我的矿机</p>
	</a>
	<a href="/index.php/Home/Info/myjiaoyi/" class="weui_grid js_grid" data-id="toast">
		<div class="weui_grid_icon user-tab">
			<img src="/Public/web/img/t2.png">
		</div>
		<p class="weui_grid_label" style="margin-top: 12px">我的交易</p>
	</a>
	<a href="/index.php/Home/Info/kuangcheshouyi/" class="weui_grid js_grid" data-id="toast">
	<div class="weui_grid_icon user-tab">
		<!--<i class="iconfont" style="color: #7E4BE5;display: block;width: 16px;margin:0 auto;font-size: 2em;margin-left: -2px;">&#xe628;</i>-->
		<img src="/Public/web/img/t3.png">
	</div>
	<p class="weui_grid_label" style="margin-top: 12px">矿机收益</p>
</a>
	<a href="/index.php/Home/Info/tgsy/" class="weui_grid js_grid" data-id="toast">
		<div class="weui_grid_icon user-tab">
			<img src="/Public/web/img/t4.png">
		</div>
		<p class="weui_grid_label" style="margin-top: 12px">公会收益</p>
	</a>
	<a href="/index.php/Home/Myuser/index/" class="weui_grid js_grid" data-id="toast">
		<div class="weui_grid_icon user-tab">
			<img src="/Public/web/img/t5.png">
		</div>
		<p class="weui_grid_label" style="margin-top: 12px">矿工公会</p>
	</a>
	<!-- <a href="/index.php/Home/info/qiugoulkc/" class="weui_grid js_grid" data-id="toast">
		<div class="weui_grid_icon">
			<i class="iconfont" style="color: #e64340;display: block;width: 16px;margin:0 auto;font-size: 2em;margin-left: -2px;">&#xe615;</i>
		</div>
		<p class="weui_grid_label" style="margin-top: 12px">求购GEC</p>
	</a>



	<a href="/index.php/Home/info/shouchu/" class="weui_grid js_grid" data-id="toast">
		<div class="weui_grid_icon">
			<i class="iconfont" style="color: #e64340;display: block;width: 16px;margin:0 auto;font-size: 2em;margin-left: -2px;">&#xe63a;</i>
		</div>
		<p class="weui_grid_label" style="margin-top: 12px">出售GEC</p>
	</a> -->



	<a href="/index.php/Home/Info/tuiguangma/" class="weui_grid js_grid" data-id="toast">
		<div class="weui_grid_icon user-tab">
			<img src="/Public/web/img/t6.png">
		</div>
		<p class="weui_grid_label" style="margin-top: 12px">公会招募
</p>
	</a>
	<a href="/index.php/Home/Info/myziliao/" class="weui_grid js_grid" data-id="toast">
		<div class="weui_grid_icon user-tab">
			<img src="/Public/web/img/t7.png">
		</div>
		<p class="weui_grid_label" style="margin-top: 12px">个人资料</p>
	</a>
	<a href="/index.php/Home/Info/mimaguanli/" class="weui_grid js_grid" data-id="toast">
		<div class="weui_grid_icon user-tab">
			<img src="/Public/web/img/t8.png">
		</div>
		<p class="weui_grid_label" style="margin-top: 12px">密码管理</p>
	</a>
	<a href="/index.php/Home/Info/lianxius/" class="weui_grid js_grid" data-id="toast">
		<div class="weui_grid_icon user-tab">
			<img src="/Public/web/img/t9.png">
		</div>
		<p class="weui_grid_label" style="margin-top: 12px">联系我们</p>
	</a>
	<a href="/index.php/Home/Index/help/" class="weui_grid js_grid" data-id="toast">
			<div class="weui_grid_icon user-tab">
				<img src="/Public/web/img/t10.png">
			</div>
			<p class="weui_grid_label" style="margin-top: 12px">帮助中心</p>
	</a>
	<a href="/index.php/Home/Index/help1/" class="weui_grid js_grid" data-id="toast">
		<div class="weui_grid_icon user-tab">
			<img src="/Public/web/img/t11.png">
		</div>
		<p class="weui_grid_label" style="margin-top: 12px">公告中心</p>
	</a>
	<a href="/Index.php/Home/info/change/" class="weui_grid js_grid" data-id="toast">
		<div class="weui_grid_icon user-tab">
			<img src="/Public/web/img/t12.png">
		</div>
		<p class="weui_grid_label" style="margin-top: 12px">电子币</p>
	</a>
	<a href="<?php echo HTTP_URL; ?>" class="weui_grid js_grid" data-id="toast">
		<div class="weui_grid_icon user-tab">
			<img src="/Public/web/img/t12.png">
		</div>
		<p class="weui_grid_label" style="margin-top: 12px">返回微圈</p>
	</a>
</div>
	



    	<div class="height55"></div>

<!--底部开始-->
<style>
	.footer ul li{
		width: 25%;
	}
</style>
	<div class="footer">
    <ul>
        
        <li><a href="/index.php/Shop/Index/" class="block"><i class="iconfont">&#xe620;</i>矿机商城</a></li>
		<li><a href="/index.php/Home/Info/mykuangche/" class="block"><i class="iconfont">&#xe612;</i>我的矿机</a></li>
		<li><a href="/index.php/Home/Info/Index/" class="block"><i class="iconfont">&#xe61e;</i>交易中心</a></li>
        <li><a href="/index.php/Home/Index/Index/" class="block"><i class="iconfont">&#xe619;</i>个人中心</a></li>
    </ul>
</div>
	<!--底部结束-->
	<script src="/Public/web/js/jquery-weui.min.js"></script>
		

</body>
</html>