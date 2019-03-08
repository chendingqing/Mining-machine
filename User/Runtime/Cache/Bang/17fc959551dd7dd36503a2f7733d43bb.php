<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1, minimum-scale=1.0"/>
	<meta content="telephone=no" name="format-detection">
	<title>我的矿机</title>
    <link href="/Public/bang/css/mui.min.css" rel="stylesheet"/>
	<link href="/Public/bang/css/kj_resert.css" rel="stylesheet" />
	<link href="/Public/bang/css/kj_public.css" rel="stylesheet" />
	<link href="/Public/bang/css/kj_geren_wodekj.css" rel="stylesheet" />
</head>
<body>
    <header class=" mui-navbar-inner mui-bar mui-bar-nav" style="background-image: url(/Public/bang/images/top.png);">
        <h1 class="mui-title" style="color:#FFF;">我的矿机</h1>
        <a href="<?php echo U('user');?>" class="left-icon">
            <img src="/Public/bang/images/head_back_icon.png"/>
        </a>
    </header>
    <div class="mui-content">
        <ul class="mui-table-view">
            <?php if(is_array($list)): foreach($list as $key=>$v): ?><li class="mui-table-view-cell" style="position: relative;">
                <div class="kj_kuangji_icon" style="padding-bottom: 8px;">
                    <img src="<?php echo ($v["b_imagepath"]); ?>" />
                </div>
                <div class="kj_kuangji_text">
                    <p><strong><?php echo ($v["project"]); ?></strong></p>
                    <p><span>运行周期:</span><span><?php echo ($v["yxzq"]); ?>小时</span></p>
                    <p><span>产量/小时 :</span><span><?php echo ($v["lixi"]); ?></span></p>
                    <p><span>矿机编号:</span><span><?php echo ($v["kjbh"]); ?></span></p>
                    <p><span>矿机状态:</span>
                        <?php if($v["zt"] == 0): ?>未使用<?php endif; ?>
                        <?php if($v["zt"] == 1): ?><span style="color: #00ff00">正在运行</span><?php endif; ?>
                        <?php if($v["zt"] == 2): ?><span style="color: #ff0000">已经结束</span><?php endif; ?>
                    </p>
                </div>
                <?php if($v["zt"] == 0): ?><a href="<?php echo U('wakuang',array('id' => $v['id']));?>" style=" height:22px;line-height:20px;color: #02d2f5;display:block;position:absolute;right:30px;bottom:24px;font-size: 12px;padding: 0 10px;border: 1px solid #02d2f5;border-radius: 4px;">运行</a><?php endif; ?>
                <?php if($v["zt"] == 1): ?><a href="<?php echo U('wakuang',array('id' => $v['id']));?>" style=" height:22px;line-height:20px;color: #fff;display:block;position:absolute;right:30px;bottom:24px;font-size:12px;padding: 0 10px;background-color: #02d2f5;border: 1px solid #02d2f5;border-radius: 4px;">查看</a><?php endif; ?>
            </li><?php endforeach; endif; ?>
        </ul>
    </div>
</body>
<script src="/Public/web/js/jquery-1.8.3.min.js"></script>
<script src="/Public/bang/layer-v3.1.1/layer/layer.js"></script>
</html>