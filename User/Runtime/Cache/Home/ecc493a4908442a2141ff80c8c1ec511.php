<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <title>登录</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <meta name="wap-font-scale" content="no">
	<link rel="stylesheet" href="/Public/Home/css/weui.min.css">
    <link rel="stylesheet" href="/Public/web/css/jquery-weui.min.css">
	
	<link rel="stylesheet" href="/Public/reg/css/style.css">
	<link rel="stylesheet" href="/Public/reg/css/common.css">
	<style>
        input:-webkit-autofill,
        textarea:-webkit-autofill,
        select:-webkit-autofill{
            -webkit-box-shadow: 0 0 0 1000px #fff inset;
        }
	.wrapper{
	min-height:auto;
	}
	</style>
</head>
<body class="page-mobile " style="background: transparent">
<div style="position: fixed;z-index: -1000;width: 100%;height: 100vh;top:0;left: 0;"><img src="/Public/web/img/body_bg.jpg" style="width:100%;height: 100vh"></div>
    <div class="wrapper login-wrapper" style="background: transparent">
    <!-- logo S -->
	
    <div >
	<img src="/Public/web/img/logo.png" style="width:36%;margin-left:32%;margin-top:10px;border-radius:10px;margin-bottom:10px"/>
    </div>
    <!-- logo E -->
    <!-- 登录输入表单 S -->
	<!--onsubmit="return false;"-->
	<form name="logFrm" id="logFrm" action="" method="post" onsubmit="return false;" >
    <div class="login-form def-m mb10" style="background: transparent">
        <ul class="com-columns span2" style="background: transparent">
		 <li class="comc-item">
                <div class="com-formbox" style="overflow:hidden;display:block;">
							<a href="/index.php/Home/Login/login/" style="float:left;width:50%;text-align:center;line-height:30px;color:#02d2f5;">中文</a>
							<a href="javascript:alert('中国区用户请到中文版登录！');" style="float:right;width:50%;text-align:center;line-height:30px;color:#fff;">English</a>
							<a href="javascript:alert('中国区用户请到中文版登录！');" style="float:right;width:50%;text-align:center;line-height:30px;color:#fff;"> تسجيل الدخول</a>
							<a href="javascript:alert('中国区用户请到中文版登录！');" style="float:right;width:50%;text-align:center;line-height:30px;color:#fff;">Σύνδεση</a>
                </div>
            </li>
            <li class="comc-item">
                <div class="com-formbox">
                    <label class="formbox-hd" for="username"><i class="iconfont icon-user"></i>&nbsp;</label>
                    <span class="formbox-bd"><input type="text" id="username" name="account"  onkeyup="this.value=this.value.replace(/ /g,'')" maxlength="60" class="input-txt" placeholder="请输入会员帐号" /></span>
                </div>
            </li>
            <li class="comc-item">
                <div class="com-formbox">
                    <label class="formbox-hd"  for="password"><i class="iconfont icon-lock"></i>&nbsp;</label>
                    <span class="formbox-bd"><input type="password" id="password" name="password" onkeyup="this.value=this.value.replace(/ /g,'')"  maxlength="26" class="input-txt" placeholder="请输入登录密码" /></span>
                </div>
            </li>
        </ul>

    </div>
    <!-- 登录输入表单 E -->
    <!-- 通用按钮 S -->
    <div class="def-p com-btnbox mb10">
	<button onclick="do_submit()" style="background-color:#02d2f5;width:100%;height:47px;line-height:47px;color:#fff;border:0px;border-radius:5px;font-size:16px;">登录</button>
       <!--  <a href="#" class="btn btn-1 btn-dis" id="login_btn">登录</a> -->
    </div>
</form>	
   <ul>
	<li style="float:left">
	<div class="def-p txtr">
       <!-- <a href="#" class="fz13 link" id="findPwd_btn">APP下载</a> -->
    </div>
	</li>
    <!-- 忘记密码 S -->
	<li>
    <!--<div class="def-p txtr">
        <a href="/index.php/Home/Login/mmzh/" class="fz13 link" id="findPwd_btn">忘记密码</a>
    </div>-->
	</li>
	</ul>

   
</div>
<!-- 登录主要内容 E -->
</div>

<script type='text/javascript'>var ROOT = "";</script>
<script src="/Public/reg/js/jquery-1.11.3.min.js"></script>
	<script src="/Public/web/js/jquery-weui.min.js"></script>
<script type="text/javascript" src="/Public/reg/js/common.js"></script>
<script type="text/javascript" src="/Public/reg/js/login.js"></script>
<div class="loading-wrapper" style="display: none;">
<div class="loading-area">
<div id="floatingBarsG1" class="floatingBarsG"></div>
<p id="msg">登录中...</p> 
</div>
<div class="mask" style="opacity: 0.3;"></div>
</div>
<script>
function do_submit(){
        $.ajax({
            url:"<?php echo U('/index.php/Home/login/logincl');?>",
            type:"post",
            data:$("form").serialize(),
            dataType:"json",
            success:function(data){
			console.log(data);
                if(data.status==1){
					
                    location.href="/index.php/Home/Index/Index/";
                }else{
                    $.alert(data.msg);
                }
            },error:function(){

            },comptele:function(){

            }
        })
     }
</script>
	</body>
</html>