<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>微信基本信息</title>
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
      <form id="form1" name="form1" method="post" action="/admin8899.php/Shop/Index/wxme">
	  <input name="id"  type="hidden" class="dfinput" value="<?php echo ($wx['id']); ?>" />
    <ul class="forminfo">
	<li><label>公众号名称:</label><input  type="text" class="dfinput" name="num" value="<?php echo ($wx['num']); ?>" /></li>
	<li><label>微信原始账号:</label><input   type="text" class="dfinput" name="ini_num" value="<?php echo ($wx['ini_num']); ?>"/></li>
   
    <li><label>支付key:</label><input name="UE_password" type="text" class="dfinput" value="<?php echo'http://';echo $_SERVER['HTTP_HOST'];echo'/index.php/Admin/Wechat/index.html'?>"/></li>
    <li><label>微信Token:</label><input type="text" class="dfinput" name="token" value="<?php echo ($wx['token']); ?>" /></li>
    <li><label>微信AppID:</label><input  type="text" class="dfinput" name="appid" value="<?php echo ($wx['appid']); ?>"/><i></i></li>
    <li><label>微信AppSecrt:</label><input type="text" class="dfinput" name="appsecret" value="<?php echo ($wx['appsecret']); ?>"/></li>

	<!-- <li><label>微信AppSecret:</label><input name="idcard" type="text" class="dfinput" value="<?php echo ($userdata['idcard']); ?>"/><i></i></li> -->
	<li><label>EncodingAESKey:</label><input type="text" class="dfinput" name="encodingaeskey" value="<?php echo ($wx['encodingaeskey']); ?>" /><i></i></li>
	<li><label>商户号(MchId):</label><input  type="text" class="dfinput" name="partnerid" value="<?php echo ($wx['partnerid']); ?>"/><i></i></li>
	<li><label>商户API密钥:</label><input type="text" class="dfinput" name="partnerkey" value="<?php echo ($wx['partnerkey']); ?>"/><i></i></li>
    <li><label>&nbsp;</label><input name="" type="submit" class="btn" value="确认保存"/></li>
    </ul>
      </form>
    
    </div> 


</body>

</html>