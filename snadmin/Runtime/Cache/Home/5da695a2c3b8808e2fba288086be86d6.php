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
      <form id="form1" name="form1" method="post" action="/admin8899.php/Home/Index/jbzscl">
	  <input name="UE_account"  type="hidden" class="dfinput" value="<?php echo ($userdata['ue_account']); ?>" />
    <ul class="forminfo"><li><label>赠送类型</label><cite><input name="lx" type="radio" value="jb" checked="checked" />
      GEC&nbsp;&nbsp;&nbsp;&nbsp;<!--<input name="lx" type="radio" value="yb" />
      银币&nbsp;&nbsp;&nbsp;&nbsp;<input name="lx" type="radio" value="zsb" />
      钻石币--></cite></li>
	 <li><label>会员账号</label><input name="user" type="text" class="dfinput" id="user" />
	 <i></i></li>
    <li><label>数量</label><input name="sl" type="text" class="dfinput" id="sl" /><i></i></li>
    <li><label>&nbsp;</label><input name="" type="submit" class="btn" value="确认保存"/></li>
    </ul>
      </form>
    
	
	 <table class="tablelist">
    	<thead>
    	<tr>
        <th>编号<i class="sort"><img src="/sncss/images/px.gif" /></i></th>
        <th>会员</th>
		<th>昵称</th>
        <th>时间</th>
        <th>数量</th>
       
       
		
        </tr>
		
        </thead>
        <tbody>
		
		<?php if(is_array($list)): foreach($list as $key=>$v): ?><tr>
		 <td><?php echo ($v["ug_id"]); ?></td>
		 <td><?php echo ($v["ug_account"]); ?></td>
		 <td><?php echo ($v["ug_othraccount"]); ?></td>
		   <td><?php echo ($v["ug_gettime"]); ?></td>
		    <td>
			 <?php echo ($v["ug_money"]); ?>
			
			
			</td>
      
        
        </tr><?php endforeach; endif; ?>
        </tbody>
    </table>
    <style>.pages a,.pages span {
    display:inline-block;
    padding:2px 5px;
    margin:0 1px;
    border:1px solid #f0f0f0;
    -webkit-border-radius:3px;
    -moz-border-radius:3px;
    border-radius:3px;
}
.pages a,.pages li {
    display:inline-block;
    list-style: none;
    text-decoration:none; color:#58A0D3;
}
.pages a.first,.pages a.prev,.pages a.next,.pages a.end{
    margin:0;
}
.pages a:hover{
    border-color:#50A8E6;
}
.pages span.current{
    background:#50A8E6;
    color:#FFF;
    font-weight:700;
    border-color:#50A8E6;
}</style>
   
   <div class="pages"><br />

                        <div align="right"><?php echo ($page); ?>
                        </div>
   </div>
	
	
	
    </div>


</body>

</html>