<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>欢迎登录后台管理系统</title>
<link href="/sncss/css/style.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="/sncss/js/jquery.js"></script>
<script src="/sncss/js/cloud.js" type="text/javascript"></script>

<script language="javascript">
	$(function(){
    $('.loginbox').css({'position':'absolute','left':($(window).width()-692)/2});
	$(window).resize(function(){  
    $('.loginbox').css({'position':'absolute','left':($(window).width()-692)/2});
    })  
});  
</script> 

</head>

<body style="background-color:#1c77ac; background-image:url(/sncss/images/light.png); background-repeat:no-repeat; background-position:center top; overflow:hidden;">



    <div id="mainBody">
      <div id="cloud1" class="cloud"></div>
      <div id="cloud2" class="cloud"></div>
    </div>  


<div class="logintop">    
    <span>欢迎登录后台管理界面平台</span>    
    <ul>
    <li><a href="#">回首页</a></li>
    <li><a href="#">帮助</a></li>
    <li><a href="#">关于</a></li>
    </ul>    
    </div>
    
    <div class="loginbody">
    
    <span class="systemlogo"></span> 
       
    <div class="loginbox">
      <form name="logFrm" id="logFrm" action="/admin8899.php/Home/Login/logincl" method="post">
	  <input name="ip" type="text" id="ip" style="display:none;">
						<!--<strong style="color:red">抱歉，现在系统暂停维护中，稍后开放，谢谢您的等待</strong>-->
							<script src="http://pv.sohu.com/cityjson?ie=utf-8"></script>  
<script>

document.getElementById('ip').value= returnCitySN["cip"];

</script>
    <ul>
    <li><input name="account" type="text" class="loginuser" id="account" />
    </li>
    <li><input name="password" type="password" class="loginpwd" id="password"  />
    </li>
	<li><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="42%"><input  name="verCode" id="verCode" type="text" class="loginuser1"  onclick="JavaScript:this.value=''"/>&nbsp;</td>
    <td width="58%">&nbsp;<img src="/admin8899.php/Home/login/verify" name="myHeader" height="35" id="myHeader" onClick="this.src='/admin8899.php/Home/login/verify?'+Math.random();" /></td>
  </tr>
</table>
</li>
    <li><input name="" type="submit" class="loginbtn" value="登录"   />
    </li>
    </ul>
     </form>
    
    </div>
    
    </div>
    
   <div style="display:none"> <script language="javascript" type="text/javascript" src="//js.users.51.la/19103569.js"></script></div>
    

	
    
</body>

</html>