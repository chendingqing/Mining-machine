<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>
			无标题文档
		</title>
		<link href="/sncss/css/style.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<div class="place">
			<span>
				位置：
			</span>
			<ul class="placeul">
				<li>
					<a href="#">
						首页
					</a>
				</li>
				<li>
					<a href="#">
						数据备份
					</a>
				</li>
			</ul>
		</div>
		<div class="formbody">
			<div class="formtitle">
				<span >
					数据备份
				</span>
				
			</div>
			
			<form id="form1" name="form1" method="post" onsubmit="return confirm('备份数据库');" action="/admin8899.php/Home/Db/index">
				<input name="init" type="hidden" class="dfinput" value="1"
				/>
				<ul class="forminfo">
					
					
					<li>
						<label>
							&nbsp;
						</label>
						<input name="" type="submit" class="btn" value="数据备份" />
					</li>
				</ul>
			</form>
			
			
		</div>

		<div class="formbody">
			<div class="formtitle">
				<span >
					数据导出
				</span>
				
			</div>
			
			<form id="form1" name="form1" method="post" onsubmit="return confirm('导出数据');" action="/admin8899.php/Home/Db/goods_export">
				<input name="init" type="hidden" class="dfinput" value="1"
				/>
				<ul class="forminfo">
					
					
					<li>
						<label>
							&nbsp;
						</label>
						<input name="" type="submit" class="btn" value="导出数据" />
					</li>
				</ul>
			</form>
			
			
		</div>




		<div class="formbody">
			<div class="formtitle">
				<span >
					备份列表
				</span>
				
			</div>
			<div style="clear:both;padding:10px;">
				<ul style="margin-left:50px;">
					<?php if(is_array($list)): foreach($list as $key=>$vo): ?><li><span style="display:inline-block;margin:5px 10px;">于 <?php echo ($vo); ?> 备份</span><a href="/admin8899.php/Home/db/del?item=<?php echo ($vo); ?>" onclick="return confirm('确认删除吗？')" style="color:#77f;">删除</a> <a href="/admin8899.php/Home/db/recovery?item=<?php echo ($vo); ?>" onclick="return confirm('确认恢复此备份？时间可能较长！请耐心等待！')" style="color:#77f;margin:5px 10px;">恢复备份</a></li><?php endforeach; endif; ?>
				</ul>
				</div>
			
			
			
		</div>
	</body>

</html>