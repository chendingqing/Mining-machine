<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="/sncss/css/style.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="/sncss/js/jquery.js"></script>

<script type="text/javascript">
$(function(){	
	//导航切换
	$(".menuson li").click(function(){
		$(".menuson li.active").removeClass("active")
		$(this).addClass("active");
	});
	
	$('.title').click(function(){
		var $ul = $(this).next('ul');
		$('dd').find('ul').slideUp();
		if($ul.is(':visible')){
			$(this).next('ul').slideUp();
		}else{
			$(this).next('ul').slideDown();
		}
	});
})	
</script>


</head>

<body style="background:#f0f9fd;">
	<div class="lefttop"><span></span>功能欄</div>
    
    <dl class="leftmenu">
        
    <dd>
    <div class="title">
    <span><img src="/sncss/images/leftico01.png" /></span>會員管理
    </div>
    	<ul class="menuson">
		 <li><cite></cite><a href="/admin8899.php/home/index/config" target="rightFrame">交易设置</a><i></i></li>
        <li><cite></cite><a href="/admin8899.php/home/index/userlist" target="rightFrame">所有會員</a><i></i></li>
      
        <li><cite></cite><a href="/admin8899.php/home/index/jbzs" target="rightFrame">GEC增送</a><i></i></li>
        
        <!-- <li><cite></cite><a href="/admin8899.php/home/index/tixians" target="rightFrame">体现管理</a><i></i></li> -->

        <li><cite></cite><a href="/admin8899.php/home/Db/index" target="rightFrame">数据备份</a><i></i></li>
		<li><cite></cite><a href="/admin8899.php/home/Index/tousu" target="rightFrame">会员投诉</a><i></i></li>
		
		<li><cite></cite><a href="/admin8899.php/home/Index/wxtjhy" target="rightFrame">微信群发</a><i></i></li>
		<li><cite></cite><a href="/admin8899.php/home/kf/fkj" target="rightFrame">发矿机</a><i></i></li>
		<!-- <li><cite></cite><a href="/admin8899.php/home/Db/daoru" target="rightFrame">数据导出</a><i></i></li> -->
		
        </ul>    
    </dd>
        
    

    <!-- <dd>
    <div class="title">
    <span><img src="/sncss/images/leftico02.png" /></span>提现管理
    </div>
        <ul class="menuson">
        <li><cite></cite><a href="/admin8899.php/home/index/tixians" target="rightFrame">提现订单</a><i></i></li>
        <li><cite></cite><a href="/admin8899.php/home/index/settings" target="rightFrame">提现金额控制</a><i></i></li>
      
        </ul>    
    </dd>
 -->

	<dd>
    <div class="title">
    <span><img src="/sncss/images/leftico02.png" /></span>汇率转换
    </div>
        <ul class="menuson">
        <li><cite></cite><a href="/admin8899.php/home/index/kjsy" target="rightFrame">结算矿机收益</a><i></i></li>
        <li><cite></cite><a href="/admin8899.php/home/index/kcsy" target="rightFrame">会员收益列表</a><i></i></li>
        <li><cite></cite><a href="/admin8899.php/home/index/settings" target="rightFrame">转换比例</a><i></i></li>
		<li><cite></cite><a href="/admin8899.php/home/index/klinea" target="rightFrame">分时K线[演示用]</a><i></i></li>
      
        </ul>    
    </dd>
	
	
	
	
	

   <dd>
    <div class="title">
    <span><img src="/sncss/images/leftico01.png" /></span>交易信息
    </div>
    	<ul class="menuson">
		 <li><cite></cite><a href="/admin8899.php/home/index/csdd" target="rightFrame">出售订单</a><i></i></li>
        <li><cite></cite><a href="/admin8899.php/home/index/qiugou" target="rightFrame">求购订单</a><i></i></li>
        <li><cite></cite><a href="/admin8899.php/home/index/jiaoyi" target="rightFrame">交易中订单</a><i></i></li>
		<li><cite></cite><a href="/admin8899.php/home/Index/jywc" target="rightFrame">求购完成订单</a><i></i></li>
		<li><cite></cite><a href="/admin8899.php/home/Index/cswc" target="rightFrame">出售完成订单</a><i></i></li>
			<li><cite></cite><a href="/admin8899.php/home/Index/change" target="rightFrame">电子钱包转换纪录</a><i></i></li><!-- wk -->
        </ul>    
    </dd>
        
	
	
    
    <dd><div class="title"><span><img src="/sncss/images/leftico03.png" /></span>帮助中心</div>
    <ul class="menuson">

		<li><cite></cite><a href="/admin8899.php/Home/Shop/zsbyg_list" target="rightFrame">帮助栏目</a><i></i></li>
		<li><cite></cite><a href="/admin8899.php/Home/Shop/zsbyg_list_xg" target="rightFrame">添加内容</a><i></i></li>
    </ul>    
    </dd>  
    
	
	
    <dd><div class="title"><span><img src="/sncss/images/leftico03.png" /></span>公告中心</div>
    <ul class="menuson">

		<li><cite></cite><a href="/admin8899.php/Home/Shop/zsbyg_list3" target="rightFrame">公告栏目</a><i></i></li>
		<li><cite></cite><a href="/admin8899.php/Home/Shop/zsbyg_list_xg3" target="rightFrame">添加内容</a><i></i></li>
    </ul>    
    </dd>  
    
	
	
	  <dd><div class="title"><span><img src="/sncss/images/leftico04.png" /></span>团队奖管理</div>
    <ul class="menuson">
		<li><cite></cite><a href="/admin8899.php/home/index/settings" target="rightFrame">分成管理</a><i></i></li>
		
    </ul>
    
    </dd>   

	<dd><div class="title"><span><img src="/sncss/images/leftico04.png" /></span>商城管理</div>
    <ul class="menuson">
        <li><cite></cite><a href="/admin8899.php/Shop/index/index" target="rightFrame">产品分类</a><i></i></li>
		<li><cite></cite><a href="/admin8899.php/Shop/Project/addProject" target="rightFrame">产品添加</a><i></i></li>
		<li><cite></cite><a href="/admin8899.php/Shop/Project/listProject" target="rightFrame">产品列表</a><i></i></li>
        <li><cite></cite><a href="/admin8899.php/Shop/index/listOrderform" target="rightFrame">商城订单列表</a><i></i></li>
    </ul>
    
    </dd>   

	
	<dd><div class="title"><span><img src="/sncss/images/leftico03.png" /></span>留言管理</div>
    <ul class="menuson">

		<li><cite></cite><a href="/admin8899.php/Home/Shop/ly_list/type/0/" target="rightFrame">未处理留言</a><i></i></li>
		<li><cite></cite><a href="/admin8899.php/Home/Shop/ly_list/type/1/" target="rightFrame">已处理留言</a><i></i></li>
    </ul>    
    </dd>  
	
    <dd><div class="title"><span><img src="/sncss/images/leftico02.png" /></span>微信管理</div>
    <ul class="menuson">
        <li><cite></cite><a href="/admin8899.php/Shop/index/wxme" target="rightFrame">微信基本信息</a><i></i></li>
		<li><cite></cite><a href="/admin8899.php/Shop/index/wxmenu" target="rightFrame">微信菜单管理</a><i></i></li>
		<!-- <li><cite></cite><a href="/admin8899.php/Shop/index/replayedit" target="rightFrame">微信回复管理</a><i></i></li>
        <li><cite></cite><a href="/admin8899.php/Shop/index/wxkjset" target="rightFrame">微信矿机管理</a><i></i></li> -->
    </ul>
    
    </dd>  
    
	
    </dl>
    
</body>
</html>