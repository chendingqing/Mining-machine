<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="/sncss/css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/sncss/js/jquery.js"></script>

</head>


<body>

	<div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="#">首页</a></li>
    </ul>
    </div>
    
    <div class="mainindex">
    
    
    <div class="welinfo">
    <span><img src="/sncss/images/sun.png" alt="天气" /></span>
    <b><?php echo (session('adminuser')); ?>，欢迎使用信息管理系统</b><a href="/admin8899.php/Home/Index/adminlist">帐号设置</a>    </div>
    
    <!--<div class="welinfo">
    <span><img src="/sncss/images/time.png" alt="时间" /></span>
    <i>您上次登录的时间：2013-10-09 15:22</i> （不是您登录的？<a href="#">请点这里</a>）
    </div>-->
    
    <div class="xline"></div>
    
    <!--<ul class="iconlist">
    
    <li><img src="/sncss/images/ico01.png" /><p><a href="#">管理设置</a></p></li>
    <li><img src="/sncss/images/ico02.png" /><p><a href="#">发布文章</a></p></li>
    <li><img src="/sncss/images/ico03.png" /><p><a href="#">数据统计</a></p></li>
    <li><img src="/sncss/images/ico04.png" /><p><a href="#">文件上传</a></p></li>
    <li><img src="/sncss/images/ico05.png" /><p><a href="#">目录管理</a></p></li>
    <li><img src="/sncss/images/ico06.png" /><p><a href="#">查询</a></p></li> 
            
    </ul>-->
    
    <!--<div class="ibox"><a class="ibtn"><img src="/sncss/images/iadd.png" />添加新的快捷功能</a></div>-->
    
    <div class="xline"></div>
    <div class="box"></div>
    
    <div class="xline"></div>
    
    <div class="uimakerinfo"><b>管理公告</b></div>
    
    <ul class="umlist">
    <li><small>系统开关:<?php if($zt["zt"] == '0'): ?><a href="/admin8899.php/Home/Index/gb">关闭系统</a>
      <?php else: ?><a href="/admin8899.php/Home/Index/kq">开启系统</a><?php endif; ?><br />
上次登入IP:<?php if($scip["ip"] == ''): ?>未登过<?php else: echo ($scip["ip"]); ?>(<?php echo ($scip["date"]); ?>)<?php endif; ?> <br />
本次登入IP:<?php echo ($bcip["ip"]); ?>(<?php echo ($bcip["date"]); ?>)</small></li>


   
    </ul>
   
    </div>
    
     <ul>
						<li>
						<label>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;总注册人数
						</label>
						<input name="" type="text"
						class="dfinput" required="true" value="<?php echo ($zuser); ?>" disabled="true"/>
						人
						</li>
						<li>
						<label>
							&nbsp;&nbsp;&nbsp;今日新增会员
						</label>
						<input name="" type="text"
						class="dfinput" required="true" value="<?php echo ($jtzchy); ?>" disabled="true" />
						人
						</li>
						<li>
						<label>
							求购莱肯币数量
						</label>
						<input name="" type="text"
						class="dfinput" required="true" value="<?php echo ($jysl); ?>" disabled="true"/>(已完成)
						
						</li>
						<li>
						<label>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;交易金额
						</label>
						<input name="" type="text"
						class="dfinput" required="true" value="<?php echo ($jyje); ?>" disabled="true"/>(已完成)
						
						</li>
		</ul>
		<br />
		<br />
		<br />
		<br />
		<form method="POST" action="/admin8899.php/Home/Index/df1">
						
	<ul>
						<li>
						<label>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;实际全网算力&nbsp;
						</label>
						<input name="" type="text"
						class="dfinput" required="true" value="<?php echo ($qwsl); ?>" disabled="true"/>
					
						</li>
						<br />
						
						<li>
						<label>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;增加
						</label>
							<input name="num" type="text" class="dfinput"  placeholder="请输入要增加的数量"/>
						</li>
						<br />
						<li>
						<label>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;显示
						</label>
							<input  type="text" class="dfinput" value="<?php echo ($xssl); ?>" disabled="true"/>
						</li>
						<br />
						<li style="margin-left:10%"><label>&nbsp;</label><input name="" type="submit" class="btn" value="确认保存"/></li>
						
	</ul>
	</form>
	<br />
	<br />
	<br />
	<br /><br />
	<form method="POST" action="/admin8899.php/Home/Index/df1">
						
	<ul>
						<li>
						<label>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;实际交易量&nbsp;
						</label>
						<input name="" type="text"
						class="dfinput" required="true" value="<?php echo ($sjjyl); ?>" disabled="true"/>
					
						</li>
						<br />
						
						<li>
						<label>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;增加
						</label>
							<input name="addnum" type="text" class="dfinput"  placeholder="请输入要增加的数量"/>
						</li>
						<br />
						<li>
						<label>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;显示
						</label>
							<input  type="text" class="dfinput" value="<?php echo ($xsjyl); ?>" disabled="true"/>
						</li>
						<br />
						<li style="margin-left:10%"><label>&nbsp;</label><input name="" type="submit" class="btn" value="确认保存"/></li>
						
	</ul>
	</form>

</body>

</html>