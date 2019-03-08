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
    
    <div class="formtitle"><span>系统设置</span></div>
      <form id="form1" name="form1" method="post" action="/admin8899.php/Home/Index/Configsave">
    <ul class="forminfo">
	<?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><li>
		<label><?php echo ($item["config_description"]); ?></label>
		<input name="<?php echo ($item["config_key"]); ?>" type="text" class="dfinput" value="<?php echo ($item["config_value"]); ?>" />
		</li><?php endforeach; endif; else: echo "" ;endif; ?>
	<li><label>&nbsp;</label><input name="" type="submit" class="btn" value="确认保存"/></li>

    </ul>
      </form>
    
    </div> 


</body>

</html>