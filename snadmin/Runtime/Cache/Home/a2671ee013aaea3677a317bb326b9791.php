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
      <form id="form1" name="form1" method="post" action="/admin8899.php/Home/Index/usercl">
	  <input name="UE_account"  type="hidden" class="dfinput" value="<?php echo ($userdata['ue_account']); ?>" />
    <ul class="forminfo">
	<li><label>会员编号</label><input name="UE_account1" disabled="true " type="text" class="dfinput" value="<?php echo ($userdata['ue_account']); ?>" /><i>不可修改</i></li>
	<li><label>推薦人</label><input name="UE_accName" disabled="true " type="text" class="dfinput" value="<?php echo ($userdata['ue_accname']); ?>"/><i>不可修改</i></li>

    <!--  <li><label>信用等级</label><?php if($userdata['ue_level'] == 0): ?><cite><input name="" type="radio" value="0" checked="checked"/>Vip0<?php endif; ?>
    <?php if($userdata['ue_level'] == 1): ?><cite><input name="UE_stop" type="radio" value="1" checked="checked"/>Vip1</cite><?php endif; ?>
    <?php if($userdata['ue_level'] == 2): ?><cite><input name="UE_stop" type="radio" value="2" checked="checked"/>Vip2</cite><?php endif; ?>
    <?php if($userdata['ue_level'] == 3): ?><cite><input name="UE_stop" type="radio" value="3" checked="checked"/>Vip3</cite><?php endif; ?>
    <?php if($userdata['ue_level'] == 4): ?><cite><input name="UE_stop" type="radio" value="4" checked="checked"/>Vip4</cite><?php endif; ?>
    <?php if($userdata['ue_level'] == 5): ?><cite><input name="UE_stop" type="radio" value="5" checked="checked"/>Vip5</cite><?php endif; ?>
    <?php if($userdata['ue_level'] == 6): ?><cite><input name="UE_stop" type="radio" value="6" checked="checked"/>Vip6</cite><?php endif; ?>
        <i></i></li>
     <li>
        <label>信用等级</label>
            <cite>
                <input name="star" type="radio" value="0" />Vip0&nbsp;&nbsp;
                <input name="star" type="radio" value="1" />Vip1&nbsp;&nbsp;
                <input name="star" type="radio" value="2" />Vip2&nbsp;&nbsp;
                <input name="star" type="radio" value="3" />Vip3&nbsp;&nbsp;
                <input name="star" type="radio" value="4" />Vip4&nbsp;&nbsp;
                <input name="star" type="radio" value="5" />Vip5&nbsp;&nbsp;
                <input name="star" type="radio" value="6" />Vip6&nbsp;&nbsp;
            </cite>
    </li> -->
	
	<li><label>会员级别</label>
		<?php if($userdata['level'] == 0): ?><cite><input name="level" type="radio" value="0" checked="checked"/>会员(未激活)</cite><?php endif; ?>
		<?php if($userdata['level'] == 1): ?><cite><input name="level" type="radio" value="1" checked="checked"/>GEC矿工</cite><?php endif; ?>
		<?php if($userdata['level'] == 2): ?><cite><input name="level" type="radio" value="2" checked="checked"/>公会会长</cite><?php endif; ?>
		<?php if($userdata['level'] == 3): ?><cite><input name="level" type="radio" value="3" checked="checked"/>创业大使</cite><?php endif; ?>
		<?php if($userdata['level'] == 4): ?><cite><input name="level" type="radio" value="4" checked="checked"/>环保大使</cite><?php endif; ?>
		<?php if($userdata['level'] == 5): ?><cite><input name="level" type="radio" value="5" checked="checked"/>国际大使</cite><?php endif; ?>
        <i></i></li>
	 <li>
        <label>会员等级</label>
            <cite>
                <input name="level" type="radio" value="0" />会员（未激活）&nbsp;&nbsp;
                <input name="level" type="radio" value="1" />GEC矿工&nbsp;&nbsp;
                <input name="level" type="radio" value="2" />公会会长&nbsp;&nbsp;
                <input name="level" type="radio" value="3" />创业大使&nbsp;&nbsp;
                <input name="level" type="radio" value="4" />环保大使&nbsp;&nbsp;
                <input name="level" type="radio" value="5" />国际大使&nbsp;&nbsp;
            </cite>
    </li>

	<li style="display:none;"><label>是否激活</label><?php if($userdata2['ue_check'] == 0): ?><cite><input name="UE_check" type="radio" value="1" />是&nbsp;&nbsp;&nbsp;&nbsp;<input name="UE_check" type="radio" value="0" checked="checked" />否</cite><?php else: ?><cite><input name="UE_check" type="radio" value="1" checked="checked" />
	是&nbsp;&nbsp;&nbsp;&nbsp;<input name="UE_check" type="radio" value="0" />
	否</cite><?php endif; ?></li>
   <!--  <li><label>是否经理</label><?php if($userdata['sfjl'] == 0 ): ?><cite><input name="UE_stop1" type="radio" value="1" />是&nbsp;&nbsp;&nbsp;&nbsp;<input name="UE_stop1" type="radio" value="0" checked="checked" />否</cite><?php else: ?><cite><input name="UE_stop1" type="radio" value="1" checked="checked" />
	是&nbsp;&nbsp;&nbsp;&nbsp;<input name="UE_stop1" type="radio" value="0" />
	否</cite><?php endif; ?></li> -->
	
	 <li><label>是否冻结</label><?php if($userdata['ue_status'] == 1 ): ?><cite><input name="UE_dj" type="radio" value="3" />是&nbsp;&nbsp;&nbsp;&nbsp;<input name="UE_dj" type="radio" value="1" checked="checked" />否</cite><?php else: ?><cite><input name="UE_dj" type="radio" value="3" checked="checked" />
	是&nbsp;&nbsp;&nbsp;&nbsp;<input name="UE_dj" type="radio" value="1" />
	否</cite><?php endif; ?></li>
   
    <li><label>一級密碼</label><input  type="text" value="<?php echo ($userdata['ue_password']); ?>" class="dfinput"/><i>不修改请留空</i></li>
    <li><label>二級密碼</label><input  type="text" value="<?php echo ($userdata['ue_secpwd']); ?>" class="dfinput"/><i>不修改请留空</i></li>
    <li><label>昵称</label><input name="UE_truename" type="text" class="dfinput" value="<?php echo ($userdata['ue_truename']); ?>"/><i></i></li>
	<li><label>国籍</label><input name="area" type="text" class="dfinput" value="<?php echo ($userdata['area']); ?>"/><i></i></li>
	<li><label>身份證</label><input name="idcard" type="text" class="dfinput" value="<?php echo ($userdata['idcard']); ?>"/><i></i></li>
	
	<!-- <li><label>GEC</label><input name="jb" type="text" class="dfinput" value="<?php echo ($userdata['ue_money']); ?>"/><i></i></li> -->
	<li><label>姓名</label><input name="zhxm" type="text" class="dfinput" value="<?php echo ($userdata['zhxm']); ?>"/><i></i></li>
	<li><label>银行名称</label><input name="yhmc" type="text" class="dfinput" value="<?php echo ($userdata['yhmc']); ?>"/><i></i></li>
	<li><label>银行帐户</label><input name="yhzh" type="text" class="dfinput" value="<?php echo ($userdata['yhzh']); ?>"/><i></i></li>
	<li><label>BTCaddress</label><input name="btc" type="text" class="dfinput" value="<?php echo ($userdata['btcaddress']); ?>"/><i></i></li>
	
	<li><label>支付宝</label><input name="zfbb" type="text" class="dfinput" value="<?php echo ($userdata['zfb']); ?>"/><i></i></li>
	<li><label>微信</label><input name="weixin" type="text" class="dfinput" value="<?php echo ($userdata['weixin']); ?>"/><i></i></li>
	
	
	<li><label>手机号</label><input name="UE_phone" type="text" class="dfinput" value="<?php echo ($userdata['phone']); ?>"/><i></i></li>
	<li><label>手持身份证</label><input name="ue_sfz" type="text" id="ue_sfz" class="dfinput" value="<?php echo ($userdata['ue_sfz']); ?>"/><i></i><a href="javascrit:;" onclick="dels()">清空路径</a>
		<?php if($userdata['ue_sfz']): ?><img src="<?php echo ($userdata['ue_sfz']); ?>" width="200px" /><?php endif; ?>
	</li>
	<script>
	function dels(){
	 
		document.getElementById('ue_sfz').value = '';
	}
	</script>
	
	
    <li><label>&nbsp;</label>
	<input name="ok" type="submit" class="btn" value="确认保存"/>
	<input name="no" type="submit" class="btn" value="审核拒绝"/>
	
	</li>
    </ul>
      </form>
    
    </div> 


</body>

</html>