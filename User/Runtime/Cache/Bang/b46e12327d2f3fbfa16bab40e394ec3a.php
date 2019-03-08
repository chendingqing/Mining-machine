<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1, minimum-scale=1.0"/>
    <meta content="telephone=no" name="format-detection">
    <title>矿机商城</title>
    <link href="/Public/bang/css/mui.min.css" rel="stylesheet"/>
    <link href="/Public/bang/css/kj_resert.css" rel="stylesheet" />
    <link href="/Public/bang/css/kj_public.css" rel="stylesheet" />
    <link href="/Public/bang/css/kj_geren.css" rel="stylesheet" />
    <style>
        .mui-table-view-cell a{
            position: relative;
        }
        .mui-table-view-cell .weizhi{
            position: absolute;
            top: 42%;
            right: 6%;
            width: 7px!important;
        }
    </style>
</head>
<body>
<header class=" mui-navbar-inner mui-bar mui-bar-nav" style="background-image: url(/Public/bang/images/top.png);">
    <h1 class="mui-title" style="color:#FFF;">个人中心</h1>
    <a href="<?php echo U('index');?>" class="left-icon">
        <img src="/Public/bang/images/head_back_icon.png"/>
    </a>
</header>
<div class="mui-content">
	<div class="geren_card">
        <div class="geren_card_bg">
            <p class="geren_card_name"><span>用户名：</span><span><?php echo ($user['ue_truename']); ?></span></p>
            <span class="geren_card_GEC">可用AD</span>
            <div class="geren_card_GEC_num"><?php echo ($user['ue_money']); ?></div>
            <p class="geren_card_GEC_no"><span>冻结AD：</span><span><?php echo ($user['djmoney']); ?></span></p>
        </div>
	</div>
    <ul class="mui-table-view geren_table_view">
        <li class="mui-table-view-cell">
			<a href="<?php echo U('mykuangche');?>">
				<span>我的矿机</span>
                <img class="weizhi" style="width: 6px;" src="/Public/bang/images/right_icon.png" />
			</a>
        </li>
        <li class="mui-table-view-cell">
            <a href="<?php echo U('kuangcheshouyi');?>">
                <span>矿机收益</span>
                <img class="weizhi" style="width: 6px;" src="/Public/bang/images/right_icon.png" />
            </a>
        </li>
        <li class="mui-table-view-cell">
            <a href="<?php echo U('myjiaoyi');?>">
				<span>我的交易</span>
                <img class="weizhi" style="width: 6px;" src="/Public/bang/images/right_icon.png" />
			</a>
        </li>
        <li class="mui-table-view-cell">
            <a href="<?php echo U('point');?>">
                <span>我的矿点</span>
                <img class="weizhi" style="width: 6px;" src="/Public/bang/images/right_icon.png" />
            </a>
        </li>
    </ul>
</div>
</body>
</html>