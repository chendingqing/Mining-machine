<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>出售订单</title>
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
    <td> <form id="form1" name="form1" method="post" action="/admin8899.php/Home/Index/qiugou">
	 
   <input name="user" type="text" class="dfinput" id="user" />
	<input name="" type="submit" class="btn" value="确认搜索"/>
      </form>
	  </td>
	  
	  <td>
	   <form id="form1" name="form1" method="post" action="/admin8899.php/Home/Index/qiugou">
    <input name="start" type="text" class="dfinput" style='width:200px;' id="start" />
	至<input name="end" type="text" class="dfinput" style='width:200px;' id="end" /><i></i><label>&nbsp;</label><input name="" type="submit" class="btn" value="确认"/>
      </form>
	  	<script>
		$("#start,#end").datetimepicker({step:30,lang:'ch'});
	</script>
	</td>
	  
    <!-- <td align="right"><a href="/admin8899.php/Home/Index/tgbz_list/cz/0/">未匹配</a> <a href="/admin8899.php/Home/Index/tgbz_list/cz/1/">已匹配</a> <a onClick="javascript:if(!confirm('1-1自动匹配前请先备份备据,未备份请点取消,点确定自动匹配所有订单!'))  return  false; "  href="/admin8899.php/Home/Index/zdpp_cl">所有订单自己动匹配</a> </td> -->
  </tr>
  <tr>
    <td>总出售数量:<?php echo ($countlkb); ?>|| 总价格:<?php echo ($countjb); ?>|| 订单数量：<?php echo ($count); ?></td>
    <td align="right">&nbsp;</td>
  </tr>
</table>

    
    </div>
    
    
    <table class="tablelist">
    	<thead>
    	<tr>
        <th>编号<i class="sort"><img src="/sncss/images/px.gif" /></i></th>
        <th>出售会员</th>
        <th>昵称</th>
        <th>会员等级</th>
        <th>出售数量</th>
        <th>报价</th>
		<th>出售时间</th>
		<th>操作</th>
		
        </tr>
        </thead>
        <tbody>
		
		<?php if(is_array($list)): foreach($list as $key=>$v): ?><tr>
		 <td><?php echo ($v["id"]); ?></td>
		 <td><?php echo ($v["p_user"]); ?></td>
		   <td><?php echo ($v["p_name"]); ?></td>
		<td>
		 <?php if($v["p_level"] == 0): ?>Vip0<?php endif; ?>
		  <?php if($v["p_level"] == 1): ?>Vip1<?php endif; ?>
		   <?php if($v["p_level"] == 2): ?>Vip2<?php endif; ?>
		    <?php if($v["p_level"] == 3): ?>Vip3<?php endif; ?>
			 <?php if($v["p_level"] == 4): ?>Vip4<?php endif; ?>
			 <?php if($v["p_level"] == 5): ?>Vip5<?php endif; ?>
			  <?php if($v["p_level"] == 6): ?>Vip6<?php endif; ?>
			   <?php if($v["p_level"] == 7): ?>Vip7<?php endif; ?>
		</td>
		<td><?php echo ($v["lkb"]); ?></td>
		<td><?php echo ($v["jb"]); ?></td>
		<td><?php echo ($v["date"]); ?></td>
		<td><a href="/admin8899.php/Home/Index/csdddel/id/<?php echo ($v["id"]); ?>" class="tablelink">删除</a></td>
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