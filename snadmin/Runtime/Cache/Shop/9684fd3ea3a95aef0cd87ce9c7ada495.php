<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="/sncss/css/style.css" rel="stylesheet" type="text/css" />
<script src="/js/jquery.js"></script>
</head>

<body>

	<div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="#">首页</a></li>
    <li><a href="#">分类管理</a></li>
    </ul>
    </div>
    
    <div class="formbody">
    <div class="formtitle"><span>基本信息</span></div>
    <div><?php $toggleshop = M('system')->where(['SYS_ID'=>'1'])->getField('toggleshop');?>
      <form id="form1" name="form1" method="post" action="/admin8899.php/Shop/Index/toggleShop">
    <ul class="forminfo">
     <li><label>开启商城：<input name="toggle" type="radio" class="" value="0" <?php if($toggleshop == 0) echo 'checked="checked"' ?> /></label>
     <i></i></li>
     <li><label>关闭商城：<input name="toggle" type="radio" class="" value="1" <?php if($toggleshop == 1) echo 'checked="checked"'?> /></label>
     <i></i></li>    
    <li><label>&nbsp;</label><input name="" type="submit" class="btn" value="提交"/></li>
    </ul>
      </form>
    </div>
      <form id="form1" name="form1" method="post" action="/admin8899.php/Shop/Index/index">
    <ul class="forminfo">
	 <li><label>类别名称：</label><input name="name" type="text" class="dfinput" id="user" />
	 <i></i></li>
    
    <li><label>&nbsp;</label><input name="" type="submit" class="btn" value="提交"/></li>
    </ul>
      </form>
    
	
	 <table class="tablelist">
    	<thead>
    	<tr>
        <th>分类编号<i class="sort"><img src="/sncss/images/px.gif" /></i></th>
        <th>分类名称</th>
        <th>添加时间</th>
        <th>操作</th>
        
       
		
        </tr>
		
        </thead>
        <tbody>
		
		<?php if(is_array($list)): foreach($list as $key=>$v): ?><tr>
		 <td><?php echo ($v["id"]); ?></td>
		 <td><input style='border:1px solid #DDD;height:20px;text-indent:10px;' value="<?php echo ($v["name"]); ?>"><a onclick="edit(this)" style='margin-left:10px;cursor:pointer;'>修改</a></td>
		 <td><?php echo (date("Y-m-d H:i:s",$v["addtime"])); ?></td>
		 <td><a onclick="del(this)" style='margin-left:10px;cursor:pointer;'>删除</a></td>
		
        </tr><?php endforeach; endif; ?>
	   <script>
			function edit(ob){
				var obj = $(ob);
				var name = obj.parent().find("input").val();
				var id = obj.parent().parent().children().eq(0).html();
				$.post("/admin8899.php/Shop/Index/edit",{name:name,id:id},function(data){
					if(data){
						alert("修改成功");
					}else{
						alert("修改成功");
					}
				},'json');
			}
			function del(ob){
				var obj = $(ob);
				var id = obj.parent().parent().children().eq(0).html();
				$.post("/admin8899.php/Shop/Index/del",{id:id},function(data){
					if(data){
						alert("删除成功");
						obj.parent().parent().remove();
					}else{
						alert("删除成功");
					}
				});
			}
	   </script>
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