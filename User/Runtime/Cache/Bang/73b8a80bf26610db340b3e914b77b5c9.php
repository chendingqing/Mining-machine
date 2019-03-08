<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1, minimum-scale=1.0"/>
	<title>立即购买</title>
    <link href="/Public/bang/css/mui.min.css" rel="stylesheet"/>
	<link href="/Public/bang/css/kj_resert.css" rel="stylesheet" />
	<link href="/Public/bang/css/kj_public.css" rel="stylesheet" />
    <style>
		.mui-bar-nav~.mui-content{
			padding-left: 15px;
			padding-right: 15px;
		}
		p{
			padding-bottom: 15px;
			line-height: 24px;
		}
	</style>
</head>
<body>
    <header class=" mui-navbar-inner mui-bar mui-bar-nav" style="background-image: url(/Public/bang/images/top.png);">
        <h1 class="mui-title" style="color:#FFF;">购买</h1>
        <a href="<?php echo U('index');?>" class="left-icon">
            <img src="/Public/bang/images/head_back_icon.png"/>
        </a>
    </header>
	<div class="mui-content">
        <?php if(!empty($project)): ?><div style="padding-top: 20px;">
			<h4 style="text-align: center;"><?php echo ($project['name']); ?></h4>
            <span style="line-height: 45px;">商品详情：</span>
			<p style="text-indent: 24px; margin-bottom: 30px;"><?php echo ($project['content']); ?></p>
			<span class="font-tianblue" style="font-size: 24px;"><?php echo ($project['price']); ?></span>
            <span>AD</span>
		</div>
		<div class="mui-btn mui-btn-block kj-goumai-btn" id="goumai_on">立即购买</div><?php endif; ?>
	</div>
</body>
<script src="/Public/web/js/jquery-1.8.3.min.js"></script>
<script src="/Public/bang/layer-v3.1.1/layer/layer.js"></script>
<script>
    $("#goumai_on").click(function(){
        layer.confirm('您确定要立即购买矿机吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            layer.closeAll();
            layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            });
            $.post("<?php echo U('confirmProject');?>",{id:"<?php echo ($project['id']); ?>"},function (data) {
                console.log(data);
                layer.closeAll();
                if(data.status == 1){
                    layer.msg(data.info,{icon:1,time:1000},function () {
                        window.location.href="<?php echo U('mykuangche');?>";
                    });
                }else{
                    layer.msg(data.info,{icon:2,time: 2000});
                }
            },"json")

        }, function(){});
    })
</script>
</html>