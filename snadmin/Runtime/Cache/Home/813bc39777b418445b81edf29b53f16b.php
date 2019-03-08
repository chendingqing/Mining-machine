<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="/sncss/css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/sncss/js/jquery.js"></script>



<script src="/Public/datetimepicker/jquery.js"></script>
    <script src="/Public/datetimepicker/jquery.datetimepicker.js"></script>
	   <link href="/Public/datetimepicker/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />



<script type="text/javascript">
$(document).ready(function(){
  $(".click").click(function(){
  $(".tip").fadeIn(200);
  });
  
  $(".tiptop a").click(function(){
  $(".tip").fadeOut(200);
});

  $(".sure").click(function(){
  $(".tip").fadeOut(100);
});

  $(".cancel").click(function(){
  $(".tip").fadeOut(100);
});

});
</script>


</head>


<body>

	<div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="#">首页</a></li>
    <li><a href="#">数据表</a></li>
    <li><a href="#">基本内容</a></li>
    </ul>
    </div>
    
    <div class="rightinfo">
    
    <div>
    
    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
     
   <td>  <form id="form1" name="form1" method="post" action="/admin8899.php/Home/Index/change">
    <input name="start" type="text" class="dfinput" style='width:200px;' id="start" />
	至<input name="end" type="text" class="dfinput" style='width:200px;' id="end" /><i></i><label>&nbsp;</label><input name="" type="submit" class="btn" value="确认"/>
	<script>
		$("#start,#end").datetimepicker({step:30,lang:'ch'});
	</script>
      </form></td>
  </tr>
 
</table>

    
    </div>
    
    
     <table class="tablelist">
    	<thead>
    	<tr>
        <th>编号<i class="sort"><img src="/sncss/images/px.gif" /></i></th>
        <th>转换会员</th>
        <th>使用会员</th>
        <th>串码</th>
        <th>价值</th>
        <th>手续费</th>
        <th>添加时间</th>
	 
		
        </tr>
        </thead>
        <tbody>
		
		<?php if(is_array($list)): foreach($list as $key=>$v): ?><tr>
			<td><?php echo ($v["id"]); ?></td>
			<td><?php echo ($v["p_user"]); ?></td>
			<td><?php echo ($v["p_name"]); ?></td>
			<td><?php echo ($v["bs"]); ?></td>
			<td><?php echo ($v["money"]); ?></td>
			<td><?php echo ($v["service"]); ?></td>
			<td><?php echo (date("y-m-d H:i:s",$v["addtime"])); ?></td>

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
    
    
    <div class="tip">
    	<div class="tiptop"><span>提示信息</span><a></a></div>
        
      <div class="tipinfo">
        <span><img src="images/ticon.png" /></span>
        <div class="tipright">
        <p>是否确认对信息的修改 ？</p>
        <cite>如果是请点击确定按钮 ，否则请点取消。</cite>
        </div>
      </div>
        
        <div class="tipbtn">
        <input name="" type="button"  class="sure" value="确定" />&nbsp;
        <input name="" type="button"  class="cancel" value="取消" />
        </div>
    
    </div>
    
    
    
    
    </div>
    
    <script type="text/javascript">
	$('.tablelist tbody tr:odd').addClass('odd');
	</script>

</body>

</html>