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
						会员管理
					</a>
				</li>
				<li>
					<a href="#">
						发放矿机
					</a>
				</li>
			</ul>
		</div>
		
			<div class="formbody">
			<div class="formtitle">
				<span>
				发放矿机
				</span>
			</div>
			
			<form id="form1" name="form1" method="post" action="/admin8899.php/Home/kf/fkj">
				<input name="UE_account" type="hidden" class="dfinput" value="<?php echo ($userdata['ue_account']); ?>"/>
				<ul class="forminfo">
					<i>
					</i>
					</li>
					<li>
						<label>
						会员账号
						</label>
						<input name="username" type="text" id=""
						class="dfinput" value="" />
						
						<i>
						</i>
					</li>
					<li>
						<label>
						矿机型号
						</label>
						<select name="p" id="">
							<?php foreach($r as $v) { ?>
						<option value="<?= $v['id'] ?>"><?= $v['name'] ?></option>
						<?php } ?>
						</select>
						<i>
						</i>
					</li>
					<li>
						<label>
						发放数量
						</label>
						<input name="num" type="text" id=""
						class="dfinput" value="" />
						
						<i>
						</i>
					</li>

					
					
						<label>
							&nbsp;
						</label>
						<input name="" type="submit" class="btn" value="确认保存" />
						</ul>
			</form>
		</div>
	</body>

</html>