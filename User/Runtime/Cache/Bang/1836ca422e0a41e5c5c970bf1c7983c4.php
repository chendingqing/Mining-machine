<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1, minimum-scale=1.0"/>
	<meta content="telephone=no" name="format-detection">
	<title>矿机收益</title>
    <link href="/Public/bang/css/mui.min.css" rel="stylesheet"/>
    <link href="/Public/bang/css/kj_resert.css" rel="stylesheet" />
    <link href="/Public/bang/css/kj_public.css" rel="stylesheet" />
    <link href="/Public/bang/css/kj_geren.css" rel="stylesheet" />
	<link href="/Public/bang/css/kj_geren_shouyi-jiaoyi.css" rel="stylesheet" />
    <style>
        header{
            -webkit-box-shadow: 0 0 0 #49bdff !important;
            box-shadow: 0 0 0 #49bdff !important;
        }
    </style>
</head>
<body>
    <header class="mui-navbar-inner mui-bar mui-bar-nav" style="background: #31b4ff">
        <h1 class="mui-title" style="color: #fff;">矿机收益</h1>
        <a href="<?php echo U('user');?>" class="left-icon"><img src="/Public/bang/images/head_back_icon.png" /></a>
    </header>
    <div class="mui-content">
        <table style="width: 100%;border-collapse:collapse; margin: 0 auto; border: 0">
            <thead style="font-size: 12px; color: #fff;">
                <tr style="height: 35px;line-height: 35px; background: #31b4ff">
                    <th style="border-bottom:2px solid #ddd ">矿机名称</th>
                    <th style="border-bottom:2px solid #ddd ">编号</th>
                    <th style="border-bottom:2px solid #ddd ">运行时间/(h)</th>
                    <th style="border-bottom:2px solid #ddd ">收入(GEC)</th>
                </tr>
            </thead>
            <tbody style="font-size: 10px;text-align: center; border: 0">
            <?php if(is_array($list)): foreach($list as $key=>$v): ?><tr style="line-height: 30px; height: 30px;">
                    <td style="min-width: 9%;border-bottom:1px solid #ddd;display:none;"><?php echo ($aab=$v["ug_id"]); ?></td>
                    <td style="min-width: 9%;border-bottom:1px solid #ddd "><?php echo ($v["kjmc"]); ?></td>
                    <td style="min-width: 9%;border-bottom:1px solid #ddd "><?php echo ($v["kjbh"]); ?></td>
                    <td style="border-bottom:1px solid #ddd "><?php echo (user_jj_ts($aab,$ztrs3)); ?></td>
                    <td style="min-width: 20%;border-bottom:1px solid #ddd "><?php echo (user_jj_lx($aab,$ztrs)); ?></td>
                </tr><?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>