<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="/sncss/css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>

	<div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="#">首页</a></li>
    <li><a href="#">表单</a></li>
    </ul>
    </div>
    
    <div class="formbody">
    
    <div class="formtitle"><span>基本信息</span></div>
      <form id="form1" name="form1" method="post" action="/admin8899.php/Home/Index/adminadd">

    <ul class="forminfo">
	<li><label>用户名</label><input name="MB_username" type="text" class="dfinput" value="" /><i>不可修改</i></li>
	<li><label>权限</label>
	<cite>
	<input name="MB_right" type="radio" value="1" checked="checked" />超级管理员&nbsp;&nbsp;&nbsp;&nbsp;<input name="MB_right" type="radio" value="0" />普通管理员
	</cite>
	
	</li>
    <li><label>密碼</label><input name="MB_userpwd" type="text" class="dfinput" /><i></i></li>
    <li><label>&nbsp;</label><input name="" type="submit" class="btn" value="确认保存"/></li>
    </ul>
     </form>
    
    </div>


</body>

</html>